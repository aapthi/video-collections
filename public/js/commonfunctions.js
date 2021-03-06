/***********Auto*********************/
function serachTitle(){
	$("#videosSearch").autocomplete({	
		source: function( request, response ) {
			var keywordsss = $('#videosSearch').val();
			var hashName='s';
			$.ajax({
				url: BASE_URL+'/search-title-result',
				dataType: "json",
				type	: "POST",
				data	:{value:keywordsss},
				success: function( data ) {
					if(data.output!=0) {		
						response( $.map( data.searchHashNames, function( item ) {
							return {
								label: item.ref,
								idd: item.part,
							}
						}));
					}else{
						$(".ui-autocomplete").css("display","none");
					}
				}				
			});
		},
		minLength: 0,	
		open: function(event, ui) {				
			$(".ui-autocomplete").css("width","506px !important");
		},
		select: function(event, ui) {
			$("#videosSearch").val(ui.item.label); 
			return false;
		},
		focus: function(event, ui) {
			return false;
		}			
	});
	$("#videosSearch").data( "uiAutocomplete" )._renderItem = function( ul, item ) {
		var vid=item.idd;
		 return $("<li><a href='"+item.idd+"'>" + item.label + "</a></li>")
		 .data("item.uiAutocomplete", item)            
		 .appendTo(ul);				
	};
}
/**********************END********************/

function contactFormFunction(){
	var flag=true;
	var fname=$('#firstName').val();
	var lnmae=$('#lastName').val();
	var contactemail=$('#contactEmail').val();
	var mobile=$('#mobileNumber').val();
	var message=$('#contactMessage').val();
	if(fname==""){
		$('#fnameError').html('Required');
		flag==false;
	}else{
		$('#fnameError').html('');
	}
	if(contactemail==''){
		$('#emailError').html('Required');
		flag=false;
	}else if(checkEmail(contactemail)==false){
		$('#emailError').html('Invalid Email');
		flag=false;
	}else{
		$('#emailError').html('');
	}
	if(mobile==''){
		$('#mobileError').html('Required');
		flag=false;
	}else{
		$('#mobileError').html('');
	}
	if(message==""){
		$('#messageError').html('Required');
		flag==false;
	}else{
		$('#messageError').html('');
	}
	if(flag==true){
		$('#con_form_id').submit();
	}
}
function alreadyExists(){
	var videocheck = $("#video_link").val();
	if(videocheck!==''){
		$.ajax({
			type:'POST',
			url:  BASE_URL+'/users/check-video-exists',
			data:{videoLink:videocheck},
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
function deleteVideo(vid){
	if(confirm("Are you sure you want to delete the video?")){
		window.location=BASE_URL+'/admin/delete-video?vid='+vid+'&st=del';
	}
	
}
function refresh(){
	$.ajax({
		url: BASE_URL+"/users/captcha-getcode",
		type: "POST",				
		success: function(msg){ 
			$("#refreshCode").val(msg.captchcode);
		},				
	});   
}
function searchByLocation(){
	var searchKey=$('#videosSearch').val();
	if(searchKey=='')
		{
			alert("Please enter search criteria");
			return false;
		}
		else
		{
			window.location=BASE_URL+"/search-result/"+searchKey;			
		}
}
function reloadPageH(){
	window.location=BASE_URL;
}
// $(document).ready(function() {
	// $('#video_img').bind('change', function() {
		// if(this.files[0].size > 1000141){
			// $("#uplodImageError").val(1);
			// alert("Image size should be below 1 mb");
			// return false;
		// }
		// else
		// {
			// $("#uplodImageError").val(0);
		// }
	// });
// });
function validateVideo(){
	if($("#video_title").val()==''){
		alert('Please enter video title.'); 
		 $( "#video_title" ).focus();
		return false;
	}
	if($("#hid_vid").val()==''){
		if($("#video_link").val()==''){
			alert('Please enter video link.'); 
			 $( "#video_link" ).focus();
			return false;
		}else if($("#hidCheckValue").val()==1){
			alert('Entered video link is already exists.'); 
			 $( "#video_link" ).focus();
			return false;	
		}
	}else{
		if($("#video_link").val()==''){
			alert('Please enter video link.'); 
			 $( "#video_link" ).focus();
			return false;
		}
		if( $("#video_link_check").val() != $("#video_link").val() ){
			if($("#hidCheckValue").val()==1){
				alert('Entered video link is already exists.'); 
				$( "#video_link" ).focus();
				return false;
			}			
		}
	}
	if($("#video_desc").val()==''){
		alert('Please enter video description.'); 
		$( "#video_desc" ).focus();
		return false;
	}
	if($("#video_cat").val()==''){
		alert('Please enter video category.');
		$( "#video_cat" ).focus();
		return false;
	}
	// if($("#hid_imag").val() == ''){
		// if($('#video_img').val()==""){
			// alert('Please image required');
			// $( "#video_img" ).focus();
			// return false;
			
		// }else{
			// if($("#uplodImageError").val()==1){
				// alert('Image size should be below 1 mb');
				// return false;
			// }
			// if($("#uplodImageError").val()!=1){
				// if($('#video_img').val()!=""){
					// var val = $('#video_img').val();
					// switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
						// case 'gif': case 'jpg': case 'png': case 'jpeg':
							// break;
						// default:
							// $(this).val('');
							// alert('Please upload valid image formats');
							// break;
							// return false;
					// }
				// }
			// }
		// }
	// }else{
		// if($("#uplodImageError").val()==1){
			// alert('Image size should be below 1 mb');
			// return false;
		// }
		// if($("#uplodImageError").val()!=1){
			// if($('#video_img').val()!=""){
				// var val = $('#video_img').val();
				// switch(val.substring(val.lastIndexOf('.') + 1).toLowerCase()){
					// case 'gif': case 'jpg': case 'png': case 'jpeg':
						// break;
					// default:
						// $(this).val('');
						// alert('Please upload valid image formats');
						// break;
						// return false;
				// }
			// }
		// }
	// }
	$('#videoForm').submit();
}
function wantChked() {
	if(document.getElementById('chk_id').checked) {
		$("#hidSpan").show();
	}else{
		$("#hidSpan").hide();
	}
}
function addSubCat(){
	$("#hidCheck").hide();
	var num=$('#countbuttons').val();
	pnum=parseInt(num)+1;
	if($("#cat_name"+num).val()==''){
		alert("Please enter subcategory name"); return false;
	}
	$("#add-companys").append('<div class="form-group" id="companyText'+pnum+'">'+
	'<label for="company-name'+pnum+'" class="control-label col-md-3 col-sm-3 col-xs-12">Subcategory</label>'+'<div class="col-md-5 col-sm-6 col-xs-12 pos_r">'+
					  '<input type="text" class="form-control col-md-7 col-xs-12" name="cat_name[]" id="cat_name'+pnum+'" placeholder="Subcategory Name">'+
					'</div>'+'<button type="button" class="btn btn-success reset_btn" onClick="removeSubCat('+pnum+')">Remove Subcategory</button>'+'</div>');
	$('#countbuttons').val(pnum);
	var cnum=$('#countbuttons').val();			
}		
function removeSubCat(cid){
	var cnum = $('#countbuttons').val();
	$('#addCompany'+cid).remove();
	$('#companyText'+cid).remove();	
	$('#countbuttons').val((parseInt(cnum)-1));
	if($('#countbuttons').val() == 0){
		$('#chk_id').prop("checked", false);
		$("#hidSpan").hide();
		$("#hidCheck").show();
	}
}
function addcategoryFunction(type){
	flag=true;
	var catname=$('#catname').val();
	var cattype=$('#cattype').val();
	var catbuttontype=$('#hid_cat_butt').val(type);
	if(catname==""){
		 $("#catnameError").html("Required");
		 flag=false;
	}else{
	  $("#catnameError").html("");
	}
	if(cattype==""){
		 $("#cattypeError").html("Required");
		 flag=false;
	}else{
	  $("#cattypeError").html("");
	}
	if(flag==true){
		$('#categoryForm').submit();
	}
}
function addCatCall(){
	if($('#catname').val()==''){
		alert("Please enter catgory name"); return false;
	}
	// if(document.getElementById('chk_id').checked) {
		// var i = 0;
		// for(i=0;i<=1000;i++){
			// if($("#cat_name"+i).val()==''){
				// alert("Please enter subcategory name"); return false;
			// }
		// }
		// $("#categoryForm").submit();
	// }else{
		// $("#categoryForm").submit();
	// }
	$("#categoryForm").submit();
}
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
		$(".error_msg_disp").html(Required);
		$('#user_lastname').focus();
		flag = false;
	}else{
		$(".error_msg_disp").html('');
	}
	if($("#user_last_name").val()==''){
		$("#user_lastname_req").html(Required);
		$('#user_lastname').focus();
		flag = false;
	}else{
		$("#user_lastname_req").html('');
	}	
	if(userEmail==""){
		$("#user_email_req").html(Required);
		$('#user_email').focus();
		flag=false;
	}else if(checkEmail(userEmail)==false){
		$("#user_email_req").html(email_wrong_format);
		$('#user_email').focus();
		flag=false;
	}else if($("#hidCheckValue").val()==1){
		tab1flag = false;
		$("#user_email_req").html(email_already_exists); 
		$('#user_email').focus();
		flag=false;
		return false;
	}else{
		$("#user_email_req").html('');
	}	
	if($("#user_password").val()==''){
		$("#user_pwd_req").html(Required);
		$('#user_password').focus();
		flag = false;
	}else{
		$("#user_pwd_req").html('');	
	}		
	if($("#user_mobile").val()==''){
		$("#user_mobile_req").html(Required);
		$('#user_mobile').focus();
		flag = false;
	}else{
		$("#user_mobile_req").html('');	
	}	
	if($("#city").val()==""){
		$("#city_req").html(Required);
		$('#city').focus();
		flag=false;
	}else{
		$("#city_req").html('');
	}
	var state_id= document.getElementById('state_id').value;
	var lang= document.getElementById('lang').value;
	if(lang==""){
		$("#lang_req").html(Required);
		$('#lang').focus();
		flag=false;
	}else{
		$("#lang_req").html('');
	}
	if(state_id==""){
		$("#state_req").html(Required);
		$('#state_id').focus();
		flag=false;
	}else{
		$("#state_req").html('');
	}
	if($("#fb").val()==""){
		$("#fb_req").html(Required);
		$('#fb').focus();
		flag=false;
	}else{
		$("#fb_req").html('');
	}
	if($('#user_captcha').val()==""){
		$("#user_captcha_req").html(Required);
		$('#user_captcha').focus();
		flag=false;
	}else if($('#user_captcha').val()!=$("#refreshCode").val()){ 
		$("#user_captcha_req").html("Please enter the correct code");
		flag=false;
	}else{
	   $('#user_captcha').html('');
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
							var url_id = $("#hid_url_id").val();
							if(url_id == ""){
								window.location=BASE_URL+"/all-profiles?cat=all";
							}else{
								window.location=BASE_URL+"/profile-user?uid="+url_id;							
							}
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
							window.location=BASE_URL+"/admin/users-list";							
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
		if(regAuth=='admin'){
			var image=BASE_PATH+'/images/ajax-loader.gif';
		} else if(regAuth=='user'){
			var image=BASE_PATH+'/images/ajax-loader.gif';
		}
			$('#reload').html('<img src='+image+' />'); 
		if(passwrd==cnfpwrd){
			if(regAuth=='admin'){
				var  url =   BASE_URL+'/users/check-password';
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
								var  url2 =   BASE_URL+'/users/change-password';
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
					$('#forgetMail').val('');
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

