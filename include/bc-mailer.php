<?php
//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
//use PHPMailer\PHPMailer\Exception;

//require_once __DIR__ . '/vendor/phpmailer/src/Exception.php';
//require_once __DIR__ . '/vendor/phpmailer/src/PHPMailer.php';
//require_once __DIR__ . '/vendor/phpmailer/src/SMTP.php';

function customBCMailSender($from,$to,$subject,$message,$headers){

	//$smtpMAIL = new PHPMailer(true);
	//try {
		// Server settings
		
		//$smtpMAIL->isSMTP();
		//$smtpMAIL->Host = 'smtp.mail.yahoo.com';
		//$smtpMAIL->SMTPAuth = true;
		//$smtpMAIL->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		//$smtpMAIL->Port = 465;
		
		//$smtpMAIL->Username = 'beebayads@yahoo.com'; // YOUR gmail email
		//$smtpMAIL->Password = 'Beebay2002+'; // YOUR gmail password
		
		// Sender and recipient settings
		//$smtpMAIL->setFrom($from, $from);
		//$smtpMAIL->addAddress($to, $to);
		//$smtpMAIL->addReplyTo($from, $from); // to set the reply to
		
		// Setting the email content
		//$smtpMAIL->IsHTML(true);
		//$smtpMAIL->Subject = $subject;
		//$smtpMAIL->Body = $message;
		//$smtpMAIL->AltBody = $message;
		//$smtpMAIL->send();
	//} catch (Exception $e) {
		//echo $e->getMessage();
		
	//}
	
	//Inbuilt Mail Functions
	mail($to,$subject,$message,$headers);

}

?>