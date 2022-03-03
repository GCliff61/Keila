<?php if (!session_id()) session_start(); ?>
<?php
   $url=$_SERVER['REQUEST_URI'];
   //header("Refresh: 60; URL=$url"); //automaattipäivitys 60 sekunnin välein
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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

    <section>

      <form class="formi" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

        <table class="syotetyt" name="syotetyt" id="syotetyt" className = "table table-bordered" style="font-size: 14px">

          <?php

            $get_data = callAPI('GET', 'https://www.veikkaus.fi/api/sport-popularity/v1/games/SPORT/draws/100335/popularity', false);
            $get_data2 = callAPI('GET', 'https://www.veikkaus.fi/api/sport-open-games/v1/games/SPORT/draws/100335', false);

            // Tutkitaan tässä, onko tuore peliprosentti-data saatavilla.
            if (strpos($get_data,"timestamp") > 0) {
              //echo ("uutta prossadataa löytyy");
              //var_dump($get_data);
              $bytes = file_put_contents("wanha.json", $get_data); 
            } else {
              //echo ("uutta prossadataa ei löydy");
              //var_dump($get_data);
              $get_data = file_get_contents("wanha.json");
            }

            // Tutkitaan tässä, onko Vakio 1 pelikohteet saatavilla.
            if (strpos($get_data2,"NOT_FOUND") > 0) {
              //echo ("uutta joukkuedataa ei löydy");
              //var_dump($get_data2,"code");
              $get_data2 = file_get_contents("wanha2.json");
            } else {
              //echo ("uutta joukkuedataa löytyy");
              $bytes = file_put_contents("wanha2.json", $get_data2); 
            }
    
            //$joku=isset($get_data);
            //$joku2=isset($get_data2);
            //echo("<script>console.log($joku);</script>");
            //echo("<script>console.log($joku2);</script>");
            //echo("<script>console.log($get_data);</script>");
            //echo("<script>console.log($get_data2);</script>");
            //echo "ccc" .$get_data. "ccc";

            $response = json_decode($get_data, true);
            $response2 = json_decode($get_data2, true);


            // timestamp on Unix epoch muotoa eli sekunteja hetkestä 1.1.1970 00:00:00 lähtien
            $timestamp = $response["timestamp"];
            $timezone = "Europe/Helsinki";
            $dt = new DateTime();
            $dt->setTimestamp(substr($timestamp, 0, 10));
            $dt->setTimezone(new DateTimeZone($timezone));
            $datetime = $dt->format('Y-m-d H:i:s');
            
            $week = $dt->format("W");
            //echo nl2br ("\n Viikko: ");
            $viik = ltrim($week, '0');
            echo "<b>Viikko $viik</b>";

            echo  (", vaihto ja peliprosentit:   ");
            echo number_format($response["exchange"]/100, 2, "."," "); // vaihto, poistetaan lopusta yilmääräiset nollat
            echo "€ / ";
            echo $datetime;


            // kerätään kaikki ottelut ohjelman sisäiseen taulukkoon
            $ottelu=array();
            $arrlength=13;
            if (isset($response2["rows"])) {
              for($x = 0; $x < $arrlength; $x++) {
                $ottelu[$x] = $response2["rows"][$x]["outcome"]["home"]["name"] . " - " . $response2["rows"][$x]["outcome"]["away"]["name"];
              }
            }

            // todo: tutki aikaleiman kautta

            //  for($x = 0; $x < $arrlength; $x++) {
            //   $ottelu[$x] = "Ottelutietoa ei ole saatavilla";
            //  }

            $result = printValues($response);
            //$result2 = printValues($response2);


            // johdetaan perusrivi peliprosenteista
            // input muuttuu 7. kohteen jälkeen minivakion takia
            $johdettu = array(0);
            $xraja = 45; // prosenttiraja "x" -merkille

            $j = 0;
            $k = 0;
            for ($i = 4; $i <= 76; $i += 12) {
              $johdettu[$k]="x";
              $j = $i + 8;
              if ( round($result["values"][$i] / 100) >= $xraja) { $johdettu[$k]="1"; };
              if ( round($result["values"][$j] / 100) >= $xraja) { $johdettu[$k]="2"; }; 
              $k++ ;
            }
            // input muuttuu
            for ($i = 88; $i <= 133; $i += 9) {
              $johdettu[$k]="x";
              $j = $i + 6;
              if ( round($result["values"][$i] / 100) >= $xraja) { $johdettu[$k]="1"; };
              if ( round($result["values"][$j] / 100) >= $xraja) { $johdettu[$k]="2"; }; 
              $k++ ;
            }

        ?>

        <!-- täytetään peliprosentti -taulukko -->
        <thead className = "thead-dark">
        <tr>
          <th style="font-size: 14px"> </th>
          <th style="font-size: 14px">1</th>
          <th style="font-size: 14px">X</th>
          <th style="font-size: 14px">2</th>
          <th style="text-align:right; font-size: 14px">%:sta johdettu perusrivi</th>
        </tr>
        </thead>
        <tbody className = "body-normal">

        <!-- täytetään html-taulukko -->
        <!-- input muuttuu 7. kohteen jälkeen minivakion takia -->
        <?php 
          $j = 0;
          $k = 0;
          $m = 0;
          for ($i = 4; $i <= 76; $i += 12): 
            $j = $i + 4;
            $k = $i + 8;
        ?>

        <tr>
          <td><?php if (isset($ottelu[$m])) {echo $ottelu[$m];}  ?></td>
          <td><?php echo round($result["values"][$i] / 100); ?></td>
          <td><?php echo round($result["values"][$j] / 100); ?></td>
          <td><?php echo round($result["values"][$k] / 100); ?></td>
          <td style="text-align:right"><?php if (isset($johdettu[$m])) {echo $johdettu[$m];}  ?></td>
        </tr>

        <?php 
          $m++;
          endfor; 
        ?>

        <!-- tässä muuttuu input, avg jää pois -->
        <?php 
          $j = 0;
          $k = 0;
          for ($i = 88; $i <= 133; $i += 9): 
            $j = $i + 3;
            $k = $i + 6;
        ?>

        <tr>
          <td><?php if (isset($ottelu[$m])) {echo $ottelu[$m];}  ?></td>
          <td><?php echo round($result["values"][$i] / 100); ?></td>
          <td><?php echo round($result["values"][$j] / 100); ?></td>
          <td><?php echo round($result["values"][$k] / 100); ?></td>
          <td style="text-align:right"><?php if (isset($johdettu[$m])) {echo $johdettu[$m];}  ?></td>
        </tr>

        <?php 
          $m++;
          endfor; 
        ?>

        </tbody>
        </table>
          
        <div class="wrapper">

          <!-- <label>Haravajärjestelmät</label><br> -->
          <select name="haravat" id="haravat" class="haravat" size="1" required>
            <option value="">Valitse harava</option>
            <option value="pt1_0_4_9">Paras tulos -1, 0 + 4,    9 riviä</option>
            <option value="pt1_7_0_16">Paras tulos -1, 7 + 0,   16 riviä</option>
            <option value="pt1_0_5_27">Paras tulos -1, 0 + 5,   27 riviä</option>
            <option value="pt2_8_0_12">Paras tulos -2, 8 + 0,   12 riviä</option>
            <option value="pt2_9_0_16">Paras tulos -2, 9 + 0,   16 riviä</option>
            <option value="pt2_0_6_17">Paras tulos -2, 0 + 6,   17 riviä</option>
            <option value="pt3_4_4_10">Paras tulos -3, 4 + 4,   10 riviä</option>
            <option value="pt3_9_1_12">Paras tulos -3, 9 + 1,   12 riviä</option>
            <option value="pt3_6_3_12">Paras tulos -3, 6 + 3,   12 riviä</option>
          </select><br>
        </div>
    
           <p><input type="text" name="vaihdellut" id="vaihdellut" hidden></p> 
            <p id="piilosysteemi" hidden></p>
            <p id="piilovarmat" hidden></p>
            <p id="piiloosittain" hidden></p>
            <p id="piilotaysin" hidden></p>
            <p id="piilorivia" hidden></p>           
            <p id="piilo0" hidden></p>
            <p id="piilo_chkxxx" hidden></p>
            <p id="piilo_chk1111" hidden></p>
            <p id="piilo_chk222" hidden></p>
            <p id="piilo_chk137" hidden></p>
            <p id="piilo_chkpr7" hidden></p>
            <p id="piilo_chkero5" hidden></p>

            <p><input class="button" type="button" id="btnTest" name="btnTest" value="Tallenna" onclick="konvertoi_ruudukko()"  style="width: 120px" /></p>
            <!-- type pitää olla button, submit ei toimi -->

            <p id="infov"></p>
            <p id="infoo"></p>
            <p id="infot"></p>

            <h5 class="kotitxt3">Tulosten tarkasteluun <span> <a href="jossittele.php">tästä</a></span></br></h5>
    </form>
    
 
<!--    </div> -->
   </section>
  <!--  </div> -->

    <aside>

      <div className = "d-flex my-4"> 
        <?php //echo "Suodattimet:"; ?> 
        <?php
          $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
          $components = parse_url($url);
          $otteluA=array();
          $otteluAA=array(); // riveissä väliblankot mukana
          $otteluB=array();
          if (isset($components['query'])) {
            parse_str($components['query'], $results);

            $otteluA=explode(",",$results['data']);
            $otteluB=explode(",",$results['data']);
          
            // tehdään tallennus jo täällä
            $bytes = file_put_contents("pelit.json", json_encode($otteluA)); 

            $timestamp = $response["timestamp"];
            $timezone = "Europe/Helsinki";
            $dt = new DateTime();
            $dt->setTimestamp(substr($timestamp, 0, 10));
            $dt->setTimezone(new DateTimeZone($timezone));
            $week = $dt->format("W");
            $viikko =  ltrim($week, '0');
            // tunnus: viikko + päivämäärä + kellonaika
            $tunnus = 'vko' . $viikko . ' ' .$dt->format('Ymd') . ' '.  $dt->format('His');

            for ($i=0; $i < count($otteluA); $i++) {
              $query = "INSERT INTO pelit (vko, tunnus, rivi) VALUES
                  ('$viikko', '$tunnus', '$otteluA[$i]')";
              //     echo 'query: '.$query;
              $yhteys->query($query);
              $lisatty=$yhteys->affected_rows;
            } 

            // laitetaan tulostettaviin riveihin väliblankot
            for ($i=0; $i < count($otteluA); $i++) {
              $alkio = $otteluA[$i];
              $hanta = substr($alkio, -4);
              $alku = substr($alkio, 0, 9);
              $chunks = str_split($alku, 3);
              $muotoiltu = implode(' ', $chunks);
              $otteluAA[$i] = $muotoiltu . ' '. $hanta;
            }

          }
        ?>

        <!-- "Suodattimet" otsikon tooltipin sisällöksi selvennökset on/off nappien kuvioista -->
           
          <span title="1-1-1-1  enintään neljä peräkkäistä ykköstä &#013;X-X-X    enintään kolme peräkkäistä ristiä  &#013;2-2-2     enintään kolme peräkkäistä kakkosta  &#013;1: 3->7  ykkösiä vähintään kolme, enintään seitsemän &#013;%: ->7   enintään seitsemän samaa merkkiä kuin perusrivissä &#013;ero 5->  valittujen rivien on erottava toisistaan vähintään viisi merkkiä">Suodattimet</span>
          <div class="row">
          <div class="column2">
          
          
          <div class="containerS">
        
            <div class="switch-holder">
                <div class="switch-label">
                  <span>1-1-1-1</span>
                </div>
                <div class="switch-toggle">
                  <input title="enintään neljä peräkkäistä ykköstä" type="checkbox" class="chk_1111" id="chk_1111" name="chk_1111"  <?php echo (isset($_POST['chk_1111']) ? 'checked' : '') ?> > </input>
                    <label for="chk_1111"></label>
                </div>
            </div>

            <div class="switch-holder">
              <div class="switch-label">
                <span>X-X-X</span>
              </div>
              <div class="switch-toggle">
                <input type="checkbox" class="chk_xxx" id="chk_xxx" name="chk_xxx"  <?php echo (isset($_POST['chk_xxx']) ? 'checked' : '') ?> > </input>
                <!-- <input type="checkbox" class="chk_xxx" id="chk_xxx" name="chk_xxx" onChange="this.form.submit()" <?php //echo (isset($_POST['chk_xxx']) ? 'checked' : '') ?> > </input> -->
                <label for="chk_xxx"></label>
              </div>
             </div>

            <div class="switch-holder">
              <div class="switch-label">
                <span>2-2-2</span>
              </div>
              <div class="switch-toggle">
                <input type="checkbox" class="chk_222" id="chk_222" name="chk_222"  <?php echo (isset($_POST['chk_222']) ? 'checked' : '') ?> > </input>
                <!-- <input type="checkbox" class="chk_222" id="chk_222" name="chk_222" onChange="this.form.submit()" <?php //echo (isset($_POST['chk_222']) ? 'checked' : '') ?> > </input> -->
                <label for="chk_222"></label>
              </div>
             </div>
             
             <!-- ykkösmerkkien määrä 3:n ja 7:n välillä -->
            <div class="switch-holder">
              <div class="switch-label">
                <span>1: 3->7</span>
              </div>
              <div class="switch-toggle">
                <input type="checkbox" class="chk_137" id="chk_137" name="chk_137"  <?php echo (isset($_POST['chk_137']) ? 'checked' : '') ?> > </input>
                <label for="chk_137"></label>
              </div>
             </div>

            <div class="switch-holder">
              <div class="switch-label">
                <span>%: ->7</span>
              </div>
              <div class="switch-toggle">
                <input type="checkbox" class="chk_pr7" id="chk_pr7" name="chk_pr7"  <?php echo (isset($_POST['chk_pr7']) ? 'checked' : '') ?> > </input>
                <label for="chk_pr7"></label>
              </div>
             </div>

            <div class="switch-holder">
              <div class="switch-label">
                <span>ero 5-></span>
              </div>
              <div class="switch-toggle">
                <input type="checkbox" class="chk_ero5" id="chk_ero5" name="chk_ero5"  <?php echo (isset($_POST['chk_ero5']) ? 'checked' : '') ?> > </input>
                <label for="chk_ero5"></label>
              </div>
             </div>

           </div>

         </div>
          <!--
          <div class="form-group" id="outer">
              <input class="inner" type="submit" name="submit" value="1-1-1-1" style="width: 120px">
              <input class="inner" type="submit" name="submit2" value="X-X-X" style="width: 120px">
              <input class="inner" type="submit" name="submit3" value="2-2-2" style="width: 120px">
              <input class="inner" type="submit" name="submit4" value="1: max 6" style="width: 120px">
              <input class="inner" type="submit" name="submit5" value="1: min 3" style="width: 120px">

          </div>
        -->
       <!-- </form> -->

 
         <?php //echo "<p>Rivejä yhteensä: " . count($otteluA) . "</p>"; ?>
         <table name="khalli" id="khalli" style="margin-top:5px"; class="khalli" border="2">

          <thead className = "thead-dark">
            <tr>
              <th style="font-size: 14px"> <?php echo "<p>Rivejä " . count($otteluA) . "</p>"; ?> </th>
            </tr>
          </thead>

          <tbody className = "body-normal">

            <!-- näytetään rivit -->
            <?php 
              
              for ($i = 0; $i < count($otteluA); $i++) :
            ?>

            <tr>
              <td><?php if (isset($otteluA[$i])) {echo $otteluAA[$i];} ?></td>
            </tr>

            <?php endfor; ?>

          </tbody>

        </table>


      </div>  
      </div>
    <!--  </form> -->
    </div>  
  <!--  </div> -->



  </aside>

</div>


<?php
//echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
?>
<?php
function callAPI($method, $url, $data){
   $curl = curl_init();
   switch ($method){
      case "POST":
         curl_setopt($curl, CURLOPT_POST, 1);
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
         break;
      case "PUT":
         curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
         if ($data)
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);			 					
         break;
      default:
         if ($data)
            $url = sprintf("%s?%s", $url, http_build_query($data));
   }
   // OPTIONS:
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'APIKEY: ROBOT',
      'Content-Type: application/json',
   ));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
   // EXECUTE:
   $result = curl_exec($curl);
   if(!$result){die("Connection Failure");}
   curl_close($curl);
   return $result;
}
?>


</body>


<script>
    var aputaulu = [];  // tieto siitä, onko varma, ositt. tai täysin vaihdeltu (v,o,t)
    var aputaulu2 = []; // varman kohteen merkki
    var aputauluw = []; // tähän kerättän osittainvaihdeltujen merkit

    function showTableData(p1, p2, p3, p4) {

        document.getElementById('infov').innerHTML = "Varma:......";
        document.getElementById('infoo').innerHTML = "Osittain:....";
        document.getElementById('infot').innerHTML = "Täysin:.....";

        var myTab = document.getElementById('syotetyt');

        var osittain = 0;
        var taysin = 0;
        var varma = 0;

        for (i=0; i < 13; i++) {
            aputauluw[i] = '';
        }

        // LOOP THROUGH EACH ROW OF THE TABLE AFTER HEADER.
        for (i = 1; i < myTab.rows.length; i++) {

            // GET THE CELLS COLLECTION OF THE CURRENT ROW.
            var objCells = myTab.rows.item(i).cells;

            // LOOP THROUGH EACH CELL OF THE CURENT ROW TO READ CELL VALUES.
            var kpl  = 0;
            var merkki = "";

            for (var j = 1; j < objCells.length; j++) {
                //if (objCells.item(j).innerHTML == '1') {
                if (objCells.item(j).style.background == "rgb(170, 170, 170)") {
                  kpl = kpl + 1;
                  switch (j) {
                    case 1:
                      merkki = "1";
                      aputauluw[i-1] = aputauluw[i-1].concat("1");
                      break;
                    case 2:
                      merkki = "x";
                      aputauluw[i-1] = aputauluw[i-1].concat("x");
                      break;
                    case 3:
                      merkki = "2";
                      aputauluw[i-1] = aputauluw[i-1].concat("2");
                      break;
                  }
                }
                // console.log("i j väri", i, j, objCells.item(j).style.background);
                // info.innerHTML = info.innerHTML + ' ' + objCells.item(j).innerHTML;
                //info.innerHTML = '*' + kpl + '*';       
            }

            switch (kpl) {
              case 1:
                varma = varma + 1;
                //console.log("i kissa varma",i); 
                aputaulu[i-1] = 'v';
                aputaulu2[i-1] = merkki;
                break;
              case 2:
                osittain= osittain + 1;
                //console.log("i kissa ositt",i);
                aputaulu[i-1] = 'o';
                aputaulu2[i-1] = '';
                break;
              case 3:
                taysin = taysin + 1;
                //console.log("i kissa tays",i);
                aputaulu[i-1] = 't';
                aputaulu2[i-1] = '';
                break;
            }
            //info.innerHTML = info.innerHTML + '<br />';     // ADD A BREAK (TAG).

        }
        //console.log("apukissa", aputaulu);
        infov.innerHTML = infov.innerHTML + varma ;
        infov.innerHTML = infov.innerHTML + ' / ' ;
        if (p2 !== undefined) {
          infov.innerHTML = infov.innerHTML + p2 ;
        } else {
          infov.innerHTML = infov.innerHTML + document.getElementById('piilovarmat').innerHTML;
        }
        if (varma == document.getElementById('piilovarmat').innerHTML) {
          infov.innerHTML = infov.innerHTML + ' ✔';
        }

        //
        infoo.innerHTML = infoo.innerHTML + osittain;
        infoo.innerHTML = infoo.innerHTML + ' / ' ;
        if (p3 !== undefined) {
          infoo.innerHTML = infoo.innerHTML + p3 ;
        } else {
          infoo.innerHTML = infoo.innerHTML + document.getElementById('piiloosittain').innerHTML;
        }
        if (osittain == document.getElementById('piiloosittain').innerHTML) {
          infoo.innerHTML = infoo.innerHTML + ' ✔';
        }

        //
        infot.innerHTML = infot.innerHTML + taysin;
        infot.innerHTML = infot.innerHTML + ' / ' ;
        if (p4 !== undefined) {
          infot.innerHTML = infot.innerHTML + p4 ;
        } else {
          infot.innerHTML = infot.innerHTML + document.getElementById('piilotaysin').innerHTML;
        }
        if (taysin == document.getElementById('piilotaysin').innerHTML) {
          infot.innerHTML = infot.innerHTML + ' ✔';
        }

    }
</script>

<!-- suodatin checkboxit -->
<script>

  var checkbox = document.querySelector("input[name=chk_xxx]");

  checkbox.addEventListener('change', function() {
    if (this.checked) {
      piilo_chkxxx.innerHTML = "1";
    } else {
      piilo_chkxxx.innerHTML = "";
    }
  });
</script>

<script>

  var checkbox = document.querySelector("input[name=chk_222]");

  checkbox.addEventListener('change', function() {
    if (this.checked) {
      piilo_chk222.innerHTML = "1";
    } else {
      piilo_chk222.innerHTML = "";
    }
  });
</script>

<script>

  var checkbox = document.querySelector("input[name=chk_1111]");

  checkbox.addEventListener('change', function() {
    if (this.checked) {
      piilo_chk1111.innerHTML = "1";
    } else {
      piilo_chk1111.innerHTML = "";
    }
  });
</script>

<script>

  var checkbox = document.querySelector("input[name=chk_137]");

  checkbox.addEventListener('change', function() {
    if (this.checked) {
      piilo_chk137.innerHTML = "1";
    } else {
      piilo_chk137.innerHTML = "";
    }
  });
</script>

<script>

  var checkbox = document.querySelector("input[name=chk_pr7]");

  checkbox.addEventListener('change', function() {
    if (this.checked) {
      piilo_chkpr7.innerHTML = "1";
    } else {
      piilo_chkpr7.innerHTML = "";
    }
  });
</script>

<script>

  var checkbox = document.querySelector("input[name=chk_ero5]");

  checkbox.addEventListener('change', function() {
    if (this.checked) {
      piilo_chkero5.innerHTML = "1";
    } else {
      piilo_chkero5.innerHTML = "";
    }
  });
</script>

<!--  haravasysteemin valinta  
        systeemitunnus: systeemi, osittain vaihdeltuja, täysin vaihdeltuja, rivejä
        (alaviivalla erotettuna) esim. pt2_8_0_16
-->
<script>
   document.getElementById('haravat').addEventListener('change', function(e){
   var systeemitunnus = "";
   var varmatlask = 0;
   if (e.target.name==='haravat') {
       /* alert(e.target.value); */
       vaihdellut.innerHTML = e.target.value; 
       piilosysteemi.innerHTML = e.target.value;
       systeemitunnus = e.target.value.split('_');
 /*      osittain.innerHTML = systeemitunnus[1]; */
 /*      taysin.innerHTML = systeemitunnus[2];  */
       varmatlask = 13 - systeemitunnus[1] - systeemitunnus[2];
       piilovarmat.innerHTML = varmatlask;
       piiloosittain.innerHTML = systeemitunnus[1];
       piilotaysin.innerHTML = systeemitunnus[2];
       piilorivia.innerHTML = systeemitunnus[3];
       showTableData(0, varmatlask, systeemitunnus[1], systeemitunnus[2]);
       /*infov.innerHTML = infov.innerHTML + varmatlask ; */
       /*infoo.innerHTML = infoo.innerHTML + systeemitunnus[1] ; */
       /*infot.innerHTML = infot.innerHTML + systeemitunnus[2] ; */
   }
  })
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


<script>
  var haraHaettu = [];
  function haeHaravat(inhara) {
    switch (inhara) {
      case "pt1_0_4_9":
        haraHaettu = [
          ['1', '1', '2', '2'],
          ['1', 'x', 'x', 'x'],
          ['1', '2', '1', '1'],
          ['x', '1', 'x', '1'],
          ['x', 'x', '1', '2'],
          ['x', '2', '2', 'x'],
          ['2', '1', '1', 'x'],
          ['2', 'x', '2', '1'],
          ['2', '2', 'x', '2']
        ];
        break;
      case "pt1_0_5_27":
        haraHaettu = [
          ['1', '1', 'x', '1','1'],
          ['1', '1', 'x', 'x','x'],
		      ['1', '1', 'x', '2','2'],
          ['1', 'x', 'x', '2','x'],
          ['1', 'x', '2', '1','x'],
          ['1', 'x', '2', 'x','2'],
          ['1', '2', '1', '1','2'],
          ['1', '2', '1', 'x','1'],
          ['1', '2', '2', '2','1'],
          ['x', '1', '2', '1','2'],
          ['x', '1', '2', 'x','1'],
          ['x', '1', '2', '2','x'],
		      ['x', 'x', '1', '1','1'],
          ['x', 'x', '1', 'x','x'],
          ['x', 'x', 'x', '2','1'],
          ['x', '2', '1', '2','2'],
          ['x', '2', 'x', '1','x'],
          ['x', '2', 'x', 'x','2'],
          ['2', '1', '1', '1','x'],
          ['2', '1', '1', 'x','2'],
          ['2', '1', '1', '2','1'],
          ['2', 'x', 'x', '1','2'],
          ['2', 'x', 'x', 'x','1'],
          ['2', 'x', '2', '2','2'],
          ['2', '2', 'x', '2','x'],
          ['2', '2', '2', '1','1'],
          ['2', '2', '2', 'x','x']
	      ];	
        break;
        case "pt2_0_6_17":
        haraHaettu = [
          ['1', '1', '1', 'x', 'x', 'x'],
          ['1', '1', 'x', 'x', '2', '2'],
          ['1', 'x', '1', '2', '2', 'x'],
          ['1', 'x', 'x', '1', 'x', '1'],
          ['1', 'x', 'x', '2', '1', '2'],
          ['1', '2', '2', '1', '1', '1'],
          ['x', '1', '2', '2', '1', '1'],
          ['x', 'x', '2', '1', 'x', '2'],
          ['x', '2', '1', '1', '1', '2'],
          ['x', '2', 'x', '2', 'x', '1'],
          ['x', '2', '2', 'x', '1', 'x'],
          ['2', '1', '1', '1', 'x', '1'],
          ['2', '1', '1', '2', '1', '2'],
          ['2', '1', 'x', '1', '2', 'x'],
          ['2', 'x', '1', 'x', '2', '1'],
          ['2', 'x', 'x', 'x', '1', 'x'],
          ['2', '2', '2', '2', 'x', '2']
        ];
        break;
        case "pt1_7_0_16":
          haraHaettu = [
            ['w', 'w', 'w', 'w', 'w', 'o', 'w'],
            ['w', 'w', 'w', 'o', 'o', 'w', 'w'],
            ['w', 'w', 'o', 'w', 'o', 'w', 'o'],
            ['w', 'w', 'o', 'o', 'w', 'o', 'o'],
            ['w', 'o', 'w', 'w', 'o', 'o', 'o'],
            ['w', 'o', 'w', 'o', 'w', 'w', 'o'],
            ['w', 'o', 'o', 'w', 'w', 'w', 'w'],
            ['w', 'o', 'o', 'o', 'o', 'o', 'w'],
            ['o', 'w', 'w', 'w', 'w', 'w', 'o'],
            ['o', 'w', 'w', 'o', 'o', 'o', 'o'],
            ['o', 'w', 'o', 'w', 'o', 'o', 'w'],
            ['o', 'w', 'o', 'o', 'w', 'w', 'w'],
            ['o', 'o', 'w', 'w', 'o', 'w', 'w'],
            ['o', 'o', 'w', 'o', 'w', 'o', 'w'],
            ['o', 'o', 'o', 'w', 'w', 'o', 'o'],
            ['o', 'o', 'o', 'o', 'o', 'w', 'o']
          ];
        break;
        case "pt2_8_0_12":
          haraHaettu = [
            ['w', 'w', 'w', 'w', 'o', 'o', 'o', 'w'],
            ['w', 'w', 'o', 'w', 'w', 'o', 'w', 'w'],
            ['w', 'w', 'o', 'o', 'w', 'w', 'o', 'o'],
            ['w', 'o', 'w', 'w', 'o', 'w', 'w', 'w'],
            ['w', 'o', 'w', 'o', 'w', 'w', 'w', 'o'],
            ['w', 'o', 'o', 'o', 'w', 'o', 'o', 'o'],
            ['o', 'w', 'w', 'w', 'w', 'o', 'o', 'w'],
            ['o', 'w', 'w', 'o', 'o', 'o', 'o', 'o'],
            ['o', 'w', 'o', 'o', 'o', 'o', 'w', 'w'],
            ['o', 'o', 'w', 'w', 'w', 'w', 'w', 'w'],
            ['o', 'o', 'o', 'w', 'o', 'w', 'w', 'o'],
            ['o', 'o', 'o', 'w', 'o', 'w', 'o', 'w']
          ];
        break;

        case "pt2_9_0_16":
          haraHaettu = [
            ['w', 'w', 'w', 'w', 'w', 'w', 'w', 'o', 'o'],
            ['w', 'w', 'w', 'o', 'o', 'o', 'w', 'w', 'w'],
            ['w', 'w', 'o', 'w', 'o', 'o', 'o', 'w', 'o'],
            ['w', 'w', 'o', 'o', 'o', 'w', 'o', 'o', 'w'],
            ['w', 'o', 'w', 'w', 'w', 'o', 'o', 'o', 'w'],
            ['w', 'o', 'w', 'o', 'w', 'w', 'o', 'w', 'o'],
            ['w', 'o', 'o', 'w', 'o', 'w', 'w', 'w', 'w'],
            ['w', 'o', 'o', 'o', 'w', 'o', 'w', 'o', 'o'],
            ['o', 'w', 'w', 'w', 'w', 'w', 'o', 'w', 'w'],
            ['o', 'w', 'w', 'o', 'o', 'o', 'o', 'o', 'o'],
            ['o', 'w', 'o', 'w', 'w', 'o', 'w', 'o', 'w'],
            ['o', 'w', 'o', 'o', 'w', 'w', 'w', 'w', 'o'],
            ['o', 'o', 'w', 'w', 'o', 'o', 'w', 'w', 'o'],
            ['o', 'o', 'w', 'o', 'o', 'w', 'w', 'o', 'w'],
            ['o', 'o', 'o', 'w', 'o', 'w', 'o', 'o', 'o'],
            ['o', 'o', 'o', 'o', 'w', 'o', 'o', 'w', 'w']
          ];
        break;

        case "pt3_4_4_10":
          haraHaettu = [
            ['w', 'o', 'o', 'o', '1', 'x', 'x', '1'],
            ['w', 'o', 'o', 'o', '1', '2', '2', '2'],
            ['w', 'o', 'o', 'o', 'x', '1', '1', 'x'],
            ['w', 'o', 'o', 'o', '2', '1', 'x', '2'],
            ['o', 'w', 'w', 'w', '1', '1', '1', 'x'],
            ['o', 'w', 'w', 'w', 'x', '1', '2', '1'],
            ['o', 'w', 'w', 'w', 'x', 'x', '1', '2'],
            ['o', 'w', 'w', 'w', 'x', '2', 'x', 'x'],
            ['o', 'w', 'w', 'w', '2', 'x', '2', 'x'],
            ['o', 'w', 'w', 'w', '2', '2', '1', '1']
          ];
        break;

        case "pt3_9_1_12":
          haraHaettu = [
            ['w', 'w', 'w', 'o', 'w', 'w', 'o', 'o', 'o', 'x'],
            ['w', 'w', 'o', 'w', 'w', 'w', 'w', 'o', 'w', '2'],
            ['w', 'w', 'o', 'o', 'o', 'o', 'o', 'w', 'o', '2'],
            ['w', 'o', 'w', 'o', 'o', 'w', 'w', 'w', 'o', '1'],
            ['w', 'o', 'o', 'w', 'w', 'o', 'o', 'w', 'w', '1'],
            ['w', 'o', 'o', 'w', 'o', 'o', 'w', 'o', 'o', 'x'],
            ['o', 'w', 'w', 'w', 'o', 'o', 'w', 'o', 'w', '1'],
            ['o', 'w', 'o', 'w', 'o', 'w', 'o', 'w', 'w', 'x'],
            ['o', 'w', 'o', 'o', 'w', 'w', 'o', 'o', 'o', '1'],
            ['o', 'o', 'w', 'w', 'w', 'o', 'w', 'w', 'o', '2'],
            ['o', 'o', 'w', 'o', 'w', 'o', 'w', 'w', 'w', 'x'],
            ['o', 'o', 'w', 'o', 'o', 'w', 'o', 'o', 'w', '2']
          ];
        break;

        case "pt3_6_3_12":
          haraHaettu = [
            ['w', 'w', 'w', 'o', 'w', 'w', '2', '1', 'x'],
            ['w', 'w', 'w', 'o', 'o', 'o', 'x', 'x', '1'],
            ['w', 'w', 'o', 'w', 'w', 'o', 'x', '2', 'x'],
            ['w', 'w', 'o', 'o', 'o', 'w', '1', '2', '2'],
            ['w', 'o', 'w', 'w', 'o', 'w', '1', '1', '1'],
            ['w', 'o', 'o', 'o', 'w', 'o', '2', 'x', '2'],
            ['o', 'w', 'w', 'w', 'o', 'w', '2', 'x', '2'],
            ['o', 'w', 'o', 'o', 'w', 'o', '1', '1', '1'],
            ['o', 'o', 'w', 'w', 'w', 'o', '1', '2', '2'],
            ['o', 'o', 'w', 'o', 'o', 'w', 'x', '2', 'x'],
            ['o', 'o', 'o', 'w', 'w', 'w', 'x', 'x', '1'],
            ['o', 'o', 'o', 'w', 'o', 'o', '2', '1', 'x']
          ];
        break;

}
console.log(haraHaettu);
  }
</script>


<!-- muutetaan html-taulukko js-muotoiseksi käyttäen apuna solun taustaväriä -->
<script>
     taulJSON = [];           // alkuperäiset tiedot
     taulJSONvali = [];       // taulukko väliaikaisia tietoja varten
     taulJSONvali2 = [];      // taulukko väliaikaisia tietoja varten
     taulJSONvali3 = [];      // taulukko väliaikaisia tietoja varten
     taulJSONvali4 = [];      // taulukko väliaikaisia tietoja varten
     taulJSONvali5 = [];      // taulukko väliaikaisia tietoja varten
     taulJSONapu = [];        // taulukko väliaikaisia tietoja varten
     taulJSONlopulliset = []; // lopullinen tulosjoukko
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
   console.log(aputauluw);

   //console.log(syotetytJS[0][0]);
   //console.log(syotetytJS[0][1]);
   //console.log(syotetytJS[0][2]);
   console.log("apukissa", aputaulu);
   console.log("apukissa2", aputaulu2);

   harajarj = document.getElementById('piilosysteemi').innerHTML;
   haeHaravat(harajarj);
   console.log("apuharava", harajarj);

   riviJSON = "";

   pituus = document.getElementById('piilorivia').innerHTML; //määräytyy haravan mukaan
   //console.log("piiloriviä", pituus, "harajärj", harajarj);

   kayt = 0;
   for (k = 0; k < pituus; k++) {

      kayt = 0;
      for (i = 0; i < 13; i++) {

        console.log("aput, aputw hara", i, aputaulu[i], aputauluw[i], k, kayt, haraHaettu[k][kayt]);

        // osittain ja täysin vaihdellut
        // osittain: laitetaan merkki haravasysteemin antaman vasen/oikea -tiedon mukaisesti
        // täysin:   laitetaan haravasysteemin antama merkki
        if (aputaulu[i] == 't' || aputaulu[i] == 'o') {

          if (aputaulu[i] == 't') {
              riviJSON = riviJSON + haraHaettu[k][kayt];
          }

          if (aputaulu[i] == 'o') {
              wo = haraHaettu[k][kayt];
              if (wo == "w") {
                riviJSON = riviJSON + aputauluw[i].charAt(0); //ensimmäinen eli vas.puol. merkki
              }
              if (wo == "o") {
                riviJSON = riviJSON + aputauluw[i].charAt(aputauluw[i].length - 1); //viim. eli oik.puol.
              }
          }

          kayt = kayt + 1;
        }

        // varmat
        for (j=1; j < 4; j++) {
       
            if (aputaulu[i] == 'v' && syotetytJS[i][j] != '') {
                //console.log("*",i,j,syotetytJS[i][j],"*");
                //console.log(syotetytJS[i][j]);
                //riviJSON = riviJSON + syotetytJS[i][j];
                riviJSON = riviJSON + aputaulu2[i];
            } 

          }
          //console.log (riviJSON);

        }
        taulJSON[k] = riviJSON;
        riviJSON = "";
    }

    // pudotetaan lopullisesta tulosjoukosta pois suodattimien karsimat rivit

    // suodatin 1-1-1-1
    chk1111 = document.getElementById('piilo_chk1111').innerHTML;
    console.log ("suodatin1111:", chk1111);
    console.log ("atul ", taulJSON);
    ykk = 0;
    pykk = 0;
    k = 0; // laskuri, jolla hoidetaan lopullisten määrä (ts. estetään tyhjät rivit)
    for (i = 0; i < taulJSON.length; i++) {
        ykk = 0;
        pykk = 0;
        alkio = Array.from(taulJSON[i]); // merkkijono taulukoksi
        for (j=0; j < 13; j++) {
            if (alkio[j] == "1") {
              ykk = ykk + 1;
              if (ykk > pykk) {
                pykk = ykk;
              }
            } else {
              ykk = 0;
            }
        }
        if ( (chk1111 == "") || (chk1111 == "1" && pykk <= 4) ) {
          taulJSONvali[k] = taulJSON[i];
          k++;
        }

    }

    // suodatin XXX
    // lähdetään liikkeelle edellisen suodattimen tulosjoukosta

    chkxxx = document.getElementById('piilo_chkxxx').innerHTML;
    //console.log ("suodatinxxx:", chkxxx);
    //console.log ("vali: ", taulJSONvali);
    ris = 0;
    pris = 0;
    k = 0; // laskuri, jolla hoidetaan lopullisten määrä (ts. estetään tyhjät rivit)
    for (i = 0; i < taulJSONvali.length; i++) {
        ris = 0;
        pris = 0;
        alkio = Array.from(taulJSONvali[i]); // merkkijono taulukoksi
        for (j=0; j < 13; j++) {
            if (alkio[j] == "x") {
              ris = ris + 1;
              if (ris > pris) {
                pris = ris;
              }
            } else {
              ris = 0;
            }
        }
        if ( (chkxxx == "") || (chkxxx == "1" && pris <= 3) ) {
          taulJSONvali2[k] = taulJSONvali[i];
          k++;
        }

    }

    // suodatin 222
    // lähdetään liikkeelle edellisen suodattimen tulosjoukosta

    chk222 = document.getElementById('piilo_chk222').innerHTML;
    //console.log ("suodatin222:", chk222);
    //console.log ("vali2: ", taulJSONvali2);
    kak = 0;
    pkak = 0;
    k = 0; // laskuri, jolla hoidetaan lopullisten määrä (ts. estetään tyhjät rivit)
    for (i = 0; i < taulJSONvali2.length; i++) {
        kak = 0;
        pkak = 0;
        alkio = Array.from(taulJSONvali2[i]); // merkkijono taulukoksi
        for (j=0; j < 13; j++) {
            if (alkio[j] == "2") {
              kak = kak + 1;
              if (kak > pkak) {
                pkak = kak;
              }
            } else {
              kak = 0;
            }
        }
        if ( (chk222 == "") || (chk222 == "1" && pkak <= 3) ) {
          taulJSONvali3[k] = taulJSONvali2[i];
          k++;
        }

    }

    // suodatin 1: 3->7
    // lähdetään liikkeelle edellisen suodattimen tulosjoukosta

    chk137 = document.getElementById('piilo_chk137').innerHTML;
    //console.log ("suodatin137:", chk137);
    //console.log ("vali3: ", taulJSONvali3);
    ykk = 0;
    k = 0; // laskuri, jolla hoidetaan lopullisten määrä (ts. estetään tyhjät rivit)
    for (i = 0; i < taulJSONvali3.length; i++) {
        ykk = 0;
        alkio = Array.from(taulJSONvali3[i]); // merkkijono taulukoksi
        for (j=0; j < 13; j++) {
            if (alkio[j] == "1") {
              ykk = ykk + 1;
            }
        }
        if ( (chk137 == "") || (chk137 == "1" && (ykk >= 3 && ykk <= 7)) ) {
          //taulJSONlopulliset[k] = taulJSONvali3[i];
          taulJSONvali4[k] = taulJSONvali3[i];
          k++;
        }

    }

    // suodatin %: ->7
    // lähdetään liikkeelle edellisen suodattimen tulosjoukosta

    chkpr7 = document.getElementById('piilo_chkpr7').innerHTML;
    console.log ("suodatinpr7:", chkpr7);
    // muutetaan php-taulukko js-taulukoksi
    var johde = <?php echo '["' . implode('", "', $johdettu) . '"]' ?>;
    console.log ("johto:", johde );
    //console.log ("vali4: ", taulJSONvali4);

    kpl = 0;
    k = 0; // laskuri, jolla hoidetaan lopullisten määrä (ts. estetään tyhjät rivit)
    for (i = 0; i < taulJSONvali4.length; i++) {
        kpl = 0;
        alkio = Array.from(taulJSONvali4[i]); // merkkijono taulukoksi
        for (j=0; j < 13; j++) {
            if (alkio[j] == johde[j]) {
              kpl = kpl + 1;
            }
        }
        if ( (chkpr7 == "") || (chkpr7 == "1" &&  kpl <= 7) ) {
          taulJSONlopulliset[k] = taulJSONvali4[i];
          k++;
        }

    }

    // suodatin ero 5->
    // lähdetään liikkeelle edellisen suodattimen tulosjoukosta
/*
    chkero5 = document.getElementById('piilo_chkero5').innerHTML;
    console.log ("suodatinero5:", chkero5);
    console.log ("vali4: ", taulJSONvali4);
    kpl = 0; 
    apuind = 1;
    taulJSONapu[0] = taulJSONvali4[0];
    console.log ("apuli: ", taulJSONapu, taulJSONapu.length);
    k = 0; // laskuri, jolla hoidetaan lopullisten määrä (ts. estetään tyhjät rivit)
    for (i = 1; i < taulJSONvali4.length; i++) {

        alkio = Array.from(taulJSONvali4[i]); // merkkijono taulukoksi
        for (ii = 0; ii < taulJSONapu.length; ii++) {
          console.log ("vali4, apu", i, ii, taulJSONvali4[i], taulJSONapu[ii]);
          perusalkio = Array.from(taulJSONapu[ii]); 
          kpl = 0;
          for (j=0; j < 13; j++) {
              if (alkio[j] != perusalkio[j] ) {
                kpl = kpl + 1;
              }
          }
          console.log ("kappeli", kpl);
          if (kpl >= 5) {
            taulJSONapu[apuind] = taulJSONvali4[ii];
            apuind++;
          }
        } 
    }
          
    if ( chkero5 == "") {
      for (k=0; k < taulJSONvali4.length; k++) {
        taulJSONlopulliset[k] = taulJSONvali4[k];
      }
    }
    if ( chkero5 == "1") {
      for (k=0; k < taulJSONapu.length; k++) {
        taulJSONlopulliset[k] = taulJSONapu[k];
      }
    }
*/
    //
    console.log ("lopulliset", taulJSONlopulliset);
    //console.log (taulJSON.length);
    //console.log (taulJSONlopulliset);
    //console.log (JSON.stringify(taulJSON));
    piilo0.innerHTML = taulJSON[0];

    var data = taulJSONlopulliset.join(',');
    console.log ("data: ", data);
    window.location.href = "home-log-out.php?data=" + data;
  }
</script>

</html>