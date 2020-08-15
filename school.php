<!-- Bernet Vincent Crud Application -->

<!-- TODO Just made this file to transform some of our data to JSON type, but i didn't figure how to make it work with some jQuerry (check edit and add php files, and autocomplete function) -->
<?php

include_once("../config.php");

//No need to continue
if (!isset($_GET['term']) die('Missing required parameter'));

if (! isset($_COOKIE[session_name()]))
{
  die("Must be logged in");
}

session_start();

if (!isset($_SESSION['user_id']))
{
  die("ACCESS DENIED SCHOOL");
}

// Don't even make a database connection until we are happy with our validation
require_once'pdo.php';

header("Content-type: application/json; charset=utf-8");

$term = $_GET['term'];
error_log("Looking up typeahead term=".$term);


$stmt = $pdo->prepare('SELECT name FROM Institution WHERE name LIKE :prefix');
$stmt->execute(array( ':prefix' => $term."%"));
$retval = array();
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
  $retval[] = $row['name'];
}

echo(json_encode($retval, JSON_PRETTY_PRINT));
