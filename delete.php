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

// Guardian: Make sure that profile_id is present
if ( ! isset($_GET['profile_id']) )
{
  $_SESSION['message'] = '<span style="color:red;weight:bold;text-aligne:center;">Missing profile_id</span>';
  header('Location: index.php');
  return;
}

// Guardian 2: Check if now the profile_id exist and is valid.
$stmt = $pdo->prepare("SELECT first_name,last_name, profile_id FROM profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false )
{
    $_SESSION['message'] = '<span style="color:red;text-align:center;">Bad value for profile_id</span>';
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
  <form method="post" style="position:absolute;top:10%;">
    <span class="Titre"> Delete the profile <?= $row['profile_id'] ?> from the data base </span>
    <!-- htmlentities here to ensure that non htmlinjection are possible -->
    <p >Confirm: Deleting <?= htmlentities($row['first_name'])." ".htmlentities($row['last_name']) ?></p>
    <input  type="hidden" name="profile_id" value="<?= $row['profile_id'] ?>">
    <input class="myButton" type="submit" value="Delete" name="delete">
    <a href="index.php" class="myButton" >Cancel</a>
  </form>

</body>
</html>
