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
     <!-- LOGO 
     <div class="logo">
         <img src="keilalogo_vaaka.jpg" alt="kuva puuttuu" width="200" height="50">
     </div> 
     -->
     <!-- NAVIGATION MENU -->
     <ul class="nav-links">
       <!-- USING CHECKBOX HACK -->
       <input type="checkbox" id="checkbox_toggle" />
       <label for="checkbox_toggle" class="hamburger">&#9776;</label>
       <!-- NAVIGATION MENUS -->
       <div class="menu">
         
         <li><a href="home-log-out.php"><i class="fa fa-fw fa-home"></i>Koti</a></li>
         <li><a href="login.php">Kirjaudu sisään/rekisteröidy</a></li>
         <li class="services">
           <a href="/">Palvelut</a>
           <!-- DROPDOWN MENU -->
           <ul class="dropdown">
             <li><a href="/">Keilahallihaku </a></li>
             <li><a href="/">Näytä Pro Shopit</a></li>
             <li><a href="selitys.php">Kootut selitykset</a></li>
           </ul>
         </li>
         <li><a href="palaute.php">Anna palautetta</a></li>
         <li><a href="logout.php">Kirjaudu ulos</a></li>
       </div>
     </ul>
   </nav>

    
<h2 class="kotitxt">Kootut selitykset</br>
</br>
<h3 class="kotitxt2">Aina ei heitto osu kohdalleen.</br>
<h3 class="kotitxt3">Alla joukko selityksiä, joilla voit avata</br>
<h3 class="kotitxt3">joukkuetovereillesi epäonnistuneen suorituksen taustoja.</br>
</br>

<?php
    include ("dbconnect_keila.php");
?>

<table class="selitys" border="2">
 

<?php

$results_per_page = 6;  

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

<div class="footer">
  <p>Footerien footer &copy;</p>
</div>

</body>
</html>