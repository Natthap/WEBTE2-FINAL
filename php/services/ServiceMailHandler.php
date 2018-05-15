<?php
/**
 * Created by PhpStorm.
 * User: mzikl
 * Date: 12.5.2018
 * Time: 13:53
 */

require('../Config.php');
include('../subpages/classes/phpmailer/mail.php');

function sendMail($email, $password) {
    $to = $email;
    $subject = "Vytvorenie noveho konta";
    $body = "<p>Bol Vám vytvorený nový účet</p>
			<p>Vaše prihlasovacie meno je: ".$email." a Vaše prihlasovacie heslo je: ".$password."</p>
			<p>Vaše heslo si môžete zmeniť na tomto odkaze: <a href='".DIR."php/subpages/Reset.php'>".DIR."php/subpages/Reset.php</a></p></p>
			<p>S pozdravom Váš super admin</p>";

    $mail = new Mail();
    $mail->setFrom(SITEEMAIL);
    $mail->addAddress($to);
    $mail->subject($subject);
    $mail->body($body);
    $mail->send();
}