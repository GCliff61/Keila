<?php
if (!session_id()) session_start();
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    $_SESSION['next_page'] = $_SERVER['PHP_SELF'];
   
    //$msg="Saavuit suojatulle sivulle. Sinut ohjataan kirjautumiseen.";
    // echo "<script type='text/javascript'>alert('$msg');</script>";
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

    <?php include 'pura.php';?>
    <?php include 'navityylikas.php';?>

    <!-- Perusrakenne   -->
    <!-- header         -->
    <!-- section  aside -->

    <div class="divheaderi">

    <section>

      <h3>Taustatietoa</h3>
      <br/>
 
      <p>Eräs hyvin tuntemani henkilö on aina ollut innokas pelaamaan vakioveikkausta.
         Hän alkoi tutkailla vakioveikkauksen järjestelmiä tarkemmin ja huomasi, että
         haravajärjestelmät tuottivat lukusia hänen mielestään "järjettömiä" rivejä.
         Tälläisiä olivat mm. rivit, joissa oli liian monta samaa merkkiä peräkkäin 
         esim. seitsemän ykköstä jne.  <br/><br/>
      </p>

      <p>
         Tämän pohjalta hän kehitteli aparaatin, jonka avulla pystyi helposti valikoimaan omalle silmälle sopivia rivejä.
         Aparaatti koostui puisesta levystä, johon oli kiinnitetty 13 vaakasuoraan liikuteltavaa tankoa. 
         Jokaisessa tangossa oli pienillä teipinpaloilla kiinni arvot "1", "x" ja "2" - useampaan kertaan.
         Tankoja liikuttamalla pystyi sitten luomaan järkeviä, silmään sopivia rivejä.
         <br/><br/>
      </p>

      <p>
         Useamman vuoden ahkeran seurannan tuloksena syntyi joukko "sääntöjä", joilla haravajärjestelmien
         tuottamaa rivimäärää pystyi pienentämään huomattavasti. Tämä ohjelma perustuu näihin havaintoihin.
         Käytännössä siis tuo vanha puinen aparaatti siirrettiin digitaaliseen muotoon.
         <br/><br/>
      </p>

    </section>

<aside> 
<p>.</p>
    <div className = "d-flex my-4">
    <div class="f-c-35">

      <div>
         <picture>
            <img src="oldman.jpg" alt="kuva" class="center" style="width:400px;height=600px; type=text/css">
         </picture>
      </div>

      </div>
   </div>  
 </aside>

</div>


<script>
function ota_kategoria() {
   var d = document.getElementById("items").value;
   document.getElementById("valittu_kunta").innerHTML = d;
   $valittu = d;
   return($valittu);
}

</script>

<!--
<div class="footer">
  <p>Footerien footer &copy;</p>
</div>
-->

</body>
</html>