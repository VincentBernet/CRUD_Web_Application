<!--                             Bernet Vincent week 2's assignment of "Building web application" course from Coursera -->
<?php

//  ERRMOD_WARNING just to check if there is some error, but not really usefull, EXCEPTION is far better
try {
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=assignment','1234','admin');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $check)
{
  error_log("Login fail".$_POST['name']);
}

/* Doesn't work well
try {
  $stmt= $pdo->prepare("SELECT * FROM autos where auto_id = :abc");
  $stmt-> execute(array(":pdw"=>$_GET['auto_id']));
}
catch (Exception $ex)
{
  echo("Internal erro, please contact support");
  error_log("Login fail ".$_POST['name']." $check");
} */
?>
