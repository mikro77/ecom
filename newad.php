<?php
session_start();
$pageTitle = "Create New Ad";
include 'ini.php';

if(isset($_SESSION['User']))
{



?>
<h1 class="text-center"> Create New Ad </h1>
<div class="create-ad block">
    <div class="container ">
        <div class="panel panel-primary">
            <div class="panel-heading"> Create New AD </div >
            <div class="panel-body"> 
          <div class="col-md-8">
          <form class="form-horizontal " action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
            <!--start name of item  -->
                    <div class="form-group has-success form-group-lg  "> 
                            <label class="control-label col-sm-2" >Item Name</label> 
                        <div class="col-sm-10 col-md-9"> 
                            <input class="form-control " require="required" type="text" name="Name" placeholder="Name Of item"> 
                        </div> 
                    </div> 
            <!--end name of item  -->
            <!--start Description of item  -->
            <div class="form-group has-success form-group-lg  "> 
                            <label class="control-label col-sm-2" >Description </label> 
                        <div class="col-sm-10 col-md-9"> 
                            <input class="form-control " require="required" type="text" name="description" placeholder="Description Of item"> 
                        </div> 
                    </div> 
            <!--end Description of item  -->
             <!--start price of item  -->
             <div class="form-group has-success form-group-lg  "> 
                            <label class="control-label col-sm-2" >Price</label> 
                        <div class="col-sm-10 col-md-9"> 
                            <input class="form-control " require="required" type="text" name="price" placeholder="Description Of item"> 
                        </div> 
                    </div> 
            <!--end price of item  -->
            <!--start counter of item  -->
            <div class="form-group has-success form-group-lg  "> 
                            <label class="control-label col-sm-2" >Country Made </label> 
                        <div class="col-sm-10 col-md-9"> 
                            <input class="form-control " require="required" type="text" name="country" placeholder="Description Of item"> 
                        </div> 
                    </div> 
            <!--end country of item  -->
            <!--start Status of item  -->
            <div class="form-group has-success form-group-lg  "> 
                            <label class="control-label col-sm-2" >Status </label> 
                        <div class="col-sm-10 col-md-9"> 
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
  
               <!--start category of item  -->
            <div class="form-group has-success form-group-lg  "> 
                            <label class="control-label col-sm-2" >Category</label> 
                        <div class="col-sm-10 col-md-9"> 
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



    <div class="col-md-4">      
    <div class="thumbnail item-box" >
    <span class="price-tag" >0</span>
            <image class="image-responsive" src="888886.JPEG" alt="" />
             <div class="caption" >
               <h3> title</h3>
               <p> description </p>
    </div>
    </div>




           </div>
            
             </div>
        </div>
    </div>
</div>




<?php

}else {
    header('location:login.php') ; 
    exit();
}
include  $tbl .'footer.php';
?>

