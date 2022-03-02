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
  
  <?php include 'pura.php';?>
  <?php include 'navityylikas.php'; ?>
  <?php include ("dbconnect_keila.php"); ?>

  <!-- Perusrakenne   -->
  <!-- header         -->
  <!-- section  aside -->
  <div class="divheaderi">

  <section class="section_nolla">

    <?php echo ("<b>Pelien tarkistaminen</b>"); ?>

      <form class="formit" action="" method="post">
      <div class="row">
          <div class="column">

          <!-- täytetään pelattujen pelien lista tuoreimmasta pelistä vanhimpaan -->

          <select name="pelilista" class="pelilista" id="pelilista" required style="width: 150px">
            <?php
              $result = mysqli_query($yhteys, "SELECT distinct tunnus FROM pelit where tunnus like 'vko%' order by tunnus desc");
            ?>

            <option value="">Valitse peli</option>

            <?php
              $i=0;
             while($row = mysqli_fetch_array($result)) {
            ?>
              <option value="<?=$row["tunnus"];?>"><?=$row["tunnus"];?></option>
            <?php
                $i++;
              }
            ?>
          </select>
            </div>
            <div class="column">
          <div class="form-group" id="outer">
            <input type="submit" name="submit" value="Hae rivit"  style="width: 150px">
          </div>

          <div>
            <p><input type="text" name="vaihdellut" id="vaihdellut" hidden></p>
            <p id="piilovarmat" hidden></p>
            <p id="piiloosittain" hidden></p>
            <p id="piilotaysin" hidden></p>
            <p id="piilorivia" hidden></p>           
            <p id="piilo0" hidden></p>

            <p id="infov"></p>
            <p id="infoo"></p>
            <p id="infot"></p>
          </div>


          </div> <!-- column -->

          </div> <!-- row -->

      <div class="row">
      <div class="column">

      <?php
              if(isset($_POST['submit'])) {
                if(!empty($_POST['pelilista'])) {
                    $valittu = $_POST['pelilista'];
                    if ($valittu == "" || $valittu == 0) {
                        $valittu = "20"; // Akaa
                    }
                   // echo 'valittu:'.$valittu;
                } else {
                    echo 'valitse kunta';
                }
        
            }
          $ottelu=[];
          $viikko=[];
          $otteluAA=[];
          $vko=[];

          // viikko: oletusarvoksi kuluva viikko
          $timestamp = time();
          $timezone = "Europe/Helsinki";
          $dt = new DateTime();
          $dt->setTimestamp(substr($timestamp, 0, 10));
          $dt->setTimezone(new DateTimeZone($timezone));
          $week = $dt->format("W");
          $vko[0] =  ltrim($week, '0');


          if (isset($valittu)) {
          $hakusql = "SELECT rivi, vko FROM pelit where tunnus = '$valittu' ";  

          echo "valittu:".$valittu;
          //echo "hakusql: ".$hakusql;
          $ls = 0;
          $tulokset = $yhteys->query($hakusql);
          if ($tulokset->num_rows > 0) {
            while($rivi = $tulokset->fetch_assoc()) {
              $ottelu[] = ($rivi["rivi"]);
              $vko[0] = ($rivi["vko"]);
            }
          }

          // laitetaan tulostettaviin riveihin väliblankot
          for ($i=0; $i < count($ottelu); $i++) {
            $alkio = $ottelu[$i];
            $hanta = substr($alkio, -4);
            $alku = substr($alkio, 0, 9);
            $chunks = str_split($alku, 3);
            $muotoiltu = implode(' ', $chunks);
            $otteluAA[$i] = $muotoiltu . ' '. $hanta;
          }
        }
      ?>


<table name="khalli" id="khalli" style="margin-top:5px"; class="khalli" border="2">

<thead className = "thead-dark">
  <tr>
    <th style="font-size: 14px">Pelatut rivit</th>
  </tr>
</thead>
<tbody className = "body-normal">

<!-- näytetään rivit -->
<?php               
    for ($i = 0; $i < count($ottelu); $i++) :
?>

  <tr>
    <td style="font-size: 14px"><?php if (isset($ottelu[$i])) {echo $otteluAA[$i];} ?></td>
  </tr>

<?php endfor; ?>

</tbody>
</table>


    </div>
    <div class="column">


<!--
      <h3>Toteutunut rivi</h3>
    -->
    <p>Toteutunut rivi, viikko <?php echo $vko[0]; ?></p>

    <?php
        $toteutuneet = [];
        $hakusql = "SELECT rivi FROM pelit where tunnus like 'oik%' and vko='" . $vko[0] . "'";
        $tulokset = $yhteys->query($hakusql);
        $lask = 0;
        $valitaulu = [];
        if ($tulokset->num_rows > 0) {
          while($rivi = $tulokset->fetch_assoc()) {
            $tote = ($rivi["rivi"]);
            //echo $rivi["rivi"];
            $valitaulu = str_split($tote); // merkkijono --> table
            //echo $valitaulu[7];
          }
        }

        
        for ($i=0;$i<39;$i++) {
          $toteutuneet[$i] = " ";
        }
        for ($i=0;$i<13;$i++) {
          //echo $i;
          //echo $valitaulu[$i];
          if ($valitaulu[$i] == "1") {
            $toteutuneet[$i * 3] = "1";
          }
          if ($valitaulu[$i] == "x") {
            $toteutuneet[$i * 3 + 1] = "x";
          }
          if ($valitaulu[$i] == "2") {
            $toteutuneet[$i * 3 + 2] = "2";
          }
        }
    ?>

    <table class="syotetyt" name="syotetyt" id="syotetyt" className = "table table-bordered">

<thead className = "thead-dark">
  <tr>
    <th>1</th>
    <th>X</th>
    <th>2</th>
    </tr>
</thead>
<tbody className = "body-normal">
  <?php 
    for ($i = 0; $i < 39; $i += 3) :  // step 3
  ?>
  <tr>
    <td style="font-size: 14px"><?php if (isset($toteutuneet[$i])) {echo $toteutuneet[$i];} ?></td>
    <td style="font-size: 14px"><?php if (isset($toteutuneet[$i + 1])) {echo $toteutuneet[$i + 1];} ?></td>
    <td style="font-size: 14px"><?php if (isset($toteutuneet[$i + 2])) {echo $toteutuneet[$i + 2];} ?></td>
  </tr>
  <?php endfor; ?>
</tbody>
</table>



          </div> <!-- column -->
      </div> <!-- row -->

      </form> 

</section>






<aside>

<p><b>Ja näin kävi</b></p>
  <div class="f-c-45">
      <div className = "d-flex my-4"> 


      <?php        
        $valitaulu2=[];       
        $voitto ="0";
        for ($i=0;$i<14;$i++) { $oikein[$i]=0; }
        for ($i = 0; $i < count($ottelu); $i++) :
      ?>
 
        <?php 
          $valitaulu2 = str_split($ottelu[$i]); // merkkijono --> table
          $kpl = 0;
          for ($j=0;$j<13;$j++) {
            //echo $valitaulu[$j] . "/" . $valitaulu2[$j];
            if ( $valitaulu[$j] == $valitaulu2[$j] ) {
              $kpl = $kpl + 1;
            }
          }
          $oikein[$kpl] = $oikein[$kpl] + 1;
          if ($kpl > 9) {
            $voitto = "1";
          }
        ?>  

      <?php endfor; ?>



      <?php
       $tottelu=array();

       for ($i=13; $i >= 0; $i--) {
         $tottelu[$i] = $i . " oikein";
         $oikein[$i];
       }

      ?>

      <table name="thalli" id="thalli" style="margin-top:5px"; class="thalli" border="2">

      <thead className = "thead-dark">
        <tr>
            <th style="font-size: 14px">Tulos</th>
            <th style="font-size: 14px">Kpl</th>
        </tr>
      </thead>

      <tbody className = "body-normal">

        <?php for ($i = 13; $i >= 0; $i--) :  // step -1 ?>
         <tr>
            <td><?php if (isset($tottelu[$i])) {echo $tottelu[$i];} ?></td>
            <td><?php if (isset($oikein[$i])) {echo $oikein[$i];} ?></td>
        </tr>
        <?php endfor; ?>

      </tbody>
      </table>

      </div>
   </div>

   <div class="f-c-35">
   <p>.</p>
      <div className = "d-flex my-4"> 
      <div>

         <?php if($voitto== "0") : ?>
          <picture>
            <img src="emptypocket.jpg" alt="kuva" class="center" style="width:200px;height=300px; type=text/css">
         </picture>
         <?php endif; ?>

         <?php if($voitto== "1") : ?>
         <picture>
            <img src="richpocket.jpg" alt="kuva" class="center" style="width:200px;height=300px; type=text/css">
         </picture>
         <?php endif; ?>
         <!--
         <picture>
            <img src="oldman.jpg" alt="kuva" class="center" style="width:100px;height=150px; type=text/css">
         </picture>
         -->
      </div>

      </div>
 </div> 









</aside>

</body>

<!-- näytön virkistys -->
<script>
  function tyhjenna() {
    location.reload();
    return false;
  }
</script>


<!-- muutetaan html-taulukko js-muotoiseksi käyttäen apuna solun taustaväriä -->
<script>
     taulJSON = [];
  function konvertoi_ruudukko() {
   var syotetytJS = [];

   $("table#syotetyt tr").each(function() {
      var rowDataArray = [];
      var actualData = $(this).find('td');
      if (actualData.length > 0) {
         actualData.each(function() {
            var color = $(this).css("background-color");
            if ( color == 'rgb(170, 170, 170)')
              rowDataArray.push($(this).text());
            if ( color !== 'rgb(170, 170, 170)')
              rowDataArray.push('');
         });
         syotetytJS.push(rowDataArray);
      }
   });
  
   var haraJS = [];
   $("table#hara tr").each(function() {
      var rowDataArray = [];
      var actualData = $(this).find('td');
      if (actualData.length > 0) {
         actualData.each(function() {
              rowDataArray.push($(this).text());
         });
         haraJS.push(rowDataArray);
      }
   });


//   syotetytJS.forEach(activity => {
//    activity[3] = 'a';
//   });

   console.log(syotetytJS);
   //console.log(haraJS);
   //console.log(haraJS[0]);

   //console.log(syotetytJS[0][0]);
   //console.log(syotetytJS[0][1]);
   //console.log(syotetytJS[0][2]);
   console.log("apukissa", aputaulu);

   haeHaravat();

   riviJSON = "";
   //taulJSON = [];
   //pituus = document.getElementById('piilorivia');
   //console.log("piiloriviä", pituus);
   pituus = 9; //määräytyy haravan mukaan
   kayt = 0;
   for (k = 0; k < pituus; k++) {

      kayt = 0;
      for (i = 0; i < 13; i++) {


        if (aputaulu[i] == 't') {
              //console.log ("i:", i, "k:", k, "käyt:", kayt);
              //console.log("zyö:", pt1_0_4_9[k, kayt],":yö");
              riviJSON = riviJSON + pt1_0_4_9[k][kayt];
              //riviJSON = riviJSON + '*';
              kayt = kayt + 1;
        }

        for (j=0; j < 3; j++) {
       
            if (aputaulu[i] == 'v' && syotetytJS[i][j] != '') {
                //console.log("*",i,j,syotetytJS[i][j],"*");
                //console.log(syotetytJS[i][j]);
                riviJSON = riviJSON + syotetytJS[i][j];
            } 

          }
          //console.log (riviJSON);

        }
        taulJSON[k] = riviJSON;
        riviJSON = "";
    }
    console.log (taulJSON);
    console.log (JSON.stringify(taulJSON));
    piilo0.innerHTML = taulJSON[0];

    var data = taulJSON.join(',');
    console.log (data);
    window.location = "pelaa.php?data="+data;
  }
</script>

<!--  1x2 taulukon on/off toiminto  -->
<script>
  window.onload = function () {
    var tds = document.getElementsByTagName("td");
    for (var i = 0; i < tds.length; i++) {
      /*window.alert(i); */
        tds[i].onclick = toggleHighlight();
    }
  }
</script>

<!--  1x2 taulukon on/off toiminto  -->
<script>
  function toggleHighlight() {
    var td = this;
    if (td.className == 'highlight')
        td.className = '';
    else
        td.className = 'highlight';
  }
</script>

<!--  1x2 taulukon on/off toiminto  -->
<script>
  $( function() {
    $('td').click( function() {
      if($(this).attr('style'))
        $(this).removeAttr('style');
      else
        $(this).css('background', 'rgb(170, 170, 170)');
    } );
  } );
</script>

<!-- reagointi ruudukon solun klikkaukseen -->
<script type="text/javascript">                     
    $(document).ready(function(){
        $('#syotetyt tbody').on( 'click', 'td', function () {
            //alert('Data:'+$(this).html().trim());
            showTableData(0);
        });
    });
</script>





</html>