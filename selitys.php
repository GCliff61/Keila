<?php
if (!session_id()) session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    $_SESSION['next_page'] = $_SERVER['PHP_SELF'];
   
    $msg="Saavuit suojatulle sivulle. Sinut ohjataan kirjautumiseen.";
     echo "<script type='text/javascript'>alert('$msg');</script>";
        //header("location: home-log-out.php");
        include("login.php");
    exit;
}
?>

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

    
<h2 class="kotitxt">Kootut selitykset</br></h2>
</br>
<h3 class="kotitxt2">Aina ei heitto osu kohdilleen.</br></h3>
<h3 class="kotitxt3">Alla joukko selityksiä, joilla voit avata joukkuetovereillesi epäonnistuneen suorituksen taustoja.</br>
</br>

<?php
    include ("dbconnect_keila.php");
?>


<table class="selitys" border="2">
 

<?php
$titleErr = $erhe = "";
$results_per_page = 5;  

$hakusql = "SELECT * from selitys";  
$tulokset = $yhteys->query($hakusql);
if ($tulokset->num_rows > 0) {
   $number_of_result = mysqli_num_rows($tulokset);
}
$number_of_page = ceil ($number_of_result / $results_per_page);  
//echo "countti:" .($number_of_page); //sivujen lukumäärä

//ongitaan esiin se sivu, jossa seikkaillaan 
if (!isset ($_GET['page']) ) {  
   $page = 1;  
}  else {  
   $page = $_GET['page'];  
}  
//määritellään aloituskohta sql LIMIT kyselyyn  
$page_first_result = ($page-1) * $results_per_page;  

  $hakusql = "SELECT * FROM selitys LIMIT " . $page_first_result . ',' . $results_per_page;
  $tulokset = $yhteys->query($hakusql);

  //näytetään tulosjoukko
  if ($tulokset->num_rows > 0) {
   while($rivi = $tulokset->fetch_assoc()) {
  ?>
     <tr>
        <td><?php echo $rivi["selitys"]; ?></td>
     </tr>
     <?php
        }
    }
     ?>

</table>

<?php
   //näytetään sivulinkki URLissa  
   for($page = 1; $page<= $number_of_page; $page++) {  
      echo '<a href = "selitys.php?page=' . $page . '">' . $page . ' </a>';  
   } 
?>

<?php
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit']))
    {
        if (empty($_POST["title"])) {
            $titleErr = "Annathan myös selityksen";
            $erhe = "1";
         } else {
            $title = test_input($_POST["title"]);
         }
         if ($erhe ==  "") {
            $query = "INSERT INTO selitys (selitys) VALUES
                 ('$title')";
            //     echo 'query: '.$query;
            $yhteys->query($query);
            $lisatty=$yhteys->affected_rows;
            //echo "<div>$lisatty</div>";
         }
    }
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
     }
?>

<div class="container"> 
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

 
    <div class="form-group">
        <div class="col-25">
        <label for="title">Voit antaa myös oman selityksen</label>
        </div>
        <div class="col-75">
            <input type="text" id="title" name="title" required placeholder="Selitys.."
            oninvalid="this.setCustomValidity('Annathan myös selityksen')"
            oninput="this.setCustomValidity('')"/>
        </div>
        <!-- <span class="error">* <?php echo $titleErr; ?></span> -->
    </div>
    <div class="form-group">
        <input type="submit" name="submit" value="Tallenna selitys">
    </div>
 
    </form> 
</div>

<div class="footer">
  <p>Footerien footer &copy;</p>
</div>

</body>
</html>