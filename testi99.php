<!DOCTYPE html>
<html>
<body>

<?php
echo "My first PHP script!";
//phpinfo();

$php = "PHP";
$java = "Java";
$perl = "Perl";
$jscript = "Javascript";
$ots = "ohjelmointikielet";

echo "<h2>".$ots."</h2>";

echo "<ul>";
  echo "<li>".$php."</li>";
  echo "<li>".$java."</li>";
  echo "<li>".$perl."</li>";
  echo "<li>".$jscript."</li>";
echo "</ul>";

if (strpos($_SERVER['HTTP_HOST'],"azurewebsites") !== false) {
  $db_username_remote = 'azure';
  $db_password_remote = '6#vWHD_$';
  $db_server_remote = 'localhost:51861'; 
  $db_site_remote = 'https://istok.azurewebsites.net';
  echo "localhost:".$db_server_remote;
}

?>


</body>
</html>