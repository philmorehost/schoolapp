<?php session_start(); error_reporting(0);
	include("include/bc-mailer.php");
	include("include/config-file.php");
	
	if(isset($_SESSION["sup_adm_session"]) OR isset($_SESSION["mod_adm_session"]) OR isset($_SESSION["adm_staff_session"]) OR isset($_SESSION["teacher_session"]) OR isset($_SESSION["stu_par_session"]) OR isset($_SESSION["stu_session"])){
		header("Location: /bc-admin.php?page=smgt_dashboard");
	}
	
	$err_msg = "";
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: User not exists";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: Invalid Verification Code";
	}

	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "4"){
		$err_msg .= "Error: Password Mismatched!";
	}

	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "5"){
		$err_msg .= "Success: Password updated successfully";
	}



	if(isset($_POST["recover"])){
		$username = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["username"])));
		$explode_username = array_filter(explode("/",trim($username)));
		$user_type = strtolower($explode_username[0]);
		$sch_id = strtolower($explode_username[1]);
		$user_id = $explode_username[2];
		
		$get_mail_sch_name = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='".$get_logged_user_details["school_id_number"]."' LIMIT 1"));
		
		$email_title = "User Email Recovery";
		$email_content = "		Hi {{user}},\n Your account recovery pin is <b>{{code}}</b>.\nIf you do not initiate this kindly login you portal immediately or report to the appropriate authorities.";
		
		// Always set content-type when sending HTML email
		$mail_headers = "MIME-Version: 1.0" . "\r\n";
		$mail_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		// More headers
		$mail_headers .= 'From: <'.$get_mail_sch_name["email"].'>' . "\r\n";
		$mail_headers .= 'Cc: '.$get_mail_sch_name["email"]."\r\n";

		$ref_char = "1234567890123456789012345678901234567890";
		$verification_code = substr(str_shuffle($ref_char),0,6);
		
		
		if(!empty($username)){
			
			if(filter_var($username,FILTER_VALIDATE_EMAIL)){
				$select_all_super_moderators = mysqli_query($connection_server, "SELECT * FROM sm_super_moderators WHERE email='$username'");
				if(mysqli_num_rows($select_all_super_moderators) == 1){
					$user_recover_detail = mysqli_fetch_array($select_all_super_moderators);
					$_SESSION["rec_sch_id"] = "";
					$_SESSION["rec_db_table"] = "sm_super_moderators";
					$_SESSION["rec_user_id"] = " email='$username'";
					$_SESSION["rec_vericode"] = $verification_code;
					$email_message = 
					mailDesignTemplate($email_title,
						str_replace("{{code}}",$_SESSION["rec_vericode"],
							str_replace("{{user}}",$user_recover_detail["firstname"]." ".$user_recover_detail["lastname"],
								$email_content
							)
						),
					'');
					customBCMailSender('',$user_recover_detail['email'],$email_title,$email_message,$mail_headers);
					$redirect_url = "/bc-forgot.php";
				}else{
					$redirect_url = "/bc-forgot.php?err=2";
				}
			}else{
				
				if(($user_type == "sc") && ($sch_id == "ad") && !empty($user_id)){
					$select_all_moderators = mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='$user_id'");
					if(mysqli_num_rows($select_all_moderators) == 1){
						$user_recover_detail = mysqli_fetch_array($select_all_moderators);
						$_SESSION["rec_sch_id"] = " school_id_number='".$user_recover_detail["school_id_number"]."' ";
						$_SESSION["rec_db_table"] = "sm_moderators";
						$_SESSION["rec_user_id"] = "";
						$_SESSION["rec_vericode"] = $verification_code;
						$email_message =
						mailDesignTemplate($email_title,
							str_replace("{{code}}",$_SESSION["rec_vericode"],
								str_replace("{{user}}",$user_recover_detail["firstname"]." ".$user_recover_detail["lastname"],
									$email_content
								)
							)
						, '');
						customBCMailSender('',$user_recover_detail['email'],$email_title,$email_message,$mail_headers);
						$redirect_url = "/bc-forgot.php";
					}
				}
				
				if(($user_type == "as") && !empty($sch_id) && !empty($user_id)){
					$select_all_admin_staffs = mysqli_query($connection_server, "SELECT * FROM sm_admin_staffs WHERE school_id_number='$sch_id' && id_number='$user_id'");
					if(mysqli_num_rows($select_all_admin_staffs) == 1){
						$user_recover_detail = mysqli_fetch_array($select_all_admin_staffs);
						$_SESSION["rec_sch_id"] = " school_id_number='".$user_recover_detail["school_id_number"]."' && ";
						$_SESSION["rec_db_table"] = "sm_admin_staffs";
						$_SESSION["rec_user_id"] = " id_number='$user_id'";
						$_SESSION["rec_vericode"] = $verification_code;
						$email_message = 
						mailDesignTemplate($email_title,
							str_replace("{{code}}",$_SESSION["rec_vericode"],
								str_replace("{{user}}",$user_recover_detail["firstname"]." ".$user_recover_detail["lastname"],
									$email_content
								)
							)
						, '');
						customBCMailSender('',$user_recover_detail['email'],$email_title,$email_message,$mail_headers);
						$redirect_url = "/bc-forgot.php";
					}
				}
				
				if(($user_type == "tc") && !empty($sch_id) && !empty($user_id)){
					$select_all_teachers = mysqli_query($connection_server, "SELECT * FROM sm_teachers WHERE school_id_number='$sch_id' && id_number='$user_id'");
					if(mysqli_num_rows($select_all_teachers) == 1){
						$user_recover_detail = mysqli_fetch_array($select_all_teachers);
						$_SESSION["rec_sch_id"] = " school_id_number='".$user_recover_detail["school_id_number"]."' && ";
						$_SESSION["rec_db_table"] = "sm_teachers";
						$_SESSION["rec_user_id"] = " id_number='$user_id'";
						$_SESSION["rec_vericode"] = $verification_code;
						$email_message = 
						mailDesignTemplate($email_title,
							str_replace("{{code}}",$_SESSION["rec_vericode"],
								str_replace("{{user}}",$user_recover_detail["firstname"]." ".$user_recover_detail["lastname"],
									$email_content
								)
							)
						, '');
						customBCMailSender('',$user_recover_detail['email'],$email_title,$email_message,$mail_headers);
						$redirect_url = "/bc-forgot.php";
					}
				}
				
				if(($user_type == "pa") && !empty($sch_id) && !empty($user_id)){
					$select_all_parents = mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number='$sch_id' && id_number='$user_id'");
					if(mysqli_num_rows($select_all_parents) == 1){
						$user_recover_detail = mysqli_fetch_array($select_all_parents);
						$_SESSION["rec_sch_id"] = " school_id_number='".$user_recover_detail["school_id_number"]."' && ";
						$_SESSION["rec_db_table"] = "sm_parents";
						$_SESSION["rec_user_id"] = " id_number='$user_id'";
						$_SESSION["rec_vericode"] = $verification_code;
						$email_message = 
						mailDesignTemplate($email_title,
							str_replace("{{code}}",$_SESSION["rec_vericode"],
								str_replace("{{user}}","Mr/Mrs ".$user_recover_detail["father_last_name"],
									$email_content
								)
							)
						, '');
						customBCMailSender('',$user_recover_detail['email'],$email_title,$email_message,$mail_headers);
						$redirect_url = "/bc-forgot.php";
					}
				}
				
				if(($user_type == "st") && !empty($sch_id) && !empty($user_id)){
					$select_all_students = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$sch_id' && admission_number='$user_id'");
					if(mysqli_num_rows($select_all_students) == 1){
						$user_recover_detail = mysqli_fetch_array($select_all_students);
						$_SESSION["rec_sch_id"] = " school_id_number='".$user_recover_detail["school_id_number"]."' && ";
						$_SESSION["rec_db_table"] = "sm_students";
						$_SESSION["rec_user_id"] = " admission_number='$user_id'";
						$_SESSION["rec_vericode"] = $verification_code;
						$email_message = 
						mailDesignTemplate($email_title,
							str_replace("{{code}}",$_SESSION["rec_vericode"],
								str_replace("{{user}}",$user_recover_detail["firstname"]." ".$user_recover_detail["lastname"]." ".$user_recover_detail["othername"],
									$email_content
								)
							)
						, '');
						customBCMailSender('',$user_recover_detail['email'],$email_title,$email_message,$mail_headers);
						$redirect_url = "/bc-forgot.php";
					}
				}
				
				if(!in_array($user_type,array("sc","as","tc","pa","st")) || empty($sch_id) || empty($user_id)){
					$redirect_url = "/bc-forgot.php?err=2";
				}
			}
			
		}else{
			$redirect_url = "/bc-forgot.php?err=1";
		}

		header("Location: ".$redirect_url);
	}

	if(isset($_POST["verify"])){
		$auth_code = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["auth-code"])));
		
		if($auth_code === $_SESSION["rec_vericode"]){
			$_SESSION["success_auth"] = "success"; 
			$redirect_url = $_SERVER["REQUEST_URI"];
		}else{
			$redirect_url = "/bc-forgot.php?err=3";
		}
		header("Location: ".$redirect_url);
	}

	if(isset($_POST["change-password"])){
		$password = md5(mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["password"]))));
		$confirm_password = md5(mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["confirm-password"]))));
		
		if(!empty($password) && !empty($confirm_password)){
			if($password === $confirm_password){
				$update_user_password = mysqli_query($connection_server, "UPDATE ".$_SESSION["rec_db_table"]." SET password='$password' WHERE ".$_SESSION["rec_sch_id"]." ".$_SESSION["rec_user_id"]);
				if($update_user_password == true){
					unset($_SESSION["rec_sch_id"]);
					unset($_SESSION["rec_db_table"]);
					unset($_SESSION["rec_user_id"]);
					unset($_SESSION["rec_vericode"]);
					unset($_SESSION["success_auth"]);
					$redirect_url = "/bc-forgot.php?err=5";
				}else{
					$redirect_url = "UPDATE ".$_SESSION["rec_db_table"]." SET password='$password' WHERE ".$_SESSION["rec_sch_id"]." ".$_SESSION["rec_user_id"];
				}
			}else{
				$redirect_url = "/bc-forgot.php?err=4";
			}
		}else{
			$redirect_url = "/bc-forgot.php?err=1";
		}
		header("Location: ".$redirect_url);
	}

	if(isset($_POST["reset"])){
		unset($_SESSION["rec_sch_id"]);
		unset($_SESSION["rec_db_table"]);
		unset($_SESSION["rec_user_id"]);
		unset($_SESSION["rec_vericode"]);
		unset($_SESSION["success_auth"]);
		header("Location: /bc-forgot.php");
	}


?>
<!DOCTYPE html>
<html>
<head>
<title></title>
<meta charset="UTF-8" />
<meta name="description" content="" />
<meta http-equiv="Content-Type" content="text/html; " />
<meta name="theme-color" content="black" />
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<link rel="stylesheet" href="cssfile/font-family.css">
<link rel="stylesheet" href="cssfile/portal.css">

<script src=""></script>
<style>
	body{
		background: linear-gradient(to right top, var(--color-4) 0% 50%, var(--color-7) 100%);
		background-repeat: no-repeat;
		background-size: 100% 5000px;
	}
</style>
</head>
<body>

<center>
    <div class="container-box bg-2 mobile-width-90 system-width-50 mobile-padding-top-10 system-padding-top-5 mobile-padding-bottom-10 system-padding-bottom-5 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-5 system-padding-right-2 mobile-margin-top-10 system-margin-top-10">
        
            <div style="display: block; text-align:right; " class="container-box bg-3 mobile-width-0 system-width-95 mobile-margin-bottom-0 system-margin-bottom-0">
            	<span class="color-4 text-bold-800 mobile-font-size-0 system-font-size-25">School Management Password Recovery Page<span><br>
            </div>
            <div style="display: inline-block;" class="container-box bg-3 mobile-width-90 system-width-30 mobile-margin-left-5 system-margin-left-1 mobile-margin-bottom-3 system-margin-bottom-1">
            	<img src="imgfile/Student_Future.png" class="mobile-width-30 system-width-60 mobile-margin-bottom-0 system-margin-bottom-10" />
            </div>
            
            <div style="display: inline-block;" class="container-box bg-3 mobile-width-90 system-width-65 mobile-margin-left-5 system-margin-left-1 mobile-margin-bottom-3 system-margin-bottom-1">
        	    <div style="display: inline-block; text-align:left; " class="container-box bg-3 mobile-width-90 system-width-0 mobile-margin-left-5 system-margin-left-5 mobile-margin-bottom-3 system-margin-bottom-3">
        	    	<span class="color-4 text-bold-800 mobile-font-size-14 system-font-size-0 mobile-margin-left-2 system-margin-left-0">School Management Login Page<span><br>
        	    </div><br>
				<?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
        	    	<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-95 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
        	    		<?php echo $err_msg; ?>
        	    	</div>
        	    <?php } ?>
				<?php
					if(!isset($_SESSION["rec_sch_id"]) && !isset($_SESSION["rec_db_table"]) && !isset($_SESSION["rec_user_id"]) && !isset($_SESSION["rec_vericode"])){
				?>
				<form method="post" enctype="multipart/form-data">
					<div style="display: inline-block;" class="container-box bg-3 mobile-width-85 system-width-45 mobile-margin-top-3 system-margin-top-0 mobile-margin-right-1 system-margin-right-1">
					<label for="label-username" style="display: inline-block; float:left; clear:both; cursor: pointer;" class="color-7 text-bold-800 mobile-font-size-13 system-font-size-16 mobile-margin-left-3 system-margin-left-3 mobile-margin-bottom-2 system-margin-bottom-2">Username</label>
						<div class="form-group mobile-width-100 system-width-96 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
							<input name="username" id="label-username" type="text" placeholder="" class="form-input" required/>
						</div>
					</div>
					<div style="display: inline-block; text-align:left;" class="container-box bg-3 mobile-width-90 system-width-45 mobile-margin-top-3 system-margin-top-0 mobile-margin-left-1 system-margin-left-2">
						<button name="recover" type="submit" class="button-box color-8 bg-4 onhover-bg-color-7 mobile-font-size-13 system-font-size-16 mobile-width-47 system-width-100 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-4 mobile-margin-right-1 system-margin-right-1">
							RECOVER
						</button>
					</div><br>
					<div style="display: inline-block; text-align: left;" class="container-box bg-3 mobile-width-90 system-width-90 mobile-margin-top-5 mobile-margin-top-5 mobile-margin-bottom-1 system-margin-bottom-1">
						<a href="/bc-login.php" style="text-decoration:none;" class="color-7 text-bold-800 mobile-font-size-12 system-font-size-16 mobile-margin-left-5 system-margin-left-1">Remember Password? Signin<a><br>
					</div>
				</form>
				<?php }else{ ?>
					<?php if($_SESSION["success_auth"] !== "success"){ ?>
						<form method="post" enctype="multipart/form-data">
							<div style="display: inline-block;" class="container-box bg-3 mobile-width-85 system-width-45 mobile-margin-top-3 system-margin-top-0 mobile-margin-right-1 system-margin-right-1">
								<label for="label-auth-code" style="display: inline-block; float:left; clear:both; cursor: pointer;" class="color-7 text-bold-800 mobile-font-size-13 system-font-size-16 mobile-margin-left-3 system-margin-left-3 mobile-margin-bottom-2 system-margin-bottom-2">Email Verification Code</label>
								<div class="form-group mobile-width-100 system-width-96 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
									<input name="auth-code" id="label-auth-code" type="text" pattern="[0-9]{6}" title="Verification code must be six digits" placeholder="" class="form-input" required/>
								</div>
							</div>
							<div style="display: inline-block; text-align:left;" class="container-box bg-3 mobile-width-90 system-width-45 mobile-margin-top-3 system-margin-top-0 mobile-margin-left-1 system-margin-left-2">
								<button name="verify" type="submit" class="button-box color-8 bg-4 onhover-bg-color-7 mobile-font-size-13 system-font-size-16 mobile-width-47 system-width-100 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-4 mobile-margin-right-1 system-margin-right-1">
									VERIFY
								</button>
							</div><br>
						</form>
						<form method="post" enctype="multipart/form-data">
							<div style="display: inline-block; text-align:left; float: left; clear: left;" class="container-box bg-3 mobile-width-90 system-width-45 mobile-margin-top-3 system-margin-top-0 mobile-margin-left-6 system-margin-left-2">
								<button name="reset" type="submit" class="button-box color-8 bg-4 onhover-bg-color-7 mobile-font-size-13 system-font-size-16 mobile-width-47 system-width-100 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-4 mobile-margin-right-1 system-margin-right-1">
									RESET
								</button>
							</div><br>
						</form>
					<?php }else{ ?>
						<form method="post" enctype="multipart/form-data">
							<div style="display: inline-block;" class="container-box bg-3 mobile-width-85 system-width-45 mobile-margin-top-3 system-margin-top-0 mobile-margin-right-1 system-margin-right-1">
								<label for="label-password" style="display: inline-block; float:left; clear:both; cursor: pointer;" class="color-7 text-bold-800 mobile-font-size-13 system-font-size-16 mobile-margin-left-3 system-margin-left-3 mobile-margin-bottom-2 system-margin-bottom-2">New Password</label>
								<div class="form-group mobile-width-100 system-width-96 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
									<input name="password" id="label-password" type="password" pattern="[a-zA-Z0-9]{8,}" title="Password must be Alphanumeric and not less than 8 character (No Special Character)" placeholder="" class="form-input" required/>
								</div>
							</div>
							<div style="display: inline-block;" class="container-box bg-3 mobile-width-85 system-width-45 mobile-margin-top-3 system-margin-top-0 mobile-margin-left-1 system-margin-left-2">
								<label for="label-confirm-password" style="display: inline-block; float:left; clear:both; cursor: pointer;" class="color-7 text-bold-800 mobile-font-size-13 system-font-size-16 mobile-margin-left-3 system-margin-left-3 mobile-margin-bottom-2 system-margin-bottom-2">Confirm New Password</label>
								<div class="form-group mobile-width-100 system-width-96 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-1 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
									<input name="confirm-password" id="label-confirm-password" type="password" pattern="[a-zA-Z0-9]{8,}" title="Password must be Alphanumeric and not less than 8 character (No Special Character)" placeholder="" class="form-input" required/>
								</div>
							</div>

							<div style="display: inline-block; text-align:left;" class="container-box bg-3 mobile-width-95 system-width-100 mobile-margin-left-0 system-margin-left-0">
								<button name="change-password" type="submit" class="button-box color-8 bg-4 onhover-bg-color-7 mobile-font-size-13 system-font-size-16 mobile-width-46 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-7 system-margin-left-4 mobile-margin-right-1 system-margin-right-1">
									CHANGE PASSWORD
								</button>
							</div><br>
						</form>
						<form method="post" enctype="multipart/form-data">
							<div style="display: inline-block; text-align:left; float: left; clear: left;" class="container-box bg-3 mobile-width-90 system-width-45 mobile-margin-top-3 system-margin-top-0 mobile-margin-left-6 system-margin-left-2">
								<button name="reset" type="submit" class="button-box color-8 bg-4 onhover-bg-color-7 mobile-font-size-13 system-font-size-16 mobile-width-47 system-width-100 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-4 system-margin-left-4 mobile-margin-right-1 system-margin-right-1">
									RESET
								</button>
							</div><br>
						</form>
					<?php } ?>
				<?php } ?>
			</div>

    </div>
</center>

</body>
</html>