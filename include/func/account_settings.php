<?php
	
	$err_msg = "";
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}

	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: Mismatched password";
	}

	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: User doesnt exists";
	}

	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "4"){
		$err_msg .= "Success: Account details updated successfully";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "5"){
		$err_msg .= "Error: Invalid Verification Code";
	}
	
	if(isset($_POST["update-user"])){
		$res_address = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["home-address"])));
		
		$account_password = md5(mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["acc-pass-auth"]))));
		$school_id = $get_logged_user_details["school_id_number"];
		
		$search_user_with_id = mysqli_query($connection_server, "SELECT * FROM ".$user_account_table_name_auth." WHERE (school_id_number='$school_id' ".$user_account_table_id_auth.")");
		
		if(!empty($res_address) && !empty($account_password)){
			if(mysqli_num_rows($search_user_with_id) == 1){
				while($user_detail = mysqli_fetch_array($search_user_with_id)){
					if($account_password == $user_detail["password"]){
						if(mysqli_query($connection_server, "UPDATE ".$user_account_table_name_auth." SET home_address='$res_address' WHERE (school_id_number='$school_id' ".$user_account_table_id_auth.")") == true){
							if(!empty($_FILES["photo"]["tmp_name"])){
								if(file_exists("dataimg/".$user_profile_photo_auth[0])){
									unlink("dataimg/".$user_profile_photo_auth[0]);
									$photo_tmp_name = $_FILES["photo"]["tmp_name"];
									move_uploaded_file($photo_tmp_name,"dataimg/".$user_profile_photo_auth[0]);
								}else{
									$photo_tmp_name = $_FILES["photo"]["tmp_name"];
									move_uploaded_file($photo_tmp_name,"dataimg/".$user_profile_photo_auth[0]);
								}
							}
							$redirect_url = $_SERVER["REQUEST_URI"]."&err=4";
						}
					}else{
						$redirect_url = $_SERVER["REQUEST_URI"]."&err=2";
					}
				}
			}else{
				$redirect_url = $_SERVER["REQUEST_URI"]."&err=3";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["update-admin"])){
		$first = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["fname"])));
		$last = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["lname"])));
		$email = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email"])));
		$gender = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["gender"])));
		$res_address = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["home-address"])));
		
		
		$account_update_pin = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["acc-update-pin"])));
		$school_id = $get_logged_admin_details["school_id_number"];
		
		$search_admin_with_id = mysqli_query($connection_server, "SELECT * FROM sm_super_moderators LIMIT 1");
		
		if(!empty($first) && !empty($last) && !empty($email) && !empty($gender) && !empty($res_address)){
			if(mysqli_num_rows($search_admin_with_id) == 1){
				while($admin_detail = mysqli_fetch_array($search_admin_with_id)){
					if($admin_detail["email"] != "admin@example.com"){
						if(!isset($_SESSION["super_rec_vericode"])){
						
							$email_title = "Admin Account Update Authentication";
						
							// Always set content-type when sending HTML email
							$mail_headers = "MIME-Version: 1.0" . "\r\n";
							$mail_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						
							// More headers
							$mail_headers .= 'From: <support@'.$_SERVER["HTTP_HOST"].'>' . "\r\n";
							$mail_headers .= 'Cc: support@'.$_SERVER["HTTP_HOST"]."\r\n";
						
							$ref_char = "1234567890123456789012345678901234567890";
							$verification_code = substr(str_shuffle($ref_char),0,6);
							$_SESSION["super_rec_vericode"] = $verification_code;
							$email_content = "		Hi {{admin}},\n Your account recovery pin is <b>{{code}}</b>.\nIf you do not initiate this kindly login you portal immediately or report to the appropriate authorities.";
							$email_message = 
							mailDesignTemplate($email_title,
								str_replace("{{code}}",$_SESSION["super_rec_vericode"],
									str_replace("{{admin}}",$admin_detail["firstname"]." ".$admin_detail["lastname"],
										$email_content
									)
								),
							'');
							customBCMailSender('',$admin_detail['email'],$email_title,$email_message,$mail_headers);
							$_SESSION["super_fname"] = $first;
							$_SESSION["super_lname"] = $last;
							$_SESSION["super_email"] = $email;
							$_SESSION["super_gender"] = $gender;
							$_SESSION["super_address"] = $res_address;
						}else{
							if($account_update_pin == $_SESSION["super_rec_vericode"]){
								if(mysqli_query($connection_server, "UPDATE sm_super_moderators SET email='".$_SESSION["super_email"]."', firstname='".$_SESSION["super_fname"]."', lastname='".$_SESSION["super_lname"]."', gender='".$_SESSION["super_gender"]."', home_address='".$_SESSION["super_address"]."' WHERE 1") == true){
									unset($_SESSION["super_fname"]);
									unset($_SESSION["super_lname"]);
									unset($_SESSION["super_email"]);
									unset($_SESSION["super_gender"]);
									unset($_SESSION["super_address"]);
									unset($_SESSION["super_rec_vericode"]);
									$redirect_url = $_SERVER["REQUEST_URI"]."&err=4";
								}
							}else{
								$redirect_url = $_SERVER["REQUEST_URI"]."&err=5";
							}
						}
					}else{
						if(mysqli_query($connection_server, "UPDATE sm_super_moderators SET email='$email', firstname='$first', lastname='$last', gender='$gender', home_address='$res_address' WHERE 1") == true){
							$redirect_url = $_SERVER["REQUEST_URI"]."&err=4";
						}
					}
				}
			}else{
				$redirect_url = $_SERVER["REQUEST_URI"]."&err=3";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		header("Location: ".$redirect_url.$email_message);
	}
	
	if(isset($_POST["reset-admin-update"])){
		unset($_SESSION["super_fname"]);
		unset($_SESSION["super_lname"]);
		unset($_SESSION["super_email"]);
		unset($_SESSION["super_gender"]);
		unset($_SESSION["super_address"]);
		unset($_SESSION["super_rec_vericode"]);
		$redirect_url = $_SERVER["REQUEST_URI"];
		header("Location: ".$redirect_url);
	}
	
?>