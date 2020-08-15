<!-- Bernet Vincent Crud Application, check the READ-ME -->

<!-- To begin with we call our pdo to link our php to our database, and we also call our utility php files, which is usefull for many functions. we end up by calling our session. -->
<?php
  require_once "pdo.php";
  session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Bernet Vincent Register</title>

<!-- Personal Css file common for every page -->
<link rel="stylesheet" href="index.css">
<meta charset="UTF-8" />
<body>

  <!-- Model Part, simple insert operation via our form to create new user which will be able to manipulate the database after the login-phase, with some data validation before it -->
  <?php
    if (isset($_POST['cancel']))
    {
      header("Location: index.php");
      return;
    }
    if(isset($_POST["name"])&&isset($_POST["email"])&&isset($_POST["password"]))
    {

        if (($_POST['name']=='')||($_POST['password']=='')||($_POST['email']==''))
        {
          $_SESSION["message"]="<div style='color:red; text-align: center;'>All values are required to register</div>";
          header("Location: register.php");
          return;
        }
        else
        {
        $sql = "INSERT INTO users(name,password, email) VALUES (:name,:password,:email)";
        $result1 = $pdo->prepare($sql);
        $result1->execute(array
        (

        ':name' => htmlentities($_POST['name']),
        ':password' => htmlentities($_POST['password']),
        ':email' => htmlentities($_POST['email'])
      ));
        $_SESSION["message"]="<div style='color:green; text-align: center;'>You are register. Welcome !</div>";
        header("Location: index.php");
        return;
      }}

  ?>

  <!-- View part -->
  <?php

  if (isset($_SESSION["message"]))
  {
    echo $_SESSION["message"];
  }
  unset($_SESSION["message"]);

  ?>

<span class="Titre"> Register Form </span>
<div class="login-box">
  <form method="post">

      <div class="user-box">
        <p>name:
          <input type="text" name="name" size="30"/>
        </p>
      </div>

      <div class="user-box">
        <p>password:
          <input type="password" name="password" size="28"/>
        </p>
      </div>

      <div class="user-box">
        <p>email:
          <input type="text" name="email" size="31"/>
        </p>
      </div>

    <!-- Our submit_box, those span tag are kind of desorienting i know, but they are just here to do some animation in css later (check index.css file) -->
      <a href="#">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <input class="myButton" type="submit" value="register"/>
        <input class="myButton" type="submit" name ="cancel" value="Cancel"/>
      </a>

  </form>
</div>

</body>
</html>
