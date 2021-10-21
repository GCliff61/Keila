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

    <nav class="navbar">
     <!-- NAVIGATION MENU -->
     <ul class="nav-links">
       <!-- USING CHECKBOX HACK -->
       <input type="checkbox" id="checkbox_toggle" />
       <label for="checkbox_toggle" class="hamburger">&#9776;</label>
       <!-- NAVIGATION MENUS -->
       <div class="menu">
         
       <li><a href="home-log-out.php"><i class="fa fa-fw fa-home"></i>Koti/kirjaudu sisään</a></li>
         <li><a href="signup.php">Rekisteröidy</a></li>
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

   <h2 class="kotitxt">Palautteen paikka</br>
  <h3 class="kotitxt2">Kerro meille, kuinka olemme onnistuneet.</br>
  <h3 class="kotitxt3">Otamme vastaan kehuja ja niiden lisäksi myös rakentavaa palautetta!</br>
  </br>

  <?php
    include ("dbconnect_keila.php");
  ?>

<?php
    $titleErr = $erhe = $palauteteksti ="";
    //echo 'requ: '.$_SERVER['REQUEST_METHOD'] ;
    //echo 'subm: '.isset($_POST['submit']) ;
    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit']))
    {
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
    <textarea id="palauteteksti" name="palauteteksti" rows="5" cols="300"> </textarea>
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


   <div class="footer">
        <p>Footerien footer &copy;</p>
    </div>

</body>