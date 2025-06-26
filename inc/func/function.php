<?php 

/*
**
**Function To Get Categories From DataBase 
* GET Cats 
*/


function getcat(){
    global $dbh ;   
    $statement  = $dbh->prepare("SELECT * FROM categories ORDER BY ID DESC ");
    $statement->execute();
    $categorys = $statement->fetchAll();
    return $categorys;
}



/*
**
**Function To Get items From DataBase 
* GET items
*/

function getitem($where , $value){
    global $dbh ;   
    $statement  = $dbh->prepare("SELECT * FROM items WHERE $where  = ?  ORDER BY Item_ID  DESC ");
    $statement->execute(array($value));
    $itemes = $statement->fetchAll();
    return $itemes;
}
/*
/*
**



**get title page 
*/
    function getTitle () {
    global $pageTitle ;
    if(isset($pageTitle)){
    echo  $pageTitle ; 
    }else{
    echo "Defult"; 
    }

    }

/*
/*
**
**get title page 
*/

function CheckUserState($user) {
global $dbh ; 
$stmtx = $dbh->prepare("SELECT
                         Username,RegStatus
                     FROM users 
                     WHERE 
                     Username = ? 
                     AND 
                     RegStatus = 0 
                     ");
$stmtx->execute(array($user));
$status = $stmtx->rowCount();
return $status ;

}

//---------------------------------------
//---------------------------------------

function redirectHome ($theMsg ,$url = null, $Seconds = 3 ){
   if($url === null){
   $url = 'index.php';
   $link = 'Homepage';
   } else{

    if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ) 
    {
     $url = $_SERVER['HTTP_REFERER'] ;
     $link = 'Previous Page';
    } else {
    $url = 'index.php' ;
    $link = 'Homepage';
    }

    }
    echo "<div class = 'alert alert-danger' > ". $theMsg ."  </div>";
    echo "<div class = 'alert alert-info' > You Will Be Redirect to Home After " . $Seconds . " Second .  </div>";
    header("refresh:$Seconds;url=$url");
    exit();

}

/*
**
**Select Item From DB  
**Function To Slect any ITEM From ANY Table by ANY Value 
**
*/

function checkitem ($select, $from, $value){
    global $dbh ; 
    $statement = $dbh->prepare("SELECT $select FROM $from WHERE $select = ? ");
    $statement->execute(array($value));
    $count = $statement->rowCount();
    return $count ;
}


/*
**
**Count Number OF Items V1.0 
**Function To Count Numbers
**
*/

function CountItems($items,$table){

     global $dbh ;   
     $statement  = $dbh->prepare("SELECT COUNT($items) FROM $table");
     $statement->execute();
     return $statement->fetchColumn();
}

/*
**
**get leatest items from  V1.0 
* GET uers Items From DB 
! 44444444444
? wwwwwwwwwwwww
todo 111111111111
*/

function getlatest($select,$table,$order,$limit = 5 ){

    global $dbh ;   
    $statement  = $dbh->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit ");
    $statement->execute();
    $rows = $statement->fetchAll();
    return $rows;

}

?>



