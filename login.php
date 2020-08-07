<!-- Bernet Vincent week 1's assignment of "JavaScript, jQuery, and JSON" course from Coursera -->

<!DOCTYPE html>
<html>
<head>
<title> Vincent Bernet Login</title>
  <!-- Personal CSS -->
<link rel="stylesheet" href="index.css">
<body>
  <?php


  // We start our session and we also regenerate our id, if previously we destroy the session
  // So if for exemple the last id session was 12623 and we had destroy it,
  // it will be put back in the random pool of number of the web server id.

  session_start();
  session_regenerate_id(true);
  // We connect to our data base via our function in an external files
  require_once "pdo.php";
  // We hash our password
  $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';
  if (isset($_POST['cancel']))
  {
    header("Location: index.php");
    return;
  }


  if ( isset($_POST['email']) && isset($_POST['pass']) )
  {
      // Bunch of condition on the user input, if they are not verified then no insert in DataBase and some indication are send
      if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 )
      {
          $_SESSION["message"] = "Email and password are required";
          header("Location: login.php");
          return;
      }
      else if (strpos($_POST["email"],'@') === false)
      {
        $_SESSION["message"] ='Email must have an at-sign (@)';
        header("Location: login.php");
        return;
      }
      else
      {
      // Every input looks fine so let's verify the password
          $salt = 'XyZzy12*_';
          $check = hash('md5', $salt.$_POST['pass']);

          $stmt = $pdo->prepare('SELECT user_id, name, email FROM users WHERE email = :em AND password = :pass');
          $stmt->execute(array( ':em' => $_POST['email'], ':pass' => $check));

          $row = $stmt->fetch(PDO::FETCH_ASSOC);
          if ( $row!==false ) {
              // Right password so Redirect the browser to our view.php and add $_POST value to our Session
              $_SESSION['email']=$_POST['email'];
              $_SESSION['name'] = $row['name'];
              $_SESSION['user_id'] = $row['user_id'];
              $_SESSION["message"]="Logged In.<br>";
              // Save our error_log just in case
              error_log("Login sucess ".$_POST["email"]."$check");
              header("Location: index.php");
              return;
          } // Bad password
            else {

              error_log("Login fail ".$_POST["email"]."$check");
              $_SESSION["message"] = "Password and Email don't match (Incorrect Password or Incorrect Email).";
              unset($_SESSION["email"]);
              header("Location: login.php");
              return;


          }
      }
  }
  ?>

  <?php
  // Message if log-in, or not, or specification on what is wrong with users input
      if ( isset($_SESSION["message"]) ) {
          echo('<br><p style="color:red; text-align:center">'.$_SESSION["message"]."</p>");
          unset($_SESSION["message"]);
      }
  ?>
  <br><br>
<div class="container">
<div class="Titre2">Please Log In</div>
<form method="POST" action="login.php">
<label for="email">Email</label>
<input type="text" name="email" id="email"><br/>
<label for="id_1723">password</label>
<input type="password" name="pass" id="id_1723"><br/>
<input type="submit" onclick="return doValidate();" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>
<p>
For a password hint, view source and find an account and password hint
in the HTML comments.
<!-- Hint:
The account is umsi@umich.edu
The password is the three character name of the
programming language used in this class (all lower case)
followed by 123. -->
</p>

<script>
function doValidate() {
    console.log('Validating...');
    try {
        addr = document.getElementById('email').value;
        pass = document.getElementById('id_1723').value;
        console.log("Validating addr="+addr+" pass="+pass);
        if (addr == null || addr == "" || pass == null || pass == "") {
            alert("Both fields must be filled out");
            return false;
        }
        if ( addr.indexOf('@') == -1 ) {
            alert("Invalid email address");
            return false;
        }
        return true;
    } catch(e) {
        return false;
    }
    return false;
}
</script>

</div>
</body>
