<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=assignment','1234','admin');
//To see erros see bellow
//ERRMOD_WARNING just to check if there is some error, but not really usefull, EXCEPTION is far better
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/*try {
  $stmt= $pdo->prepare("SELECT * FROM autos where auto_id = :abc");
  $stmt-> execute(array(":pdw"=>$_GET['auto_id']));
}
catch (Exception $ex)
{
  echo("Internal erro, please contact support");
  error_log("Login fail ".$_POST['name']." $check");
}*/
?>
