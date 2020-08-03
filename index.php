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
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['message']) ) {
    echo '<p style="color:green">'.$_SESSION['message']."</p>\n";
    unset($_SESSION['message']);
}
if (!isset($_SESSION["email"]))
{
echo('    <div class="container">
          <h2>Welcome to the Automobiles Database</h2>
          <p><a href="login.php">Please log in</a></p>
          <p>Attempt to <a href="add.php">add data</a> without logging in</p>
        <a href="logout.php">Logout</a>');}

else if(isset($_SESSION["email"]))
{
  echo"<h2>Welcome to the Automobiles Database</h2><br>";
echo('<table border="1">'."\n");
$stmt = $pdo->query("SELECT autos_id,	make,	model,	year,	mileage FROM autos");

// Perform query
echo"There is no row";





//else {
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    echo "<tr><td>";
    echo(htmlentities($row['make']));
    echo("</td><td>");
    echo(htmlentities($row['model']));
    echo("</td><td>");
    echo(htmlentities($row['year']));
    echo("</td><td>");
    echo(htmlentities($row['mileage']));
    echo("</td><td>");
    echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
    echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
    echo("</td></tr>\n");}

//}
echo('</table><a href="add.php">Add New Entry</a>');
echo('<br><a href="logout.php">Logout</a>');}
?>

</body>
</html>
