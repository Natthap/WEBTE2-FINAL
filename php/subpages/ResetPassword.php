<?php require('../Config.php');

//include the user class, pass in the database connection
include('classes/user.php');
include('classes/phpmailer/mail.php');
$user = new User($db);

ob_start();
session_start();

//if logged in redirect to members page
if( $user->is_logged_in() ){
    header('Location: Home.php');
    exit();
}

$resetToken = hash('SHA256', ($_GET['key']));

$stmt = $db->prepare('SELECT resetToken, resetComplete FROM members WHERE resetToken = :token');
$stmt->execute(array(':token' => $resetToken));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

//if no token from db then kill the page
if(empty($row['resetToken'])){
	$stop = 'Zadaný neplatný token, použite odkaz v poslanom emaily.';
} elseif($row['resetComplete'] == 'Yes') {
	$stop = 'Vaše heslo už bolo zmenené!';
}

//if form has been submitted process it
if(isset($_POST['submit'])){

	if (!isset($_POST['password']) || !isset($_POST['passwordConfirm']))
		$error[] = 'Obidve hesla musia byť zadané';

	//basic validation
	if(strlen($_POST['password']) < 3){
		$error[] = 'Heslo je príliš krátke.';
	}

	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Potvrdzovacie heslo je príliš krátke.';
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Heslá sa nezhodujú.';
	}

	//if no errors have been created carry on
	if(!isset($error)){

		//hash the password
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		try {
			$stmt = $db->prepare("UPDATE members SET password = :hashedpassword, resetComplete = 'Yes'  WHERE resetToken = :token");
			$stmt->execute(array(
				':hashedpassword' => $hashedpassword,
				':token' => $row['resetToken']
			));

			//redirect to index page
			header('Location: Login.php?action=resetAccount');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}
	}
}

$title = 'Reset Account';

require('layout/header.php'); 
?>

<div class="container">
	<div class="row">
	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
	    	<?php if(isset($stop)){
	    		echo "<p class='bg-danger'>$stop</p>";
	    	} else { ?>
				<form role="form" method="post" action="#" autocomplete="off">
					<h2>Zmena hesla</h2>
					<hr>

					<?php
					//check for any errors
					if(isset($error)){
						foreach($error as $error){
							echo '<p class="bg-danger">'.$error.'</p>';
						}
					}

					//check the action
					switch ($_GET['action']) {
						case 'active':
							echo "<h2 class='bg-success'>Vaše konto je teraz aktívne môžete sa prihlásiť.</h2>";
							break;
						case 'reset':
							echo "<h2 class='bg-success'>Skontrolujte si Váš email.</h2>";
							break;
					}
					?>

					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-6">
							<div class="form-group">
								<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Heslo" tabindex="1">
							</div>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-6">
							<div class="form-group">
								<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Potvrdenie hesla" tabindex="2">
							</div>
						</div>
					</div>
					
					<hr>
					<div class="row">
						<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Zmeniť heslo" class="btn btn-primary btn-block btn-lg" tabindex="3"></div>
					</div>
				</form>
			<?php } ?>
		</div>
	</div>
</div>

<?php 
//include header template
require('layout/footer.php'); 
?>