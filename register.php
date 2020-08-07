<!-- Bernet Vincent week 1's assignment of "JavaScript, jQuery, and JSON" course from Coursera -->

<!DOCTYPE html>
<html>
<head>
<title>Bernet Vincent Register</title>


<!-- My personal css -->
<link rel="stylesheet" href="index.css">

<body>
  <?php
    require_once "pdo.php";

    session_start();

    //Test to see if the user_id is in fact in our $_SESSION so we can manage index.php to only permit user to delet or edit their own profile
    /*if (isset($_SESSION['user_id']))
    {
      echo('<p style="color:green; text-align:center">'.$_SESSION['user_id'].'</p>');
    }*/

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
  <div class="Titre"> Register Form </div>
<div class="login-box">
<form method="post">
    <div class="user-box">
<p>name:
<input type="text" name="name" size="30"/></p></div>
<div class="user-box">
<p>password:
<input type="password" name="password" size="28"/></p> </div>
  <div class="user-box">
<p>email:
<input type="text" name="email" size="31"/></p></div>

<a href="#">
  <span></span>
  <span></span>
  <span></span>
  <span></span>
<input type="submit" value="register"/>
<input type="submit" name ="cancel" value="Cancel"/>
</a>
</form>
</ul>
</div>
</body>
</html>
