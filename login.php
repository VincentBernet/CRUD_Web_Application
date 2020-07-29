<!--                             Bernet Vincent week 2's assignment of "Building web application" course from Coursera -->
<html>

  <head>
    <title>Bernet Vincent assignment-login c7c78f10</title>
  <link type="text/css" rel="stylesheet" href="index.css">
  </head>

  <body>
    <?php
      require_once "pdo.php";

        /* First Test : if(isset($_POST["who"]===false)&&(isset($_POST["email"])===false))
        {
          echo'hi';
        }
        if (($_POST["who"]=='')||($_POST["pass"])=='')
        {
          echo'Email and pass are required !';
        }
        else if(strpos($_POST["who"],'@') === false)
        {
          echo'Your who must contain at least one @';
        }
        else if((isset($_POST["who"]))&&($_POST["pass"]!='123'))
        {
          echo'Incorrect pass';
        }*/

        $failure = false;
        $salt = 'XyZzy12*_';
        $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';
        if (isset($_POST['cancel']))
        {
          header("Location: index.php?");
        }
        if ( isset($_POST['who']) && isset($_POST['pass']) )
        {

            if ( strlen($_POST['who']) < 1 || strlen($_POST['pass']) < 1 )
            {
                $failure = "Email and password are required";
            }
            else if (strpos($_POST["who"],'@') === false)
            {
              $failure='Email must have an at-sign (@)';
            }
            else
            {
                $check = hash('md5', $salt.$_POST['pass']);
                if ( $check == $stored_hash ) {
                    // Redirect the browser to game.php
                    $_GET['who']=$_POST['who'];
                    error_log("Login sucess ".$_POST["who"]."$check");
                    header("Location: autos.php?who=".urlencode($_GET['who']));
                    return;
                } else {
                    error_log("Login fail ".$_POST["who"]."$check");

                    $failure = "Incorrect password";
                }
            }
        }
        if ( $failure !== false ) {
            echo('<br><br><br><br><p style="color: white;text-align:center;">'.htmlentities($failure)."</p>\n");
        }?>

        <div class="Titre">
         Login Time<br>Please Log In</div>
    <div class="login-box">
      <h2>Login</h2>
      <form method="post">
        <div class="user-box">
          <input type="text" name="who" size="40" value="  ">
          <label>User name</label>
        </div>
        <div class="user-box">
          <input type="pass" name="pass" size="40" >
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
<form>
    <input type="radio" name="choice" value="Yes"/>
      <label for="Yes">Yes</label>
    <input type="radio" name="choice" value="No"/>
      <label for="No">No</label>
      <input type="submit" name="hint"/>
    </form>
<br>
    <?php
    if (isset($_GET["choice"]))
    {

    if ($_GET["choice"]=='Yes')
    {
      $Response='inline';
    }
    else {
      $Response='none';
      echo'good luck so !';
    }

    echo'<div style="display:'.$Response.'";>The password is your favorite programming language followed by the 3 first digit after 0 </div>';}?>


  </div>
  </body>

</html>
