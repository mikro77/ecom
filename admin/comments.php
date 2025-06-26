<?php 

/*
============================
 == [  Mange COMMENT page  ]
 == [  You Can Add -- Edit -- Delete Member From Here  ]
 ===================== =====
 */

session_start();
$pageTitle = "Comments";

/*** check if the users is already logged in ***/
if(isset($_SESSION['Username'])) {
     include 'ini.php'; 
     $do = "" ;
     if(isset($_GET['do'])){
      $do = $_GET['do'] ;
     }else {
         $do = 'Manage' ; 
     }

if ($do == "Manage"){
    
 
    $stmt = $dbh->prepare(" SELECT  comments.*,  items.Name AS item_id , users.Username AS user
                            FROM 
                            comments
                            INNER JOIN
                            items
                            ON 
                            items.Item_ID = comments.item_id
                            INNER JOIN
                            users
                            ON
                            users.UserID = comments.user_id
    ") ;
    $stmt->execute();
    $rows = $stmt->fetchAll();
    


  
     
   
    ?>

<h1 class="text-center"> Mange page </h1>
<div class="container">
<div class="table-responsive">
<table class="main-table table table-bordered"> 

    <tr>
    <td>#ID</td>
    <td>comment</td>
    <td>item name</td>
    <td>user name</td>
    <td>add DATE</td>
    <td>Control</td>
    </tr>
   
   <?php 
   

   /*  INSERT INTO `comments` (`c_id`, `status`, `comment_date`, `item_id`, `user_id`    */
   foreach($rows as $row) {

    $id = $row['c_id'];
    $comment = $row['comment'];
    $itemid = $row['item_id'];
    $userid = $row['user'];
    $Date = $row['comment_date'];
   
       echo "<tr>" ; 
       echo "<td>  .  $id   . </td>" ; 
       echo "<td>  .  $comment  . </td>" ; 
       echo "<td>  . $itemid  . </td>" ; 
       echo "<td>  .  $userid    . </td>" ; 
       echo "<td>  .  $Date   . </td>" ; 
       echo '<td> 
       <a href="comments.php?do=Edit&commentid=' . $row['c_id'] .' " class="btn btn-succeess"> Edit   </a>
       <a href="comments.php?do=Delete&commentid=' . $row['c_id'] .' " class="btn btn-danger confirm"> Delete </a> ' ;
       if ($row['status'] == 0 ){
        echo '<a href="comments.php?do=Approve&commentid=' . $row['c_id'] .' " class="btn btn-info "> Approve </a> ';
        }
       echo'</td>' ;
       echo "</tr> " ; 

   }
   
   ?>
   
</table>
</div> 
</div>

<?php
}elseif ( $do == "Edit" ){ 

          $comid = isset($_GET['commentid']) && is_numeric ($_GET['commentid']) ? intval ($_GET['commentid']) : 0 ;   
          $stmt = $dbh->prepare("SELECT * FROM comments Where c_id = ? ");
          $stmt->execute(array($comid));
          $row = $stmt->fetch();
          $count = $stmt->rowCount();
          // if Count > 0 this DB contain Record username    
            
            if($stmt->rowCount() > 0 ) {

?>

<h1 class="text-center"> Edit Comment <h1>
<div class="container">
<form class="form-horizontal " action="?do=update" method="POST"> 
<input  type="hidden" name="comid"  value="<?php echo  $comid ; ?> "> 
            <div class="form-group has-success form-group-lg  "> 
                <label class="control-label col-sm-2" >Comment</label> 
                <div class="col-sm-10 col-md-6"> 
                    <input class="form-control " require="required" type="text" name="comment" autocomplete="off" value="<?php echo $row['comment']; ?> "> 
                </div> 
            </div> 

            <div class="form-group has-success form-group-lg"> 
                <div class="col-sm-offset-2 col-sm-10"> 
                <button type="submit" value="Save" class="btn btn-primary btn-lg"> 
                   Update Comment
                </button> 
                </div>
            </div> 


        </form> 
</div>
<?PHP

    }// if count > 0 

    else {

    echo "<div class='container'>" ;  
    $theMSG = 'ther is no such id'  ;
    redirectHome($theMSG);
    echo "</div>";

     }

 } // if do  == Edit
 
 elseif($do == "update") {

echo "<h1 class='text-center'> Update comment </h1>"; 
echo "<div class='container' >";
 if($_SERVER['REQUEST_METHOD'] == 'POST' ){

    // GET VARIABLE 
   $comid   = $_POST['comid'];
   $comment = $_POST['comment'];

   
        $stmt = $dbh->prepare("UPDATE comments SET comment = ?  WHERE c_id = ?  ");
        $stmt->execute(array($comment  ,  $comid ));
        echo "<div class='container'>" ;  
        $theMSG = $stmt->rowCount() .  ' : Row counnt Updated'  ;
        redirectHome($theMSG , 'back');    
        echo "</div>";
 

   } else {
    echo "<div class='container'>" ;  
    $theMSG = '<div class="alert alert-danger"> soory you cant brower this Direct </div>'  ;
    redirectHome($theMSG );    
    echo "</div>";
  
   }
   echo "</div>";
} // if do == update

elseif($do == "Approve"){

    echo "<h1 class='text-center'> Activate Member </h1>"; 
    $comid = isset($_GET['commentid']) && is_numeric ($_GET['commentid']) ? intval ($_GET['commentid']) : 0 ;   
   
    $check = checkitem ("c_id","comments", $comid) ;
    if($check>0){

        $stmt = $dbh->prepare("UPDATE comments SET status = 1  Where c_id = ? ");
        $stmt->execute(array($comid));

        echo "<div class='container'>" ;  
        $theMSG = '<div class="alert alert-danger" > this member Approved  </div> <br />'  ;
        redirectHome($theMSG , 'back');
        echo "</div>";
     
         }else {
     
             echo "<div class='container'>" ;  
             $theMSG = '<div class="alert alert-danger"> ther is no such id </div>'  ;
             redirectHome($theMSG . 'back');
             echo "</div>";
     
         }





    echo "<div class='container' >";

    echo "</div>";

}
/*  */
elseif($do = "Delete"){

    echo "<h1 class='text-center'> Delete comment </h1>"; 
    echo "<div class='container' >";

    $comid = isset($_GET['commentid']) && is_numeric ($_GET['commentid']) ? intval ($_GET['commentid']) : 0 ;   
     

    $check = checkItem('c_id','comments',$comid );
    
  
  if($check > 0 ) {

    $stmt = $dbh->prepare("DELETE FROM comments Where c_id = :comid");
    $stmt->bindParam('comid', $comid, PDO::PARAM_STR);
    $stmt->execute();
   // $stmt-> bindParam("zuser",$userid) ;
   //$stmt->execute();

   echo "<div class='container'>" ;  
   $theMSG = '<div class="alert alert-danger" > this member deleted </div> <br />'  ;
   redirectHome($theMSG);
   echo "</div>";

    }else {

        echo "<div class='container'>" ;  
        $theMSG = '<div class="alert alert-danger"> ther is no such id </div>'  ;
        redirectHome($theMSG);
        echo "</div>";
    }

    echo "</div>";
}


include  $tbl .'footer.php';

} // if isset username
else {

    header('Location:index.php');
    exit();
}














/*

elseif($do = "Delete"){
    
    echo "<h1 class='text-center'> Delete Member </h1>"; 
    echo "<div class='container' >";
    
            $userid = isset($_GET['userid']) && is_numeric ($_GET['userid']) ? intval ($_GET['userid']) : 0 ;   
            $stmt = $dbh->prepare("SELECT * FROM users Where UserID = ? LIMIT 1 ");
            $stmt->execute(array($userid));
            $count = $stmt->rowCount();
            // if Count > 0 this DB contain Record username    
          
          if($stmt->rowCount() > 0 ) {
            $stmt = $dbh->prepare("DELETE FROM users Where UserID = :zuser");
            $stmt->bindParam('zuser', $userid, PDO::PARAM_STR);
            $stmt->execute();
           // $stmt-> bindParam("zuser",$userid) ;
           //$stmt->execute();
    
           echo "<div class='container'>" ;  
           $theMSG = '<div class="alert alert-danger" > this member deleted </div> <br />'  ;
           redirectHome($theMSG);
           echo "</div>";
    
            }else {
    
                echo "<div class='container'>" ;  
                $theMSG = '<div class="alert alert-danger"> ther is no such id </div>'  ;
                redirectHome($theMSG);
                echo "</div>";
    
            }
    
            echo "</div>";
        }
    
    



*/


?> 
