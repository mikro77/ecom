<?php 

session_start();
$pageTitle = "login";
if(isset($_SESSION['User'])){

header('Location:index.php'); // Redirect to dashboard
}
include 'ini.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  echo $_SERVER['REQUEST_METHOD']  ;

if(isset($_POST['login'])){

  var_dump($_POST);

$user = $_POST['username'];
$pass = $_POST['password'];
$hashpass = sha1($pass);

//::// [:: CHECK USER && PASS ::] //:://

$stmt = $dbh->prepare("SELECT
                         UserID,Username,Password 
                     FROM users 
                     WHERE 
                     Username = ? 
                     AND 
                     Password = ? 
                     ");

$stmt->execute(array($user,$hashpass));
$count = $stmt->rowCount();
// if Count > 0 this DB contain Record username 
    if ($count > 0 ){
          $_SESSION['User'] = $user ;  //register username 
          header('Location:index.php'); // Redirect to dashboard 
          exit();  
    }else 
    {
        echo " <br /> username or password is error ";
    }

}// $_POST['login']
else {
   var_dump($_POST);

   // START REGISTRATION CHECKED
//$formError = array();
$formErrors = array();
$username =      $_POST['username'];
$password =  $_POST['password'];
$password2 = $_POST['password-confirmation'];
$email =     $_POST['email'];

if (isset($username)) {

// استخدام الوظيفة الجديدة لتطهير البيانات
$filterUser =  htmlspecialchars($username);
echo $filterUser;
//  $filterdUser = filter_var($username, FILTER_SANITIZE_STRING);

if(strlen($filterUser) < 4 ){
  $formErrors[] = 'UserName Mustbe Larger Than 4';
}
}
//if (isset($password && $password2))
if (isset($password) && isset($password2))
{

  if(empty($password)){
    $formErrors[] = 'password is empty';
  }
  if (sha1($password) !== sha1($password2)) {
    $formErrors[] = 'password is not match';
  }
}

if(isset($email)){
  $filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
if (filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true) {
  $formErrors[] = 'This Email Is Not Valid';
  }
}

if(empty($formError)) {

$check = checkitem ("Username", "users", $username)   ;

if ($check == 1 ){
  $formErrors[] = 'this user is exist ' ;
}else {

$stm  = $dbh->prepare ("INSERT INTO 
users(Username, Password, Email, RegStatus, Date)
VALUES(:zuser, :zpass, :zmail, 0, now())");
$stm->execute(array(
'zuser' => $username,
'zpass' => sha1($password),
'zmail' => $email

));

$succesMsg = 'Congrats You Are Now Registerd User';

} // insert item if not exist

} // checkitem in DataBase

} // End REGISTRATION CHECKED

}// REQUEST_METHOD


?>

<div class="container login-page">
    <h1 class="text-center">
        <span class="selected" data-class="login">Login</span> |
        <span data-class="singup">Singup</span>
    </h1>
  <!-- Start login form -->
  <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
      <div class="input-container">
          <input type="text" class="form-control" name="username" placeholder="Username" required autocomplete="off">
      </div>
      <div class="input-container">
          <input type="password" class="form-control" name="password" placeholder="Password" required autocomplete="new-password">
      </div>
          <input type="submit" class="btn btn-primary btn-block" name="login" value="Login">
  </form>
  <!-- End login form -->


  <!-- Start singup form -->
  <form class="singup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
      <div class="input-container">
        <input type="text" class="form-control" name="username" placeholder="Username" required pattern=".{4,8}" title="Username must be between 4 and 8 characters" autocomplete="off">
      </div>
        <div class="input-container">
           <input type="password" class="form-control" name="password" placeholder="Password" required minlength="4" autocomplete="new-password">
        </div>
        <div class="input-container">
           <input type="password" class="form-control" name="password-confirmation" placeholder="Password Confirmation" required minlength="4" autocomplete="new-password">
        </div>
        <div class="input-container">
            <input type="email" class="form-control" name="email" placeholder="example@domain.com" required>
        </div>
      <input type="submit" class="btn btn-success btn-block" name="singup" value="registration">
  </form>
  <!-- End singup form -->

	<div class="the-errors text-center">
		<?php 

			if (!empty($formErrors)) {

				foreach ($formErrors as $error) {

					echo '<div class="msg error">' . $error . '</div>';

				}

			}

			if (isset($succesMsg)) {

				echo '<div class="msg success">' . $succesMsg . '</div>';

			}

		?>
	</div>
</div>



<?php
include $tbl . 'footer.php' ; 
?>