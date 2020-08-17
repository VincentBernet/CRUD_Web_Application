<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="header.css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  </head>

  <header class="header">
    <div class="header-container">
      <h1 class="header-logo">
        <img
          class="header-logo-img"
          src="Ressource/VB.png"
          alt="Oups my logo should have been here"
        />
      </h1>

      <h2 class="TitreSite">
        Management Plateform
      </h2>
      <nav class="header-nav">
        <ul class="header-nav-list">



            <?php
              if (!isset($_SESSION['email']))
              {
                echo('<li><a href="index.php">Home</a></li>');
                echo('<li><a href="login.php">Login</a></li>');
                echo('<li><a href="register.php">Register</a></li>');
                echo('<li><a href="add.php" class="forbidden">Add New profile</a></li>');
              }
              else
              {
                echo('<li><a href="index.php">TeamsView</a></li>');
                echo('<li><a href="logout.php">logout</a></li>');
                echo('<a href="add.php">Add New profile</a>');

              }
            ?>
        </ul>
      </nav>
      <button id="Night-button" name="Night">Night Mode</button>
    </div>


  <script type='text/javascript'>
    $(document).ready(function (){
    document.getElementById('Night-button').addEventListener('click', function () {
      let NightMode = document.body.classList.toggle('Night-Mode');
      localStorage.setItem('NightMode', NightMode);
      //localStorage.setItem('dark-theme-enabled2', darkThemeEnabled2);
});});
  </script>

  </header>
</html>
