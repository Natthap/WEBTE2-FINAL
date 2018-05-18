<?php
/**
 * Created by PhpStorm.
 * User: mzikl
 * Date: 12.5.2018
 * Time: 13:53
 */

include('../subpages/classes/phpmailer/mail.php');

class ServiceMailHandler
{
    /*function to send an email
    emailType is 1 for sending successful register
    2 is fo sending mail to admin
    3 is for reseting password
    */
    function sendMail($email, $password, $subject, $message, $emailType)
    {
        if ($emailType == 1) {
            try {
                /*$body = "<p>Bol Vám vytvorený nový účet</p>
                <p>Vaše prihlasovacie meno je: " . $email . " a Vaše prihlasovacie heslo je: " . $password . "</p>
                <p>Vaše heslo si môžete zmeniť na tomto odkaze: <a href='" . DIR . "php/subpages/Reset.php'>" . DIR . "php/subpages/Reset.php</a></p></p>
                <p>S pozdravom Váš super admin</p>";*/

                $mail = new Mail();
                $mail->setFrom(SITEEMAIL);
                $mail->addAddress($email);
                $mail->subject($subject);
                $mail->body($message);
                $mail->send();
            } catch (PDOException $e) {
                $error[] = $e->getMessage();
            }
        }
        if ($emailType == 2) {
            try {
                $mail = new Mail();
                $mail->setFrom($email);
                $mail->addAddress(SITEEMAIL);
                $mail->subject($subject);
                $mail->body($message);
                $mail->send();

            } catch (PDOException $e) {
                $error[] = $e->getMessage();
            }
        }
        if ($emailType == 3) {
            try {
                $mail = new Mail();
                $mail->setFrom(SITEEMAIL);
                $mail->addAddress($email);
                $mail->subject($subject);
                $mail->body($message);
                $mail->send();
            } catch (PDOException $e) {
                $error[] = $e->getMessage();
            }
        }
    }
}