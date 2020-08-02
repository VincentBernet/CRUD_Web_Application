<!--  Bernet Vincent week 4's assignment of "Building web application" course from Coursera -->

<!DOCTYPE html>
<html>
<head>
<title>Bernet Vincent Add-Page ed59399f</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<!-- My personal css -->
<link rel="stylesheet" href="index.css">

<body>
  <?php
    require_once "pdo.php";

    session_start();
    if (!isset($_SESSION['email']))
    {
      die("<div style='text-align:center;color:pink;weight:bold;font-size:35px;margin-top:10%;'>Not log in <br> <a href='index.php'>Back to Index</a></div>");
    }

    if (isset($_POST['cancel']))
    {
      header("Location: view.php");
      return;
    }

    if(isset($_POST["make"])&&isset($_POST["year"])&&isset($_POST["mileage"]))
    {
      $_SESSION["make"]=$_POST["make"];
      $_SESSION["year"]=$_POST["year"];
      $_SESSION["mileage"]=$_POST["mileage"];

        if ($_POST['make']=='')
        {
          $_SESSION["message"]="<div style='color:red; text-align: center;'>Make is required</div>";
          header("Location: add.php");
          return;
        }
        else if ((is_numeric($_POST["year"])&&(is_numeric($_POST["mileage"]))))
        {
        $sql = "INSERT INTO autos(make, year, mileage) VALUES (:make,:year,:mileage)";
        $result1 = $pdo->prepare($sql);
        $result1->execute(array
        (':make' => htmlentities($_POST['make']),
        ':year' => htmlentities($_POST['year']),
        ':mileage' => htmlentities($_POST['mileage']),
      ));
        $_SESSION["message"]="<div style='color:green; text-align: center;'>Record inserted</div>";
        header("Location: view.php");
        return;
      }
      else if (!is_numeric($_POST["year"])||(!is_numeric($_POST["mileage"])))
      {
        $_SESSION["message"]="<div style='color:red; text-align: center;'>Mileage and year must be numeric</div>";
        header("Location: add.php");
        return;
      }
    }
  ?>

  <!-- View part -->
  <?php
  echo"<div class='Titre'>Tracking Autos for ".$_SESSION["email"]."</div>";

  if (isset($_SESSION["message"]))
  {
    echo $_SESSION["message"];
  }
  unset($_SESSION["message"]);

  ?>
<div class="login-box">


<form method="post">
    <div class="user-box">
<p>Make:
<input type="text" name="make" size="30"/></p></div>
  <div class="user-box">
<p>Year:
<input type="text" name="year" size="31"/></p></div>
  <div class="user-box">
<p>Mileage:
<input type="text" name="mileage" size="28"/></p> </div>
<a href="#">
  <span></span>
  <span></span>
  <span></span>
  <span></span>
<input type="submit" value="Add"/>
<input type="submit" name ="cancel" value="Cancel"/>
</a>
</form>
</ul>
</div>
</body>
</html>
