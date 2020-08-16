<!-- Bernet Vincent Crud Application, check the READ-ME -->

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

  <br>
  <?php
    // View part from the begining.
    // We call our header page
    include('header.php');
  ?>
  <h1 class="Titre2">Profile information</h1>
  <?php

    // Flash Message : print the result of our login / add / Logout / register / view action
    flashMessages();
    // Display profile information from the eponymic table.
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

    // Display Education information of the selected profile, inaddition of some data of Institution table
    $stmt = $pdo->prepare("Select year,name FROM Education JOIN Institution
      ON Education.institution_id = Institution.institution_id
      WHERE profile_id = :profile_id ORDER BY rank");
    $stmt -> execute(array
    (
      ':profile_id' => $_REQUEST['profile_id']
    ));
    echo("<p> Education : <ul></p>");
    while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
    {
      echo("<li>Year ".htmlentities($row['year']).": ");
      echo(" ".htmlentities($row['name'])." </li>");
    }
    echo('</ul>');

    // Display Position information of the selected profile
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
  <!-- Redirect to index.php when we are done at looking this profile information. -->
  <p>
    <a href="index.php">Done</a>
  </p>

</body>
</html>
