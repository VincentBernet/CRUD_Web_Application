<html>
  <head>
    <title>Bernet Vincent assignment-Index</title>
  <link type="text/css" rel="stylesheet" href="index.css">
  </head>

  <body>
<!-- Model part : -->
<?php
  require_once "pdo.php";
  if (isset($_POST["log-out"]))
  {
    echo'gg wp';
    header("Location: index.php?");
  }
  if(isset($_POST["make"])&&isset($_POST["year"])&&isset($_POST["mileage"]))
  {
    $sql = "INSERT INTO autos(make, year, mileage) VALUES (:make,:year,:mileage)";
    //echo"<pre>".$sql."</pre>";
    $result1 = $pdo->prepare($sql);
    $result1->execute(array
      (':make' => $_POST['make'],
      ':year' => $_POST['year'],
      ':mileage' => $_POST['mileage']));
  }
  ?>



<!-- View part : Simple html form where the user can insert or delete row in our database (sign-in / sign-out patern)-->
<?php echo"<div class='Titre' >
 Tracking Autos for<br>".$_GET['name']."</div>";?>
<div class="login-box">
  <h2>Create User</h2>
  <form method="post">
    <div class="user-box">
      <input type="text" name="make" size="40">
      <label>Make:</label>
    </div>
    <div class="user-box">
      <input type="number" name="year" size="40">
      <label>Year:</label>
    </div>
    <div class="user-box">
      <input type="number" name="mileage" size="40">
      <label>Mileage</label>
    </div>
    <a href="#">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    Submit:<input type="submit" value="   "/>
    Log-Out:<input type="submit" name="log-out" value="    "/>
    </a>
  </form>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<?php
  echo'<br><br><br><br><br> <div style="text-align:center;font-family: Arial, serif;font-size: 14px;letter-spacing: 0px;word-spacing: 0px;color: #FFB8FF;font-weight: 400;text-decoration: none solid rgb(68, 68, 68);font-style: none;font-variant: normal;text-transform: none;">';
    print_r($_POST);
  echo'</div>';
  require_once "pdo.php";
  $result = $pdo->query("SELECT * FROM autos");
  echo '<table id="user">'.'<br>';
  echo
    ("<tr>
      <th>Year</th>
      <th>Make</th>
      <th>Mileage</th>
    </tr>");
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
  echo '</table></p>';
?>


</body>

</html>
