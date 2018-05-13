<?php
require('../Config.php');

//include the user class, pass in the database connection
include('classes/user.php');
include('classes/phpmailer/mail.php');
$user = new User($db);

ob_start();
session_start();

//if logged in redirect to members page
if( $user->is_logged_in()){
    header('Location: MembersPage.php');
    exit();
}

//if form has been submitted process it
if(isset($_POST['submit'])){

    if (!isset($_POST['email'])) $error[] = "Prosím vyplňte všetky polia";
    if (!isset($_POST['password'])) $error[] = "Prosím vyplňte všetky polia";

	$username = $_POST['username'];

	//very basic validation
	if(!$user->isValidUsername($username)){
		$error[] = 'Prihlasovacie meno musí byť dlhé aspoň 8 znaky a kratšie ako 17 znakov.';
	} else {
		$stmt = $db->prepare('SELECT username FROM members WHERE username = :username');
		$stmt->execute(array(':username' => $username));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['username'])){
			$error[] = 'Prihlasovacie meno je už použíté.';
		}
	}

	if(strlen($_POST['password']) < 3){
		$error[] = 'Heslo je príliš krátke.';
	}

	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Overovacie heslo je príliš krátke.';
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Heslá nie sú rovnaké.';
	}

	//email validation
	$email = htmlspecialchars_decode($_POST['email'], ENT_QUOTES);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Prosím zadajte platnú emalovú adresu.';
	} else {
		$stmt = $db->prepare('SELECT email FROM members WHERE email = :email');
		$stmt->execute(array(':email' => $email));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['email'])){
			$error[] = 'Zadaný email sa už používa.';
		}

	}


	//if no errors have been created carry on
	if(!isset($error)){
		//hash the password
		$hashed_password = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);
        //$password = $_POST['password'];

		//create the activasion code
		$activasion = md5(uniqid(rand(),true));

        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $school = $_POST['school'];
        $schoolAddress = $_POST['schoolAddress'];
        $city = $_POST['city'];
        $address = $_POST['address'];

		try {
            $address = 'avenida+gustavo+paiva,maceio,alagoas,brasil';

            $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$address.'&sensor=false');

            $output= json_decode($geocode);

            $lat = $output->results[0]->geometry->location->lat;
            $long = $output->results[0]->geometry->location->lng;

            $stm = $db->prepare('INSERT INTO memberData (meno,priezvisko,skola,skola_adresa,bydlisko,bydlisko_adresa,skola_GPS,bydlisko_GPS) VALUES (:firstName, :lastName, :school, :schoolAddress, :city, :address)');
            $stm->execute(array(
                ':firstName' => $firstName,
                ':lastName' => $lastName,
                ':school' => $school,
                ':schoolAddress' => $schoolAddress,
                ':city' => $city,
                ':address' => $address
            ));
            $idData = $db->lastInsertId('id');

			//insert into database with a prepared statement
			$stmt = $db->prepare('INSERT INTO members (data_id,username,password,email,personType,active) VALUES (:idData, :username, :password, :email, 1, :active)');
			$stmt->execute(array(
                ':idData' => $idData,
				':username' => $username,
				':password' => $hashed_password,
				':email' => $email,
				':active' => $activasion
			));
			$id = $db->lastInsertId('id');

			//send email
			$to = $_POST['email'];
			$subject = "Registration Confirmation";
			$body = "<p>Ďakujem Vám za registráciu</p>
			<p>Na aktiváciu vášho konta použite nasledujúci odkaz: <a href='".DIR."php/subpages/Activate.php?x=$id&y=$activasion'>".DIR."php/subpages/Activate.php?x=$id&y=$activasion</a></p>
			<p>S pozdravom váš super admin</p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			//redirect to index page
			header('Location: Register.php?action=joined');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}
	}
}

//define page title
$title = 'Úvodná stránka prihlasovacieho systému';

//include header template
require('layout/header.php');
?>

<div class="container">
	<div class="row">
	    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
			<form role="form" method="post" action="#" autocomplete="off">
				<h2>Zaregistrujte sa</h2>
				<p>Máte už účet? <a href='Login.php'>Prihláste sa</a></p>
				<hr>

				<?php
				//check for any errors
				if(isset($error)){
					foreach($error as $error){
						echo '<p class="bg-danger">'.$error.'</p>';
					}
				}

				//if action is joined show sucess
				if(isset($_GET['action']) && $_GET['action'] == 'joined'){
					echo "<h2 class='bg-success'>Registrácia prebehla úspešne skontrolujte si Váš email.</h2>";
				}
				?>

				<div class="form-group">
					<input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['email'], ENT_QUOTES); } ?>" tabindex="1">
				</div>
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password" tabindex="2">
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control input-lg" placeholder="Confirm Password" tabindex="3">
						</div>
					</div>
				</div>
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="text" name="firstName" id="firstName" class="form-control input-lg" placeholder="First Name" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['firstName'], ENT_QUOTES); } ?>" tabindex="4">
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <div class="form-group">
                            <input type="text" name="lastName" id="lastName" class="form-control input-lg" placeholder="Last Name" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['lastName'], ENT_QUOTES); } ?>" tabindex="5">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <input type="text" name="school" id="school" class="form-control input-lg" placeholder="School" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['school'], ENT_QUOTES); } ?>" tabindex="6">
                </div>
                <div class="form-group">
                    <input type="text" name="schoolAddress" id="schoolAddress" class="form-control input-lg" placeholder="School Address" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['schoolAddress'], ENT_QUOTES); } ?>" tabindex="7">
                </div>
                <div class="form-group">
                    <input type="text" name="city" id="city" class="form-control input-lg" placeholder="City" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['city'], ENT_QUOTES); } ?>" tabindex="8">
                </div>
                <div class="form-group">
                    <input type="text" name="address" id="address" class="form-control input-lg" placeholder="Address" value="<?php if(isset($error)){ echo htmlspecialchars($_POST['address'], ENT_QUOTES); } ?>" tabindex="9">
                </div>

				<div class="row">
					<div class="col-xs-6 col-md-6"><input type="submit" name="submit" value="Register" class="btn btn-primary btn-block btn-lg" tabindex="10"></div>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
//include header template
require('layout/footer.php');
?>