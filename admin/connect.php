<?php

try {
$dbh = new PDO('mysql:host=localhost;dbname=shop','root','', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); 
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
/*echo 'YOU ARE CONNECTED WELCOME DATABASE';*/
}
catch (PDOException $e) {
echo 'Faild TO Connect ' . $e->getMessage(); 
}

?>


