<?php
$pageTitle = "login";
session_start();
$noNavbar = "" ;
if(isset($_SESSION['Username'])){
header('Location:dashboard.php'); // Redirect to dashboard
}

include 'ini.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
$username = $_POST['user'];
$password = $_POST['pass'];
$hashpassword = sha1($password);

//::// [:: CHECK USER && PASS ::] //:://

$stmt = $dbh->prepare("SELECT
                         UserID,Username,Password 
                     FROM users 
                     WHERE 
                     Username = ? 
                     AND 
                     Password = ? 
                     AND 
                     GroubID = 1 
                     LIMIT 1");

$stmt->execute(array($username,$hashpassword));
$row = $stmt->fetch();
$count = $stmt->rowCount();
// if Count > 0 this DB contain Record username 

if ($count > 0 ){
    $_SESSION['Username'] = $username ;  //register username 
    $_SESSION['ID'] = $row['UserID'] ;  //register Session ID 
    header('Location:dashboard.php'); // Redirect to dashboard 
    exit();  
}else {

    echo " <br /> username or password is error";
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

//echo '<br> '. $count ; 

}

?>
<form class='login' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" >
<h4> ADMIN LOGIN </h4> 
<input class="form-control input-lg" type="text" name="user" placeholder="username" autocomplete="off" /> 
<input class="form-control input-lg"  type="password" name="pass" placeholder="password" autocomplete="new-password"/>
<input class="btn btn-primary btn-block btn-lg"  type="submit" value="login" />
</form>



<?php
include  $tbl .'footer.php';



?>


76/20

AN@S 
102030