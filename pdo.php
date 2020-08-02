<!--  Bernet Vincent week 4's assignment of "Building web application" course from Coursera -->

<?php
  try
  {
    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc','Admin','1234');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  catch (PDOException $check)
  {
    error_log("Login fail".$_POST['name']);
  }
?>
