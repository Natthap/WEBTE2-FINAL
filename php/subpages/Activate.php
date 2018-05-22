<?php
require('../Config.php');

ob_start();
session_start();

//collect values from the url
$memberID = trim($_GET['x']);
$active = trim($_GET['y']);

if($memberID != null && !empty($active)){

	$stmt = $db->prepare("UPDATE members SET active = 'Yes' WHERE email = :memberID AND active = :active");
	$stmt->execute(array(
		':memberID' => $memberID,
		':active' => $active
	));

	//if the row was updated redirect the user
	if($stmt->rowCount() == 1){

		//redirect to login page
		header('Location: Login.php?action=active');
		exit;

	} else {
		echo "Vaše konto nemohlo byť aktivované.";
	}
}
?>