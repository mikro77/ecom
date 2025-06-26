<?php 
ob_start ();
session_start();
$pageTitle = "Dash Board";

/*** check if the users is already logged in ***/
if(isset($_SESSION['Username'])) {
include 'ini.php'; 
/*  Start Dashboard Page    */

$LastUsers = 5 ; 
$latestusers = getlatest("*","users","UserID",$LastUsers); 

$Lastitems = 5 ; 
$latestitem = getlatest("*","items","Item_ID",$Lastitems); 

$Lastcomments = 5 ; 
$latestcomment = getlatest("*","comments","c_id",$Lastcomments); 
?>
<div class="container home-stats text-center">
<i class="fa fa-users" aria-hidden="true"></i>
<h1> DashBoard </h1>
<div class="row">

<div class="col-md-3">
<div class="stat stat-members">
<i class="fa fa-users" aria-hidden="true"> </i>
<div class="info"> 
Total Members 
<span> <?php echo CountItems('UserID','users') ; ?> </span>
</div>
</div>

</div>

<div class="col-md-3">
<div class="stat stat-pending"> <i class="fa fa-edit" aria-hidden="true"></i> <div class="info">  Pending Members <span><a href="members.php?do=Manage&page=pending"> <?php echo  checkitem ('RegStatus', 'users', 0)  ; ?> </a> </span> </div></div>
</div>


<div class="col-md-3">
  
<div class="stat stat-total"> <i class="fa fa-tag" aria-hidden="true"></i> <div class="info">  Total Items <span> <?php echo CountItems('Item_ID ','items') ; ?> </span> </div></div>

</div>

<div class="col-md-3">

<div class="stat stat-comments"><i class="fa fa-comments-o" aria-hidden="true"></i> <div class="info"> Total Comments <span> 200 </span> </div> </div>

</div>

</div>
</div>

  <div class="container latest" >
  <div class="row">

  <div class="col-md-6">
  <div class="panel panel-default">

  <div class="panel-heading">
  <i class="fa fa-users"> </i> Leatst <?php echo '[' .  $LastUsers . ']' ?> Registerd Users
  </div>

<div class="panel-body">
<ul class="list-unstyled latest-users"> 
    <?php 
    
    foreach($latestusers as $users) 
    {
         echo " <li>
         <i class='fa fa-user-circle-o' aria-hidden='true'>&nbsp;&nbsp; </i>"
         .  $users['Username'] . 
         "<span class='pull-right ' >
         <button type='button' class='btn btn-success  float-start'><a href='members.php?do=Edit&userid=" .  $users['UserID'] . " ' ><i class='fa fa-user-circle-o' aria-hidden='true'>&nbsp; </i> Edit </a></button>

        ";

        if ($users['RegStatus'] == 0 ){

          echo " 
          
          <button type='button' class='btn  btn-primary  float-end'><a href='members.php?do=Activate&userid=" .$users['UserID'] . " ' ><i class='fa fa-user-circle-o' aria-hidden='true'>&nbsp; </i> Activate </a></button> 
          
         ";
          }
          echo "
          </span>
          </li>
          " ;
         
    }
    ?>

    </ul>
</div>
</div>
</div>


<div class="col-md-6">
<div class="panel panel-default">

<div class="panel-heading">
  <i class="fa fa-users"> </i> Leatst <?php echo '[' .  $Lastitems . ']' ?> Registerd Users
  </div>

<div class="panel-body">
<ul class="list-unstyled latest-users"> 
    <?php 
    
    foreach($latestitem as $item) 
    {
         echo " <li>
         <i class='fa fa-user-circle-o' aria-hidden='true'>&nbsp;&nbsp; </i>"
         .  $item['Name'] . 
         "<span class='pull-right ' >
         <button type='button' class='btn btn-success  float-start'><a href='items.php?do=Edit&itemid=" .  $item['Item_ID'] . " ' ><i class='fa fa-user-circle-o' aria-hidden='true'>&nbsp; </i> Edit </a></button>

        ";

        if ($item['Approve'] == 0 ){

          echo " 
          
          <button type='button' class='btn  btn-primary  float-end'><a href='items.php?do=Approve&itemid=" .$item['Item_ID'] . " ' > <i class='fa fa-check' aria-hidden='true'></i> Approve </a></button> 
          
         ";
          }
          echo "
          </span>
          </li>
          " ;
         
    }
    ?>

    </ul>
</div>

</div>
</div>


<div class="col-md-6">
<div class="panel panel-default">

<div class="panel-heading">
  <i class="fa fa-comments-o"> </i> <?php echo '[' .  $Lastcomments . ']' ?>Leatst COmments
  </div>

<div class="panel-body">

<div class="panel-body">
								<?php
									$stmt = $dbh->prepare("SELECT 
																comments.*, users.Username AS Member  
															FROM 
																comments
															INNER JOIN 
																users 
															ON 
																users.UserID = comments.user_id
															ORDER BY 
																c_id DESC
															LIMIT $Lastcomments");

									$stmt->execute();
									$comments = $stmt->fetchAll();

									if (! empty($comments)) {
										foreach ($comments as $comment) {
											echo '<div class="comment-box">';
												echo '<span class="member-n">
													<a href="members.php?do=Edit&userid=' . $comment['user_id'] . '">
														' . $comment['Member'] . '</a></span>';
												echo '<p class="member-c">' . $comment['comment'] . '</p>';
											echo '</div>';
										}
									} else {
										echo 'There\'s No Comments To Show';
									}
								?>
							</div>

















    <?php 
    /*
     $stmt = $dbh->prepare(" SELECT  comments.*,  users.Username AS user
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
      $comments = $stmt->fetchAll();

    foreach($comments as $comment) 
    {
      echo '<div class = "comment-box" > '; 
      echo '<span class = "user-n"> '  . $comment['user'] . '</span >'  ;
      echo '<p class = "user-c">'  . $comment['comment'] . '</p >'  ;     
      echo '</div>'; 
    }
    */
    ?>

    
</div>

</div>
</div>






  </div>
  </div>



<?php

include  $tbl .'footer.php';
     
}

/*  CHECKED SEEION IS NOT REGISTERED GO TO LOGIN   */
else { 
header('Location:index.php');
exit();
}

ob_end_flush ();

?> 