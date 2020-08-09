<!-- Bernet Vincent week 2's assignment of "JavaScript, jQuery, and JSON" course from Coursera -->
<!-- Added so jQuerry to show and insert or not new Position (with a new table eponyme) -->

<!DOCTYPE html>
<html>
<head>
<title>Bernet Vincent Add</title>


  <!-- Personal CSS -->
<link rel="stylesheet" href="index.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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

          // Time to insert now the position entries in the table corresponding
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
      <p> Position:
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
  );}

  );
</script>
</div>

</body>
</html>
