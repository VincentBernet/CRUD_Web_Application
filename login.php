<html>
  <head>
    <title>Bernet Vincent assignment-autos</title>
  <link type="text/css" rel="stylesheet" href="index.css">
  </head>

  <body>
    <?php
      require_once "pdo.php";
        /*if(isset($_POST["name"]===false)&&(isset($_POST["email"])===false))
        {
          echo'hi';
        }
        if (($_POST["name"]=='')||($_POST["password"])=='')
        {
          echo'Email and password are required !';
        }
        else if(strpos($_POST["name"],'@') === false)
        {
          echo'Your Name must contain at least one @';
        }
        else if((isset($_POST["name"]))&&($_POST["password"]!='123'))
        {
          echo'Incorrect password';
        }*/
        $failure = false;
        $salt = 'XyZzy12*_';
        $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';
        if (isset($_POST['cancel']))
        {
          header("Location: index.php?");
        }
        if ( isset($_POST['name']) && isset($_POST['password']) )
        {

            if ( strlen($_POST['name']) < 1 || strlen($_POST['password']) < 1 )
            {
                $failure = "Email and password are required";
            }
            else if (strpos($_POST["name"],'@') === false)
            {
              $failure='Your Name must contain at least one @';
            }
            else
            {
                $check = hash('md5', $salt.$_POST['password']);
                if ( $check == $stored_hash ) {
                    // Redirect the browser to game.php
                    $_GET['name']=$_POST['name'];
                    header("Location: autos.php?name=".urlencode($_GET['name']));
                    return;
                } else {
                    echo'error_log("Login fail ".$_POST["name"]." $check")';
                    $failure = "Incorrect password";
                }
            }
        }
        if ( $failure !== false ) {
            // Look closely at the use of single and double quotes
            echo('<br><br><br><br><p style="color: white;text-align:center;">'.htmlentities($failure)."</p>\n");
        }?>

        <div class="Titre">
         Login Time<br></div>
    <div class="login-box">
      <h2>Login</h2>
      <form method="post">
        <div class="user-box">
          <input type="text" name="name" size="40" value="  ">
          <label>User Name</label>
        </div>
        <div class="user-box">
          <input type="password" name="password" size="40" >
          <label>Password</label>
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
    </div>
  </form>
  <div style="position:relative; margin-top:550px; text-align:center">
Do you wanna a small hints for the password ?<br><br>
    <input type="radio" name="choice" value="Yes" checked/>
      <label for="Yes">Yes</label>
    <input type="radio" name="choice" value="No"/>
      <label for="No">No</label>
<br> <br>
    The password is your favorite programming language followed by the 3 first digit after 0
  </div>
  </body>

</html>
