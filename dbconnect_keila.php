<?php
$db_username_local = 'root';
$db_password_local = '';
$db_server_local = '127.0.0.1';
$db_site_local = "http://localhost";

if (strpos($_SERVER['HTTP_HOST'],"azurewebsites") !== false) {
    $db_username_local = 'azure';
    $db_password_local = '6#vWHD_$';
    $db_server_local = 'localhost:51861'; 
    $db_site_remote = 'https://istok.azurewebsites.net';
}

$palvelin = $db_server_local;
$kayttaja = $db_username_local;
$salasana = $db_password_local;
//$palvelin = "localhost";
//$kayttaja = "root";  // tämä on tietokannan käyttäjä, ei tekemäsi järjestelmän
//$salasana = "";
$tietokanta = "keila";

// luo yhteys
$yhteys = new mysqli($palvelin, $kayttaja, $salasana, $tietokanta);

// jos yhteyden muodostaminen ei onnistunut, keskeytä
if ($yhteys->connect_error) {
   die("Yhteyden muodostaminen epäonnistui: " . $yhteys->connect_error);
}
// aseta merkistökoodaus (muuten ääkköset sekoavat)
$yhteys->set_charset("utf8");



?>