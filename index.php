<!-- Bernet Vincent week 1's assignment of "JavaScript, jQuery, and JSON" course from Coursera -->
<?php
require_once "pdo.php";
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title> Vincent Bernet Index</title>
  <!-- Personal CSS -->
  <link rel="stylesheet" href="index.css">
</head>
<body>
  <?php


  // View Part :

  //Test to see if the user_id is in fact in our $_SESSION so we can manage index.php to only permit user to delet or edit their own profile
  /*if (isset($_SESSION['user_id']))
  {
    echo('<p style="color:green; text-align:center">'.$_SESSION['user_id'].'</p>');
  }*/

  // Flash Message : print the result of our login / add / Logout / register action
  if (isset($_SESSION['message']))
  {
    echo('<p style="color:green; text-align:center">'.$_SESSION['message'].'</p>');
    unset($_SESSION['message']);
  }

  // If we are not login yet
  if (!isset($_SESSION["email"]))
  {
  echo('    <div class="container">
  <br>
            <div class="Titre2">Bernet Vincent\'s Resume Registry</div>
            <p><a href="login.php">Please log in</a> or if you don\'t have an account yet, you can <a a href="register.php"> Register here</a></p>
            <p>Attempt to <a href="add.php">add data</a> without logging in</p>
          <a href="logout.php">Logout</a>');}
  // When we are login-in :
  else
  {
  echo("<div class='Titre'>Vincent Bernet's Resume Registry<br>Welcome to :".$_SESSION['name']."</div>");
  echo('<table border="1" id="myTable">'."\n");

  /* Use it to permit the view only on the own user_id profile
  $sql = "SELECT user_id,profile_id,first_name,last_name,	headline FROM profile where user_id = :user_id";
  $stmt = $pdo-> prepare($sql);
  $stmt->execute(array(
    ':user_id' => $_SESSION['user_id'],));*/


  $stmt = $pdo->query("SELECT user_id,profile_id,first_name,last_name,	headline FROM profile");

  while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
      echo "<tr><td>";
      echo("<a href='#'>".htmlentities($row['first_name'])."</a  |".htmlentities($row['last_name']));
      echo("</td><td>");
      echo(htmlentities($row['headline']));
      echo("</td><td>");
      if ($row['user_id']==$_SESSION['user_id'])
      {
        echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
        echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
      }
      else
      {
        echo('Can\'t access');
      }
      echo("</td></tr>\n");}

  echo('</table><a href="add.php">Add New Entry</a>');
  echo('<br><a href="logout.php">Logout</a>');

}

  // Try to set a search button on our data view, but php seems to not be the best option, JS looks better with his interactivity
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
            echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
            echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
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


  ?>
  <br><br>






</body>
