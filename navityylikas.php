<header class="headeri">
	<h6 class="logo"><a href="#">Veikkausharava</a></h6>
      <ul class="main-nav">
        <li><a href="home-log-out.php"><i class="fa fa-fw fa-home"></i>Koti / Pelaa</a></li>
        <?php if (!isset($_SESSION['firstname'])) : ?>  
            <li><a href="signup.php">Rekisteröidy</a></li>
            <li><a href="login.php">Kirjaudu sisään</a></li>
        <?php endif ?>
        <li><a href="jossittele.php">Tulokset</a></li>
        <li><a href="yleista.php">Haravajärjestelmät</a></li>
        <li><a href="taustaa.php">Taustatietoa</a></li>
        <li><a href="palaute.php">Anna palautetta</a></li>
        <li><a href="logout.php">Kirjaudu ulos</a></li>
        <?php if (isset($_SESSION['firstname'])) : ?>    
            <li><a href="">Tervetuloa: <?php echo $_SESSION['firstname']; ?></a></li>
        <?php endif ?>
      </ul>
</header> 