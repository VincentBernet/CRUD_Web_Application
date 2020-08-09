<!-- Bernet Vincent week 2's assignment of "JavaScript, jQuery, and JSON" course from Coursera -->
<!-- Added some jQuerry to show and insert or not new Position (with a new table eponyme) -->

<?php
require_once "pdo.php";
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Vincent Bernet Delete</title>
    <!-- Personal CSS -->
  <link rel="stylesheet" href="index.css">
  <meta charset="UTF-8" />
</head>
<body>
<?php
if (!isset($_SESSION["email"]))
{
  die("<div style='text-align:center;color:pink;weight:bold;font-size:35px;margin-top:10%;'>ACCESS DENIED<br> <a href='index.php'>Back to Index</a></div>");
}

if ( isset($_POST['delete']) && isset($_POST['profile_id']) )
{
    $sql = "DELETE FROM profile WHERE profile_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['profile_id']));
    $_SESSION['message'] = '<span style="color:green;weight:bold;text-aligne:center;">Record deleted</span>';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that profile_id is present
if ( ! isset($_GET['profile_id']) )
{
  $_SESSION['message'] = '<span style="color:red;weight:bold;text-aligne:center;">Missing profile_id</span>';
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT first_name,last_name, profile_id FROM profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false )
{
    $_SESSION['message'] = '<span style="color:red;text-align:center;">Bad value for profile_id</span>';
    header( 'Location: index.php' ) ;
    return;
}
?>
<p>Confirm: Deleting <?= htmlentities($row['first_name'])." ".htmlentities($row['last_name']) ?></p>

<form method="post">
  <input type="hidden" name="profile_id" value="<?= $row['profile_id'] ?>">
  <input type="submit" value="Delete" name="delete">
  <a href="index.php">Cancel</a>
</form>

</body>
</html>
