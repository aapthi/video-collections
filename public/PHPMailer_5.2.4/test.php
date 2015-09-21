<?php
		include_once('class.phpmailer.php');
	
		$mail             = new PHPMailer(); // defaults to using php "mail()"
		$mail->IsSMTP(); // send via SMTP
		$mail->Host     = "relay-hosting.secureserver.net"; // SMTP servers
		$mail->Port  = 25; // SMTP port used by GMAIL server
		$mail->IsSendmail(); // telling the class to use SendMail transport

		$body             = 'Hello world';

		$mail->AddReplyTo("samarasay@gmail.com","First Last");

		$mail->SetFrom('samarasay@gmail.com', 'First Last');

		$mail->AddReplyTo("samarasay@gmail.com","First Last");

		$address = "samarasay@gmail.com";
		$mail->AddAddress($address, "John Doe");

		$mail->Subject    = "PHPMailer Test Subject via Sendmail, basic";

		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

		$mail->MsgHTML($body);

		if(!$mail->Send()) {
		  echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
		  echo "Message sent!";
		}
?>
    