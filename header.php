<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="header.css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  </head>
  <br>
  <header id="header">
    <div class="header-container">
      <h1 class="header-logo">
        <img
          class="header-logo-img"
          src="Ressource/VB.png"
          alt="Oups my logo should have been here"
        />
      </h1>
      
      <h2 id="TitreSite">
        Management Plateform
      </h2>
      <nav class="header-nav">
        <ul class="header-nav-list">



            <?php
              if (!isset($_SESSION['email']))
              {
                echo('<li><a class="linkChange" href="index.php">Home</a></li>');
                echo('<li><a class="linkChange" href="login.php">Login</a></li>');
                echo('<li><a class="linkChange" href="register.php">Register</a></li>');
                echo('<li><a class="linkChange forbidden" href="add.php">Add New profile</a></li>');
              }
              else
              {
                echo('<li><a class="linkChange" href="index.php">TeamsView</a></li>');
                echo('<li><a class="linkChange" href="logout.php">logout</a></li>');
                echo('<a class="linkChange" href="add.php">Add New profile</a>');

              }
            ?>
        </ul>
      </nav>
      
      <span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span>
     


    </div>
    </header>

    
    <button id="Night-button" name="Night">Night Mode</button>
    <audio id="myAudio"  src="Ressource/click.mp3" type="audio/mpeg"></audio>
  <script type='text/javascript'>
    $(document).ready(function (){
    document.getElementById('Night-button').addEventListener('click', function () {

      document.getElementById("myAudio").play();
      let NightMode = document.body.classList.toggle('Night-Mode');
      localStorage.setItem('NightMode', NightMode);

      let HeaderElement = document.querySelector("#header");
        HeaderElement.classList.toggle("Night-Mode");
      
      let TitleElement = document.querySelector("#TitreSite");
        TitleElement.classList.toggle("Titre-Night-Mode");

        let NavElement = document.querySelectorAll(".linkChange");
        for (i=0;i<NavElement.length;i++)
        {
          NavElement[i].classList.toggle("ChangeColor");
        }
        
        let LinkElement = document.querySelectorAll(".linkChange2");
        for (i=0;i<LinkElement.length;i++)
        {
          LinkElement[i].classList.toggle("ChangeColor");
        }
        
        

      
        
});
      
    
    //localStorage.setItem('dark-theme-enabled2', darkThemeEnabled2);
    if (JSON.parse(localStorage.getItem('NightMode'))) {
        document.body.classList.add('Night-Mode');
        document.querySelector("#header").classList.add("Night-Mode");
        document.querySelector("#TitreSite").classList.add("Titre-Night-Mode");


        let NavElement = document.querySelectorAll(".linkChange");
        for (i=0;i<NavElement.length;i++)
        {
          NavElement[i].classList.add("ChangeColor");
        }
        
        let LinkElement = document.querySelectorAll(".linkChange2");
        for (i=0;i<LinkElement.length;i++)
        {
          LinkElement[i].classList.add("ChangeColor");
        }
    }});
    

        
  </script>


  
</html>
