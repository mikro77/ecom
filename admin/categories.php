<?php 
/*
============================
 == [ Categories  ]
 == [  You Can Add -- Edit -- Delete categories From Here  ]
 ===================== =====
 */
ob_start();
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

/*
$stmt2 = $dbh->prepare("SLECT * FROM categories");
$stmt2->execute();
$cats = stmt2->fetchALL(); 
*/

$sort = "ASC";
$sort_array = array ('ASC','DESC'); 
if(isset($_GET['sort']) && in_array($_GET['sort'] , $sort_array )) {
$sort = $_GET['sort'] ; 
}

$stmt = $dbh->prepare("SELECT * FROM categories ORDER BY Ordring $sort  ") ;
$stmt->execute();
$rows = $stmt->fetchAll(); ?>

<h1 class="text-center"> Mange Categories </h1>

    <div class="container categoryies">
 
        <div class="panel panel-default">
            <div class="panel-heading"> Mange Categories
                <div class="Ordring pull-right" >
                Ordring : 
                <a class= "<?php  if ($sort == 'ASC' ) { echo " active " ; }  ?>" href="?sort=ASC">ASC</a>
                <a class= "<?php  if ($sort == 'DESC'){  echo " active " ; } ?>" href="?sort=DESC">DESC</a>
                </div>
            </div>

            <div class="panel-body">
            <?php
                foreach ($rows as $cat){
                    echo " <div class='cat' >
                    <div class ='hidden-buttons' >
                    <a href ='categories.php?do=Edit&catid=".$cat['ID']."' class='btn btn-xs btn-brimary'> <i class='fa fa-edit'> </i>Edit</a> 
                    <a href ='categories.php?do=Delete&catid=".$cat['ID']."' class='confirm btn btn-xs btn-brimary'> <i class='fa fa-close'> </i>Delete</a>
                    </div>
                    ";
                
                    echo '<h3>' .$cat['Name'] . '</h3>' ;
                    echo '<p>' ; if ($cat['Description'] == "" ){ echo 'Ther is NO Description </p> <br />'; } 
                    if($cat['Visibility'] == 1 ) {echo '<span class="Visibility" > Hidden </span>' ;  }  
                    if($cat['Allow_Comment'] == 1 ) {echo '<span class="Allow_Comment" > Comment Disable </span>' ;  }     
                    if($cat['Allow_Ads'] == 1 ) {echo '<span class="Allow_Ads" > Ads Hidden </span>' ;  } 
                    echo ' <hr /> ' ;
            }

            ?>

            </div>

        </div>
    <?php  echo '<a class="button btn-primary" href="categories.php?do=Add" ><i class="fa fa-plus"> </i> Add New Category</a> '; ?>
    </div>  

    
<?php

    /*
    ID
    Name
    Description
    Ordring
    Visibility
    Allow_Comment	
    Allow_Ads
    */
   

}


elseif($do =="Add") {  ?>


<h1 class="text-center"> ADD NEW Category  <h1>
<div class="container">
<form class="form-horizontal " action="?do=Insert" method="POST">
           <div class="form-group has-success form-group-lg  "> 
               <label class="control-label col-sm-2" >Name</label> 
               <div class="col-sm-10 col-md-6"> 
                   <input class="form-control " require="required" type="text" name="Name" autocomplete="off" placeholder="Name Of Category"> 
               </div> 
           </div> 

           <div class="form-group has-success form-group-lg"> 
               <label class="control-label col-sm-2 "  >Description</label> 
               <div class="col-sm-10 col-md-6 "> 
                   <input class="form-control " type="text"  name="Description"  placeholder="Descripe The Category" > 
               </div> 
           </div> 


           <div class="form-group has-success form-group-lg"> 
               <label class="control-label col-sm-2" >Ordering</label> 
               <div class="col-sm-10 col-md-6"> 
                   <input class="form-control "  type="text" name="Ordring" placeholder="Num Of Ordring" > 
               </div> 
           </div> 


           <div class="form-group has-success form-group-lg"> 
               <label class="control-label col-sm-2" >Visabil</label> 
               <div class="col-sm-10 col-md-6"> 
                   <div>
                    <input type="radio" name="Visibility" value="0" checked  /> 
                    <label for="vis-yes">Yes</label>
                    </div>
                    <div>
                    <input type="radio" name="Visibility" value="1"   /> 
                    <label for="vis-no">NO</label>
                    </div>
               </div> 
           </div> 
           
           <div class="form-group has-success form-group-lg"> 
               <label class="control-label col-sm-2" >Allow Comments</label> 
               <div class="col-sm-10 col-md-6"> 
                   <div>
                    <input type="radio" name="Cominting" value="0" checked  /> 
                    <label for="com-yes">Yes</label>
                    </div>
                    <div>
                    <input type="radio" name="Cominting" value="1"   /> 
                    <label for="com-no">NO</label>
                    </div>
               </div> 
           </div> 
           

     
           <div class="form-group has-success form-group-lg"> 
               <label class="control-label col-sm-2" >Allow Ads</label> 
               <div class="col-sm-10 col-md-6"> 
                   <div>
                    <input type="radio" name="Ads" value="0" checked  /> 
                    <label for="ads-yes">Yes</label>
                    </div>
                    <div>
                    <input type="radio" name="Ads" value="1"   /> 
                    <label for="ads-no">NO</label>
                    </div>
               </div> 
           </div> 
           
               <div class="col-sm-offset-2 col-sm-10"> 
               <button type="submit" value="Addcat" class="btn btn-primary btn-lg"> 
                Add Category
               </button> 
               </div>
           </div> 

       </form> 
</div>

<?php

             
 }
elseif($do =="Insert") {
         
     if($_SERVER['REQUEST_METHOD'] == 'POST' ){
        // GET VARIABLE 
       $name         =  $_POST['Name'];
       $Description  =  $_POST['Description'];
       $Ordring      =  $_POST['Ordring'];
       $Visibility   =  $_POST['Visibility'];
       $Cominting    =  $_POST['Cominting'];
       $Ads          =  $_POST['Ads'];
  
           //check user is alerady exist 
           $check = checkitem ("Name","categories",$name) ;
           if($check == 1) {

            echo "<div class='container'>" ;  
            $theMSG = '<div class="alert alert-danger" > ...Sorry This Cateogory Is Inserted...  </div> <br /> '  ;
            redirectHome($theMSG,'back');
            echo "</div>";
           }else { 
            //echo $id . $user . $email . $fullname ; 
            $stmt = $dbh->prepare("INSERT INTO categories(Name,Description,Ordring,Visibility,Allow_Comment,Allow_Ads) 
            VALUES(:zName,:zDescription,:zOrder,:zVisible,:zComment,:zAds)");
            $stmt->execute(array('zName' => $name , 'zDescription' => $Description ,'zOrder'=>$Ordring , 'zVisible'=>$Visibility ,'zComment'=>$Cominting,'zAds'=>$Ads ));
            echo "<div class='container'>" ;  
            $theMSG =   "<div class='alert alert-danger' > ... [ Welcome You Are Add New CATEGORY ]...  ". $name  . " </div> <br /> ";
            redirectHome($theMSG,'back');
            echo "</div>";
       
        }
  
       
    /*
    ID
    Name
    Description
    Ordring
    Visibility
    Allow_Comment	
    Allow_Ads
    */
    
    } else {
        echo "<div class='container'>" ; 
       $theMSG = '<div class="alert alert-danger"> Sorry you Cant Browse This Page Directly </div>'  ;
       redirectHome($theMSG);
       echo "</div>";
 
       }

}

elseif($do == "Edit") {

    $catid = isset($_GET['catid']) && is_numeric ($_GET['catid']) ? intval ($_GET['catid']) : 0 ;   
    $stmt = $dbh->prepare("SELECT * FROM categories Where ID = ? ");
    $stmt->execute(array($catid));
    $cat = $stmt->fetch();
    $count = $stmt->rowCount();
      ;
    // if Count > 0 this DB contain Record username    
      
    if($stmt->rowCount() > 0 ) { ?>

    good this id is exisit
   

<h1 class="text-center"> Edit Categories  <h1>
<div class="container">
<form class="form-horizontal " action="?do=Update" method="POST">
<input type="hidden" type ="text" name = "catid"  value = "<?php echo $catid   ; ?> " >
           <div class="form-group has-success form-group-lg  "> 
               <label class="control-label col-sm-2" >Name</label> 
               <div class="col-sm-10 col-md-6"> 
                   <input class="form-control " require="required" type="text" name="Name"  placeholder="Name Of Category" value = "<?php echo $cat['Name'] ;   ?>"> 
               </div> 
           </div> 

           <div class="form-group has-success form-group-lg"> 
               <label class="control-label col-sm-2 "  >Description</label> 
               <div class="col-sm-10 col-md-6 "> 
                   <input class="form-control " type="text"  name="Description"  placeholder="Descripe The Category" value = "<?php echo $cat['Description'] ;   ?>"> 
               </div> 
           </div> 


           <div class="form-group has-success form-group-lg"> 
               <label class="control-label col-sm-2" >Ordering</label> 
               <div class="col-sm-10 col-md-6"> 
                   <input class="form-control "  type="text" name="Ordring" placeholder="Num Of Ordring" value = ' <?php echo $cat['Ordring'] ;   ?> '> 
               </div> 
           </div> 


           <div class="form-group has-success form-group-lg"> 
               <label class="control-label col-sm-2" >Visabil</label> 
               <div class="col-sm-10 col-md-6"> 
                   <div>
                    <input type="radio" name="Visibility" value="0" <?PHP if($cat['Visibility'] == 0){ echo "checked" ; } ?>   /> 
                    <label for="vis-yes">Yes</label>
                    </div>
                    <div>
                    <input type="radio" name="Visibility" value="1" <?PHP if ($cat['Visibility'] == 1){echo "checked"; } ?>   /> 
                    <label for="vis-no">NO</label>
                    </div>
               </div> 
           </div> 
           
           <div class="form-group has-success form-group-lg"> 
               <label class="control-label col-sm-2" >Allow Comments</label> 
               <div class="col-sm-10 col-md-6"> 
                   <div>
                    <input type="radio" name="Cominting" value="0" <?PHP if($cat['Allow_Comment' ]== 0){echo "checked"; } ?>  /> 
                    <label for="com-yes">Yes</label>
                    </div>
                    <div>
                    <input type="radio" name="Cominting" value="1"  <?PHP if($cat['Allow_Comment' ]== 1 ){echo "checked"; } ?> /> 
                    <label for="com-no">NO</label>
                    </div>
               </div> 
           </div> 
           
     
           <div class="form-group has-success form-group-lg"> 
               <label class="control-label col-sm-2" >Allow Ads</label> 
               <div class="col-sm-10 col-md-6"> 
                   <div>
                    <input type="radio" name="Ads" value="0" <?PHP if($cat['Allow_Ads' ] == 0){echo "checked"; } ?> /> 
                    <label for="ads-yes">Yes</label>
                    </div>
                    <div>
                    <input type="radio" name="Ads" value="1"  <?PHP if($cat['Allow_Ads' ] == 1 ){echo "checked"; } ?> /> 
                    <label for="ads-no">NO</label>
                    </div>
               </div> 
           </div> 
           
               <div class="col-sm-offset-2 col-sm-10"> 
               <button type="submit" value="Save" class="btn btn-primary btn-lg"> 
                Save
               </button> 
               </div>
           </div> 

       </form> 


     <?php    echo $cat['Visibility']  , $cat['Allow_Comment']  , $cat['Allow_Ads']   ;?>







</div>

<?PHP

}// if count > 0 

else {

echo "<div class='container'>" ;  
$theMSG = 'there is no such id'  ;
redirectHome($theMSG);
echo "</div>";

}

}



elseif($do =="Update") {

    echo "<h1 class='text-center'> Update Categories </h1>"; 
    echo "<div class='container' >";
     if($_SERVER['REQUEST_METHOD'] == 'POST' ){

/*
+---------------+--------------+------+-----+---------+----------------+
| Field         | Type         | Null | Key | Default | Extra          |
+---------------+--------------+------+-----+---------+----------------+
| ID            | smallint(6)  | NO   | PRI | NULL    | auto_increment |
| Name          | varchar(255) | NO   |     | NULL    |                |
| Description   | text         | NO   |     | NULL    |                |
| Ordring       | int(11)      | YES  |     | NULL    |                |
| Visibility    | tinyint(4)   | NO   |     | 0       |                |
| Allow_Comment | tinyint(4)   | NO   |     | 0       |                |
| Allow_Ads     | tinyint(4)   | NO   |     | 0       |                |
+---------------+--------------+------+-----+---------+----------------+
*/

    
        // GET VARIABLE 
       $id = $_POST['catid'];
       $Name = $_POST['Name'];
       $Description = $_POST['Description'];
       $Ordring = $_POST['Ordring'];


       $Visibility = $_POST['Visibility'];
       $Allow_Comments = $_POST['Cominting'];
       $Allow_Ads = $_POST['Ads'];
       
         
      
            $stmt = $dbh->prepare("UPDATE categories SET Name = ? , Description = ? , Ordring = ?  , Visibility= ? , Allow_Comment= ? , Allow_Ads = ?   WHERE ID = ?  ");
            $stmt->execute(array($Name , $Description , $Ordring , $Visibility , $Allow_Comments , $Allow_Ads , $id ));

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



    
}

elseif($do = "Delete"){

    echo "<h1 class='text-center'> Delete Member </h1>"; 
    echo "<div class='container' >";

    $Catid = isset($_GET['catid']) && is_numeric ($_GET['catid']) ? intval ($_GET['catid']) : 0 ; 
     
    //$check = checkitem ("Username","users",$user) ;
    $check = checkItem('ID','categories',$Catid);
    /* 
    $stmt = $dbh->prepare("SELECT * FROM users Where UserID = ? LIMIT 1 ");
    $stmt->execute(array($userid));
    $count = $stmt->rowCount();
    */
    // if Count > 0 this DB contain Record username    
  
  if($check > 0 ) {
    $stmt = $dbh->prepare("DELETE FROM categories Where ID = :IDUser");
    $stmt->bindParam('IDUser', $Catid, PDO::PARAM_STR);
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
}// End DELETE SYSTEM



else {}


include  $tbl .'footer.php';


} // End OF ISSET_USERNAME CHECKED  
 else { 
header('Location:index.php');
exit();
}

ob_end_flush();
?>

