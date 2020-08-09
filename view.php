<!-- Bernet Vincent week 2's assignment of "JavaScript, jQuery, and JSON" course from Coursera -->
<!-- Added some jQuerry to show and insert or not new Position (with a new table eponyme) -->

<?php
require_once "pdo.php";
require_once "utility.php";
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title> Vincent Bernet Index</title>
  <!-- Personal CSS -->
  <link rel="stylesheet" href="index.css">
  <meta charset="UTF-8" />
</head>

<body>
  <br>
  <h1 class="Titre2">Profile information</h1>
  <?php
    flashMessages();
    $stmt = $pdo->prepare("SELECT first_name,last_name,email,headline,summary FROM profile  WHERE profile_id= :profile_id");
    $stmt -> execute(array
    (
      ':profile_id' => $_REQUEST['profile_id']
    ));
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
    {
        echo("<p>First name : ".htmlentities($row['first_name'])." </p>");
        echo("<p>Last name : ".htmlentities($row['last_name'])." </p>");
        echo("<p>Email : ".htmlentities($row['email'])." </p>");
        echo("<p>Headline : ".htmlentities($row['headline'])." </p>");
        echo("<p>Summary : ".htmlentities($row['summary'])." </p>");
    }
    $stmt = $pdo->prepare("SELECT year,description FROM position  WHERE profile_id= :profile_id");
    $stmt -> execute(array
    (
      ':profile_id' => $_REQUEST['profile_id']
    ));
    echo("<p> Position : <ul></p>");
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
    {
      echo("<li>Year ".htmlentities($row['year']).": ");
      echo(" ".htmlentities($row['description'])." </li>");
    }
    echo('</ul>');
  ?>

  <p>
    <a href="index.php">Done</a>
  </p>

</body>
</html>
