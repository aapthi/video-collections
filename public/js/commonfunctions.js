function checkEmail(emailStr) {
	if (emailStr.length == 0) {
		return true;
	}
	var emailPat=/^(.+)@(.+)$/;
	var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]";
	var validChars="\[^\\s" + specialChars + "\]";
	var quotedUser="(\"[^\"]*\")";
	var ipDomainPat=/^(\d{1,3})[.](\d{1,3})[.](\d{1,3})[.](\d{1,3})$/;
	var atom=validChars + "+";
	var word="(" + atom + "|" + quotedUser + ")";
	var userPat=new RegExp("^" + word + "(\\." + word + ")*$");
	var domainPat=new RegExp("^" + atom + "(\\." + atom + ")*$");
	var matchArray=emailStr.match(emailPat);
	if (matchArray == null) {
		return false;
	}
	var user=matchArray[1];
	var domain=matchArray[2];
	if (user.match(userPat) == null) {
		return false;
	}
	var IPArray = domain.match(ipDomainPat);
	if (IPArray != null) {
		for (var i = 1; i <= 4; i++) {
			if (IPArray[i] > 255) {
				return false;
			}
		}
		return true;
	}
	var domainArray=domain.match(domainPat);
	if (domainArray == null) {
		return false;
	}
	var atomPat=new RegExp(atom,"g");
	var domArr=domain.match(atomPat);
	var len=domArr.length;
	if ((domArr[domArr.length-1].length < 2) ||(domArr[domArr.length-1].length > 3)) {
		return false;
	}
	if (len < 2) {
	   return false;
	}
	return true;
}
var Required = 'Required';
var email_wrong_format = 'Entered email format is wrong';
var email_already_exists = 'Entered email is already registered';
function checkEmailVaild(){
	if( $("#hid_user_id").val() == ''){		
		var emailcheck = $("#user_email").val();
		if(emailcheck!==''){
			if(checkEmail(emailcheck)==false)
			{
				$("#user_email_req").html(email_wrong_format); return false;
			}else{
				$("#user_email_req").html('');
				$.ajax({
					type:'POST',
					url:  BASE_URL+'/users/check-email-exists',
					data:{user_email:emailcheck},
					success: function(data){
						if(data.output=='exists'){
							$("#hidCheckValue").val('1');
						}else{
							$("#hidCheckValue").val('0');
						}
					}
				});
			}
		}
	}
}
function validateReg()
{
	var flag = true;	
	var userEmail = $("#user_email").val();
	if($("#user_first_name").val()==''){
		$("#user_firstname_req").html(Required);
		flag = false;
	}else{
		$("#user_firstname_req").html('');
	}
	if($("#user_last_name").val()==''){
		$("#user_lastname_req").html(Required);
		flag = false;
	}else{
		$("#user_lastname_req").html('');
	}
	if($("#hid_user_id").val()==""){
		if(userEmail==""){
			$("#user_email_req").html(Required);
			flag=false;
		}else if(checkEmail(userEmail)==false){
			$("#user_email_req").html(email_wrong_format);
			flag=false;
		}else if($("#hidCheckValue").val()==1){
			tab1flag = false;
			$("#user_email_req").html(email_already_exists); 
			flag=false;
			return false;
		}else{
			$("#user_email_req").html('');
		}
	}else{
		$("#hidCheckValue").val('0');
		$("#user_email_req").html('');
	}
	if($("#user_password").val()==''){
		$("#user_pwd_req").html(Required);
		flag = false;
	}else{
		$("#user_pwd_req").html('');	
	}		
	if($("#user_mobile").val()==''){
		$("#user_mobile_req").html(Required);
		flag = false;
	}else{
		$("#user_mobile_req").html('');	
	}
	if(flag==false){		
		return false;
	}else{
		$("#frm_meth").submit();	
	}
}
function loginValidations(){
	var flag=true;
	$('#errorMsg').html('');
	var userEmail=$('#email').val();
	var userPassword=$('#password').val();
	if(userEmail==''){
		$('#emailError').html('Required');
		flag=false;
	}else if(checkEmail(userEmail)==false){
		$('#emailError').html('Enter valid email address without spaces');
		flag=false;
	}else{
		$('#emailError').html('');
	}
	if(userPassword==''){
		$('#passwordError').html('Required');
		flag=false;
	}else{
		$('#passwordError').html('');
	}
	if(flag==false){
		return false;
	}else{
			var image=BASE_PATH+'/images/ajax-loader.gif';
			$('#reload').html('<img src='+image+' />'); 
			var url=BASE_URL+'/users/login';
			$.ajax({
				type:'POST',
				datatype:'json',
				url:  url,
				data:{inputEmail:userEmail,password:userPassword},
				success: function(response){
					$('#reload').html('');
					if(response.output=='success'){
						if(response.user_type_id==4){
							window.location=BASE_URL+"/admin/dashboard";							
						}else {
							window.location=BASE_URL;
						}
					}else{
						$('#errorMsg').html('Entered wrong username and/or password');
					}
				}
			});
	}
}
function adloginValidations(){
	var flag=true;
	$('#errorMsg').html('');
	var userEmail=$('#user_email').val();
	var userPassword=$('#user_password').val();
	if(userEmail==''){
		$('#emailError').html('Required');
		flag=false;
	}else if(checkEmail(userEmail)==false){
		$('#emailError').html('Enter valid email address without spaces');
		flag=false;
	}else{
		$('#emailError').html('');
	}
	if(userPassword==''){
		$('#passwordError').html('Required');
		flag=false;
	}else{
		$('#passwordError').html('');
	}
	if(flag==false){
		return false;
	}else{
			var image=BASE_PATH+'/images/ajax-loader.gif';
			$('#reload').html('<img src='+image+' />'); 
			var url=BASE_URL+'/admin/login';
			$.ajax({
				type:'POST',
				datatype:'json',
				url:  url,
				data:{inputEmail:userEmail,password:userPassword},
				success: function(response){
					$('#reload').html('');
					if(response.output=='success'){
						if(response.user_type=='admin'){
							window.location=BASE_URL+"/admin/dashboard";							
						}
					}else{
						$('#errorMsg').html('Entered wrong username and/or password');
					}
				}
			});
	}
}
function changePassword(regAuth){	
	$('#errorMsg').html('');
	$('#sucessMsg').html('');
	$("#sucessdiv").hide();
	$("#errordiv").hide();
	var flag=true;
	var userId=$("#hidUserId").val();
	var oldpasswrd=$("#oldPassword").val();		
	var passwrd=$("#newPassword").val();
	var cnfpwrd=$("#confirmPassword").val();
	if(oldpasswrd==""){
		$('#oldPwdError').html('Required');
		$("#oldPassword").focus();
		flag=false;
	}else{
		$('#oldPwdError').html('');
	}		
	if(passwrd==""){
		$('#newPwdError').html('Required');
		$("#newPassword").focus();
		flag=false;
	}else{
		$('#newPwdError').html('');
	}		
	if(cnfpwrd==""){
		$('#confirmPwdError').html('Required');
		$("#confirmPassword").focus();
		flag=false;
	}else{
		$('#confirmPwdError').html('');
	}		
	if(flag==false){
		return false;
	}else{
		$('#errorMsg').html('');
		$('#sucessMsg').html('');
		var image=BASE_PATH+'/images/ajax-loader.gif';
			$('#reload').html('<img src='+image+' />'); 
		if(passwrd==cnfpwrd){
			if(regAuth=='admin'){
				var  url =   ADMIN_BASE_URL+'/admin/check-password';
			} else if(regAuth=='user'){
				var  url =  BASE_URL+'/users/check-password';
			}
			$.ajax({
				type:'POST',
				url: url,
				data:{oldpasswrd:oldpasswrd,userId:userId},
				success: function(data){
					if(data.output=='success'){
						$('#reload').html('');
						if(regAuth=='admin'){
								var  url2 =   ADMIN_BASE_URL+'/admin/change-password';
						} else if(regAuth=='user'){
								var  url2 =  BASE_URL+'/users/change-password';
						}
						$.ajax({
							type:'POST',
							url: url2, 
							data:{cnfpwrd:cnfpwrd,userId:userId},
							success: function(data){
								$("#oldPassword").val('');
								$("#newPassword").val('');
								$("#confirmPassword").val('');
								$("#errordiv").hide();
								$("#sucessdiv").show();
								$('#sucessMsg').html('Your password has been changed');
							
							}
						});					
					}else{
						$("#sucessdiv").hide();
						$("#errordiv").show();
						$('#reload').html('');
						$('#errorMsg').html('Old password is wrong');
					}
				}
			});			
		}else{
			$("#sucessdiv").hide();
			$("#errordiv").show();
			$('#errorMsg').html('New and confirm passwords do not match');
			$("#confirmPassword").focus();
			$('#reload').html('');
		}
	}		
}	
function forgetPassword(){	
	$("#sucessdiv").hide();
	$("#errordiv").hide();
	$('#errorMsg').html('');
	$('#sucessMsg').html('');
    var flag=true;
	var emailcheck=$('#forgetMail').val();
	if(emailcheck==''){
		$('#emailError').html('Required');
		flag=false;
	}else if(checkEmail(emailcheck)==false){
		$('#emailError').html('Enter valid email address');
		flag=false;
	}else{
		$('#emailError').html('');
	}
	if(flag==false){ 
		return false;
	}else{	
		var image=BASE_PATH+'/images/ajax-loader.gif';
		$('#reload').html('<img src='+image+' />'); 
		var  url =  BASE_URL+'/users/send-password-reset-url';
		$.ajax({
			type:'POST',
			url:   url,
			data:{email:emailcheck},
			success: function(result){
				$('#reload').html(''); 
				if(result.output=='success'){
					$("#sucessdiv").show();
					$('#sucessMsg').html('Email sent to you');
				}else if(result.output=='Not Found The Email'){
					$("#errordiv").show();
					$('#errorMsg').html('Email is not in our database');
				}else if(result.output=='server-error'){
					$("#errordiv").show();
					$('#errorMsg').html('Email is not going');
				}
			}
		});			
	}		
}
function resetPassword(regAuth){	
	var flag=true;
	$('#errorMsg').html('');
	$('#sucessMsg').html('');
	$("#errordiv").hide();
	$("#errordiv").hide();
	var token=$('#hidToken').val();	
	var passwrd=$("#newPassword").val();
	var cnfpwrd=$("#confirmPassword").val();
	if(passwrd==""){
		$('#newPwdError').html('Required');
		$("#newPassword").focus();
		flag=false;
	}else{
		$('#newPwdError').html('');
	}		
	if(cnfpwrd==""){
		$('#confirmPwdError').html('Required');
		$("#confirmPassword").focus();
		flag=false;
	}else{
		$('#confirmPwdError').html('');
	}
	if(flag==false){ 
			return false;
	}else{	
		var image=BASE_PATH+'/images/ajax-loader.gif';
		$('#reload').html('<img src='+image+' />');
		if(passwrd==cnfpwrd){
		var  url = BASE_URL+'/users/setnepassword';
			$.ajax({
				type:'POST',
				url:url,
				data:{cnfpwrd:cnfpwrd,token:token},
				success: function(data){
					$('#reload').html(''); 
					if(data.output=='success'){	
						$("#sucessdiv").show();
						$('#sucessMsg').html('Password reset');
							window.location=BASE_URL;
					}else{
						$("#sucessdiv").show();
						$('#sucessMsg').html('Password already reset');
					}
				}
			});
		}else{
			$('#reload').html(''); 
			$("#errordiv").show();
			$('#errorMsg').html('New and confirm passwords do not match');
			$("#confirmPassword").focus();
		}
	}		
}
function openPopup(url)
	{
		var left = Number((screen.width/2)-(500/2));
		var top = Number((screen.height/2)-(500/2));
		var windowFeatures = 'channelmode=0,directories=0,fullscreen=0,location=0,menubar=0,resizable=0,scrollbars=0,status=0,width=500,height=450,top=' + top + ',left=' + left;
		$('#userMessage').hide();
		$('#userMessage').html( "" );
		window.location=url;
	}
