<!-- Bernet Vincent Crud Application, check the READ-ME -->

<!-- There is a lot of stuff here, those function will be used many and many times in other file -->
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
    return '<p style="color:red; text-align:center">All fields are required</p>';
  }
  if (strpos($_POST['email'],'@')===false)
  {
    return "<p style='color:red; text-align:center'>Email address must contain @</p>";
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
      return '<p style="color:red; text-align:center">All fields are required</p>';
    }

    if ( ! is_numeric($year) ) {
      return '<p style="color:red; text-align:center">Position year must be numeric</p>';
    }
  }
  return true;
}

function validateEdu() {
  for($i=1; $i<=9; $i++) {
    if ( ! isset($_POST['edu_year'.$i]) ) continue;
    if ( ! isset($_POST['edu_school'.$i]) ) continue;

    $edu_year = $_POST['edu_year'.$i];
    $school_name = $_POST['edu_school'.$i];

    if ( strlen($edu_year) == 0 || strlen($school_name) == 0 ) {
      return '<p style="color:red; text-align:center">All fields are required</p>';
    }

    if ( ! is_numeric($edu_year) ) {
      return '<p style="color:red; text-align:center">Studies year must be numeric</p>';
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

function loadEdu($pdo,$profile_id)
{
  $stmt = $pdo->prepare('Select year,name FROM Education JOIN Institution
    ON Education.institution_id = Institution.institution_id
    WHERE profile_id = :prof ORDER BY rank');
  $stmt->execute(array(':prof' => $profile_id));
  $educations = array();
  while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
  {
    $educations[] = $row;
  }
  return $educations;
}

// Insert the position entries
function insertPositions($pdo, $profile_id)
{
  $rank = 1;
  for ($i=1; $i<=9; $i++)
  {
    if (!isset($_POST['year'.$i])) continue;
    if (!isset($_POST['description'.$i])) continue;
    $year = $_POST['year'.$i];
    $description = $_POST['description'.$i];
    $stmt = $pdo->prepare('INSERT INTO Position
      (profile_id, rank, year, description )
      VALUES (:profile_id,:rank,:year,:description)');
      $stmt-> execute(array(
        ':profile_id' => $profile_id,
        ':rank' => $rank,
        ':year' => $year,
        ':description' => $description)
      );
    $rank++;
  }
}

// Insert the education entries TODO
function insertEducations($pdo, $profile_id)
{
  $rank = 1;
  for ($i=1; $i<=9; $i++)
  {
    if (!isset($_POST['edu_year'.$i])) continue;
    if (!isset($_POST['edu_school'.$i])) continue;
    $year = $_POST['edu_year'.$i];
    $school = $_POST['edu_school'.$i];

    //Lookup the school if it is here
    $institution_id = false;
    $stmt = $pdo-> prepare('SELECT institution_id FROM Institution WHERE name=:name');
    $stmt -> execute(array(':name'=>$school));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if ($row !== false) $institution_id = $row['institution_id'];

    // If there was no institution, insert interface
    if ( $institution_id === false )
    {
      $stmt = $pdo -> prepare('INSERT INTO Institution (name) VALUES (:name)');
      $stmt-> execute(array(':name' => $school));
      $institution_id = $pdo -> lastInsertID();
    }

    $stmt = $pdo->prepare('INSERT INTO Education
      (profile_id, rank, year, institution_id )
      VALUES (:profile_id, :rank, :year, :institution_id)');
      $stmt-> execute(array(
        ':profile_id' => $profile_id,
        ':rank' => $rank,
        ':year' => $year,
        ':institution_id' => $institution_id)
      );
    $rank++;
  }
}

function flashMessages()
{
  if (isset($_SESSION['message']))
  {
    echo($_SESSION['message']);
    unset($_SESSION['message']);
  }
}
