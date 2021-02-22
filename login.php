<!-- Bernet Vincent Crud Application, check the READ-ME -->


<!DOCTYPE html>
<html>
<head>
<title> Vincent Bernet Login</title>
<!-- Personal Css file common for every page -->
<link rel="stylesheet" href="index.css">
<meta charset="UTF-8" />
<body>

  <?php
  // We start our session and we also regenerate our id, in case if previously we destroyed the session
  // So if for exemple the last id session was 12623 and we had destroy it,
  // it will be put back in the random pool of number of the web server id.
  session_start();
  session_regenerate_id(true);

  // We connect to our data base via our function in an external files
  require_once "pdo.php";
  // We call our personnal librairy
  require_once "utility.php";
  // We hash our password
  $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';

  // Redirection to index if cancel button is clicked
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
          $_SESSION["message"] = '<span style="color:red;weight:bold;text-align:center;">Email and password are required</span>';
          header("Location: login.php");
          return;
      }

      else if (strpos($_POST["email"],'@') === false)
      {
        $_SESSION["message"] ='<span style="color:red;weight:bold;text-align:center;">Email must have an at-sign (@)</span>';
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
              // Right password so we redirect the browser to our index.php and add $_POST value to our Session
              $_SESSION['email']=$_POST['email'];
              $_SESSION['name'] = $row['name'];
              $_SESSION['user_id'] = $row['user_id'];
              $_SESSION["message"]='<span style="color:green;weight:bold;text-align:center;">Logged In.</span><br>';
              // Save our error_log just in case
              error_log("Login sucess ".$_POST["email"]."$check");
              header("Location: index.php");
              return;
          } // in case of Bad password, load login page again, with an error message via our session
            else {

              error_log("Login fail ".$_POST["email"]."$check");
              $_SESSION["message"] = '<span style="color:red;weight:bold;text-align:center;">Password and Email don\'t match (Incorrect Password or Incorrect Email).';
              unset($_SESSION["email"]);
              header("Location: login.php");
              return;


          }
      }
  }
  // View part from the begining.
  include('header.php');
  // Flash Message if log-in, or not, or specification on what is wrong with users input
      flashMessages();
  ?>
  <br><br>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  <!-- Our login form -->
<div class="login-box">
  <div class="Titre2">Please Log In</div>
  <form method="POST" action="login.php" autocomplete="off">

    <div class="user-box">
      <p>Email:
        <input type="text" name="email" id="email" >
      </p>
    </div>
    <span class="user-box">
      Password:
        <input type="password" name="pass" id="id_1723">
    </span>

    <!-- Our submit_box, those span tag are kind of desorienting i know, but they are just here to do some animation in css later (check index.css file) -->
    <a href="#">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <input class="myButton" type="submit" onclick="return doValidate();" value="Log In">
      <input class="myButton" type="submit" name="cancel" value="Cancel">
    </a>
  </form>
<p>
  For a password hint, view source and find an account and password hint   <!-- Hint:
                                                                            The account is vincent.bernet@gmail.com
                                                                            The password is the three character name of the
                                                                            programming language used in this class (all lower case)
                                                                            followed by 123. -->
  in the HTML comments. <br><br> Admin@gmail.com Mdp: Admin
</p>
<!-- Some JavaScript validation, with pop up alert if wrong value entered -->
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
<?php
// We call our header page
include('footer.php');?>
</html>