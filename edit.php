<!-- Bernet Vincent week 4's assignment of "Building web application" course from Coursera -->

<?php
require_once "pdo.php";
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Vincent Bernet Index-Page ed59399f</title>
  <!-- My personal css -->
  <link rel="stylesheet" href="index.css">
</head>
<body>
<?php
if (!isset($_SESSION['email']))
{
  die("<div style='text-align:center;color:pink;weight:bold;font-size:35px;margin-top:10%;'>ACCESS DENIED<br> <a href='index.php'>Back to Index</a></div>");
}
if (isset($_POST['cancel']))
{
  header("Location: index.php");
  return;
}
if ( isset($_POST['make']) && isset($_POST['model'])
     && isset($_POST['year'])&& isset($_POST['mileage']) && isset($_POST['autos_id']) ) {

    // Data validation
    if (($_POST['make']=='')||($_POST['model']=='')||($_POST['year']=='')||($_POST['mileage']==''))
    {
      $_SESSION["message"]="<div style='color:red; text-align: center;'>MISSING DATA</div>";
      header("Location: edit.php");
      return;
    }



    $sql = "UPDATE autos SET make = :make,
            model = :model, year = :year, mileage = :mileage
            WHERE autos_id = :autos_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage'],
        ':autos_id' => $_POST['autos_id']));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Missing autos_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$n = htmlentities($row['make']);
$e = htmlentities($row['model']);
$p = htmlentities($row['year']);
$q = htmlentities($row['mileage']);

$autos_id = $row['autos_id'];
?>
<p>Edit User</p>
<form method="post">
<p>Make:
<input type="text" name="make" value="<?= $n ?>"></p>
<p>Model:
<input type="text" name="model" value="<?= $e ?>"></p>
<p>Year:
<input type="text" name="year" value="<?= $p ?>"></p>
<p>Mileage:
<input type="text" name="mileage" value="<?= $q ?>"></p>
<input type="hidden" name="autos_id" value="<?= $autos_id ?>">
<p><input type="submit" value="Save"/>
<a href="index.php">Cancel</a></p>
</form>
</body>
</html>
