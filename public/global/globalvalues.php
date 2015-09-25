<?php
/*Forget Password*/
global $forgotPasswordSubject;
global $frogotPasswordMessage;
$forgotPasswordSubject = "Request For New Password for Poraapo";
$frogotPasswordMessage = '<body>
		<table width="600" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><table width="600" border="0" cellspacing="0" cellpadding="5" style="border:1px solid #178acc">
			<tr><td bgcolor="#178acc">
				<a href="javascript:void(0);" target="_blank" style="text-decoration: none;">
				<span style="color:#fff; font:normal 30px arial">Video Blogger</span></a></td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="10" align="left">
						<tr><td><a href="javascript:void(0);" style="color:#4ca4b6; font:bold 12px arial; text-decoration:none;">Hello&nbsp;<FULLNAME></a></td></tr>
						<tr><td>This email was generated based on your request for new password.</td></tr>
						<tr><td>Please click the below link to reset your password.</td></tr>
						<tr><td><a href="<PASSWORDLINK>"><PASSWORDLINK></a></td></tr>
						<tr><td>Note: If you did not request for new password, please ignore this email.</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>Sincerely,</td></tr>
						<tr><td>Video Blogger Team</td></tr>
					</table>
				</td>
			</tr>  
			</table></td>
		</tr> 
	</table>
<br/><br/>
Regards,<br/>
Video Blogger 
</body>';
/*End Forget Password*/

/* Cron Message subject */
global $activeUserSubject;
global $activeUsersMessage;
$activeUserSubject= "Welcome, New User.";
$activeUsersMessage='<body>
		<table width="600" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><table width="600" border="0" cellspacing="0" cellpadding="5" style="border:1px solid #178acc ">
			<tr><td bgcolor="#178acc ">
				<a href="Javascript:void(0);" target="_blank" style="text-decoration: none;">
				<span style="color:#fff; font:normal 30px arial">Video Blogger</span></a></td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="10" align="left">
						<tr><td><a href="javascript:void(0);" style="color:#4ca4b6 ; font:bold 12px arial; text-decoration:none;">Dear&nbsp;<FULLNAME></a></td></tr>
						<tr><td><a href="<ACTIVATIONLINK>"><ACTIVATIONLINK></a></td></tr>
						<tr><td>Please click on this link to verfiy your account.</td></tr>
						<tr><td>Your Login Credentials.</td></tr>						
						<tr><td><EMAILID></td></tr>						
						<tr><td><PASSWORD></td></tr>						
						<tr><td>&nbsp;</td></tr>
						<tr><td>Sincerely,</td></tr>
						<tr><td>Video Blogger Team</td></tr>
					</table>
				</td>
			</tr>  
			</table></td>
		</tr> 
	</table>
<br/><br/>
Regards,<br/>
Video Blogger
</body>';
/* end Cron subject*/



/* register subject */
global $regSubject;
global $regMessage;
$regSubject= "Registration confirmation";
$regMessage='<body>
		<table width="600" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><table width="600" border="0" cellspacing="0" cellpadding="5" style="border:1px solid #178acc ">
			<tr><td bgcolor="#178acc ">
				<a href="Javascript:void(0);" target="_blank" style="text-decoration: none;">
				<span style="color:#fff; font:normal 30px arial">Video Blogger</span></a></td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="10" align="left">
						<tr><td><a href="javascript:void(0);" style="color:#4ca4b6 ; font:bold 12px arial; text-decoration:none;">Hello&nbsp;<FULLNAME></a></td></tr>
						<tr><td><a href="<ACTIVATIONLINK>"><ACTIVATIONLINK></a></td></tr>
						<tr><td>Please click on this link to verfiy your account.</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>Sincerely,</td></tr>
						<tr><td>Video Blogger Team</td></tr>
					</table>
				</td>
			</tr>  
			</table></td>
		</tr> 
	</table>
<br/><br/>
Regards,<br/>
Video Blogger
</body>';
/* end register subject*/
global $completeRegisterSubject;				
global $completeRegisterMessage;	
$completeRegisterSubject="Welcome to Video Blogger";
$completeRegisterMessage='<body>
		<table width="600" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><table width="600" border="0" cellspacing="0" cellpadding="5" style="border:1px solid #178acc ">
			<tr><td bgcolor="#178acc ">
				<a href="Javascript:void(0);" target="_blank" style="text-decoration: none;">
				<span style="color:#fff; font:normal 30px arial">Video Blogger</span></a></td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="10" align="left">
						<tr><td><a href="javascript:void(0);" style="color:#4ca4b6 ; font:bold 12px arial; text-decoration:none;">Hello&nbsp;<FULLNAME></a></td></tr>
						<tr><td><a href="<ClickeHere>"><ClickeHere></a></td></tr>
						<tr><td>Successfully registered with Video Blogger, Thanks for joining us.</td></tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>Sincerely,</td></tr>
						<tr><td>Video Blogger Team</td></tr>
					</table>
				</td>
			</tr>  
			</table></td>
		</tr> 
	</table>
<br/><br/>
Regards,<br/>
Video Blogger
</body>';
/* register subject */
global $sentShareMsgSubject;
global $sentShareMessage;
$sentShareMsgSubject= "Share mail from Video Blogger";
$sentShareMessage='<body>
		<table width="400" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><table width="400" border="0" cellspacing="0" cellpadding="5" style="border:1px solid #178acc ">
			<tr><td bgcolor="#178acc ">
				<a href="Javascript:void(0);" target="_blank" style="text-decoration: none;">
				<span style="color:#fff; font:normal 30px arial">Video Blogger</span></a></td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="10" align="left">
						<tr><td><MESSAGE></td></tr>
						<tr><td><CATEGORYNAME>-<TITLE></td></tr>						
						<tr><td><DESCRIPTION></td></tr>						
					</table>
				</td>
			</tr>  
			</table></td>
		</tr> 
	</table>
</body>';
/* end register subject*/
/* register subject */
global $contactSubject;				
global $contactMessage;
$contactSubject= "Contact Information";
$contactMessage='<body>
		<table width="400" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td><table width="400" border="0" cellspacing="0" cellpadding="5" style="border:1px solid #178acc ">
			<tr><td bgcolor="#178acc ">
				<a href="Javascript:void(0);" target="_blank" style="text-decoration: none;">
				<span style="color:#fff; font:normal 30px arial">Video Blogger</span></a></td>
			</tr>
			<tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="10" align="left">
						<tr><td>Contact Name:</td><td><FIRSTNAME></td></tr>
						<tr><td>Conatct Email:</td><td><CONTACTEMAIL></td></tr>
						<tr><td>Conatct Number:</td><td><PHONENUMBER></td></tr>
						<tr><td>Contact Message:</td><td><CONTACTMESSAGE></td></tr>
					</table>
				</td>
			</tr>  
			</table></td>
		</tr> 
	</table>
</body>';

