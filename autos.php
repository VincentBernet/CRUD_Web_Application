<html>
  <head>
    <title>Bernet Vincent assignment-Autos c7c78f10</title>
  <link type="text/css" rel="stylesheet" href="index.css">
  </head>

  <body>
<!-- Model part : -->
<?php
  require_once "pdo.php";
  if (!isset($_GET['who']))
  {
    die("<div style='text-align:center;color:pink;weight:bold;font-size:35px;margin-top:30%;'>Name parameter is missing</div>");
  }
  if (isset($_POST["log-out"]))
  {
    header("Location: index.php?");
  }
  if(isset($_POST["make"])&&isset($_POST["year"])&&isset($_POST["mileage"])&&isset($_POST['Url']))
  {

    if ((is_numeric($_POST["year"])&&(is_numeric($_POST["mileage"]))))
    {
      $sql = "INSERT INTO autos(make, year, mileage, Url) VALUES (:make,:year,:mileage,:Url)";
      $result1 = $pdo->prepare($sql);
      $result1->execute(array
      (':make' => htmlentities($_POST['make']),
      ':year' => htmlentities($_POST['year']),
      ':mileage' => htmlentities($_POST['mileage']),
      ':Url' => htmlentities($_POST['Url']),
    ));
      echo"<div style='color:green; text-align: center;'>Record inserted</div>";
    }
    else if (strlen($_POST['make'])<1)
    {
      echo"Make is required";
    }
    else if (!is_numeric($_POST["year"])||(!is_numeric($_POST["mileage"])))
    {
      echo"Mileage and year must be numeric";
    }



  }
  ?>



<!-- View part : Simple html form where the user can insert or delete row in our database (sign-in / sign-out patern)-->
<?php echo"<div class='Titre' >
 Tracking Autos for<br>".$_GET['who']."</div>";
 $oldmake = isset($_POST['make'])? $_POST['make'] : '';
 $oldyear = isset($_POST['year'])? $_POST['year'] : '';
 $oldmileage = isset($_POST['mileage'])? $_POST['mileage'] : '';
 $oldUrl = isset($_POST['Url'])? $_POST['Url'] : '';
 ?>
<div class="login-box">
  <h2>Create User</h2>
  <form method="post">
    <div class="user-box">
      <input type="text" name="make" size="40" value="<?= $oldmake?>">
      <label>Make:</label>
    </div>
    <div class="user-box">
      <input type="text" name="year" size="40" value="<?= htmlentities($oldyear)?>">
      <label>Year:</label>
    </div>
    <div class="user-box">
      <input type="text" name="mileage" size="40" value="<?= htmlentities($oldmileage)?>">
      <label>Mileage</label>
    </div>
    <div class="user-box">
      <input type="text" name="Url" size="40" value="<?= htmlentities($oldUrl)?>">
      <label>Url</label>
    </div>
    <a href="#">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    Submit:<input type="submit" value="Add"/>
    Log-Out:<input type="submit" name="logout" value="logout"/>
    </a>
  </form>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<?php

  require_once "pdo.php";
  $result = $pdo->query("SELECT * FROM autos ORDER BY make;");
  echo '<table id="user"';


    while ($row = $result->fetch(PDO::FETCH_ASSOC))
    {
      echo "<tr ><td>";
      echo $row['year'];
      echo "</td><td>";
      echo $row['make'];
      echo "</td><td>";
      echo $row['mileage'];
      echo "</td><td>";
      if ((strpos($row['Url'],'http://')!==false)||(strpos($row['Url'],'https://')!==false))
      {
        echo ('<a href="'.$row['Url'].'">'."Automobile Link : ".$row['Url']."</a>");
      }
      else {echo('No links');}
      echo"</td></tr>";
    }
    echo '</table></p>';

  //style="display:none">'.'<br>';

?>


</body>

</html>
