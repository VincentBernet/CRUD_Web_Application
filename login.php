<!--  Bernet Vincent week 4's assignment of "Building web application" course from Coursera -->
<!DOCTYPE html>
<html>
<head>
<title>Vincent Bernet Login-Page ed59399f</title>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
<!-- My personal css -->
<link rel="stylesheet" href="index.css">

</head>

<body>

  <!-- Model part, and some controller part aswell-->
<?php
  // We start our session and we also regenerate our id, if previously we destroy the session
  // So if for exemple the last id session was 12623 and we had destroy it,
  // it will be put back in the random pool of number of the web server id.

  session_start();
  session_regenerate_id(true);
  // We connect to our data base via our function in an external files
  require_once "pdo.php";
  // We hash our password
  $salt = 'XyZzy12*_';
  $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';

  if (isset($_POST['cancel']))
  {
    header("Location: index.php");
    return;
  }
  // If start only if user submit something (so $_POST get a value (can be Null))
  if ( isset($_POST['email']) && isset($_POST['pass']) )
  {
      // Bunch of condition on the user input, if they are not verified then no insert in DataBase and some indication are send
      if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 )
      {
          $_SESSION["Impact"] = "Email and password are required";
          header("Location: login.php");
          return;
      }
      else if (strpos($_POST["email"],'@') === false)
      {
        $_SESSION["Impact"] ='Email must have an at-sign (@)';
        header("Location: login.php");
        return;
      }
      else
      {
      // Every input looks fine so let's verify the password
          $check = hash('md5', $salt.$_POST['pass']);

          if ( $check == $stored_hash ) {
              // Right Password so Redirect the browser to our view.php and add $_POST value to our Session
              $_SESSION['email']=$_POST['email'];
              $_SESSION["Impact"]="Logged In.<br>";
              // Save our error_log just in case
              error_log("Login sucess ".$_POST["email"]."$check");
              header("Location: index.php");
              return;
          } // Bad password
            else {

              error_log("Login fail ".$_POST["email"]."$check");
              $_SESSION["Impact"] = "Incorrect password.";
              unset($_SESSION["email"]);
              header("Location: login.php");
              return;


          }
      }
  }
?>

<!-- View Part -->
<?php
// Message if log-in, or not, or specification on what is wrong with users input
    if ( isset($_SESSION["Impact"]) ) {
        echo('<br><p style="color:red; text-align:center">'.$_SESSION["Impact"]."</p>");
        unset($_SESSION["Impact"]);
    }
?>
<!-- Login Form -->
  <div class="login-box">
    <h1 class="Titre">Please Log In</h1>
      <br><br>
    <form method="post" >
      <div class="user-box">
        <label for="email">Email</label><br><br>
        <input type="text" name="email" id="email">
      </div>

      <div class="user-box">
        <label for="pass">Password</label><br><br>
        <input type="text" name="pass" id="pass">
      </div>

      <a href="#">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <input type="submit" value="Log In"/>
        <input type="submit" name ="cancel" value="Cancel"/>
      </a>
    </form>
    <p>
      <br>
      For a password hint, view source and find an account and password hint
      in the HTML comments. (F12)
<!--
Hint:
  The account is csev@umich.edu
  The password is the three character name of the
  programming language used in this class (all lower case)
  followed by 123. -->
    </p>
  </div>
</body>
</html>
