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

    <?php include 'navityylikas.php';?>

    <div class="divheaderi">

        <section>

            <h3>Taustatietoa</h3>
            <br/>
        
            <p>Eräs hyvin tuntemani henkilö on aina ollut innokas pelaamaan vakioveikkausta.
            <br/>Hän alkoi tutkailla vakioveikkauksen järjestelmiä tarkemmin ja huomasi, että
                haravajärjestelmät tuottivat lukusia hänen mielestään "järjettömiä" rivejä.
            <br/>Tälläisiä olivat muunmuassa rivit, joissa oli liian monta samaa merkkiä peräkkäin 
            <br/>esim. seitsemän ykköstä tai viisi ristiä  jne.  <br/><br/>
            </p>

            <p>
                Tämän pohjalta hän kehitteli aparaatin, jonka avulla pystyi helposti valikoimaan 
            <br/>omalle silmälle sopivia rivejä.
                Aparaatti koostui puisesta levystä, johon oli kiinnitetty 
            <br/>13 vaakasuoraan liikuteltavaa tankoa. 
                Jokaisessa tangossa oli pienillä teipinpaloilla 
            <br/>kiinnitetty arvot "1", "x" ja "2" - useampaan kertaan.
                Tankoja liikuttamalla pystyi sitten luomaan järkeviä, silmään sopivia rivejä.
                <br/><br/>
            </p>

            <p>
                Useamman vuoden ahkeran seurannan tuloksena syntyi joukko "sääntöjä", joilla haravajärjestelmien
                tuottamaa rivimäärää pystyi pienentämään huomattavasti. 
            <br/>Tämä ohjelma perustuu näihin havaintoihin.
            <br/><br/>Käytännössä siis tuo vanha puinen aparaatti siirrettiin digitaaliseen muotoon.
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

</body>
</html>