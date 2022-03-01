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
        <a href="">Haravajärjestelmät</a>
        <!-- DROPDOWN MENU -->
        <ul class="dropdown">
          <li><a href="yleista.php">Yleistä</a></li>
          <li><a href="proshop.php">Pelaa</a></li>
         <li><a href="selitys.php">Jossittelut</a></li>
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