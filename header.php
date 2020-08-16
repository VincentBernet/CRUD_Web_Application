<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="header.css" >
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
      <button id ="New-color-theme" > </button>
      <h2 class="TitreSite">
        Management Plateform
      </h2>
      <nav class="header-nav">
        <ul class="header-nav-list">

          <li>
            <a href="index.php">Index</a>
          </li>

            <?php
              if (!isset($_SESSION['email']))
              {
                echo('<li><a href="login.php">Login</a></li>');
                echo('<li><a href="register.php">Register</a></li>');
                echo('<li><a href="add.php" class="forbidden">Add New profile</a></li>');
              }
              else
              {
                echo('<li><a href="logout.php">logout</a></li>');
                echo('<a href="add.php">Add New profile</a>');

              }
            ?>
        </ul>
      </nav>
    </div>

  <script type="text/javascript">
    document.getElementById('New-color-theme').addEventListener('click', function () {
      let darkThemeEnabled = document.body.classList.toggle('dark-theme');
      document.body.classList.toggle('dark-theme');
      //document.getElementById("header").classList.toggle('dark-theme');
      localStorage.setItem('dark-theme-enabled', darkThemeEnabled);
});
  </script>
  </header>
  <body>
    hahahah
  </body>
</html>
