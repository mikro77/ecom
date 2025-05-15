<?php 

/*
============================
 == [  Mange Member page  ]
 == [  You Can Add -- Edit -- Delete Member From Here  ]
 ===================== =====
 */

session_start();
$pageTitle = "Members";

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
    
    $quary = '';
    if(isset($_GET['page'])  && $_GET['page'] == 'pending' ){
        $quary = " AND RegStatus = 0 ";
    }
     
    $stmt = $dbh->prepare("SELECT * FROM users WHERE GroubID != 1 $quary") ;
    $stmt->execute();
    $rows = $stmt->fetchAll();
    
    ?>

<h1 class="text-center"> Mange page </h1>
<div class="container">
<div class="table-responsive">
<table class="main-table table table-bordered"> 

    <tr>
    <td>#ID</td>
    <td>UserName</td>
    <td>Email</td>
    <td>FullName</td>
    <td>Register DATE</td>
    <td>Control</td>
    </tr>
   
   <?php 
   
   foreach($rows as $row) {

    $id = $row['UserID'];
    $user = $row['Username'];
    $Email = $row['Email'];
    $FullName = $row['FullName'];
    $Date = $row['Date'];
   
       echo "<tr>" ; 
       echo "<td>  .  $id   . </td>" ; 
       echo "<td>  .  $user   . </td>" ; 
       echo "<td>  .  $Email  . </td>" ; 
       echo "<td>  .  $FullName   . </td>" ; 
       echo "<td>  .  $Date   . </td>" ; 
       echo '<td> 
       <a href="members.php?do=Edit&userid=' . $row['UserID'] .' " class="btn btn-succeess"> Edit   </a>
       <a href="members.php?do=Delete&userid=' . $row['UserID'] .' " class="btn btn-danger confirm"> Delete </a> ' ;
       if ($row['RegStatus'] == 0 ){
        echo '<a href="members.php?do=Activate&userid=' . $row['UserID'] .' " class="btn btn-info "> Activate </a> ';
        }
       echo'</td>' ;
       echo "</tr> " ; 

   }
   
   ?>
   
</table>
</div> 
<a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"> </i> Add new Members </a> 
</div>

<?php
}elseif($do == "Add"){
echo " Welcome to Add Members " ;

 ?>

<h1 class="text-center"> ADD NEW MEMBERS  <h1>
<div class="container">
<form class="form-horizontal " action="?do=Insert" method="POST"> 
            <div class="form-group has-success form-group-lg  "> 
                <label class="control-label col-sm-2" >Username</label> 
                <div class="col-sm-10 col-md-6"> 
                    <input class="form-control " require="required" type="text" name="username" autocomplete="off" placeholder=" user name to login"> 
                </div> 
            </div> 

            <div class="form-group has-success form-group-lg"> 
                <label class="control-label col-sm-2 "  >Password</label> 
                <div class="col-sm-10 col-md-6 "> 
                    <input class="form-control " type="password" name="password"  placeholder="" > 
                </div> 
            </div> 


            <div class="form-group has-success form-group-lg"> 
                <label class="control-label col-sm-2" >Email</label> 
                <div class="col-sm-10 col-md-6"> 
                    <input class="form-control " require="required" type="text" name="email" placeholder="Email must be valid" > 
                </div> 
            </div> 


            <div class="form-group has-success form-group-lg"> 
                <label class="control-label col-sm-2" >Full Name</label> 
                <div class="col-sm-10 col-md-6"> 
                    <input class="form-control " require="required" type="text" name="fullname" placeholder="FullNAME TO YOUR DATA" > 
                </div> 
            </div> 

            <div class="form-group has-success form-group-lg"> 
                <div class="col-sm-offset-2 col-sm-10"> 
                <button type="submit" value="addmember" class="btn btn-primary btn-lg"> 
                   Add New
                </button> 
                </div>
            </div> 

        </form> 
</div>


<?php 

} elseif ( $do == "Insert" ){
  
     if($_SERVER['REQUEST_METHOD'] == 'POST' ){
    
        echo "<h1 class='text-center'> insert Member </h1>"; 
        echo "<div class='container' >";

        // GET VARIABLE 
       
        $name     =  $_POST['Name'];
        $desc     =  $_POST['description'];
        $price    =  $_POST['price'];
        $country =  $_POST['country'];
        $status = $_POST['status'];
 

       //  Form Check ERRORR
       $formerror = array();
       if(strlen($user)  < 4 ){$formerror[] = '  username filed is less thaN <strong> 4 char </strong> ' ;} 
       if(strlen($user)  > 20 ){$formerror[] = ' username filed is morethan 20 char ' ;} 
       if(empty($user)){$formerror[] = ' username filed is empty  ' ;} 
       if(empty($pass)){$formerror[] = ' PASSWORD CAN BE EMBTY is empty ' ; }
       if(empty($email)){$formerror[] = ' email filed is empty ' ; }
       if(empty($fullname)){$formerror[] = 'fullname filed is empty ' ;}
       foreach($formerror as $error){echo  "<div class='alert alert-danger' > ".  $error  . " </div> <br /> "; }
        if (empty($formerror)){
           //check user is alerady exist 
           $check = checkitem ("Username","users",$user) ;
           if($check == 1) {

            echo "<div class='container'>" ;  
            $theMSG = '<div class="alert alert-danger" > ...Sorry This User Is Exist...  </div> <br /> '  ;
            redirectHome($theMSG,'back');
            echo "</div>";
   
           }else { 


            //echo $id . $user . $email . $fullname ; 
            $dt  = date("Y-m-d") ;
            $stmt = $dbh->prepare("INSERT INTO users(Username,Password,Email,FullName,RegStatus,Date) 
            VALUES(:zuser,:zpass,:zemail,:zname ,1, $dt)");
            $stmt->execute(array('zuser' => $user , 'zpass' => $hashpass ,'zemail'=>$email , 'zname'=>$fullname));
            echo "<div class='container'>" ;  
            $theMSG = "<div class='alert alert-danger' > ...Welcome You Are Add New Memebr...  ". $user  . " </div> <br /> ";
            redirectHome($theMSG,'back');
            echo "</div>";

       
        }
    }
       
    /*
    UserID
    Username
    Password
    Email
    FullName
    GroubID
    TrustStatus
    RegStatus
    */
    
       } else {
        echo "<div class='container'>" ; 
       $theMSG = '<div class="alert alert-danger"> Sorry you Cant Browse This Page Directly </div>'  ;
       redirectHome($theMSG );
       echo "</div>";
 
       }

       echo "</div>";

}elseif ( $do == "Edit" ){ 

          $userid = isset($_GET['userid']) && is_numeric ($_GET['userid']) ? intval ($_GET['userid']) : 0 ;   
          $stmt = $dbh->prepare("SELECT * FROM users Where UserID = ? ");
          $stmt->execute(array($userid));
          $row = $stmt->fetch();
          $count = $stmt->rowCount();
          // if Count > 0 this DB contain Record username    
            
            if($stmt->rowCount() > 0 ) {

?>

<h1 class="text-center"> Edit Members  <h1>
<div class="container">
<form class="form-horizontal " action="?do=update" method="POST"> 
<input  type="hidden" name="userid"  value="<?php echo  $userid ; ?> "> 
            <div class="form-group has-success form-group-lg  "> 
                <label class="control-label col-sm-2" >Username</label> 
                <div class="col-sm-10 col-md-6"> 
                    <input class="form-control " require="required" type="text" name="username" autocomplete="off" value="<?php echo $row['Username']; ?> "> 
                </div> 
            </div> 

            <div class="form-group has-success form-group-lg"> 
                <label class="control-label col-sm-2 "  >Password</label> 
                <div class="col-sm-10 col-md-6 "> 
                <input type="hidden" name="oldpassword" value="<?php echo $row['Password']; ?>" > 
                <input class="form-control " type="password" name="newpassword"  > 
                </div> 
            </div> 


            <div class="form-group has-success form-group-lg"> 
                <label class="control-label col-sm-2" >Email</label> 
                <div class="col-sm-10 col-md-6"> 
                    <input class="form-control " require="required" type="text" name="email" value="<?php echo $row['Email']; ?> "> 
                </div> 
            </div> 


            <div class="form-group has-success form-group-lg"> 
                <label class="control-label col-sm-2" >Full Name</label> 
                <div class="col-sm-10 col-md-6"> 
                    <input class="form-control " require="required" type="text" name="fullname"  value="<?php echo $row['FullName']; ?> " > 
                </div> 
            </div> 

            <div class="form-group has-success form-group-lg"> 
                <div class="col-sm-offset-2 col-sm-10"> 
                <button type="button "  value="Save" class="btn btn-primary btn-lg"> 
                   Save
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

echo "<h1 class='text-center'> Update Member </h1>"; 
echo "<div class='container' >";
 if($_SERVER['REQUEST_METHOD'] == 'POST' ){

    // GET VARIABLE 
   $id = $_POST['userid'];
   $user = $_POST['username'];
   $email = $_POST['email'];
   $fullname = $_POST['fullname'];
   
   // password Trick

   $passwd = empty($_POST['newpassword']) ? $passwd = $_POST['oldpassword']  : $passwd = sha1($_POST['newpassword']) ;
   
   //  Form Check ERRORR
   $formerror = array();
   if(strlen($user)  < 4 ){$formerror[] = '<div class="alert alert-danger" >  username filed is less thaN <strong> 4 char </strong> </div>' ;} 
   if(strlen($user)  > 20 ){$formerror[] = '<div class="alert alert-danger" > username filed is morethan 20 char </div>' ;} 
   if(empty($user)){$formerror[] = '<div class="alert alert-danger" > username filed is empty  </div>' ;} 
   if(empty($email)){$formerror[] = '<div class="alert alert-danger" > email filed is empty </div>' ; }
   if(empty($fullname)){$formerror[] = '<div class="alert alert-danger" > fullname filed is empty </div>' ;}
   foreach($formerror as $error){echo $error  . "<br /> "; }
    if (empty($formerror)){

        $stmt2  = $dbh->prepare("SELECT * FROM users where Username = ? AND UserID != ?   "); 
        $stmt2->execute (array($user,$id));
        $count = $stmt2->rowCount();
        if ($count == 1){
            echo ' YOU CAN Not UPDATED'; 
        } else {
          

            $stmt = $dbh->prepare("UPDATE users SET  Username = ? , Email = ? , FullName = ? , Password = ?  WHERE UserID = ?  ");
            $stmt->execute(array($user , $email , $fullname , $passwd ,  $id ));
            echo "<div class='container'>" ;  
            $theMSG = $stmt->rowCount() .  ' : Row counnt Updated'  ;
            redirectHome($theMSG , 'back');    
            echo "</div>";
         
        }

    }


/*
UserID
Username
Password
Email
FullName
GroubID
TrustStatus
RegStatus
*/

   } else {
    echo "<div class='container'>" ;  
    $theMSG = '<div class="alert alert-danger"> soory you cant brower this Direct </div>'  ;
    redirectHome($theMSG );    
    echo "</div>";
  
   }
   echo "</div>";
} // if do == update

elseif($do == "Activate"){

    echo "<h1 class='text-center'> Activate Member </h1>"; 
    $userid = isset($_GET['userid']) && is_numeric ($_GET['userid']) ? intval ($_GET['userid']) : 0 ; 
   
    $check = checkitem ("UserID","users",$userid) ;
    if($check>0){

        $stmt = $dbh->prepare("UPDATE users SET RegStatus = 1  Where UserID = ? ");
        $stmt->execute(array($userid));

        echo "<div class='container'>" ;  
        $theMSG = '<div class="alert alert-danger" > this member Activated </div> <br />'  ;
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

    echo "<h1 class='text-center'> Delete Member </h1>"; 
    echo "<div class='container' >";

    $userid = isset($_GET['userid']) && is_numeric ($_GET['userid']) ? intval ($_GET['userid']) : 0 ; 
     
    //$check = checkitem ("Username","users",$user) ;
    $check = checkItem('UserID','users',$userid);
    /* 
    $stmt = $dbh->prepare("SELECT * FROM users Where UserID = ? LIMIT 1 ");
    $stmt->execute(array($userid));
    $count = $stmt->rowCount();
    */
    // if Count > 0 this DB contain Record username    
  
  if($check > 0 ) {
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
