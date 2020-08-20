<!-- Bernet Vincent Crud Application, check the READ-ME -->
<!-- Index page : 2 different views, depends if the user is connected or not. -->


<!-- To begin with we call our pdo to link our php to our database, and we also call our utility php files, which is usefull for many functions. we end up by calling our session. -->
<?php
require_once "pdo.php";
require_once "utility.php";
session_start();
?>


<!DOCTYPE html>
<html>
<head>
  <title> Vincent Bernet Index</title>
  <!-- Personal Css file common for every page-->
  <link rel="stylesheet" href="index.css">
  <meta charset="UTF-8" />
</head>
<?php
// We call our header page
include('header.php');?>
<body>
  <?php
  // Begining of the View Part :


  // Flash Message : print the result of our login / add / Logout / register action
  flashMessages();
  
  // If we are not login yet : display first version of our index file
  if (!isset($_SESSION["email"]))
  {
  echo('    <div class="container">
  <br>
            <h1 class="Titre2">Welcome to the new way of managing your teams collaborator.</h1><br><br>
             <br>
            <div class="Regular_Text">Before managing your teams members you need to login or register if you don\'t have an account yet.
            <br> Turn on on the Night Mode button, don\'t harm your eyes !
            <br>  This Website is a complete CRUD (Create, Read, Update, Delete) application made by Vincent Bernet as a Side project during Coursera\'s certification from the university of Michigan. <br>
            Short list of Technologies used : <br><ul> FrontEnd part : <li>Html, SCSS, JavaScript ( & jQuerry )</li> BackEnd part : <li> PHP,
</div>
            ');}

  // When we are login-in : display seconde version of our index file
  else
  {
  echo("<div class='Titre'><br>Welcome to :".$_SESSION['name']);
  echo("<br>Your Team's dashboard </div>");
  echo('<table border="1" id="myTable">'."\n");
  echo('<br><br><br>');
  // Display few data information of our user, with the option to edit, delete or view them in more detail

  $stmt = $pdo->query("SELECT user_id,profile_id,first_name,last_name,	headline FROM profile");
  while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
  {
      echo ('<tr><td>');
      echo('<a class="linkChange2" href="view.php?profile_id='.$row["profile_id"].'">'.htmlentities($row["first_name"]).'</a  |'.htmlentities($row["last_name"]));
      echo('</td><td>');
      echo(htmlentities($row["headline"]));
      echo('</td><td>');
      if ($row['user_id']==$_SESSION['user_id'])
      {
        echo('<a class="linkChange2" href="edit.php?profile_id='.$row['profile_id'].'&user_id='.$row['user_id'].'">Edit</a> / ');
        echo('<a class="linkChange2" href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
      }
      else
      {
        echo('Can\'t access');
      }
      echo("</td></tr>\n");}

  echo('</table><a class="linkChange2" href="add.php">Add New Entry</a>');
  // Possibility to Logout
  echo('<br><a class="linkChange2" href="logout.php">Logout</a>');

}?>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
</body>
</html>


<?php
  // TODO Try to set a search button on our data view, but php seems to not be the best option, JS looks better with his interactivity
  /*else
  {
    echo("<div class='Titre'>Vincent Bernet's Resume Registry<br>Welcome to :".$_SESSION['name']."</div>");
    echo('<table border="1">'."\n");
    $sql = "SELECT user_id,profile_id,first_name,last_name,	headline FROM profile WHERE first_name LIKE :first_name% ";
    $stmt = $pdo-> prepare($sql);
    $stmt->execute(array(
      ':first_name' => $_POST['search']));
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
          echo "<tr><td>";
          echo(htmlentities($row['first_name'])." | ".htmlentities($row['last_name']));
          echo("</td><td>");
          echo(htmlentities($row['headline']));
          echo("</td><td>");
          if ($row['user_id']==$_SESSION['user_id'])
          {
            echo('<a class="link" href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
            echo('<a class="link" href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
          }
          else
          {
            echo('Can\'t access');
          }
          echo("</td></tr>\n");}
          echo("<form method='post'>
            <p> Search
            <input type='text' name='search'/> </p>
            <input type='submit' value='Add'/>
          </form>");
  }*/

  //<br><br>
?>
