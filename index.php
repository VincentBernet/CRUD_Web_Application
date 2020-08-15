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
  <!-- Personal Css file common for every page -->
  <link rel="stylesheet" href="index.css">
  <meta charset="UTF-8" />
</head>
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
            <div class="Titre2">Bernet Vincent\'s Resume Registry</div><br><br>
            <p><a href="login.php">Please log in</a> or if you don\'t have an account yet, you can <a a href="register.php"> Register here</a></p>
            <p>Attempt to <a href="add.php">add data</a> without logging in</p>
          ');}

  // When we are login-in : display seconde version of our index file
  else
  {
  echo("<div class='Titre'>Vincent Bernet's Resume Registry<br>Welcome to :".$_SESSION['name']."</div>");
  echo('<table border="1" id="myTable">'."\n");
  echo('<br><br><br>');
  // Display few data information of our user, with the option to edit, delete or view them in more detail

  $stmt = $pdo->query("SELECT user_id,profile_id,first_name,last_name,	headline FROM profile");
  while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
  {
      echo "<tr><td>";
      echo("<a href='view.php?profile_id=".$row['profile_id']."'>".htmlentities($row['first_name'])."</a  |".htmlentities($row['last_name']));
      echo("</td><td>");
      echo(htmlentities($row['headline']));
      echo("</td><td>");
      if ($row['user_id']==$_SESSION['user_id'])
      {
        echo('<a href="edit.php?profile_id='.$row['profile_id'].'&user_id='.$row['user_id'].'">Edit</a> / ');
        echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
      }
      else
      {
        echo('Can\'t access');
      }
      echo("</td></tr>\n");}

  echo('</table><a href="add.php">Add New Entry</a>');
  // Possibility to Logout
  echo('<br><a href="logout.php">Logout</a>');

}?>
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

  //<br><br>
?>
