<?php


if (!function_exists('lang')) { 
 
  function lang($phrase) {

    static $lang = array (
       //DASHBOARD PAGE
        'HOME-ADMIN' => 'Welcome' ,
        'Comments' => 'Comments' ,
        'Categories'=>'Categories'
         ) ;

    return $lang[$phrase]; 
}
 
} 


// function_exists Return true if this function is decliration 
// !function_exists Return true if this function is not decliration 

?>