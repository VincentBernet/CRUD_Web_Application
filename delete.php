<!-- Bernet Vincent Crud Application, check the READ-ME -->

<!-- To begin with we call our pdo to link our php to our database. We end up by calling our session. -->
<?php
require_once "pdo.php";
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Vincent Bernet Delete</title>
  <!-- Personal Css file common for every page -->
  <link rel="stylesheet" href="index.css">
  <meta charset="UTF-8" />
</head>
<body>
<?php

// First check if the user is logged in
if (!isset($_SESSION["email"]))
{
  die("<div style='text-align:center;color:pink;weight:bold;font-size:35px;margin-top:10%;'>ACCESS DENIED<br> <a href='index.php'>Back to Index</a></div>");
}

// Second redirect to index.php if user wants to cancel
if (isset($_POST['cancel']))
{
  header("Location: index.php");
  return;
}

// Guardian: Make sure that profile_id is present
if ( ! isset($_GET['profile_id']) )
{
  $_SESSION['message'] = '<span style="color:red;weight:bold;text-aligne:center;">Missing profile_id</span>';
  header('Location: index.php');
  return;
}

// Guardian 2: Check if now the profile_id exist and is valid.
$stmt = $pdo->prepare("SELECT first_name,last_name, profile_id FROM profile where profile_id = :profile_id");
$stmt->execute(array(":profile_id" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false )
{
    $_SESSION['message'] = '<span style="color:red;text-align:center;">This profile_id doesn\'t exist</span>';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian 3: Check if the profile selected to be deleted was created by the current user.
$stmt = $pdo->prepare("SELECT first_name,last_name, profile_id FROM profile where profile_id = :profile_id And user_id = :user_id");
$stmt->execute(array(":profile_id" => $_GET['profile_id'], ":user_id" => $_GET['user_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false )
{
    $_SESSION['message'] = '<span style="color:red;text-align:center;">You can\'t delete a profile that is not created by your account !</span>';
    header( 'Location: index.php' ) ;
    return;
}


// If submit button to delete have been pressed then we delete via sql Querry the profile_id selected previously
if ( isset($_POST['delete']) && isset($_POST['profile_id']) )
{
    $sql = "DELETE FROM profile WHERE profile_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['profile_id']));
    $_SESSION['message'] = '<span style="color:green;weight:bold;text-aligne:center;">Record deleted</span>';
    header( 'Location: index.php' ) ;
    return;
}
?>

<!-- View Part : -->

<?php
  // We call our header page
  include('header.php');
?>
<br><br>
  <form method="post">
    <span class="Titre"> Delete the profile <?= $row['profile_id'] ?> from the data base </span>
    <!-- htmlentities here to ensure that non htmlinjection are possible -->
    <p >Confirm Deleting "<?= htmlentities($row['first_name'])." ".htmlentities($row['last_name']) ?>"</p>
 
    <?php
  
    // Display profile information from the eponymic table.
    $stmt = $pdo->prepare("SELECT first_name,last_name,email,headline,summary FROM profile  WHERE profile_id= :profile_id");
    $stmt -> execute(array
    (
      ':profile_id' => $_GET['profile_id']
    ));
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
    {
        echo("<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Email : ".htmlentities($row['email'])." </p>");
        echo("<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Headline : ".htmlentities($row['headline'])." </p>");
        echo("<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Summary : ".htmlentities($row['summary'])." </p>");
    }

    // Display Education information of the selected profile, inaddition of some data of Institution table
    $stmt = $pdo->prepare("Select year,name FROM Education JOIN Institution
      ON Education.institution_id = Institution.institution_id
      WHERE profile_id = :profile_id ORDER BY rank");
    $stmt -> execute(array
    (
      ':profile_id' => $_GET['profile_id']
    ));
    echo("<p> Education : <ul></p>");
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
    {
      echo("<li> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year ".htmlentities($row['year']).": ");
      echo(" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities($row['name'])." </li>");
    }
    echo('</ul>');

    // Display Position information of the selected profile
    $stmt = $pdo->prepare("SELECT year,description FROM Position  WHERE profile_id= :profile_id");
    $stmt -> execute(array
    (
      ':profile_id' => $_GET['profile_id']
    ));
    echo("<p> Position : <ul></p>");
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
    {
      echo("<li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year ".htmlentities($row['year']).": ");
      echo(" &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".htmlentities($row['description'])." </li>");
    }
    echo('</ul>');
  ?>
    <input  type="hidden" name="profile_id" value="<?= $row['profile_id'] ?>">
    <input class="myButton" type="submit" value="Delete" name="delete">
    <input class="myButton" type="submit" name ="cancel" value="Cancel"/>

  </form>

</body>
<?php
// We call our header page
include('footer.php');?>
</html>
