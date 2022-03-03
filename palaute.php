<?php if (!session_id()) session_start(); 
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
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css">
  <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include 'pura.php';?>
    <?php include 'navityylikas.php';?>
    <?php include ("dbconnect_keila.php"); ?>

    <div class="divheaderi">
      <section>
 
        <h3 class="kotitxt3">Palautteen paikka</h3>
        <br/>
        <p>Kerro meille, kuinka olemme onnistuneet.</br></p>
        <p>Otamme vastaan kehuja ja niiden lisäksi myös rakentavaa palautetta!</br></p>
        <br/><bt/>

        <?php
          $titleErr = $erhe = $palauteteksti ="";
          if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit'])) {
            if (empty($_POST["palauteteksti"])) {
              //$titleErr = "Annathan myös selityksen";
              //$erhe = "1";
            } else {
              $palauteteksti = test_input($_POST["palauteteksti"]);
            }
            if ($erhe == "") {
              $query = "INSERT INTO palaute (palaute, rating) VALUES
                 ('$palauteteksti', 5)";
                 echo 'query: '.$query;
              $yhteys->query($query);
              $lisatty=$yhteys->affected_rows;
              echo "<div>$lisatty</div>";
              echo "Virhe: $yhteys->error";
            }
          }
          function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }
        ?>


        <div class="pala">
          <label for="palauteteksti">Kehut ja rakentavat palautteet:</label>
          <textarea id="palauteteksti" name="palauteteksti" rows="5" cols="100"> </textarea>
        </div>

        <div class="star-rating">
          <div class="thanks-msg">Kiitos palautteestasi !!!</div>
            <div class="star-input">
              <input type="radio" name="rating" id="rating-5">
                <label for="rating-5" class="fas fa-star"></label>
              <input type="radio" name="rating" id="rating-4">
                <label for="rating-4" class="fas fa-star"></label>
              <input type="radio" name="rating" id="rating-3">
                <label for="rating-3" class="fas fa-star"></label>
              <input type="radio" name="rating" id="rating-2">
                <label for="rating-2" class="fas fa-star"></label>
              <input type="radio" name="rating" id="rating-1">
                <label for="rating-1" class="fas fa-star"></label>

              <!-- Rating Submit Form -->
              <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                  <span class="rating-reaction"></span>
                  <button type="submit" name="submit" class="submit-rating">Lähetä palaute</button> 
              </form>
          </div>
      </div>

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
    </aside>

  </div>

<script>
  const btn = document.querySelector(".submit-rating");
  const thanksmsg = document.querySelector(".thanks-msg");
  const starRating = document.querySelector(".star-input");

  // Success msg show/hide
  btn.onclick = () => {
    var ratev = document.querySelector("input[name=rating]:checked").value;
    //ratev = 1;
    //alert(ratev);
    starRating.style.display = "none";
    thanksmsg.style.display = "table";
      return false;
  };
</script>

</body>
</html>