<!-- Bernet Vincent week 2's assignment of "JavaScript, jQuery, and JSON" course from Coursera -->
<!-- Added some jQuerry to show and insert or not new Position (with a new table eponyme) -->

<?php
function validateProfile()
{
  if ( $_POST['first_name'] == "" || $_POST['last_name'] == "" || $_POST['email'] == "" || $_POST['headline'] == "" ||  $_POST['summary'] == "" )
  {
    $_SESSION['message']= '<p style="color:red;weight:bold; text-align:center">All files are required / Missing Data</p>';
    header("Location: add.php");
    return;
  }
  if ( strpos($_POST['email'], '@') === false)
  {
    $_SESSION['message']= '<p style="color:red; text-align:center">Email address must contain @</p>';
    header("Location: add.php");
    return;
  }
  return true;
}

function validateProfile2()
{
  if (strlen($_POST['first_name']) == 0 ||strlen($_POST['last_name']) == 0 ||
  strlen($_POST['email']) == 0 ||strlen($_POST['headline']) == 0 ||
  strlen($_POST['summary']) == 0)
  {
    return "All fields are required";
  }
  if (strpos($_POST['email'],'@')===false)
  {
    return "Email address must contain @";
  }
  return true;
}

function validatePos() {
  for($i=1; $i<=9; $i++) {
    if ( ! isset($_POST['year'.$i]) ) continue;
    if ( ! isset($_POST['description'.$i]) ) continue;

    $year = $_POST['year'.$i];
    $desc = $_POST['description'.$i];

    if ( strlen($year) == 0 || strlen($desc) == 0 ) {
      return "All fields are required";
    }

    if ( ! is_numeric($year) ) {
      return "Position year must be numeric";
    }
  }
  return true;
}

function loadPos($pdo,$profile_id)
{
  $stmt = $pdo->prepare('Select * FROM Position
    WHERE profile_id = :prof ORDER BY rank');
  $stmt->execute(array(':prof' => $profile_id));
  $positions = array();
  while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
  {
    $positions[] = $row;
  }
  return $positions;
}

function flashMessages()
{
  if (isset($_SESSION['message']))
  {
    echo($_SESSION['message']);
    unset($_SESSION['message']);
  }
}
