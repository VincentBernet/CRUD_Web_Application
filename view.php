<!--  Bernet Vincent week 4's assignment of "Building web application" course from Coursera -->

<!DOCTYPE html>
<html>
<head>
<title>Dr. Chuck's Automobile Tracker ed59399f</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<link rel="stylesheet" href="index.css">
</head>
<body>
  <!-- View Part -->
<div class="container">
  <?php
  session_start();
  // If the user don't have a session yet, ask him to login, block him from this page
  if (!isset($_SESSION["email"]))
  {
    die("<div style='text-align:center;color:pink;weight:bold;font-size:35px;margin-top:10%;'>Not log in <br> <a href='index.php'>Back to Index</a></div>");

  }
  if (isset($_SESSION["message"]))
  {
    echo $_SESSION["message"];
  }
  echo"<h1>Tracking Autos for ".$_SESSION["email"]."</h1>";
  ?>

  <h2>Automobiles</h2>

  <?php
    require_once "pdo.php";
    $result = $pdo->query("SELECT * FROM autos ORDER BY make;");
    $result2 = $pdo->query("SELECT * FROM autos ORDER BY make;");

    echo'<table id="user"';
    while ($row = $result->fetch(PDO::FETCH_ASSOC))
    {
      echo "<tr ><td>";
      echo $row['year'];
      echo "</td><td>";
      echo $row['make'];
      echo "</td><td>";
      echo $row['mileage'];
      echo "</td></tr>";
    }
    echo '</table></p><br><br>';

    echo '<ul>';
    while ($row2 = $result2->fetch(PDO::FETCH_ASSOC))
    {
      echo "<li>".$row2['year']." ";
      echo " ".$row2['make']." /";
      echo " ".$row2['mileage']."</li>";
    }
    echo'</ul>';
  ?>
<p>
<a href="add.php">Add New</a> |
<a href="logout.php">Logout</a>
</p>
</div>
</body>
</html>
