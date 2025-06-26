<?php 

include 'connect.php';
// Route 
$tbl = "include/temp/" ;
$js = "layout/js/";
$css = "layout/css/";
$func = "include/func/";
$langu = "include/lang/";


// include files 

include $langu ."english.php" ; 
include $tbl   ."header.php" ; 
include $func  ."function.php" ; 

//include navbar without noNavbar Variable 
if(!isset($noNavbar)){include $tbl . "navbar.php" ; }

 
?>