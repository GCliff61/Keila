<?php
if (!session_id()) session_start();
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

    <div class="divheaderi">

      <section>

        <h3>Haravasta yleisesti</h3>
        <br/>
  
        <p>Järjestelmäpelaamisella tarkoitetaan usean rivin pelaamista
          yhteen ruudukkoon. Täydellinen järjestelmä pitää sisällään kaikki
          ne yksittäisrivit, jotka valituilla numeroilla/merkeillä voidaan
          muodostaa. <br/><br/>
          Yksi järjestelmäpelaamisen muoto on haravajärjestelmä.
          Haravaan eli epätäydelliseen järjestelmään on poimittu valikoitu
          rivimäärä vastaavasta täydellisestä järjestelmästä. Jokaiselle
          haravalle on tietty kaavionsa, jonka avulla pelijärjestelmä poimii ns. avainrivit. 
          Vakiossa esimerkiksi harava 0+4 (paras tulos -1) sisältää yhdeksän riviä kun vastaava 
          täydellinen järjestelmä sisältää 81 riviä.  <br/><br/>
        </p>

        <p>
          Vakion haravat on jaettu kolmeen ryhmään minimitakuun mukaan:<br/>
          • minimitakuu paras tulos -1 <br/>
          • minimitakuu paras tulos -2 <br/>
          • minimitakuu paras tulos -3 <br/>
          Minimitakuu kertoo, mikä on haravan taattu vähimmäistulos
          peliisi osuviin merkkeihin nähden.
          Esimerkki: Jos pelaaja on pelannut minimitakuu -2 -haravan
          ja peliriviin osuu 13 oikein, on hänellä varmasti kupongillaan
          11 oikein, mutta myös 13 oikein- ja 12 oikein -voittotulokset
          ovat mahdollisia.
        </p>

     </section>

    <aside> 
        <div className = "d-flex my-4">
          <?php echo "Esimerkkejä haravajärjestelmistä:"; ?> 
          <?php
              $ottelu=array();
              $harava=array();
              
              $get_data = file_get_contents("pt1_9_harava.json");
              $response = json_decode($get_data, true);

              $resultpt1=array();
              $arrlength=39;
              if (isset($response["rows"])) {
                for($x = 0; $x < $arrlength; $x++) {
                    $resultpt1[$x] = $response["rows"][$x]["mrk"];
                }
              }

              $get_data2 = file_get_contents("pt1_9_rivit.json");
              $response2 = json_decode($get_data2, true);
        

              $ottelupt1=array();
              $arrlength=9;
              if (isset($response2["rows"])) {
                for($x = 0; $x < $arrlength; $x++) {
                    $ottelu[$x] = $response2["rows"][$x]["rivi"];
                    $ottelupt1[$x] = $response2["rows"][$x]["rivi"];
                }
              }
              $ottelu = $ottelupt1;  // oletusarvo
              $harava = $resultpt1;  // oletusarvo

            //
            $get_data3 = file_get_contents("pt2_12_harava.json");
            $response3 = json_decode($get_data3, true);

            $resultpt2=array();
            $arrlength=39;
            if (isset($response3["rows"])) {
              for($x = 0; $x < $arrlength; $x++) {
                  $resultpt2[$x] = $response3["rows"][$x]["mrk"];
              }
            }

            $get_data4 = file_get_contents("pt2_12_rivit.json");
            $response4 = json_decode($get_data4, true);
      

            $ottelupt2=array();
            $arrlength=12;
            if (isset($response4["rows"])) {
              for($x = 0; $x < $arrlength; $x++) {
                $ottelupt2[$x] = $response4["rows"][$x]["rivi"];
              }
            }
            //
            $get_data5 = file_get_contents("pt3_10_harava.json");
            $response5 = json_decode($get_data5, true);

            $resultpt3=array();
            $arrlength=39;
            if (isset($response5["rows"])) {
              for($x = 0; $x < $arrlength; $x++) {
                $resultpt3[$x] = $response5["rows"][$x]["mrk"];
              }
            }

            $get_data6 = file_get_contents("pt3_10_rivit.json");
            $response6 = json_decode($get_data6, true);
      

            $ottelupt3=array();
            $arrlength=10;
            if (isset($response6["rows"])) {
              for($x = 0; $x < $arrlength; $x++) {
                $ottelupt3[$x] = $response6["rows"][$x]["rivi"];
              }
            }

          ?>

            
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

          <div class="row">
          <div class="column">

            <div class="form-group" id="outer">
              <input class="inner" type="submit" name="submit" value="PT-1">
              <input class="inner" type="submit" name="submit2" value="PT-2">
              <input class="inner" type="submit" name="submit3" value="PT-3">
            </div>

            <?php

              if(isset($_POST['submit'])) {
                $ottelu = $ottelupt1;
                $harava = $resultpt1;

              }
              if(isset($_POST['submit2'])) {
                $ottelu = $ottelupt2;
                $harava = $resultpt2;
              }
              if(isset($_POST['submit3'])) {
                $ottelu = $ottelupt3;
                $harava = $resultpt3;          
              }

            ?>
    </div>
    </div>
    <div class="row">
    <div class="column">

            <table style="margin-left:10px";>

              <thead className = "thead-dark">
                <tr>
                  <th>1</th>
                  <th>X</th>
                  <th>2</th>
                </tr>
              </thead>

              <tbody className = "body-normal">

                <?php for ($i = 0; $i < 39; $i += 3) : // step 3 ?> 
                
                  <tr>
                    <td><?php if (isset($harava[$i])) {echo $harava[$i];} ?></td>
                    <td><?php if (isset($harava[$i + 1])) {echo $harava[$i + 1];} ?></td>
                    <td><?php if (isset($harava[$i + 2])) {echo $harava[$i + 2];} ?></td>
                  </tr>

                <?php endfor; ?>

              </tbody>

          </table>

      </div>

    

          <div class="column"> 

                <table style="margin-top:5px" class="khalli" border="2">

                <thead className = "thead-dark">
                  <tr>
                    <th>rivit</th>
                  </tr>
                </thead>

                <tbody className = "body-normal">

                  <?php for ($i = 0; $i < count($ottelu); $i++) : ?>

                  <tr>
                    <td><?php if (isset($ottelu[$i])) {echo $ottelu[$i];} ?></td>
                  </tr>

                  <?php endfor; ?>

                </tbody>
              </table>


          </div> <!-- column -->

          </div> <!-- row -->

        </form> 
        </div> <!-- d-flex -->
    </aside>

  </div>

</body>
</html>