<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
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

<?php  
  include ("dbconnect_keila.php");
  
  // Error & success messages
  global $wrongPwdErr, $accountNotExistErr, $emailPwdErr, $verificationRequiredErr, $email_empty_err, $pass_empty_err;

  if(isset($_POST['login'])) {
    $email_signin        = $_POST['email_signin'];
    $password_signin     = $_POST['password_signin'];

    // clean data 
    $user_email = filter_var($email_signin, FILTER_SANITIZE_EMAIL);
    $pswd = mysqli_real_escape_string($yhteys, $password_signin);

    // Query if email exists in db
    $sql = "SELECT * From users WHERE email = '{$email_signin}' ";
    $query = mysqli_query($yhteys, $sql);
    $rowCount = mysqli_num_rows($query);

    // If query fails, show the reason 
    if(!$query){
       die("SQL query failed: " . mysqli_error($yhteys));
    }

    if(!empty($email_signin) && !empty($password_signin)){
        if(!preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{6,20}$/", $pswd)) {
            $wrongPwdErr = '<div class="alert alert-danger">
                    Password should be between 6 to 20 charcters long, contains atleast one special chacter, lowercase, uppercase and a digit.
                </div>';
        }
        // Check if email exist
        if($rowCount <= 0) {
            $accountNotExistErr = '<div class="alert alert-danger">
                    User account does not exist.
                </div>';
        } else {
            // Fetch user data and store in php session
            while($row = mysqli_fetch_array($query)) {
                $id            = $row['id'];
                $firstname     = $row['firstname'];
                $lastname      = $row['lastname'];
                $email         = $row['email'];
                $mobilenumber   = $row['mobilenumber'];
                $pass_word     = $row['password'];
                $token         = $row['token'];
                $is_active     = $row['is_active'];
            }

            // Verify password
            $password = password_verify($password_signin, $pass_word);

            // Allow only verified user
            if($is_active == '1') {
                if($email_signin == $email && $password_signin == $password) {
                  if (!session_id()) session_start();

                   
                   $_SESSION['id'] = $id;
                   $_SESSION['firstname'] = $firstname;
                   $_SESSION['lastname'] = $lastname;
                   $_SESSION['email'] = $email;
                   $_SESSION['mobilenumber'] = $mobilenumber;
                   $_SESSION['token'] = $token;
                   $_SESSION['loggedin'] = true;

                   // Redirect user to welcome page
                  if (isset($_SESSION['next_page'])) {
                    $next_page = $_SESSION['next_page'];
                    unset($_SESSION['next_page']);
                    header("location: $next_page");
                    exit;
                  }
                  header("Location: home-log-out.php");

                } else {
                    $emailPwdErr = '<div class="alert alert-danger">
                            Either email or password is incorrect.
                        </div>';
                }
            } else {
                $verificationRequiredErr = '<div class="alert alert-danger">
                        Account verification is required for login.
                    </div>';
            }

        }

    } else {
        if(empty($email_signin)){
            $email_empty_err = "<div class='alert alert-danger email_alert'>
                        Email not provided.
                </div>";
        }
        
        if(empty($password_signin)){
            $pass_empty_err = "<div class='alert alert-danger email_alert'>
                        Password not provided.
                    </div>";
        }            
    }

}




?>

<div class="container">
  <form action="" method="post">
    <h2 class="kotitxt">Sisäänkirjautuminen</h2>

    <?php echo $accountNotExistErr; ?>
    <?php echo $emailPwdErr; ?>
    <?php echo $verificationRequiredErr; ?>
    <?php echo $email_empty_err; ?>
    <?php echo $pass_empty_err; ?>

    <div class="form-group">
      <div class="col-25">
        <label>Sähköposti</label>
      </div>
      <div class="col-75">
        <input type="email" class="form-control" name="email_signin" id="email_signin" required
          oninvalid="this.setCustomValidity('Sähköposti puuttuu')"
          oninput="this.setCustomValidity('')"/>
      </div>
    </div>

    <div class="form-group">
      <div class="col-25">
        <label>Salasana</label>
      </div>
      <div class="col-75">
        <input type="password" class="form-control" name="password_signin" id="password_signin" required
          oninvalid="this.setCustomValidity('Salasana puuttuu')"
          oninput="this.setCustomValidity('')"/>
      </div>
    </div>

    <div class="form-group">
      <input type="submit" name="login" value="Kirjaudu sisään">
    </div>
<!--
    <button type="submit" name="login" id="sign_in"
      class="btn btn-outline-primary btn-lg btn-block">Kirjaudu sisään
    </button>
-->

  </form>
</div>




<div class="footer">
  <p>Footerien footer &copy;</p>
</div>

</body>