<?php
session_start();
$pageTitle = "profile";
include 'ini.php';

if(isset($_SESSION['User']))
{

$getUser  = $dbh->prepare("SELECT * FROM users WHERE Username = ? ");
$getUser->execute(array($sessionUser)) ;
$info = $getUser->fetch();

?>

<div class="information block">
    <div class="container ">
        <div class="panel panel-primary">
            <div class="panel-heading"> My information </div >
            <div class="panel-body"> 
            Name : <?php echo $info['Username']; ?> <br />
            Email : <?php echo $info['Email']; ?>  <br />
            RegStatus : <?php echo $info['RegStatus']; ?> <br />
            Date : <?php echo $info['Date']; ?> <br />
            
             </div>
        </div>
    </div>
</div>

<div class="my-ads block">
    <div class="container ">
        <div class="panel panel-primary">
            <div class="panel-heading"> my Ads </div >
            <div class="panel-body"> 
            <?php
                   // $pageid = $_GET['pageid'] ; 
                    $getitem = getitem('Member_ID', $info['UserID'] ) ; 
                    foreach($getitem as $Ads)
                    {
                    echo '
                    <div class = "col-sm-6 col-md-3">
                        <div class="thumbnail item-box" >
                        <span class="price-tag" >' . $Ads['Price'] . '</span>
                                <image class="image-responsive" src="888886.JPEG" alt="" />
                                <div class="caption" >
                                <h3>  '.  $Ads['Name'] .' </h3>
                                <p>  '.  $Ads['Description'] .'  </p>
                                </div>
                        </div>
                    </div>

                    ';

                    }
?>
                          
             </div>
        </div>
    </div>
</div>

<div class="my-comments block">
    <div class="container ">
        <div class="panel panel-primary">
            <div class="panel-heading"> Test Comments </div >
            <div class="panel-body"> 
            <?php
                
                $statement  =   $dbh->prepare("SELECT comment FROM comments WHERE user_id  = ? ");
                $statement->execute(array($info['UserID']));
                $comments = $statement->fetchAll();
                           
				if (! empty($comments)) {
					foreach ($comments as $comment) {
						echo '<p>' . $comment['comment'] . '</p>';
					}
				} else {
                    echo 'There\'s No Comments to Show create <a href="newad.php" > new ad </a>  ';
                    
				}
			?>
            
            
            
            
            
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

