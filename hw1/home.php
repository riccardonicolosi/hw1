<?php 
    require_once 'auth.php';
    if (!$userid = checkAuth()) {
        header("Location: login.php");
        exit;
    }
?>

<html>
  <?php 
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['name'], $dbconfig['user'], $dbconfig['password']);
    $userid = mysqli_real_escape_string($conn, $userid);
    $query = "SELECT * FROM users WHERE id = $userid";
    $res = mysqli_query($conn, $query);
    $userinfo = mysqli_fetch_assoc($res);
  ?>

  <head>
    <title>Lookin'4Food</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&display=swap" rel="stylesheet">         
    <meta charset="utf-8">
    <link rel="stylesheet" href="home.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="home.js" defer="true"></script>
  </head>
  
  <body>
    <div id="overlay" class="hidden">
    </div>
    <header>
      <nav>
        <div id="logo">
          Lookin'4Food
        </div>
        <div id="links">
          <a>HOME</a>
          <a>RANDOMIZER</a>
          <a>ABOUT</a>
          <a>CONTACT</a>
          <div id="separator"></div>
          <a href='profile.php'>PROFILO</a>
          <a href='logout.php' class='button'>LOGOUT</a>
        </div>
        <div id="menu">
          <div></div>
          <div></div>
          <div></div>
        </div>
      </nav>
      <h1>Eat Pray Love</h1>
      <a class="subtitle">
        Usa Lookin'4Food per scoprire nuovi piatti da provare!
      </a>
    </header>
    <section id="search">
      <form autocomplete="off">
        <div class="search">
          <label for='search'>Cerca</label>
          <input type='text' name="search" class="searchBar">
          <input type="submit" value="Cerca">
        </div>
      </form>
      
    </section>
    <section class="container">

            <div id="results">
                
            </div>
    </section>
    <footer>
      <nav>
        <div class="footer-container">
          <div class="footer-col">
            <h1>L4F</h1>
          </div>
          <div class="footer-col">
            <strong>AZIENDA</strong>
            <p>Chi siamo</p>
            <p>Lavora con noi</p>
          </div>
          <div class="footer-col">
            <strong>CATEGORIE</strong>
            <p>Primi</p>
            <p>Secondi</p>
            <p>Contorni</p>
            <p>Dolci</p>
          </div>
          <div class="footer-col">
            <strong>LINK UTILI</strong>
            <p>Assistenza</p>
            <p>App per cellulare</p>
            <p>Informazioni legali</p>
          </div>
        </div>
      </nav>
    </footer>
  </body>
  </html>