<?php
/*
=======================================================
==  [==>  Items Page  <==]  
=======================================================
*/
ob_start();
session_start();
$pageTitle = "Items";
if(isset($_SESSION['Username'])){

//if(isset($_SESSION['Username'])) {
    include 'ini.php' ; 
    $do = isset($_GET['do']) ? $_GET['do']  : 'Manage'  ;
    //---------------------------
    
    if ($do == 'Manage'){
       
        $stmt = $dbh->prepare("SELECT items .* ,
         categories.Name AS category_name , 
         users.Username AS username
        FROM items 
        INNER JOIN categories ON categories.ID = items.Cat_ID 
        INNER JOIN users ON users.UserID = items.Member_ID  ");
        $stmt->execute();
        $items = $stmt->fetchAll();
        
        ?>
    
    <h1 class="text-center"> Mange Items </h1>
    <div class="container">
    <div class="table-responsive">
    <table class="main-table table table-bordered"> 
    
        <tr>
        <td>#ID</td>
        <td>Name</td>
        <td>Description</td>
        <td>Price</td>
        <td>Category Name</td>
        <td>User Name</td>
        <td>Adding DATE</td>
        <td>Control</td>
        </tr>
       
       <?php 
       
       foreach($items as $item) {
    
        $id = $item['Item_ID'];
        $name = $item['Name'];
        $Description = $item['Description'];
        $Price = $item['Price'];
        $cat_name = $item['category_name'];
        $username = $item['username'];
        $Add_Date = $item['Add_Date'];
       
           echo "<tr>" ; 
           echo "<td>  .  $id   . </td>" ; 
           echo "<td>  .  $name   . </td>" ; 
           echo "<td>  .  $Description  . </td>" ; 
           echo "<td>  .  $Price   . </td>" ; 
           echo "<td>  .  $cat_name   . </td>" ; 
           echo "<td>  .  $username  . </td>" ; 
           echo "<td>  .  $Add_Date   . </td>" ; 
           echo '<td> 
           <a href="items.php?do=Edit&itemid=' . $item['Item_ID'] .' " class="btn btn-succeess"> Edit   </a>
           <a href="items.php?do=Delete&itemid=' . $item['Item_ID'] .' " class="btn btn-danger confirm"> Delete </a> ' ;
           if ($item['Approve'] == 0 ){
            echo '<a href="items.php?do=Approve&itemid=' . $item['Item_ID'] .' " class="btn btn-info "> Approve </a> ';
            }
           echo'</td>' ;
           echo "</tr> " ; 
    
       }
       
       ?>
       
    </table>
    </div> 
    <a href="items.php?do=ADD" class="btn btn-sm btn-primary"><i class="fa fa-plus"> </i> Add New Item </a> 
    </div>
    
    <?php


    
    }elseif ( $do == 'ADD'){

?>

    <h1 class="text-center"> ADD NEW Items  <h1>
        <div class="container">
            <form class="form-horizontal " action="?do=Insert" method="POST">
            <!--start name of item  -->
                    <div class="form-group has-success form-group-lg  "> 
                            <label class="control-label col-sm-2" >Item Name</label> 
                        <div class="col-sm-10 col-md-6"> 
                            <input class="form-control " require="required" type="text" name="Name" placeholder="Name Of item"> 
                        </div> 
                    </div> 
            <!--end name of item  -->
            <!--start Description of item  -->
            <div class="form-group has-success form-group-lg  "> 
                            <label class="control-label col-sm-2" >Description </label> 
                        <div class="col-sm-10 col-md-6"> 
                            <input class="form-control " require="required" type="text" name="description" placeholder="Description Of item"> 
                        </div> 
                    </div> 
            <!--end Description of item  -->
             <!--start price of item  -->
             <div class="form-group has-success form-group-lg  "> 
                            <label class="control-label col-sm-2" >Price</label> 
                        <div class="col-sm-10 col-md-6"> 
                            <input class="form-control " require="required" type="text" name="price" placeholder="Description Of item"> 
                        </div> 
                    </div> 
            <!--end price of item  -->
            <!--start counter of item  -->
            <div class="form-group has-success form-group-lg  "> 
                            <label class="control-label col-sm-2" >Country Made </label> 
                        <div class="col-sm-10 col-md-6"> 
                            <input class="form-control " require="required" type="text" name="country" placeholder="Description Of item"> 
                        </div> 
                    </div> 
            <!--end country of item  -->
            <!--start Status of item  -->
            <div class="form-group has-success form-group-lg  "> 
                            <label class="control-label col-sm-2" >Status </label> 
                        <div class="col-sm-10 col-md-6"> 
                           <select class="form-control " name="status"> 
                            <option value="0" >... </option>
                            <option value="1" >New </option>
                            <option value="2" >Like new </option>
                            <option value="3" >Used </option>
                            <option value="4" >Old </option>
                           </select> 
                        </div> 
                    </div> 
                <!--end status of item  -->
                <!--start member of item  -->
            <div class="form-group has-success form-group-lg  "> 
                            <label class="control-label col-sm-2" >Memeber </label> 
                        <div class="col-sm-10 col-md-6"> 
                           <select class="form-control " name="member"> 
                            <option value="0" >... </option>
                  <?php
                      $stmt = $dbh->prepare("SELECT * FROM users");
                        $stmt->execute();
                        $row = $stmt->fetchALL();
                        foreach($row as $user){
                        echo "<option value='".$user['UserID']."'>". $user['Username']."  </option>";
                        }
                 ?>

                     ?>
                           </select> 
                        </div> 
                    </div> 
                <!--end member of item  -->
               <!--start category of item  -->
            <div class="form-group has-success form-group-lg  "> 
                            <label class="control-label col-sm-2" >Category</label> 
                        <div class="col-sm-10 col-md-6"> 
                           <select class="form-control " name="category"> 
                            <option value="0" >... </option>
                  <?php
                      $stmt2 = $dbh->prepare("SELECT * FROM categories");
                        $stmt2->execute();
                        $row2 = $stmt2->fetchALL();
                        foreach($row2 as $cat){
                        echo "<option value='".$cat['ID']."'>". $cat['Name']."  </option>";
                        }
                 ?>

                     ?>
                           </select> 
                        </div> 
                    </div> 
                <!--end category of item  -->
                
                    <div class="col-sm-offset-2 col-sm-10"> 
                            <button type="submit" value="Addcat" class="btn btn-primary btn-lg"> 
                                Add New Item
                             </button> 
                        </div>
                    </div> 
                   
                </form> 
        </div>

     

<?php

    }
    elseif ( $do == 'Insert') {
       
        if($_SERVER['REQUEST_METHOD'] == 'POST' ){
            echo "<h1 class='text-center'> insert Member </h1>"; 
            echo "<div class='container' >";
    
            // GET VARIABLE 
           // Name   description  price   country   status
           $name     =  $_POST['Name'];
           $desc     =  $_POST['description'];
           $price    =  $_POST['price'];
           $country  =  $_POST['country'];
           $status   =  $_POST['status'];
           $member   =  $_POST['member'];
           $category   =  $_POST['category'];
           
    
           //  Form Check ERRORR
           $formerror = array();
            if(empty($name)){$formerror[] = '  the Name cant be  <strong> Empty </strong> ' ;} 
            if(empty($desc)){$formerror[] = '   the description cant be  <strong> Empty </strong> ' ;} 
            if(empty($price)){$formerror[] = '  the price cant be  <strong> Empty </strong> ' ; } 
            if(empty($country)) {$formerror[] = ' the country cant be  <strong> Empty </strong> ' ; }
           if(empty($status)){$formerror[] = ' the status cant be <strong> Empty </strong> ' ; }
           if(empty($member)){$formerror[] = ' the member cant be <strong> Empty </strong> ' ; }
           if(empty($category)){$formerror[] = ' the Category cant be <strong> Empty </strong> ' ; }
           if($status == 0){$formerror[] = ' the status cant be <strong> ZERO </strong> ' ; }
           foreach($formerror as $error){echo  "<div class='alert alert-danger' > ".  $error  . " </div> <br /> "; }
           if (empty($formerror)){
            
 
             //echo $id . $user . $email . $fullname ; 
             $dt  = date("Y-m-d") ;
             $stmt = $dbh->prepare("INSERT INTO items(Name,Description,Price,country_Make,Status,Cat_ID,Member_ID,Add_Date) 
             VALUES(:zname,:zdesc,:zprice,:zcmade,:zstatus,:zcat,:zmember,$dt)");
             $stmt->execute(array(
                 'zname' => $name ,
                 'zdesc' => $desc ,
                 'zprice'=> $price ,
                 'zcmade'=> $country ,
                 'zstatus'=> $status,
                 'zcat'=> $category,
                 'zmember'=> $member,
                ));
             echo "<div class='container'>" ;  
             $theMSG = "<div class='alert alert-danger' > ...Welcome You Are Add New Memebr...  ". $stmt->rowCount()  . " </div> <br /> ";
             redirectHome($theMSG,'back');
             echo "</div>";
   
/*
Name
Description 
Price 
Add_Date
Country_Made
Image
Status
Rating 
Cat_ID
Member_ID

*/  

        
     }

    } else {
        echo "<div class='container'>" ; 
       $theMSG = '<div class="alert alert-danger"> Sorry you Cant Browse This Page Directly </div>'  ;
       redirectHome($theMSG );
       echo "</div>";
       echo "CCCCCCCCCCCC";
 
       }
    
    } elseif ( $do == 'Edit') {
       
        $itemid = isset($_GET['itemid']) && is_numeric ($_GET['itemid']) ? intval ($_GET['itemid']) : 0 ;   
        $stmt = $dbh->prepare("SELECT * FROM items Where Item_ID = ? ");
        $stmt->execute(array($itemid));
        $item = $stmt->fetch();
        $count = $stmt->rowCount();
        // if Count > 0 this DB contain Record username    
          
          if($stmt->rowCount() > 0 ) { ?>

            <h1 class="text-center"> Edit Items  <h1>
            <div class="container">

                <form class="form-horizontal " action="?do=Update" method="POST">
                <input  type="hidden" name="itemid"  value="<?php echo $itemid ; ?> "> 
                <!--start name of item  -->
                        <div class="form-group has-success form-group-lg  "> 
                                <label class="control-label col-sm-2" >Item Name</label> 
                            <div class="col-sm-10 col-md-6"> 
                                <input class="form-control " require="required" type="text" name="Name" placeholder="Name Of item" value ="<?php echo $item['Name']; ?>" /> 
                            </div> 
                        </div> 
                <!--end name of item  -->
                <!--start Description of item  -->
                <div class="form-group has-success form-group-lg  "> 
                                <label class="control-label col-sm-2" >Description </label> 
                            <div class="col-sm-10 col-md-6"> 
                                <input class="form-control " require="required" type="text" name="description" placeholder="Description Of item" value ="<?php echo $item['Description']; ?>"> 
                            </div> 
                        </div> 
                <!--end Description of item  -->
                 <!--start price of item  -->
                 <div class="form-group has-success form-group-lg  "> 
                                <label class="control-label col-sm-2" >Price</label> 
                            <div class="col-sm-10 col-md-6"> 
                                <input class="form-control " require="required" type="text" name="price" placeholder="Description Of item" value ="<?php echo $item['Price']; ?>"> 
                            </div> 
                        </div> 
                <!--end price of item  -->
                <!--start counter of item  -->
                <div class="form-group has-success form-group-lg  "> 
                                <label class="control-label col-sm-2" >Country Made </label> 
                            <div class="col-sm-10 col-md-6"> 
                                <input class="form-control " require="required" type="text" name="country" placeholder="Description Of item" value ="<?php echo $item['country_Make']; ?>"> 
                            </div> 
                        </div> 
                <!--end country of item  -->
                <!--start Status of item  -->
                <div class="form-group has-success form-group-lg  "> 
                                <label class="control-label col-sm-2" >Status </label> 
                            <div class="col-sm-10 col-md-6"> 
                               <select class="form-control " name="status"> 
                                <option value="0" <?php if($item['Status'] == 0) { echo 'selected' ;} ?> >... </option>
                                <option value="1" <?php if($item['Status'] == 1) { echo 'selected' ;} ?>>New </option>
                                <option value="2" <?php if($item['Status'] == 2) { echo 'selected' ;} ?>>Like new </option>
                                <option value="3" <?php if($item['Status'] == 3) { echo 'selected' ;} ?>>Used </option>
                                <option value="4" <?php if($item['Status'] == 4) { echo 'selected' ;} ?>>Old </option>
                               </select> 
                            </div> 
                        </div> 
                    <!--end status of item  -->
                    <!--start member of item  -->
                <div class="form-group has-success form-group-lg  "> 
                                <label class="control-label col-sm-2" >Memeber </label> 
                            <div class="col-sm-10 col-md-6"> 
                               <select class="form-control " name="member"> 
                                <option value="0" >... </option>
                      <?php
                          $stmt = $dbh->prepare("SELECT * FROM users");
                            $stmt->execute();
                            $row = $stmt->fetchALL();
                            foreach($row as $user){
                            echo "<option value='  ".$user['UserID']."  '  " ;
                            if($item['Member_ID'] == $user['UserID']) { echo 'selected' ;}
                             echo">" . $user['Username']."  </option>";
                            }
                     ?>
    
                         ?>
                               </select> 
                            </div> 
                        </div> 
                    <!--end member of item  -->
                   <!--start category of item  -->
                <div class="form-group has-success form-group-lg  "> 
                                <label class="control-label col-sm-2" >Category</label> 
                            <div class="col-sm-10 col-md-6"> 
                               <select class="form-control " name="category"> 
                                <option value="0" >... </option>
                      <?php
                          $stmt2 = $dbh->prepare("SELECT * FROM categories");
                            $stmt2->execute();
                            $row2 = $stmt2->fetchALL();
                            foreach($row2 as $cat){
                            echo "<option value='  "  .$cat['ID'].  " ' " ;  
                            if($item['Cat_ID'] == $cat['ID']) { echo 'selected' ;}  
                             echo ">"  .   $cat['Name']   .    "</option>";
                            }
                     ?>
    
                         ?>
                               </select> 
                            </div> 
                        </div> 
                    <!--end category of item  -->
                    
                    <div class="col-sm-offset-2 col-sm-10"> 
               <button type="submit" value="Save" class="btn btn-primary btn-lg"> 
                Save
               </button> 
               </div>
                </div>     
                </form> 
<!--start  of Mange Comment -->
 <?php 
                $stmt = $dbh->prepare(" SELECT  comments.*,   users.Username AS user
                            FROM 
                            comments
                            INNER JOIN
                            users
                            ON
                            users.UserID = comments.user_id
                            WHERE item_id = ? 
                    ") ;
                    $stmt->execute(array($itemid));
                    $rows = $stmt->fetchAll();
                    if(!empty($rows)) {

    ?>

<h1 class="text-center"> Mange [ <?php echo $item['Name']; ?>  ] Comments </h1>
<div class="container">
<div class="table-responsive">
<table class="main-table table table-bordered"> 
    <tr>
    <td>comment</td>
    <td>user name</td>
    <td>add DATE</td>
    <td>Control</td>
    </tr>
   <?php 
   

   /*  INSERT INTO `comments` (`c_id`, `status`, `comment_date`, `item_id`, `user_id`    */
   foreach($rows as $row) {

    $id = $row['c_id'];
    $comment = $row['comment'];
    $userid = $row['user'];
    $Date = $row['comment_date'];
   
       echo "<tr>" ; 
       echo "<td>  .  $comment  . </td>" ;
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
</div> <!--End of Mange Comment -->
<?php }  ?><!--IF empty comments  -->
</div><!--End of container -->

<?PHP

  }// if count > 0 

  else {

  echo "<div class='container'>" ;  
  $theMSG = 'ther is no such id'  ;
  redirectHome($theMSG);
  echo "</div>";

   }
    } 

    elseif ( $do == 'Update') {

        echo "<h1 class='text-center'> Update Member </h1>"; 
        echo "<div class='container' >";
        
         if($_SERVER['REQUEST_METHOD'] == 'POST' ){
        
          // GET VARIABLE 
           $id     = $_POST['itemid'];
           $name   = $_POST['Name'];
           $desc   = $_POST['description'];
           $price  = $_POST['price'];
    
           $country = $_POST['country'];
           $status  = $_POST['status'];
           $member  = $_POST['member'];
           $cat     = $_POST['category'];
           echo "gggggggggggg";
           //  Form Check ERRORR
           $formerror = array();
           if(empty($name)){$formerror[] = '  the Name cant be  <strong> Empty </strong> ' ;} 
           if(empty($desc)){$formerror[] = '   the description cant be  <strong> Empty </strong> ' ;} 
           if(empty($price)){$formerror[] = '  the price cant be  <strong> Empty </strong> ' ; } 
           if(empty($country)) {$formerror[] = ' the country cant be  <strong> Empty </strong> ' ; } 
           if(empty($status)){$formerror[] = ' the status cant be <strong> Empty </strong> ' ; }
           if(empty($member)){$formerror[] = ' the member cant be <strong> Empty </strong> ' ; }
           if(empty($cat)){$formerror[] = ' the Category cant be <strong> Empty </strong> ' ; }
           if($status == 0){$formerror[] = ' the status cant be <strong> ZERO </strong> ' ; }
           if (empty($formerror)){
                echo $name . $desc . $price . $country ; 
                $stmt = $dbh->prepare("UPDATE items SET  Name = ? , Description = ? , Price = ? , country_Make = ? , Status = ? , Member_ID = ? , Cat_ID = ? WHERE Item_ID = ? ");
                //$stmt = $dbh->prepare("UPDATE users SET  Username = ? , Email = ? , FullName = ? , Password = ?  WHERE UserID = ?  ");
                $stmt->execute(array($name , $desc , $price , $country , $status , $member , $cat , $id ));
               
                echo "<div class='container'>" ;  
                $theMSG = $stmt->rowCount() .  ' : Row counnt Updated'  ;
                redirectHome($theMSG , 'back');    
                echo "</div>";
                echo "uuuuuuuu";
            }
        
        
        
           } else {
            echo "<div class='container'>" ;  
            $theMSG = '<div class="alert alert-danger"> soory you cant brower this Direct </div>'  ;
            redirectHome($theMSG );    
            echo "</div>";
          
           }
           echo "</div>";
    
        }












  elseif ( $do == 'Delete')
    {
       

        echo "<h1 class='text-center'> Delete Member </h1>"; 
        echo "<div class='container' >";
    
        $itmeid= isset($_GET['itemid']) && is_numeric ($_GET['itemid']) ? intval ($_GET['itemid']) : 0 ; 
         
        $check = checkItem('Item_ID','items',$itmeid);
     
      if($check > 0 ) 
       {

        $stmt = $dbh->prepare("DELETE FROM items Where Item_ID = :zid");
        $stmt->bindParam('zid', $itmeid, PDO::PARAM_STR);
        $stmt->execute();
  
       echo "<div class='container'>" ;  
       $theMSG = '<div class="alert alert-danger" > this item deleted </div> <br />'  ;
       redirectHome($theMSG);
       echo "</div>";

       }else{

        echo "<div class='container'>" ;  
        $theMSG = '<div class="alert alert-danger"> ther is no such id </div>'  ;
        redirectHome($theMSG);
        echo "</div>";

       }
    






       
    
    }



    elseif ( $do == 'Approve')
    {
        
        echo "<h1 class='text-center'> Activate Member </h1>"; 
        $itemid = isset($_GET['itemid']) && is_numeric ($_GET['itemid']) ? intval ($_GET['itemid']) : 0 ; 
       
        $check = checkitem ("Item_ID","items",$itemid) ;

    echo "ffffffffff" . $check ;
        if($check > 0){
    
            $stmt = $dbh->prepare("UPDATE items SET Approve = 1  Where Item_ID = ? ");
            $stmt->execute(array($itemid));
    
            echo "<div class='container'>" ;  
            $theMSG = '<div class="alert alert-danger" > this items Approved </div> <br />'  ;
            redirectHome($theMSG , 'back');
            echo "</div>";
         
             }else {
         
                 echo "<div class='container'>" ;  
                 $theMSG = '<div class="alert alert-danger"> ther is no such id </div>'  ;
                 redirectHome($theMSG . 'back');
                 echo "</div>";
         
             }
    


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
