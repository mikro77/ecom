<?php 


ini_set('display_errors','on');
error_reporting(E_ALL);

$sessionUser = '' ;

if(isset($_SESSION['User'])){

$sessionUser  =  $_SESSION['User'] ;

}

include 'admin/connect.php';
// Route 
$tbl = "inc/temp/" ;
$js = "layout/js/";
$css = "layout/css/";
$func = "inc/func/";
$langu = "inc/lang/";

// include files 
include $func  ."function.php" ; 
include $langu ."english.php" ; 
include $tbl   ."header.php" ; 


//include navbar without noNavbar Variable 
include $tbl . "navbar.php" ;

 
?>