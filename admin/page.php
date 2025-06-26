<?php
/*
=======================================================
==  [==>  Items Page  <==]  
=======================================================
*/
ob_start();
session_start();
$pageTitle = "Items";

if(isset($_SESSION[''])){ 
    include 'ini.php' ; 
    $do = isset($_GET['do'] ? $_GET['do']  : 'Manage' ) ;
    //---------------------------
    
    if ($do == 'Manage'){
        echo 'Welcome in Items Page ';

    
    }elseif ( $do == 'ADD')
    {
       

    }elseif ( $do == 'Insert')
    {
        echo 'Welcome in Insetrt page  PAGE ';
    }elseif ( $do == 'Edit')
    {
        echo 'Welcome in Insetrt page  PAGE ';
    }elseif ( $do == 'Update')
    {
        echo 'Welcome in Insetrt page  PAGE ';
    }elseif ( $do == 'Delete')
    {
        echo 'Welcome in Insetrt page  PAGE ';
    }elseif ( $do == 'Approve')
    {
        echo 'Welcome in Insetrt page  PAGE ';
    }else {
        echo 'Error / there are not page name ';
    }
    
 include $tbl . 'footer.php' ;  


/* if not UserName in Session redirect to index.php to login  */   
}else {
header('location:index.php');
exit();
}
ob_end_flush();







?>
