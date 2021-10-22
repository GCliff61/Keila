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

    
<h2 class="kotitxt">Keilahallihaku kunnittain</br></h2>
</br>

<p hidden id="valittu_kunta"></p>

<?php
    include ("dbconnect_keila.php");
?>


<table class="proshop" border="2">
 

<label for="items">Valitse kunta:</label>
  <select onchange="ota_kategoria()" name="items" id="items"> 

<?php
$valittu = '';


// Haetaan kunnat valintalaatikkoon
$hakusql = "SELECT kunnan_nimi, kuntanumero FROM kunta";

$tulokset = $yhteys->query($hakusql);
$i=0;
while($row = mysqli_fetch_array($tulokset)) {
   ?>
      <option value=<?php echo $row["kuntanumero"]; ?>><?php echo $row["kunnan_nimi"]; ?> </option>
   <?php
   $i++;
}
?>

</select>



<!-- sivutus -->

<?php
$titleErr = $erhe = "";
$results_per_page = 3;  
if (isset($_POST["items"])) {
    $valittu=$_POST["items"];
}


$hakusql = "SELECT *  from halli where kuntanumero = '$valittu'";  

echo "valittu:".$valittu;
echo "hakusql: ".$hakusql;
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

  $hakusql = "SELECT * from halli LIMIT " . $page_first_result . ',' . $results_per_page;
  $tulokset = $yhteys->query($hakusql);

  //näytetään tulosjoukko
  if ($tulokset->num_rows > 0) {
   while($rivi = $tulokset->fetch_assoc()) {
  ?>
     <tr>
        <td><?php echo $rivi["nimi"]; ?></td>
        <td><?php echo $rivi["puhelinnumero"]; ?></td>
     </tr>
     <?php
        }
    }
     ?>

</table>

<?php
   //näytetään sivulinkki URLissa  
   for($page = 1; $page<= $number_of_page; $page++) {  
      echo '<a href = "keilahalli.php?page=' . $page . '">' . $page . ' </a>';  
   } 
?>

<script>
function ota_kategoria() {
   var d = document.getElementById("items").value;
   document.getElementById("valittu_kunta").innerHTML = d;
   $valittu = d;
   return($valittu);
}
</script>


<div class="footer">
  <p>Footerien footer &copy;</p>
</div>

</body>
</html>