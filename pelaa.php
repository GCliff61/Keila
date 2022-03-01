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
  <?php include 'navityylikas.php';
  ?>

  <?php
    $aputaulu = array();
  ?>

  <!-- Perusrakenne   -->
  <!-- header         -->
  <!-- section  aside -->
  <div class="divheaderi">

    <section>

      <div class="f-c">

        <h3>Haravajärjestelmällä pelaaminen</h3><br/>

        <h5>• valitse haravajärjestelmä</h5><br/>
        <h5>• täytä ruudukko</h5><br/>
        <h5>• valitse suodatus</h5>

 
        <form class="formi" action="" method="post">
            
          <div class="wrapper">

            <label>Haravajärjestelmät</label><br>
            <select name="haravat" id="haravat" class="haravat" size="1" required>
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
          <div>
            <p><input type="text" name="vaihdellut" id="vaihdellut" hidden></p>
            <p id="piilovarmat" hidden></p>
            <p id="piiloosittain" hidden></p>
            <p id="piilotaysin" hidden></p>
            <p id="piilorivia" hidden></p>           
            <p id="piilo0" hidden></p>
            <p><input type="button" id="bt" value="Show Table Data" onclick="showTableData(0)" hidden /></p>
            <p><input type="button" id="btt" value="Tyhjennä" onclick="tyhjenna()" /></p>
            <p><input type="button" id="bttt" value="Test" onclick="konvertoi_ruudukko()" /></p>


            <p id="infov"></p>
            <p id="infoo"></p>
            <p id="infot"></p>
          </div>

      </form>
 
    </div>


    <div class="f-c-35">
      <div className = "d-flex my-4">

      <table class="hara" name="hara" id="hara" className = "table table-bordered" hidden>
      <thead className = "thead-dark">
            <tr>
              <th>1</th>
              </tr>
          </thead>
          <tbody className = "body-normal">
            <tr>
              <td onclick="toggleHighlight()">v</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">o</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">t</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
            </tr>

          </tbody>
      </table>

        <table class="syotetyt" name="syotetyt" id="syotetyt" className = "table table-bordered">

          <thead className = "thead-dark">
            <tr>
              <th>1</th>
              <th>X</th>
              <th>2</th>
              </tr>
          </thead>
          <tbody className = "body-normal">
            <tr>
              <td onclick="toggleHighlight()">1</td>
              <td onclick="toggleHighlight()">x</td>
              <td onclick="toggleHighlight()">2</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
              <td onclick="toggleHighlight()">x</td>
              <td onclick="toggleHighlight()">2</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
              <td onclick="toggleHighlight()">x</td>
              <td onclick="toggleHighlight()">2</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
              <td onclick="toggleHighlight()">x</td>
              <td onclick="toggleHighlight()">2</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
              <td onclick="toggleHighlight()">x</td>
              <td onclick="toggleHighlight()">2</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
              <td onclick="toggleHighlight()">x</td>
              <td onclick="toggleHighlight()">2</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
              <td onclick="toggleHighlight()">x</td>
              <td onclick="toggleHighlight()">2</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
              <td onclick="toggleHighlight()">x</td>
              <td onclick="toggleHighlight()">2</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
              <td onclick="toggleHighlight()">x</td>
              <td onclick="toggleHighlight()">2</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
              <td onclick="toggleHighlight()">x</td>
              <td onclick="toggleHighlight()">2</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
              <td onclick="toggleHighlight()">x</td>
              <td onclick="toggleHighlight()">2</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
              <td onclick="toggleHighlight()">x</td>
              <td onclick="toggleHighlight()">2</td>
            </tr>
            <tr>
              <td onclick="toggleHighlight()">1</td>
              <td onclick="toggleHighlight()">x</td>
              <td onclick="toggleHighlight()">2</td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>

  </section>

  <aside>
    <div className = "d-flex my-4">


  <form class="formiAside" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
     <div class="f-c">
      <label>Suodattimet:</label><br/>
    </div>
    <div class="form-group" id="outer">
          <input class="inner" type="submit" name="submit" value="PT-1">
          <input class="inner" type="submit" name="submit2" value="PT-2">
          <input class="inner" type="submit" name="submit3" value="PT-3">
   </div>
  </form>
    <div class="f-c-35">
      <div className = "d-flex my-4"> 
      <?php
        $url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        $components = parse_url($url);
        if (isset($components['query'])) {
          parse_str($components['query'], $results);
          $ottelu=array();
          $ottelu=explode(",",$results['data']);
          // tehdään tallennus jo täällä
          $bytes = file_put_contents("pelit.json", json_encode($ottelu)); 
        }
      ?>
        <?php //$ottelu=array('1x21x21x21x21','1','1','1','1','1','1','1','1','1','1','1','1'); ?>
         <table name="khalli" id="khalli" style="margin-top:5px"; class="khalli" border="2">

          <thead className = "thead-dark">
            <tr>
              <th>rivit</th>
            </tr>
          </thead>
          <tbody className = "body-normal">
            <tr>
              <td><?php if (isset($ottelu[0])) {echo $ottelu[0];} ?></td>
            </tr>
            <tr>
              <td><?php if (isset($ottelu[1])) {echo $ottelu[1];} ?></td>
            </tr>
            <tr>
              <td><?php if (isset($ottelu[2])) {echo $ottelu[2];} ?></td>
            </tr>
            <tr>
              <td><?php if (isset($ottelu[3])) {echo $ottelu[3];} ?></td>
            </tr>
            <tr>
              <td><?php if (isset($ottelu[4])) {echo $ottelu[4];} ?></td>
            </tr>
            <tr>
              <td><?php if (isset($ottelu[5])) {echo $ottelu[5];} ?></td>
            </tr>
            <tr>
              <td><?php if (isset($ottelu[6])) {echo $ottelu[6];} ?></td>
            </tr>
            <tr>
              <td><?php if (isset($ottelu[7])) {echo $ottelu[7];} ?></td>
            </tr>
            <tr>
              <td><?php if (isset($ottelu[8])) {echo $ottelu[8];} ?></td>
            </tr>
            <tr>
              <td><?php if (isset($ottelu[9])) {echo $ottelu[9];} ?></td>
            </tr>
            <tr>
              <td><?php if (isset($ottelu[10])) {echo $ottelu[10];} ?></td>
            </tr>
            <tr>
              <td><?php if (isset($ottelu[11])) {echo $ottelu[11];} ?></td>
            </tr>
            <tr>
              <td><?php if (isset($ottelu[12])) {echo $ottelu[12];} ?></td>
            </tr>

          </tbody>
        </table>

     </div>  
    </div>

      </div>
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
<!--
<script> 
      var valitut = document.getElementById("syotetyt"), rIndex, cIndex;
      for (var i=0; i < valitut.rows.length; i++)
      {
        for (var j=0; j < valitut.rows[i].cells.length; j++)
        {
            valitut.rows[i].cells[j].onclick = function()
            {
                rIndex = this.parentElement.rowIndex;
                cIndex = this.cellIndex;
                console.log(rIndex, cIndex);
                var color = $(this).css('background-color');
                console.log(color);
                if (color == 'rgb(170, 170, 170)')
                  console.log("oli valittu");
            };
        } 
      }

</script>
    -->

<script>
    var aputaulu = [];
    function showTableData(p1, p2, p3, p4) {

        document.getElementById('infov').innerHTML = "Varma:......";
        document.getElementById('infoo').innerHTML = "Osittain:....";
        document.getElementById('infot').innerHTML = "Täysin:.....";

        var myTab = document.getElementById('syotetyt');

        var osittain = 0;
        var taysin = 0;
        var varma = 0;


        // LOOP THROUGH EACH ROW OF THE TABLE AFTER HEADER.
        for (i = 1; i < myTab.rows.length; i++) {

            // GET THE CELLS COLLECTION OF THE CURRENT ROW.
            var objCells = myTab.rows.item(i).cells;

            // LOOP THROUGH EACH CELL OF THE CURENT ROW TO READ CELL VALUES.
            var kpl  = 0;
            for (var j = 0; j < objCells.length; j++) {
                //if (objCells.item(j).innerHTML == '1') {
                if (objCells.item(j).style.background == "rgb(170, 170, 170)") {
                  kpl = kpl + 1;
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
                break;
              case 2:
                osittain= osittain + 1;
                //console.log("i kissa ositt",i);
                aputaulu[i-1] = 'o';
                break;
              case 3:
                taysin = taysin + 1;
                //console.log("i kissa tays",i);
                aputaulu[i-1] = 't';
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

<!--  haravasysteemin valinta  
        systeemitunnus: systeemi, osittain vaihdeltuja, täysin vaihdeltuja
        (alaviivalla erotettuna) esim. pt2_8_0
-->
<script>
   document.getElementById('haravat').addEventListener('change', function(e){
   var systeemitunnus = "";
   var varmatlask = 0;
   if (e.target.name==='haravat') {
       /* alert(e.target.value); */
       vaihdellut.innerHTML = e.target.value;
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

<!-- näytön virkistys -->
<script>
  function tyhjenna() {
    location.reload();
    return false;
  }
</script>

<script>
  var pt1_0_4_9 = [];
  function haeHaravat() {
    pt1_0_4_9 = [
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
console.log(pt1_0_4_9);
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


</html>