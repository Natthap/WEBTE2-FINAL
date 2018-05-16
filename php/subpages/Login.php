<?php
//include config
require_once('../Config.php');

//include the user class, pass in the database connection
include('classes/user.php');
include('classes/phpmailer/mail.php');

$user = new User($db);

ob_start();
session_start();

//check if already logged in move to home page
if( $user->is_logged_in() ){
    header('Location: Home.php');
    exit();
}

//process login form if submitted
if(isset($_POST['submit'])){
	if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
                //your site secret key
        	$secret = '6LcjzFcUAAAAAMC61X7zptXc6GIr18MHYZ8cRc9j';
                //get verify response data
        	$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
        	$responseData = json_decode($verifyResponse);

		if($responseData->success){
			if (!isset($_POST['username'])) $error[] = "Prosím vyplňte všetky polia";
			if (!isset($_POST['password'])) $error[] = "Prosím vyplňte všetky polia";

			$username = $_POST['username'];
			//if ($user->isValidUsername($username)){
				if (!isset($_POST['password'])){
					$error[] = 'A password must be entered';
				}
				$password = $_POST['password'];

				if($user->login($username,$password)){
					$_SESSION['username'] = $username;
					header('Location: Home.php');
					exit;

				} else {
					$error[] = 'Zlé meno heslo alebo konto ešte nebolo aktivované';
				}
			//} else{
			//	$error[] = 'Prihlasovacie mená musia byť alfanumerické s dĺžkou 3-16 znakov';
			//}
            $succMsg = 'reCAPTCHA kód bol úspešne overený.';
            $name = '';
            $email = '';
            $message = '';
        } else {
            $errMsg = 'Robot verifikácia zlyhala, prosím skúste znovu';
        }
    } else {
        $errMsg = 'Prosím kliknite na reCAPTCHA okno.';
    }
} else {
	$errMsg = '';
	$succMsg = '';
    $name = '';
    $email = '';
    $message = '';
}
//end if submit

//define page title
$title = 'Login';

//include header template
require('layout/header.php');
?>

<div class="container">
	<div class="row">
	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<?php if(!empty($errMsg)): ?><div class="errMsg"><?php echo $errMsg; ?></div><?php endif; ?>
            <?php if(!empty($succMsg)): ?><div class="succMsg"><?php echo $succMsg; ?></div><?php endif; ?>

			<form role="form" method="post" action="#" autocomplete="off">
				<h2>Prihláste sa</h2>
				<p><a href='../../index.php'>Naspäť na domovskú stránku</a></p>
                <p><a href='Reset.php'>Resetujte si heslo</a></p>
				<hr>

				<?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				if(isset($_GET['action'])){
					//check the action
					switch ($_GET['action']) {
						case 'active':
							echo "<h2 class='bg-success'>Vaše konto je aktívne, môžete sa prihlásiť.</h2>";
							break;
						case 'reset':
							echo "<h2 class='bg-success'>Prosím skontrolujte si Vašu emailovú schránku na resetovací kód.</h2>";
							break;
						case 'resetAccount':
							echo "<h2 class='bg-success'>Heslo bolo zmenené, môžete sa prihlásiť.</h2>";
							break;
					}
				}
				?>

				<div class="form-group">
					<input type="text" name="username" id="username" class="form-control input-lg" placeholder="Email" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['username'], ENT_QUOTES); } ?>" tabindex="1">
				</div>

				<div class="form-group">
					<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Heslo" tabindex="3">
				</div>

				<div class="g-recaptcha" data-sitekey="6LcjzFcUAAAAAJwGdMJuNhdvZvg1pEchJGIrdOOl"></div>
				
				<hr>
				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Prihlásenie" class="btn btn-primary btn-block btn-lg" tabindex="5"></div>
				</div>
			</form>
		</div>
	</div>
</div>


<?php 
//include header template
require('layout/footer.php');
?>
