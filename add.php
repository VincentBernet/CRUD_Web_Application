<!-- Bernet Vincent Crud Application -->
<!-- Added some jQuerry to show and insert or not new Position (with a new table eponymic) -->

<!DOCTYPE html>
<html>
<head>
<title>Bernet Vincent Add</title>
<!-- Personal Css file common for every page -->
<link rel="stylesheet" href="index.css">
<!-- Don't forget to call jQuerry librairy -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bunch of optinal commodity to make it looks better -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>

<meta charset="UTF-8" />
<body>
  <?php
    require_once "pdo.php";
    require_once "utility.php";

    session_start();
    if (!isset($_SESSION['email']))
    {
      die("<div style='text-align:center;color:pink;weight:bold;font-size:35px;margin-top:10%;'>ACCESS DENIED<br> <a href='index.php'>Back to Index</a></div>");
    }

    if (isset($_POST['cancel']))
    {
      header("Location: index.php");
      return;
    }



    flashMessages();
    if ( isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary']) )
    {
        // Check if our regular form have valid data :
        $msg = validateProfile2();
        if (is_string($msg))
        {
          $_SESSION['message'] = $msg;
          header('Location: add.php');
          return;
        }
          // Check now our position additionnal form
          $msg = validatePos();
          if (is_string($msg))
          {
            $_SESSION['message'] = $msg;
            header('Location: add.php');
            return;
          }

          $msg = validateEdu();
          if (is_string($msg))
          {
            $_SESSION['message'] = $msg;
            header('Location: add.php');
            return;
          }

          // Data are valid we can insert now
          $_SESSION["first_name"]=$_POST["first_name"];
          $_SESSION["last_name"]=$_POST["last_name"];
          $_SESSION["email"]=$_POST["email"];
          $_SESSION["headline"]=$_POST["headline"];
          $_SESSION["summary"]=$_POST["summary"];

          $sql = "INSERT INTO profile(user_id,first_name,last_name, email, headline, summary) VALUES (:user_id,:first_name,:last_name,:email,:headline, :summary)";
          $result1 = $pdo->prepare($sql);
          $result1->execute(array
          (
            ':user_id' => $_SESSION['user_id'],
            ':first_name' => htmlentities($_POST['first_name']),
            ':last_name' => htmlentities($_POST['last_name']),
            ':email' => htmlentities($_POST['email']),
            ':headline' => htmlentities($_POST['headline']),
            ':summary' => htmlentities($_POST['summary'])
          ));
          $profile_id=$pdo->lastInsertId();

          insertPositions($pdo, $profile_id);
          insertEducations($pdo, $profile_id);





          $_SESSION["message"]="<div style='color:green; text-align: center;'>Your new profile as been added</div>";
          header("Location: index.php");
          return;
      }

  ?>

  <!-- View part -->
  <?php
  echo('<div class="Titre" style="text-align:left;">Adding Profiles for '.$_SESSION["name"].'</div>');
  ?>
<div class="login-box">
  <form method="post">

    <div class="user-box">
      <p>first_name:
        <input type="text" name="first_name" size="30"/>
      </p>
    </div>

    <div class="user-box">
      <p>last_name:
        <input type="text" name="last_name" size="28"/>
      </p>
    </div>

    <div class="user-box">
      <p>email:
        <input type="text" name="email" size="31"/>
      </p>
    </div>

    <div class="user-box">
      <p>headline:
        <input type="text" name="headline" size="28"/>
      </p>
    </div>

    <div class="user-box">
      <p>summary:
        <textarea style ="background:#19273c;color:white;" name="summary" rows="3" cols="45" ></textarea>
      </p>
    </div>
    <div class="user-box">
    <p>  School: &nbsp&nbsp&nbsp&nbsp&nbsp<button id = "addEdu" type="button" >
       +
    </button>
    <!--<input type="text" size="80" name="edu_school1" class="school" value="" />-->

    </p></div>
      <div id="education_fields">
      </div>

    <div class="user-box">
      <p> Position: &nbsp&nbsp
        <button id = "addPos" type="button" >
           +
        </button>
      </p>
    </div>

    <div id="position_fields">
    </div>

    <a href="#">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
      <input class = "myButton" type="submit" value="Add"/>
      <input class = "myButton" type="submit" name ="cancel" value="Cancel"/>
    </a>
  </form>

<script type="text/javascript">
  countPos = 0;
  $(document).ready(function (){
    window.console && console.log("The dom is ready: Script begin");
    $("#addPos").click(function(event){
      event.preventDefault();
      if (countPos>=9){
        alert("Maximum of nine position entries exceeded");
        return;
      }
      countPos++;
      window.console && console.log('Adding position'+countPos);
      $('#position_fields').append(
        '<div id="position'+countPos+'"> \
        <input type="button" value="-" \
          onclick= "window.console && console.log(\'Removing position'+countPos+'\');countPos--;$(\'#position'+countPos+'\').remove();return false;"> Year: <input type="text" name="year'+countPos+'" value=""/>  \
          <textarea name="description'+countPos+'"style="background:#19273c;color:white;" rows="2" cols="45"></textarea>\
          </div><br>');

    }
  );
  countEdu = 0;
  $("#addEdu").click(function(event){
    event.preventDefault();
    if (countEdu>=9){
      alert("Maximum of nine education entries exceeded");
      return;
    }
    countEdu++;
    window.console && console.log('Adding education'+countEdu);
    $('#education_fields').append(
      '<div id="education'+countEdu+'"> \
      <input type="button" value="-" \
        onclick= "window.console && console.log(\'Removing education'+countEdu+'\');countEdu--;$(\'#education'+countEdu+'\').remove();return false;"> Year: <input type="text" name="edu_year'+countEdu+'" value=""/>  \
        <textarea name="edu_school'+countEdu+'"style="background:#19273c;color:white;" rows="2" cols="45"></textarea>\
        </div><br>');

  }
);

}
);
</script>
</div>

</body>
</html>
