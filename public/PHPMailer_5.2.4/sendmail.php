<?php
	include_once('class.phpmailer.php');
	function sendMail($to,$subject,$message,$fromAddress='',$fromUserName='',$toName='',$bcc='',$upload_dir='', $filename='')
	{	
		
		try{
		$mail             	= new PHPMailer();
		$mail->IsSMTP();
		$mail->Host     	= "sm4.siteground.biz";
		$mail->Port  		= 2525;
		$mail->SMTPAuth = true; 
		$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)

		// Enable SMTP authentication
		$mail->Username = 'dileepkumarkonda@gmail.com';                // SMTP username
		$mail->Password = 'samarasa@1234';                  // SMTP password
		$mail->IsHTML(true);
		$mail->ClearAddresses();
		$find = strpos($to,',');		
		if($find)
		{
			$ids = explode(',',$to);
			for($i=0;$i<count($ids);$i++)
			{
				$mail->AddAddress($ids[$i]);
			}
		}
		else
		{
			$mail->AddAddress($to);
		}	
		
		if($fromAddress!=''){
			$mail->From     = $fromAddress;
		} else {
			$mail->From     = "dileepkumarkonda@gmail.com";
		}
		if($fromUserName!=''){
			$mail->FromName = $fromUserName;
		} else {
			$mail->FromName = "Video Collections";	
		}
		$mail->WordWrap = 50; 
		$mail->IsHTML(true);
		$mail->Subject 	= $subject;			
		$mail->Body 	= $message;
		if($upload_dir!='')
		{
			foreach($upload_dir as $uploaddirs)
			{
				$mail->AddAttachment($uploaddirs, $filename); 
			}
		}
		if($mail->Send())
		{
		
			return 1;	
		}
		else
		{
			return 0;	
		}
		} catch (phpmailerException $e) {
		  echo $e->errorMessage(); //Pretty error messages from PHPMailer
		} catch (Exception $e) {
		  echo $e->getMessage(); //Boring error messages from anything else!
		}
	}
	//sendMail('sivareddybtech@gmail.com','subject','mesaage')
?>