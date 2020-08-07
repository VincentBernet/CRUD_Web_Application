<!-- Bernet Vincent week 4's assignment of "Building web application" course from Coursera -->

<?php
require_once "pdo.php";
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Vincent Bernet Edit</title>
    <!-- Personal CSS -->
  <link rel="stylesheet" href="index.css">
</head>
<body>
<?php
//Test to see if the user_id is in fact in our $_SESSION so we can manage index.php to only permit user to delet or edit their own profile
/*if (isset($_SESSION['user_id']))
{
  echo('<p style="color:green; text-align:center">'.$_SESSION['user_id'].'</p>');
}*/
if (!isset($_SESSION['email']))
{
  die("<div style='text-align:center;color:pink;weight:bold;font-size:35px;margin-top:10%;'>ACCESS DENIED<br> <a href='index.php'>Back to Index</a></div>");
}
if (isset($_POST['cancel']))
{
  header("Location: index.php");
  return;
}
if ( isset($_POST['first_name']) && isset($_POST['last_name'])
     && isset($_POST['email'])&& isset($_POST['headline']) && isset($_POST['summary']) ) {

    // Data validation
    if (($_POST['first_name']=='')||($_POST['last_name']=='')||($_POST['email']=='')||($_POST['headline']==''))
    {
      $_SESSION["message"]="<div style='color:red; text-align: center;'>MISSING DATA</div>";
      header("Location: edit.php");
      return;
    }



    $sql = "UPDATE profile SET first_name = :first_name,
            last_name = :last_name, email = :email, headline = :headline, summary = :summary
            WHERE profile_id = :profile_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':first_name' => $_POST['first_name'],
        ':last_name' => $_POST['last_name'],
        ':email' => $_POST['email'],
        ':headline' => $_POST['headline'],
        ':summary' => $_POST['summary'],
        ':profile_id' => $_POST['profile_id']));
    $_SESSION['message'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: first_name sure that user_id is present
if ( ! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing profile_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$n = htmlentities($row['first_name']);
$e = htmlentities($row['last_name']);
$p = htmlentities($row['email']);
$q = htmlentities($row['headline']);
$v =  htmlentities($row['summary']);
$y = htmlentities($row['profile_id']);

$profile_id = $row['profile_id'];
?>
<div class="container">
<h1>Editing Profile for UMSI</h1>
<form method="post" action="edit.php">
<p>First Name:
<input type="text" name="first_name" size="60"
value="<?= $n ?>"
/></p>
<p>Last Name:
<input type="text" name="last_name" size="60"
value="<?= $e ?>"
/></p>
<p>Email:
<input type="text" name="email" size="30"
value="<?= $p ?>"
/></p>
<p>Headline:<br/>
<input type="text" name="headline" size="80"
value="<?= $q ?>"
/></p>
<p>Summary:<br/>
<textarea name="summary" rows="8" cols="80" >
<?= $v ?>
</textarea>
<p>
<input type="hidden" name="profile_id"
value="<?= $y ?>"
/>
<input type="submit" value="Save">
<input type="submit" name="cancel" value="Cancel">
</p>
</form>
</div>
</body>
</html>
