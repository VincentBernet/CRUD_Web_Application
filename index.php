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
             
            <div class="Regular_Text">Before managing your teams members you need to login or register if you don\'t have an account yet.
            <br> Turn on on the Night Mode button, don\'t harm your eyes !
            <br>  This Website is a complete CRUD (Create, Read, Update, Delete) application made by Vincent Bernet as a Side project during Coursera\'s certification from the university of Michigan. <br>
            Short list of Technologies used : <br>
</div>

<ul class="Regular_Text">  <li>FrontEnd part : Html, SCSS, JavaScript ( & jQuerry )</li> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<li>BackEnd part : PHP</li>
       </ul> <div class="Regular_Text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus vestibulum volutpat ex. Aenean libero felis, cursus a lacus vitae, vestibulum congue sem. Curabitur euismod suscipit enim, nec semper elit euismod sed. Sed accumsan nec augue quis ultrices. Cras varius viverra risus sit amet interdum. Praesent blandit varius nisl, at mollis mauris. Nulla sed diam non libero euismod convallis id non mi. Duis consectetur tincidunt maximus. Suspendisse tempor velit id sem congue, vitae rutrum quam lacinia. In dapibus urna quis consectetur hendrerit. Quisque consequat et lorem fermentum faucibus. Sed ac nisi in orci lobortis ultricies. Duis malesuada turpis sed enim aliquam, vulputate varius turpis iaculis.
       Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus vestibulum volutpat ex. Aenean libero felis, cursus a lacus vitae, vestibulum congue sem. Curabitur euismod suscipit enim, nec semper elit euismod sed.
       </div>     ');}

  // When we are login-in : display seconde version of our index file
  else
  {
  echo("<div class='Titre'><br>Welcome to : ".$_SESSION['name']);
  echo("<br>Your Team's dashboard </div>");
  echo('<table border="1" id="myTable">'."\n");
  echo('<br><br><br><br>');
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
        echo('No authorization to update or delete');
      }
      echo("</td></tr>\n");}

  echo('</table><a class="linkChange2" href="add.php">Add New Entry</a>');
  // Possibility to Logout
  echo('<br><a class="linkChange2" href="logout.php">Logout</a><br><br><br><br><br>');

}?>
<br><br>
</body>

<?php
// We call our footer page
include('footer.php');?>
</html>
