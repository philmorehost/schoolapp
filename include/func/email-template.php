<?php
	
	$err_msg = "";
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}
	
	if(isset($_POST["save-student-reg-mail-template"])){
		$email_subject = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-subject"])));
		$email_message = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-message"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		if(!empty($email_subject) && !empty($email_message) && !empty($school_id)){
			if(mysqli_query($connection_server, "UPDATE sm_email_templates SET template_title='$email_subject', template_message='$email_message' WHERE (school_id_number='$school_id' && template_name='student-reg')") == true){
				$redirect_url = "/bc-admin.php?page=smgt_email_template";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["save-fee-payment-mail-template"])){
		$email_subject = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-subject"])));
		$email_message = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-message"])));
		$school_id = $get_logged_user_details["school_id_number"];
	
		if(!empty($email_subject) && !empty($email_message) && !empty($school_id)){
			if(mysqli_query($connection_server, "UPDATE sm_email_templates SET template_title='$email_subject', template_message='$email_message' WHERE (school_id_number='$school_id' && template_name='fees-alert')") == true){
				$redirect_url = "/bc-admin.php?page=smgt_email_template";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
	
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["save-add-user-mail-template"])){
		$email_subject = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-subject"])));
		$email_message = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-message"])));
		$school_id = $get_logged_user_details["school_id_number"];
	
		if(!empty($email_subject) && !empty($email_message) && !empty($school_id)){
			if(mysqli_query($connection_server, "UPDATE sm_email_templates SET template_title='$email_subject', template_message='$email_message' WHERE (school_id_number='$school_id' && template_name='add-user')") == true){
				$redirect_url = "/bc-admin.php?page=smgt_email_template";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
	
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["save-student-assign-to-teacher-mail-template"])){
		$email_subject = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-subject"])));
		$email_message = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-message"])));
		$school_id = $get_logged_user_details["school_id_number"];
	
		if(!empty($email_subject) && !empty($email_message) && !empty($school_id)){
			if(mysqli_query($connection_server, "UPDATE sm_email_templates SET template_title='$email_subject', template_message='$email_message' WHERE (school_id_number='$school_id' && template_name='student-assign-teacher')") == true){
				$redirect_url = "/bc-admin.php?page=smgt_email_template";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
	
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["save-student-assigned-to-teacher-student-mail-template"])){
		$email_subject = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-subject"])));
		$email_message = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-message"])));
		$school_id = $get_logged_user_details["school_id_number"];
	
		if(!empty($email_subject) && !empty($email_message) && !empty($school_id)){
			if(mysqli_query($connection_server, "UPDATE sm_email_templates SET template_title='$email_subject', template_message='$email_message' WHERE (school_id_number='$school_id' && template_name='student-assigned-teacher')") == true){
				$redirect_url = "/bc-admin.php?page=smgt_email_template";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
	
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["save-attendance-absent-notification-mail-template"])){
		$email_subject = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-subject"])));
		$email_message = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-message"])));
		$school_id = $get_logged_user_details["school_id_number"];
	
		if(!empty($email_subject) && !empty($email_message) && !empty($school_id)){
			if(mysqli_query($connection_server, "UPDATE sm_email_templates SET template_title='$email_subject', template_message='$email_message' WHERE (school_id_number='$school_id' && template_name='attendance-absent')") == true){
				$redirect_url = "/bc-admin.php?page=smgt_email_template";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
	
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["save-invoice-payment-mail-template"])){
		$email_subject = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-subject"])));
		$email_message = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-message"])));
		$school_id = $get_logged_user_details["school_id_number"];
	
		if(!empty($email_subject) && !empty($email_message) && !empty($school_id)){
			if(mysqli_query($connection_server, "UPDATE sm_email_templates SET template_title='$email_subject', template_message='$email_message' WHERE (school_id_number='$school_id' && template_name='payment-invoice')") == true){
				$redirect_url = "/bc-admin.php?page=smgt_email_template";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
	
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["save-notice-mail-template"])){
		$email_subject = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-subject"])));
		$email_message = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-message"])));
		$school_id = $get_logged_user_details["school_id_number"];
	
		if(!empty($email_subject) && !empty($email_message) && !empty($school_id)){
			if(mysqli_query($connection_server, "UPDATE sm_email_templates SET template_title='$email_subject', template_message='$email_message' WHERE (school_id_number='$school_id' && template_name='notice')") == true){
				$redirect_url = "/bc-admin.php?page=smgt_email_template";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
	
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["save-holiday-mail-template"])){
		$email_subject = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-subject"])));
		$email_message = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-message"])));
		$school_id = $get_logged_user_details["school_id_number"];
	
		if(!empty($email_subject) && !empty($email_message) && !empty($school_id)){
			if(mysqli_query($connection_server, "UPDATE sm_email_templates SET template_title='$email_subject', template_message='$email_message' WHERE (school_id_number='$school_id' && template_name='holiday')") == true){
				$redirect_url = "/bc-admin.php?page=smgt_email_template";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
	
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["save-school-bus-allocation-mail-template"])){
		$email_subject = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-subject"])));
		$email_message = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-message"])));
		$school_id = $get_logged_user_details["school_id_number"];
	
		if(!empty($email_subject) && !empty($email_message) && !empty($school_id)){
			if(mysqli_query($connection_server, "UPDATE sm_email_templates SET template_title='$email_subject', template_message='$email_message' WHERE (school_id_number='$school_id' && template_name='school-bus')") == true){
				$redirect_url = "/bc-admin.php?page=smgt_email_template";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
	
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["save-hostel-bed-assigned-mail-template"])){
		$email_subject = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-subject"])));
		$email_message = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-message"])));
		$school_id = $get_logged_user_details["school_id_number"];
	
		if(!empty($email_subject) && !empty($email_message) && !empty($school_id)){
			if(mysqli_query($connection_server, "UPDATE sm_email_templates SET template_title='$email_subject', template_message='$email_message' WHERE (school_id_number='$school_id' && template_name='hostel-bed')") == true){
				$redirect_url = "/bc-admin.php?page=smgt_email_template";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
	
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["save-assign-subject-mail-template"])){
		$email_subject = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-subject"])));
		$email_message = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-message"])));
		$school_id = $get_logged_user_details["school_id_number"];
	
		if(!empty($email_subject) && !empty($email_message) && !empty($school_id)){
			if(mysqli_query($connection_server, "UPDATE sm_email_templates SET template_title='$email_subject', template_message='$email_message' WHERE (school_id_number='$school_id' && template_name='subject-assigned')") == true){
				$redirect_url = "/bc-admin.php?page=smgt_email_template";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
	
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["save-issue-book-mail-template"])){
		$email_subject = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-subject"])));
		$email_message = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email-message"])));
		$school_id = $get_logged_user_details["school_id_number"];
	
		if(!empty($email_subject) && !empty($email_message) && !empty($school_id)){
			if(mysqli_query($connection_server, "UPDATE sm_email_templates SET template_title='$email_subject', template_message='$email_message' WHERE (school_id_number='$school_id' && template_name='issue-book')") == true){
				$redirect_url = "/bc-admin.php?page=smgt_email_template";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
	
		header("Location: ".$redirect_url);
	}
	
	
	
?>