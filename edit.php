<!-- Bernet Vincent Crud Application, check the READ-ME -->
<!-- Added some jQuerry to show and insert or not new Position (with a new table eponymic) and new Education (with 2 new tables, Institution and Education) -->

<!-- To begin with we call our pdo to link our php to our database, and we also call our utility php files, which is usefull for many functions. we end up by calling our session. -->
<?php
require_once "pdo.php";
require_once "utility.php";
session_start();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Vincent Bernet Edit</title>
  <!-- Personal Css file common for every page -->
  <link rel="stylesheet" href="index.css">
  <!-- Don't forget to call jQuerry librairy -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <meta charset="UTF-8" />
</head>
<body>
<?php

// First check if the user is logged in
if (!isset($_SESSION['email']))
{
  die("<div style='text-align:center;color:pink;weight:bold;font-size:35px;margin-top:10%;'>ACCESS DENIED<br> <a href='index.php'>Back to Index</a></div>");
}

// Second redirect to index.php if user wants to cancel
if (isset($_POST['cancel']))
{
  header("Location: index.php");
  return;
}

// Third make sure the REQUEST parameter is present
if (! isset($_REQUEST['profile_id']))
{
  $_SESSION['message'] = "<span style='color:red;text-align:cernet;weight:bold;'>Missing profile_id</span>";
  header('Location: index.php');
  return;
}



// Fifth: We can now start obsverving our data in our form and proceed to the update
if ( isset($_POST['first_name']) && isset($_POST['last_name'])&& isset($_POST['email'])&& isset($_POST['headline']) && isset($_POST['summary']) )
{

  // Data validation of basic inputs in our utility file, if false we stop and print the error on the same page
  $msg1 = validateProfile2();
  // Data validation in our utility file on Position related inputs, if false we stop and print the error on the same page
  $msg2 = validatePos();
  // Data validation in our utility file on Education related inputs, if false we stop and print the error on the same page
  $msg3 = validateEdu();
  if (is_string($msg1))
  {
    $_SESSION['message'] = $msg1;
    header('Location: edit.php?profile_id='. $_REQUEST["profile_id"]);
    return;
  }

  else if (is_string($msg2))
  {
    $_SESSION['message'] = $msg2;
    header('Location: edit.php?profile_id='. $_REQUEST["profile_id"]);
    return;
  }
  else if (is_string($msg3))
  {  
    $_SESSION['message'] = $msg3;
    header('Location: edit.php?profile_id='. $_REQUEST["profile_id"]);
    return;
  }

  else {
  //Begin to update our DataBase Profiles
  $sql = "UPDATE profile SET first_name = :first_name, last_name = :last_name, email = :email, headline = :headline, summary = :summary
          WHERE profile_id=:profile_id AND user_id= :user_id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
        ':first_name' => $_POST['first_name'],
        ':last_name' => $_POST['last_name'],
        ':email' => $_POST['email'],
        ':headline' => $_POST['headline'],
        ':summary' => $_POST['summary'],
        ':profile_id' => $_REQUEST['profile_id'],
        ':user_id' => $_SESSION['user_id'])
      );

  // Clear out the old position entries
  $stmt = $pdo -> prepare('DELETE FROM Position WHERE profile_id=:profile_id');
  $stmt -> execute(array( ':profile_id' => $_REQUEST['profile_id']));

  // Insert the position entries
  insertPositions($pdo, $_REQUEST['profile_id']);

  // Clear out the old educations entries
  $stmt = $pdo -> prepare('DELETE FROM Education WHERE profile_id=:profile_id');
  $stmt -> execute(array( ':profile_id' => $_REQUEST['profile_id']));

  // Insert the education entries
  insertEducations($pdo, $_REQUEST['profile_id']);

  $_SESSION['message'] = '<span style="color:green;weight:bold;text-aligne:center;">Record Updated</span>';
  header("Location: index.php");
  return;
}}

//load up all the positions and educations rows
$positions=loadPos($pdo,$_REQUEST['profile_id']);
$schools= loadEdu($pdo,$_REQUEST['profile_id']);

// Sixth: Verify is this profile_id exist (if it correspond to a row in our database)
$stmt = $pdo->prepare("SELECT * FROM profile where profile_id = :profile_id");
$stmt->execute(array(":profile_id" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['message'] = '<span style="color:red;weight:bold;text-aligne:center;">Bad value for profile_id, this profile doesn\'t exist</span>';
   
    header("Location: index.php");
    return;
}

// Seventh : Verify if this profile_id is link to our current user_id
$stmt = $pdo->prepare("SELECT * FROM profile where profile_id = :profile_id AND user_id= :user_id");
$stmt->execute(array(":profile_id" => $_GET['profile_id'],":user_id" => $_GET['user_id'] ));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['message'] = '<span style="color:red;weight:bold;text-aligne:center;">You can\'t modify a profile that was not create by your account</span>';
    header("Location: index.php");
    return;
}

// Define some abreviation variable for the form bellow with inside a copy of profile's data selectionned to be changed.
$n = htmlentities($row['first_name']);
$e = htmlentities($row['last_name']);
$p = htmlentities($row['email']);
$q = htmlentities($row['headline']);
$v =  htmlentities($row['summary']);
$y = htmlentities($row['profile_id']);
$profile_id = $row['profile_id'];

require_once "header.php";
//  Flash Message -> print the result of our login / add / Logout / register action
flashMessages();
?>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<!-- View part : Our Edit form -->
<div class="add-box">
  <h1 class="Titre2">Editing Profile for UMSI</h1>
  <form method="post" action="edit.php">

      <p>First Name:
        <input type="text" class="fields_edit" name="first_name" size="43" value="<?= $n ?>"/>
      </p>

      <p>Last Name:
        <input type="text" class="fields_edit" name="last_name" size="43" value="<?= $e ?>"/>
      </p>

      <p>Email: &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
        <input type="text"  class="fields_edit" name="email" size="43"value="<?= $p ?>"/>
      </p>

      <p>Headline: &nbsp&nbsp
        <input type="text" class="fields_edit" name="headline" size="43" value="<?= $q ?>"/>
      </p>

      <p>Summary:<br/>
        <textarea name="summary" class="fields_edit" rows="8" cols="40" ><?= $v ?></textarea>
      </p>

      <?php
        //We print the current (/old) Education data of the profile selected to be edited
        $countEdu = 0;
        echo('<p> Education:&nbsp <input type ="submit" id = "addEdu" value="+">'."\n");
        echo('<div id="edu_fields">'."\n");
        if ( count($schools)>0)
        {
          foreach($schools as $school)
          {
            $countEdu++;
            echo('<div id="edu'.$countEdu.'">');
            echo('<p>Universities Year: <input type="text" class="fields_edit" name="edu_year'.$countEdu.'" value ="'.$school['year'].'"/>
            <input type ="button" value ="-" onclick="$(\'#edu'.$countEdu.'\').remove(); return false;"></p>
            <p>School Name:&nbsp&nbsp&nbsp&nbsp&nbsp <input type="text" class="fields_edit" size="43" name="edu_school'.$countEdu.'" class="school"
            value = "'.htmlentities($school['name']).'"/>');
            echo("\n</div>\n");
          }
        }
        echo("</div></p>\n");
        ?>
        <!-- Here, this fields gonna be the place where Education inputs gonna be add -->
        <div id="education_fields">

        </div>
        <?php
        //We print the current (/old) Position data of the profile selected to be edited
        $countPos = 0;
        echo('<p> Position: &nbsp&nbsp&nbsp <input type ="submit" id = "addPos" value="+">'."\n");
        echo('<div id="position_fields">'."\n");
        if ( count($positions)>0)
        {
          foreach($positions as $position)
          {
            $countPos++;
            echo('<div class = "position" id="position'.$countPos.'">');
            echo('<p>Positions Year: <input type="text" class="fields_edit" name="year'.$countPos.'" value ="'.htmlentities($position['year']).'"/>
            <input type ="button" value ="-" onclick="$(\'#position'.$countPos.'\').remove(); return false;"><br>');
            echo('<textarea class="fields_edit" name="desc'.$countPos.'"rows="8" cols="40">'."\n");
            echo(htmlentities($position['description'])."\n");
            echo("\n</textarea>\n</div>\n");
          }
        }
        echo("</div></p>\n");
       ?>

       <!-- Here, this fields gonna be the place where Position inputs gonna be add -->
      <div id="position_fields">

      </div>

      <!-- Our submit_box, those span tag are kind of desorienting i know, but they are just here to do some animation in css later (check index.css file) -->
      <p class="submit_box">
        <a href="#">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
          <input class="myButton" type="hidden" name="profile_id" value="<?= $y ?>"/>
          <input class="myButton" type="submit" value="Save">
          <input class="myButton" type="submit" name ="cancel" value="Cancel"/>

          <!--<a id="CancelButton" href="http://crud-vb.epizy.com/index.php">Cancel</a>-->
        </a>
      </p>
  </form>
</div>

  <script type="text/javascript">
  // Adding Clicking event, when the user click on "+", so we add a new field for education or position inputs
    countPos = 0;
    $(document).ready(function (){
      window.console && console.log("The dom is ready: Script begin");
      $("#addPos").click(function(event){
        event.preventDefault();
        if (countPos>=3){
          alert("Maximum of three position entries exceeded");
          return;
        }

        countPos++;
        // Kind of dirty code here, just to create new position related fields
        window.console && console.log('Adding position'+countPos);
        $('#position_fields').append(
          '<div id="position'+countPos+'"> \
          <input type="button" value="-" \
            onclick= "window.console && console.log(\'Removing position'+countPos+'\');countPos--;$(\'#position'+countPos+'\').remove();return false;">Positions Year: <input type="text" class="fields_edit" placeholder="<? $rand=rand(1900,2020);echo($rand);?>" name="year'+countPos+'" value=""/>  \
            <textarea class="fields_edit" placeholder="Positions description :" name="description'+countPos+'" rows="2" cols="45"></textarea>\
            </div><br>');});



        countEduc = 0;
        $("#addEdu").click(function(event){
            event.preventDefault();
              if (countEduc>=3)
              {
                alert("Maximum of three education entries exceeded");
                return;
              }
              countEduc++;
              // Kind of dirty code here, just to create new education related fields
              window.console && console.log('Adding education'+countEduc);
                $('#education_fields').append(
                  '<div id="education'+countEduc+'"> \
                  <input type="button" value="-" \
                    onclick= "window.console && console.log(\'Removing education'+countEduc+'\');countEduc--;$(\'#education'+countEduc+'\').remove();return false;"> Studies year: <input type="text" class="fields_edit" placeholder="<? $rand=rand(1900,2020);echo($rand);?>" name="edu_year'+countEduc+'" value=""/>  \
                    <textarea class="school fields_edit" placeholder="Universities Name" name="edu_school'+countEduc+'" rows="2" cols="45"></textarea>\
                    </div><br>');


      }
    );
  });



  </script>
</div>
</body>

<?php
// We call our header page
include('footer.php');?>
</html>
