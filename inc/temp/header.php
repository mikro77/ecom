<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8" />
<title>   </title>

<link rel="stylesheet"href="<?php  echo  $css ;?>bootstrap.min.css">
<link rel="stylesheet"href="<?php  echo  $css ;?>font-awesome.min.css">
<link rel="stylesheet"href="<?php  echo  $css ;?>front.css">

</head>
<body class="homepage" >
    <div class="upper-bar">
        <div class="container" >
        <?php
            if(isset($_SESSION['User'])){
                echo 'Welcome ' .   $sessionUser ;
                echo '<a href="profile.php"> [ my profile ] </a>  ' ; 
                echo '<a href="newad.php"> [ New AD ] </a>  ' ; 
                echo '<a href="logout.php"> [ LogOut ] </a>  ' ; 
                $userstatus = CheckUserState($_SESSION['User']) ; 
                if($userstatus == 1){
                    echo "[ You Are Need To Activate By Admin ] ";
                }
            }else{
echo '   <span class="pull-right"> <a href="login.php" > login | signup </a> </span>';
            }
         ?>
         
      
        </div>
    </div>



