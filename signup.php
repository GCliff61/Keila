<?php include('register.php'); ?> 

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Tuuri-keilaajien rekisteröityminen</title>
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
  </div>
  </ul>
</nav>

<div class="container">
    <form action="" method="post">
        <h2 class="kotitxt">Tuuri-keilaajien rekisteröityminen</h2>

        <?php echo $success_msg; ?>
        <?php echo $email_exist; ?>

        <?php echo $email_verify_err; ?>
        <?php echo $email_verify_success; ?>

        <div class="form-group">
            <div class="col-25">
                <label>Etunimi</label>
            </div>
            <div class="col-75">
                <input type="text" name="firstname" id="firstname" required
                    oninvalid="this.setCustomValidity('Etunimi puuttuu')"
                    oninput="this.setCustomValidity('')"/>
            </div>
            <?php echo $fNameEmptyErr; ?>
            <?php echo $f_NameErr; ?>
        </div>

        <div class="form-group">
            <div class="col-25">
                 <label>Sukunimi</label>
            </div>
            <div class="col-75">
                <input type="text" name="lastname" id="lastname" required
                    oninvalid="this.setCustomValidity('Sukunimi puuttuu')"
                    oninput="this.setCustomValidity('')"/>
            </div>
            <?php echo $l_NameErr; ?>
            <?php echo $lNameEmptyErr; ?>
        </div>

        <div class="form-group">
            <div class="col-25">
                 <label>Sähköposti</label>
            </div>
            <div class="col-75">
                <input type="email"  name="email" id="email" required
                    oninvalid="this.setCustomValidity('Sähköposti puuttuu')"
                    oninput="this.setCustomValidity('')"/>
            </div>
            <?php echo $_emailErr; ?>
            <?php echo $emailEmptyErr; ?>
        </div>

        <div class="form-group">
            <div class="col-25">
                <label>GSM</label>
            </div>
            <div class="col-75">
                <input type="text"  name="mobilenumber" id="mobilenumber" required
                    oninvalid="this.setCustomValidity('GSM numero puuttuu')"
                    oninput="this.setCustomValidity('')"/>
            </div>
            <?php echo $_mobileErr; ?>
            <?php echo $mobileEmptyErr; ?>
        </div>

        <div class="form-group">
            <div class="col-25">
                <label>Salasana</label>
            </div>
            <div class="col-75">
                <input type="password"  name="password" id="password" required
                    oninvalid="this.setCustomValidity('Salasana puuttuu')"
                    oninput="this.setCustomValidity('')"/>
            </div>
            <?php echo $_passwordErr; ?>
            <?php echo $passwordEmptyErr; ?>
        </div>

        <div class="form-group">
            <input type="submit" name="submit" value="Rekisteröidy">
        </div>
<!--
                    <button type="submit" name="submit" id="submit" class="btn btn-outline-primary btn-lg btn-block">Rekisteröidy
                    </button>
-->
   </form>

</div>

    
<div class="footer">
  <p>Footerien footer &copy;</p>
</div>

</body>

</html>