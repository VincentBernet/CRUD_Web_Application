<!DOCTYPE html>
<html>
<head>
  <title>Test php sign-in, sign-out Vincent Bernet</title>
  <link type="text/css" rel="stylesheet" href="index.css">
</head>
<body>

<!-- Brief description on this Test-->
    <p style="text-align:center;font-family: Georgia, serif;font-size: 32px;letter-spacing: 0px;word-spacing: 0px;color: #FFB8FF;font-weight: 400;text-decoration: none solid rgb(68, 68, 68);font-style: italic;font-variant: normal;text-transform: none;">
        Html form linked to local data-base, sort of sign-in/out user<br> test also some sql injection, and some securing possibility</p>


<!-- Model part : Take the value of the html form via $_POST and use it to insert data in our database-->

  <?php
    require_once "pdo.php";
    if(isset($_POST["name"])&&isset($_POST["email"])&&isset($_POST["password"]))
    {
      $sql = "INSERT INTO users(name, email, PASSWORD) VALUES (:name,:email,:password)";
      //echo"<pre>".$sql."</pre>";
      $result1 = $pdo->prepare($sql);
      $result1->execute(array
        (':name' => $_POST['name'],
        ':email' => $_POST['email'],
        ':password' => $_POST['password']));
    }

// Still in the Model part : Take the value of the second html form, and delete the correspondant row (where user_id=correspondant row)-->
// If user_id set to one by the user, then delete the whole table.

    if (isset($_POST["user_id"])&&($_POST["user_id"]==-1)&&(isset($_POST["Delete"])))
    {
      $sql = "DELETE FROM users";
      echo '<div style="text-align:center;font-family: Arial, serif;font-size: 14px;letter-spacing: 0px;word-spacing: 0px;color: #FFB8FF;font-weight: 400;text-decoration: none solid rgb(68, 68, 68);font-style: none;font-variant: normal;text-transform: none;">
      All Table are delete </div>';
      $result = $pdo->prepare($sql);
      $result->execute(array
        (':zip'=> $_POST['user_id']));
      }
    else if(isset($_POST["user_id"]))
    {
      $sql = "DELETE FROM users WHERE user_id= :zip";
      echo"<pre>".$sql." = ".$_POST["user_id"]."</pre>";
      $result = $pdo->prepare($sql);
      $result->execute(array
        (':zip'=> $_POST['user_id']));
    }
    ?>

<!-- View part : Simple html form where the user can insert or delete row in our database (sign-in / sign-out patern)-->
<div class="insert-box">
  <h2>Create User</h2>
  <form method="post">
    <div class="user-box">
      <input type="text" name="name" size="40">
      <label>Name</label>
    </div>
    <div class="user-box">
      <input type="text" name="email" size="40">
      <label>Email</label>
    </div>
    <div class="user-box">
      <input type="password" name="password" size="40">
      <label>Password</label>
    </div>
    <a href="#">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    Submit:<input type="submit" value="      "/>
    </a>
  </form>
</div>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<div class="delete-box">
  <h2>Delete User</h2>
  <form method="post">
    <div class="user-box">
      <input type="number" name="user_id" size="40">
      <label>Choose the Id_user to delete (-1 = Whole table)</label>
    </div>
    <a href="#">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    Delete:<input type="submit" name="Delete" value="     "/>
    </a>
  </form>
</div>

<!-- View part : Just some php code to print our data base, so we can see it evolve with the user modification -->
  <?php
    echo'<br><br><br><br><br> <div style="text-align:center;font-family: Arial, serif;font-size: 14px;letter-spacing: 0px;word-spacing: 0px;color: #FFB8FF;font-weight: 400;text-decoration: none solid rgb(68, 68, 68);font-style: none;font-variant: normal;text-transform: none;">';
      print_r($_POST);
    echo'</div>';
    require_once "pdo.php";
    $result = $pdo->query("SELECT * FROM users");
    echo '<table id="user">'.'<br>';
    echo
      ("<tr>
        <th>Name</th>
        <th>Email</th>
        <th>Password</th>
        <th>Id_user</th>
        <th>Delete</th>
      </tr>");
    while ($row = $result->fetch(PDO::FETCH_ASSOC))
    {
      echo "<tr><td>";
      echo $row['name'];
      echo "</td><td>";
      echo $row['email'];
      echo "</td><td>";
      echo $row['PASSWORD'];
      echo "</td><td>";
      echo $row['user_id'];
      echo "</td><td>";
      echo  ('<form method="post"><input type="hidden"');
      echo ('name="user_id" value="'.$row['user_id'].'">'."<br>");
      echo('<input type="submit" value="Delete" name="Delete">');
      echo("</form>");
      echo "</td></tr>";
    }
    echo '</table></p>';
  ?>
</body>
</html>
