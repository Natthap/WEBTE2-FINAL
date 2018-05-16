<?php require('../Config.php');

//include the user class, pass in the database connection
include('classes/user.php');
include('classes/phpmailer/mail.php');
include('../services/ServiceUser.php');

$user = new User($db);

ob_start();
session_start();

//if logged in redirect to members page
if( $user->is_logged_in() ){
    header('Location: Home.php');
    exit();
}

//if form has been submitted process it
if(isset($_POST['submit'])){

	//Make sure all POSTS are declared
	if (!isset($_POST['email'])) $error[] = "Prosím vyplňte všetky polia.";


	//email validation
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Zadajte platnú emailovú adresu.';
	} else {
		if(!userExist($db, $_POST['email'])){
			$error[] = 'Zadaný email nerozoznaný.';
		}

	}

	//if no errors have been created carry on
	if(!isset($error)){

		//create the activation code
		$stmt = $db->prepare('SELECT password, email FROM members WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$token = hash_hmac('SHA256', $user->generate_entropy(8), $row['password']);//Hash and Key the random data
        $storedToken = hash('SHA256', ($token));//Hash the key stored in the database, the normal value is sent to the user

		try {

			$stmt = $db->prepare("UPDATE members SET resetToken = :token, resetComplete='No' WHERE email = :email");
			$stmt->execute(array(
				':email' => $row['email'],
				':token' => $storedToken
			));

			//send email
			$to = $row['email'];
			$subject = "Obnovenie hesla";
			$body = "<p>Niekto požiadal o obnovenie hesla.</p>
			<p>Ak je tento mail chyba môžete ho ignorovať.</p>
			<p>Na obnovenie hesla použite nasledujúci odkaz: <a href='".DIR."php/subpages/ResetPassword.php?key=$token'>".DIR."php/subpages/resetPassword.php?key=$token</a></p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			//redirect to index page
			header('Location: Login.php?action=reset');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}
	}
}

$title = 'Obnovenie konta';

require('layout/header.php');
?>

<div class="container">
	<div class="row">
	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form" method="post" action="#" autocomplete="off">
				<h2>Obnovenie hesla</h2>
				<p><a class="btn btn-primary" href='Login.php'>Späť na prihlásenie</a></p>
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
							echo "<h2 class='bg-success'>Vaše konto je teraz aktívne môžete sa prihlásiť.</h2>";
							break;
						case 'reset':
							echo "<h2 class='bg-success'>Skontrolujte si Vás email.</h2>";
							break;
					}
				}
				?>

				<div class="form-group">
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email" value="" tabindex="1">
				</div>

				<hr>
				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Poslať resetovací link" class="btn btn-primary btn-block btn-lg" tabindex="2"></div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
//include header template
require('layout/footer.php');
?>
