<!--  Bernet Vincent week 4's assignment of "Building web application" course from Coursera -->

<!DOCTYPE html>
<html>
<head>
<title>Bernet Vincent Add</title>


  <!-- Personal CSS -->
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
    if (!isset($_SESSION['email']))
    {
      die("<div style='text-align:center;color:pink;weight:bold;font-size:35px;margin-top:10%;'>ACCESS DENIED<br> <a href='index.php'>Back to Index</a></div>");
    }

    if (isset($_POST['cancel']))
    {
      header("Location: index.php");
      return;
    }

    if(isset($_POST["first_name"])&&isset($_POST["email"])&&isset($_POST["headline"])&&isset($_POST["last_name"])&&isset($_POST["summary"]))
    {
      $_SESSION["first_name"]=$_POST["first_name"];
      $_SESSION["last_name"]=$_POST["last_name"];
      $_SESSION["email"]=$_POST["email"];
      $_SESSION["headline"]=$_POST["headline"];
      $_SESSION["summary"]=$_POST["summary"];

        if (($_POST['first_name']=='')||($_POST['last_name']=='')||($_POST['email']=='')||($_POST['headline']=='')||($_POST['summary']==''))
        {
          $_SESSION["message"]="<div style='color:red; text-align: center;'>All values are required</div>";
          header("Location: add.php");
          return;
        }
        else
        {
        $sql = "INSERT INTO profile(user_id,first_name,last_name, email, headline, summary) VALUES (:user_id,:first_name,:last_name,:email,:headline, :summary)";
        $result1 = $pdo->prepare($sql);
        $result1->execute(array
        (
        ':user_id' => $_SESSION['user_id'],
        ':first_name' => htmlentities($_POST['first_name']),
        ':last_name' => htmlentities($_POST['last_name']),
        ':email' => htmlentities($_POST['email']),
        ':headline' => htmlentities($_POST['headline']),
        ':summary' => htmlentities($_POST['summary'])
      ));
        $_SESSION["message"]="<div style='color:green; text-align: center;'>added</div>";
        header("Location: index.php");
        return;
      }}

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
<p>first_name:
<input type="text" name="first_name" size="30"/></p></div>
<div class="user-box">
<p>last_name:
<input type="text" name="last_name" size="28"/></p> </div>
  <div class="user-box">
<p>email:
<input type="text" name="email" size="31"/></p></div>
  <div class="user-box">
<p>headline:
<input type="text" name="headline" size="28"/></p> </div>
<p>summary:
  <textarea style ="background:#19273c" name="summary" rows="8" cols="45" >

  </textarea>

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
