<?php
include 'ini.php';
?>

<div class="container" > 
<h1 class="text-center"> <?php  echo str_replace('-',' ',$_GET['sh'])  ;?> </h1>
<?php
 $pageid = $_GET['pageid'] ; 
 $getitem = getitem( 'Cat_ID' , $pageid ) ; 
foreach($getitem as $items)
{
echo '

<div class = "col-sm-6 col-md-3">
    <div class="thumbnail item-box" >
    <span class="price-tag" >' . $items['Price'] . '</span>
            <image class="image-responsive" src="888886.JPEG" alt="" />
             <div class="caption" >
               <h3>  '.  $items['Name'] .' </h3>
               <p>  '.  $items['Description'] .'  </p>
             </div>
    </div>
</div>

';

}
?>
</div> 
<?php
include  $tbl .'footer.php';
?>

