<?php session_start(); error_reporting(1);
	include("include/config-file.php");
	if(isset($_GET["redirect"]) && !empty(trim(strip_tags($_GET["redirect"])))){
		$login_parameter_suffix = "redirect=".trim(strip_tags($_GET["redirect"]));
		$login_redirect_parameter = trim(str_replace(" ","&",trim(strip_tags($_GET["redirect"]))));
	}else{
		$login_parameter_suffix = "";
		$login_redirect_parameter = "/bc-admin.php?page=smgt_dashboard";
	}
	
	if(isset($_SESSION["sup_adm_session"])){
		header("Location: ".$login_redirect_parameter);
	}else{
		if(isset($_SESSION["mod_adm_session"])){
			header("Location: ".$login_redirect_parameter);
		}else{
			if(isset($_SESSION["adm_staff_session"])){
				header("Location: ".$login_redirect_parameter);
			}else{
				if(isset($_SESSION["teacher_session"])){
					header("Location: ".$login_redirect_parameter);
				}else{
					if(isset($_SESSION["stu_par_session"])){
						header("Location: ".$login_redirect_parameter);
					}else{
						if(isset($_SESSION["stu_session"])){
							header("Location: ".$login_redirect_parameter);
						}
					}
				}
			}
		}
	}
		
	$err_msg = "";
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: User not exists";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: Incorrect Password";
	}
		
	if(isset($_POST["login"])){
		$username = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["username"])));
		$password = md5(mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["password"]))));
		
		if(!empty($username) && !empty($password)){
			if(filter_var($username,FILTER_VALIDATE_EMAIL)){
				$select_all_super_moderators = mysqli_query($connection_server, "SELECT * FROM sm_super_moderators WHERE email='$username'");
				if(mysqli_num_rows($select_all_super_moderators) == 1){
					$select_check_all_super_moderators_password = mysqli_query($connection_server, "SELECT * FROM sm_super_moderators WHERE email='$username' && password='$password'");
					if(mysqli_num_rows($select_check_all_super_moderators_password) == 1){
						$_SESSION["sup_adm_session"] = mysqli_fetch_array($select_check_all_super_moderators_password)["email"];
						$redirect_url = $login_redirect_parameter;
					}else{
						$redirect_url = "/bc-login.php?".$login_parameter_suffix."err=3";
					}
				}else{
					$redirect_url = "/bc-login.php?".$login_parameter_suffix."err=2";
				}
			}else{
				$explode_username = array_filter(explode("/",trim($username)));
				$user_type = strtolower($explode_username[0]);
				$sch_id = strtolower($explode_username[1]);
				$user_id = $explode_username[2];
				
				if(($user_type == "sc") && ($sch_id == "ad") && !empty($user_id)){
					$select_all_moderators = mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='$user_id'");
					if(mysqli_num_rows($select_all_moderators) == 1){
						$select_check_all_moderators_password = mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='$user_id' && password='$password'");
						if(mysqli_num_rows($select_check_all_moderators_password) == 1){
							$_SESSION["mod_adm_session"] = mysqli_fetch_array($select_check_all_moderators_password)["school_id_number"];
							$redirect_url = $login_redirect_parameter;
						}else{
							$redirect_url = "/bc-login.php?".$login_parameter_suffix."err=3";
						}
					}
				}
				
				if(($user_type == "as") && !empty($sch_id) && !empty($user_id)){
					$select_all_admin_staffs = mysqli_query($connection_server, "SELECT * FROM sm_admin_staffs WHERE school_id_number='$sch_id' && id_number='$user_id'");
					if(mysqli_num_rows($select_all_admin_staffs) == 1){
						$select_check_all_admin_staffs_password = mysqli_query($connection_server, "SELECT * FROM sm_admin_staffs WHERE school_id_number='$sch_id' && id_number='$user_id' && password='$password'");
						if(mysqli_num_rows($select_check_all_admin_staffs_password) == 1){
							$user_details = mysqli_fetch_array($select_check_all_admin_staffs_password);
							$_SESSION["adm_staff_session"] = $user_details["id_number"];
							$_SESSION["school_id"] = $user_details["school_id_number"];
							$redirect_url = $login_redirect_parameter;
						}else{
							$redirect_url = "/bc-login.php?".$login_parameter_suffix."err=3";
						}
					}
				}
				
				if(($user_type == "tc") && !empty($sch_id) && !empty($user_id)){
					$select_all_teachers = mysqli_query($connection_server, "SELECT * FROM sm_teachers WHERE school_id_number='$sch_id' && id_number='$user_id'");
					if(mysqli_num_rows($select_all_teachers) == 1){
						$select_check_all_teachers_password = mysqli_query($connection_server, "SELECT * FROM sm_teachers WHERE school_id_number='$sch_id' && id_number='$user_id' && password='$password'");
						if(mysqli_num_rows($select_check_all_teachers_password) == 1){
							$user_details = mysqli_fetch_array($select_check_all_teachers_password);
							$_SESSION["teacher_session"] = $user_details["id_number"];
							$_SESSION["school_id"] = $user_details["school_id_number"];
							$redirect_url = $login_redirect_parameter;
						}else{
							$redirect_url = "/bc-login.php?".$login_parameter_suffix."err=3";
						}
					}
				}
				
				if(($user_type == "pa") && !empty($sch_id) && !empty($user_id)){
					$select_all_parents = mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number='$sch_id' && id_number='$user_id'");
					if(mysqli_num_rows($select_all_parents) == 1){
						$select_check_all_parents_password = mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number='$sch_id' && id_number='$user_id' && password='$password'");
						if(mysqli_num_rows($select_check_all_parents_password) == 1){
							$user_details = mysqli_fetch_array($select_check_all_parents_password);
							$_SESSION["stu_par_session"] = $user_details["id_number"];
							$_SESSION["school_id"] = $user_details["school_id_number"];
							$redirect_url = $login_redirect_parameter;
						}else{
							$redirect_url = "/bc-login.php?".$login_parameter_suffix."err=3";
						}
					}
				}
				
				if(($user_type == "st") && !empty($sch_id) && !empty($user_id)){
					$select_all_students = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$sch_id' && admission_number='$user_id'");
					if(mysqli_num_rows($select_all_students) == 1){
						$select_check_all_students_password = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$sch_id' && admission_number='$user_id' && password='$password'");
						if(mysqli_num_rows($select_check_all_students_password) == 1){
							$user_details = mysqli_fetch_array($select_check_all_students_password);
							$_SESSION["stu_session"] = $user_details["admission_number"];
							$_SESSION["school_id"] = $user_details["school_id_number"];
							$redirect_url = $login_redirect_parameter;
						}else{
							$redirect_url = "/bc-login.php?".$login_parameter_suffix."err=3";
						}
					}
				}
				
				if(!in_array($user_type,array("sc","as","tc","pa","st")) || empty($sch_id) || empty($user_id)){
					$redirect_url = "/bc-login.php?".$login_parameter_suffix."err=2";
				}
			}
			
		}else{
			$redirect_url = "/bc-login.php?".$login_parameter_suffix."err=1";
		}
		
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["setup-db"])){
		$server = strip_tags(strtolower($_POST["server"]));
		$user = strip_tags(strtolower($_POST["user"]));
		$pass = strip_tags(strtolower($_POST["pass"]));
		$dbname = strip_tags(strtolower($_POST["dbname"]));
		
		if(file_exists("include/db-json.php")){
			file_put_contents("include/db-json.php",'<?php'."\n".'	$db_json_dtls = array("server" => "'.$server.'", "user" => "'.$user.'", "pass" => "'.$pass.'", "dbname" => "'.$dbname.'");'."\n".'	$db_json_encode = json_encode($db_json_dtls,true);'."\n".'	$db_json_decode = json_decode($db_json_encode,true);'."\n".'?>');
		}else{
			fopen("include/db-json.php","a++");
			file_put_contents("include/db-json.php",'<?php'."\n".'	$db_json_dtls = array("server" => "'.$server.'", "user" => "'.$user.'", "pass" => "'.$pass.'", "dbname" => "'.$dbname.'");'."\n".'	$db_json_encode = json_encode($db_json_dtls,true);'."\n".'	$db_json_decode = json_decode($db_json_encode,true);'."\n".'?>');
		}
		
		header("Location: /bc-login.php");
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
        <form method="post">
            
            <?php if(!empty($db_json_decode["server"]) && !empty($db_json_decode["dbname"]) && ($connection_server == true)){ ?>
            <div style="display: block; text-align:right; " class="container-box bg-3 mobile-width-0 system-width-95 mobile-margin-bottom-0 system-margin-bottom-0">
            	<span class="color-4 text-bold-800 mobile-font-size-0 system-font-size-25">School Management Login Page<span><br>
            </div>
            <div style="display: inline-block;" class="container-box bg-3 mobile-width-90 system-width-30 mobile-margin-left-5 system-margin-left-1 mobile-margin-bottom-3 system-margin-bottom-1">
            	<img src="imgfile/Student_Future.png" class="mobile-width-30 system-width-60 mobile-margin-bottom-0 system-margin-bottom-40" />
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
        	    <div style="display: inline-block;" class="container-box bg-3 mobile-width-85 system-width-45 mobile-margin-top-3 system-margin-top-0 mobile-margin-right-1 system-margin-right-1">
     	           <label for="label-username" style="display: inline-block; float:left; clear:both; cursor: pointer;" class="color-7 text-bold-800 mobile-font-size-13 system-font-size-16 mobile-margin-left-3 system-margin-left-3 mobile-margin-bottom-2 system-margin-bottom-2">Username</label>
					<div class="form-group mobile-width-100 system-width-96 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    	<input name="username" id="label-username" type="text" placeholder="" class="form-input" required/>
                	</div>
            	</div>
            	<div style="display: inline-block;" class="container-box bg-3 mobile-width-85 system-width-45 mobile-margin-top-3 system-margin-top-0 mobile-margin-left-1 system-margin-left-2">
                	<label for="label-password" style="display: inline-block; float:left; clear:both; cursor: pointer;" class="color-7 text-bold-800 mobile-font-size-13 system-font-size-16 mobile-margin-left-3 system-margin-left-3 mobile-margin-bottom-2 system-margin-bottom-2">Password</label>
                	<div class="form-group mobile-width-100 system-width-96 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-1 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                    	<input name="password" id="label-password" type="password" placeholder="" class="form-input" required/>
                	</div>
            	</div>

				<div style="display: inline-block; text-align:left;" class="container-box bg-3 mobile-width-95 system-width-100 mobile-margin-left-0 system-margin-left-0">
					<button name="login" type="submit" class="button-box color-8 bg-4 onhover-bg-color-7 mobile-font-size-13 system-font-size-16 mobile-width-46 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-7 system-margin-left-4 mobile-margin-right-1 system-margin-right-1">
						LOGIN
					</button>
				</div><br>
				<div style="display: inline-block; text-align: left;" class="container-box bg-3 mobile-width-90 system-width-90 mobile-margin-top-5 mobile-margin-top-5 mobile-margin-bottom-1 system-margin-bottom-1">
					<a href="/bc-forgot.php" style="text-decoration:none;" class="color-7 text-bold-800 mobile-font-size-12 system-font-size-16 mobile-margin-left-5 system-margin-left-1">Forgot Password? Recover Now<a><br>
				</div>
			</div>
			<?php }else{ ?>
			<div style="display: block; text-align:right; " class="container-box bg-3 mobile-width-0 system-width-95 mobile-margin-bottom-0 system-margin-bottom-0">
				<span class="color-4 text-bold-800 mobile-font-size-0 system-font-size-25">School Management Database Setup<span><br>
			</div>
			<div style="display: inline-block;" class="container-box bg-3 mobile-width-90 system-width-30 mobile-margin-left-5 system-margin-left-1 mobile-margin-bottom-3 system-margin-bottom-1">
				<img src="imgfile/Student_Future.png" class="mobile-width-30 system-width-60 mobile-margin-bottom-0 system-margin-bottom-40" />
			</div>

			<div style="display: inline-block;" class="container-box bg-3 mobile-width-90 system-width-65 mobile-margin-left-5 system-margin-left-1 mobile-margin-bottom-3 system-margin-bottom-1">
        	    <div style="display: inline-block; text-align:left; " class="container-box bg-3 mobile-width-90 system-width-0 mobile-margin-left-5 system-margin-left-5 mobile-margin-bottom-3 system-margin-bottom-3">
        	    	<span class="color-4 text-bold-800 mobile-font-size-14 system-font-size-0 mobile-margin-left-2 system-margin-left-0">School Management Database Setup<span><br>
        	    </div><br>
        	    <?php if(!empty(mysqli_real_escape_string($connection_server, strip_tags($_GET["err"])))){ ?>
        	    	<div style="display: inline-block;" class="container-box color-4 bg-10 text-bold-800 mobile-font-size-14 system-font-size-16 border-radius-5px mobile-width-80 system-width-95 mobile-padding-top-2 system-padding-top-1 mobile-padding-left-2 system-padding-left-2 mobile-padding-right-2 system-padding-right-2 mobile-padding-bottom-2 system-padding-bottom-1 mobile-margin-bottom-1 system-margin-bottom-1">
        	    		<?php echo $err_msg; ?>
        	    	</div>
        	    <?php } ?>
        	    <div style="display: inline-block;" class="container-box bg-3 mobile-width-85 system-width-45 mobile-margin-top-3 system-margin-top-0 mobile-margin-right-1 system-margin-right-1">
        	    	<label for="label-server" style="display: inline-block; float:left; clear:both; cursor: pointer;" class="color-7 text-bold-800 mobile-font-size-13 system-font-size-16 mobile-margin-left-3 system-margin-left-3 mobile-margin-bottom-2 system-margin-bottom-2">Server URL</label>
        	    	<div class="form-group mobile-width-100 system-width-96 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
        	    		<input name="server" id="label-server" type="text" placeholder="" class="form-input" placeholder="e.g localhost" value="<?php if(file_exists('include/db-json.php')){ echo $db_json_decode['server']; } ?>" required/>
        	    	</div>
        	    </div>
       			<div style="display: inline-block;" class="container-box bg-3 mobile-width-85 system-width-45 mobile-margin-top-3 system-margin-top-0 mobile-margin-right-1 system-margin-right-1">
     	       		<label for="label-user" style="display: inline-block; float:left; clear:both; cursor: pointer;" class="color-7 text-bold-800 mobile-font-size-13 system-font-size-16 mobile-margin-left-3 system-margin-left-3 mobile-margin-bottom-2 system-margin-bottom-2">Server Username</label>
					<div class="form-group mobile-width-100 system-width-96 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
        				<input name="user" id="label-user" type="text" placeholder="" class="form-input" placeholder="e.g user" value="<?php if(file_exists('include/db-json.php')){ echo $db_json_decode['user']; } ?>" required/>
    				</div>
				</div>
				<div style="display: inline-block;" class="container-box bg-3 mobile-width-85 system-width-45 mobile-margin-top-3 system-margin-top-0 mobile-margin-right-1 system-margin-right-1">
					<label for="label-pass" style="display: inline-block; float:left; clear:both; cursor: pointer;" class="color-7 text-bold-800 mobile-font-size-13 system-font-size-16 mobile-margin-left-3 system-margin-left-3 mobile-margin-bottom-2 system-margin-bottom-2">Server Password</label>
					<div class="form-group mobile-width-100 system-width-96 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
						<input name="pass" id="label-pass" type="password" placeholder="" class="form-input" placeholder="e.g ********" value="<?php if(file_exists('include/db-json.php')){ echo $db_json_decode['pass']; } ?>" />
					</div>
				</div>
				<div style="display: inline-block;" class="container-box bg-3 mobile-width-85 system-width-45 mobile-margin-top-3 system-margin-top-0 mobile-margin-right-1 system-margin-right-1">
					<label for="label-db" style="display: inline-block; float:left; clear:both; cursor: pointer;" class="color-7 text-bold-800 mobile-font-size-13 system-font-size-16 mobile-margin-left-3 system-margin-left-3 mobile-margin-bottom-2 system-margin-bottom-2">Database Name</label>
					<div class="form-group mobile-width-100 system-width-96 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
						<input name="dbname" id="label-db" type="text" placeholder="" class="form-input" placeholder="e.g mydb (new or existing db)" value="<?php if(file_exists('include/db-json.php')){ echo $db_json_decode['dbname']; } ?>" required/>
					</div>
				</div>
				<div style="display: inline-block; text-align:left;" class="container-box bg-3 mobile-width-95 system-width-100 mobile-margin-left-0 system-margin-left-0">
					<button name="setup-db" type="submit" class="button-box color-8 bg-4 onhover-bg-color-7 mobile-font-size-13 system-font-size-16 mobile-width-46 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-7 system-margin-left-4 mobile-margin-right-1 system-margin-right-1">
						SET-UP
					</button>
				</div>
			</div>

			<?php } ?>
        </form>
    </div>
</center>

</body>
</html>