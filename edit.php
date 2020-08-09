<!-- Bernet Vincent week 2's assignment of "JavaScript, jQuery, and JSON" course from Coursera -->
<!-- Added some jQuerry to show and insert or not new Position (with a new table eponyme) -->

<?php
require_once "pdo.php";
require_once "utility.php";
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Vincent Bernet Edit</title>
    <!-- Personal CSS -->
  <link rel="stylesheet" href="index.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <meta charset="UTF-8" />
</head>
<body>
<?php

// First check if the user is logged in
if (!isset($_SESSION['email']))
{
  die("<div style='text-align:center;color:pink;weight:bold;font-size:35px;margin-top:10%;'>ACCESS DENIED<br> <a href='index.php'>Back to Index</a></div>");
}

// Second if the user requested cancel go back to index.php
if (isset($_POST['cancel']))
{
  header("Location: index.php");
  return;
}

// Third make sure the REQUEST parameter is present
if (! isset($_REQUEST['profile_id']))
{
  $_SESSION['message'] = "<span style='color:yellow;text-align:cernet;weight:bold;'>Missing profile_id</span>";
  header('Location: index.php');
  return;
}

//flash patern
flashMessages();

$msg = validatePos();
if (is_string($msg))
{
  $_SESSION['message'] = $msg;
  header('Location: edit.php?profile_id='. $_REQUEST["profile_id"]);
  return;
}
/*
// Second: make sure that the profile_id that we want to edit is in the url
if ( ! isset($_GET['profile_id']) && !($_POST['profile_id']) ) {
  $_SESSION['message'] = '<span style="color:red;weight:bold;text-aligne:center;">Missing user_id</span>';
  header('Location: index.php');
  return;
}*/


// Third: We can now start obsverving our data in our form and proceed to the update
if ( isset($_POST['first_name']) && isset($_POST['last_name'])&& isset($_POST['email'])&& isset($_POST['headline']) && isset($_POST['summary']) )
{

  // Data validation in our utility file, if false we stop and print the error on the index
  $msg = validateProfile2();
  if (is_string($msg))
  {
    $_SESSION['message'] = $msg;
    header('Location: edit.php?profile_id='. $_REQUEST["profile_id"]);
    return;
  }

  $sql = "UPDATE profile SET first_name = :first_name, last_name = :last_name, email = :email, headline = :headline, summary = :summary
          WHERE profile_id=:profile_id AND user_id= :user_id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
        ':first_name' => $_POST['first_name'],
        ':last_name' => $_POST['last_name'],
        ':email' => $_POST['email'],
        ':headline' => $_POST['headline'],
        ':summary' => $_POST['summary'],
        ':profile_id' => $_REQUEST['profile_id'],
        ':user_id' => $_SESSION['user_id'])
      );

  // Clear out the old position entries
  $stmt = $pdo -> prepare('DELETE FROM Position WHERE profile_id=:profile_id');
  $stmt -> execute(array( ':profile_id' => $_REQUEST['profile_id']));

  // Insert the position entries

  $rank = 1;
  for ($i=1; $i<=9; $i++)
  {
    if (!isset($_POST['year'.$i])) continue;
    if (!isset($_POST['description'.$i])) continue;
    $year = $_POST['year'.$i];
    $desc = $_POST['year'.$i];
    $stmt = $pdo->prepare('INSERT INTO Position
      (profile_id, rank, year, description )
      VALUES (:profile_id,:rank,:year,:description)');
    $stmt-> execute(array(
      ':profile_id' => $profile_id,
      ':rank' => $rank,
      ':year' => $year,
      ':description' => $description)
    );
    $rank++;
  }
  $_SESSION['message'] = '<span style="color:green;weight:bold;text-aligne:center;">Record Updated</span>';
  header( 'Location: index.php' ) ;
  return;
}

$positions=loadPos($pdo,$_REQUEST['profile_id']);

// Fourth: Verify is this profile_id exist (if it correspond to a row in our database)
$stmt = $pdo->prepare("SELECT * FROM profile where profile_id = :profile_id");
$stmt->execute(array(":profile_id" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['message'] = '<span style="color:red;weight:bold;text-aligne:center;">Bad value for profile_id</span>';
    header( 'Location: index.php' ) ;
    return;
}

// Define some abreviation variable for your form with inside a copy of profile's data selectionned to be changed.
$n = htmlentities($row['first_name']);
$e = htmlentities($row['last_name']);
$p = htmlentities($row['email']);
$q = htmlentities($row['headline']);
$v =  htmlentities($row['summary']);
$y = htmlentities($row['profile_id']);
$profile_id = $row['profile_id'];
//$textPosition = $row['description'];
//$yearPosition = $row['year'];

// Return to index.php without changing anything if we click on cancel button

?>

<div class="container">
  <h1>Editing Profile for UMSI</h1>
  <form method="post" action="edit.php">

      <p>First Name:
        <input type="text" name="first_name" size="60" value="<?= $n ?>"/>
      </p>

      <p>Last Name:
        <input type="text" name="last_name" size="60" value="<?= $e ?>"/>
      </p>

      <p>Email:
        <input type="text" name="email" size="30"value="<?= $p ?>"/>
      </p>
      <p>Headline:<br/>
        <input type="text" name="headline" size="80" value="<?= $q ?>"/>
      </p>
      <p>Summary:<br/>
        <textarea name="summary" rows="8" cols="80" ><?= $v ?></textarea>
      </p>

      <div class="user-box">
        <p> Position:
          <button id = "addPos" type="button" >
             +
          </button>
        </p>
      </div>

      <div id="position_fields">
          <!--Year: <input type="text" name="year'+countPos+'" value="<\? $yearPosition ?>"/>
          <textarea name="description"style="background:#19273c;color:white;" rows="2" cols="45"><\?= $textPosition ?></textarea>-->
      </div>

      <p>
        <input type="hidden" name="profile_id" value="<?= $y ?>"/>
        <input type="submit" value="Save">
        <input type="submit" name="cancel" value="Cancel">
      </p>
  </form>
  <script type="text/javascript">
    countPos = 0;
    $(document).ready(function (){
      window.console && console.log("The dom is ready: Script begin");
      $("#addPos").click(function(event){
        event.preventDefault();
        if (countPos>=9){
          alert("Maximum of nine position entries exceeded");
          return;
        }
        countPos++;
        window.console && console.log('Adding position'+countPos);
        $('#position_fields').append(
          '<div id="position'+countPos+'"> \
          <input type="button" value="-" \
            onclick= "window.console && console.log(\'Removing position'+countPos+'\');countPos--;$(\'#position'+countPos+'\').remove();return false;"> Year: <input type="text" name="year'+countPos+'" value=""/>  \
            <textarea name="description'+countPos+'"style="background:#19273c;color:white;" rows="2" cols="45"></textarea>\
            </div><br>');

      }
    );}

    );
  </script>
</div>
</body>
</html>
