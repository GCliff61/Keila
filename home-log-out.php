<?php if (!session_id()) session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
<!-- jQuery + Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

</head>

<body>
<nav class="navbar">
  <!-- NAVIGATION MENU -->
  <ul class="nav-links">
  <!-- USING CHECKBOX HACK -->
  <input type="checkbox" id="checkbox_toggle" />
  <label for="checkbox_toggle" class="hamburger">&#9776;</label>
  
  <!-- NAVIGATION MENUS -->
  <div class="menu">      
    <li><a href="home-log-out.php"><i class="fa fa-fw fa-home"></i>Koti</a></li>
    <li><a href="signup.php">Rekisteröidy</a></li>
    <li><a href="login.php">Kirjaudu sisään</a></li>
    <li class="services">
      <a href="">Palvelut</a>
      <!-- DROPDOWN MENU -->
      <ul class="dropdown">
        <li><a href="keilahalli.php">Keilahallihaku </a></li>
        <li><a href="proshop.php">Näytä Pro Shopit</a></li>
        <li><a href="selitys.php">Kootut selitykset</a></li>
      </ul>
    </li>
    <li><a href="palaute.php">Anna palautetta</a></li>
    <li><a href="logout.php">Kirjaudu ulos</a></li>
    <?php if (isset($_SESSION['firstname'])) : ?>    
      <li><a href="">Tervetuloa: <?php echo $_SESSION['firstname']; ?></a></li>
    <?php endif ?>
  </div>
  </ul>
</nav>

    
<h2 class="kotitxt">Tervetuloa Tuuri-pelaajien kotisivulle</br> </h2>
</br>
<h3 class="kotitxt2">Paikka, jossa kerrotaan, miten teet järjestelmäveikkaamisesta helppoa ja entistäkin mielenkiintoisempaa!</br></h3>
</br>
<picture>
  <img src="keilafun1.jpg" alt="kuva" class="center" style="width:100px;height=150px; type=text/css">
</picture>
</br></br>
<div>
  <h3 class="kotitxt3">Etkö ole vielä jäsen? <p> <a href="signup.php">Rekisteröidy tästä</a></p></br></h3>
  <h3 class="kotitxt3">Olet jo jäsen, siirry kirjautumiseen <p> <a href="login.php">tästä</a></p></br></h3>
</div>

<?php
//echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
?>


<div class="footer">
  <p>Footerien footer &copy;</p>
</div>

</body>
</html>