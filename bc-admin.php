<?php session_start(); error_reporting(1);
	include("include/bc-mailer.php");
	if(!isset($_SESSION["sup_adm_session"])){
		if(!isset($_SESSION["mod_adm_session"])){
			if(!isset($_SESSION["adm_staff_session"])){
				if(!isset($_SESSION["teacher_session"])){
					if(!isset($_SESSION["stu_par_session"])){
						if(!isset($_SESSION["stu_session"])){
							$get_current_request_uri = str_replace("&"," ",$_SERVER["REQUEST_URI"]); 
							header("Location: /bc-login.php?redirect=".$get_current_request_uri);
						}
					}
				}
			}
		}
	}
	include("include/config-file.php");
	if ((strip_tags($_GET["page"]) == "smgt_sms_settings" || strip_tags($_GET["page"]) == "smgt_sms_payments") && !isset($_SESSION["sup_adm_session"])) {
		header("Location: /bc-admin.php?page=smgt_dashboard");
	}
	$additional_back_tag = "";
	$additional_add_tag = "";
	
	if(!isset($_SESSION["sup_adm_session"])){
		if(isset($_SESSION["mod_adm_session"])){
			$get_school_identification = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".$_SESSION["mod_adm_session"]."'"));
		}else{
			if(isset($_SESSION["adm_staff_session"])){
				$get_school_identification = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_admin_staffs WHERE school_id_number='".$_SESSION["school_id"]."' && id_number='".$_SESSION["adm_staff_session"]."'"));
			}else{
				if(isset($_SESSION["teacher_session"])){
					$get_school_identification = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_teachers WHERE school_id_number='".$_SESSION["school_id"]."' && id_number='".$_SESSION["teacher_session"]."'"));
				}else{
					if(isset($_SESSION["stu_par_session"])){
						$get_school_identification = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number='".$_SESSION["school_id"]."' && id_number='".$_SESSION["stu_par_session"]."'"));
					}else{
						if(isset($_SESSION["stu_session"])){
							$get_school_identification = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='".$_SESSION["school_id"]."' && admission_number='".$_SESSION["stu_session"]."'"));
						}else{
						//Error No School Identification Number
						}
					}
				}
			}
		}
		
	}
	
	if(isset($_SESSION["sup_adm_session"])){
		$show_back_arrow = true;
		$show_item_auth = false;
		$user_class_statement_auth = "";
		$user_identifier_auth_id = "super_mod";
		$show_hd_add_button = true;
	}
	
	if(isset($_SESSION["mod_adm_session"])){
		$show_back_arrow = true;
		$show_item_auth = true;
		$user_class_statement_auth = "";
		$user_identifier_auth_id = "mod_adm";
		$show_hd_add_button = true;
		$user_profile_photo_auth = array("school_".$get_logged_user_details["school_id_number"].".png","Student_Future.png");
	
	}
	
	if(isset($_SESSION["adm_staff_session"])){
		$show_back_arrow = true;
		$show_item_auth = true;
		$user_class_statement_auth = "";
		$user_identifier_auth_id = "adm_staff";
		$show_hd_add_button = true;
		$user_profile_photo_auth = array("adminstaff_".$get_logged_user_details["school_id_number"]."_".$get_logged_user_details["id_number"].".png","admin-staff.png");
		
		$user_account_table_name_auth = "sm_admin_staffs";
		$user_account_table_id_auth = "&& id_number='".$get_logged_user_details["id_number"]."'";
		
	}
	
	if(isset($_SESSION["teacher_session"])){
		$show_back_arrow = false;
		$show_item_auth = false;
		$user_identifier_auth_id = "teacher";
		$show_hd_add_button = false;
		$get_teacher_stukids_class_id = mysqli_query($connection_server, "SELECT * FROM sm_teachers WHERE school_id_number='".$get_logged_user_details['school_id_number']."' && id_number='".$get_logged_user_details["id_number"]."'");
		if(mysqli_num_rows($get_teacher_stukids_class_id) > 0){
			while($kids_classes = mysqli_fetch_assoc($get_teacher_stukids_class_id)){
				$teacher_class_id_names_raw .= $kids_classes["class"];
			}
		}
		
		$user_teacher_class_id_explode = array_unique(array_filter(explode("\n",trim($teacher_class_id_names_raw))));
		foreach($user_teacher_class_id_explode as $class_id){
			$user_teacher_class_statement_auth_find .= "current_class='".$class_id."' ";
		}
		$user_teacher_class_names_auth_find = "&& (".str_replace(" "," OR ",trim($user_teacher_class_statement_auth_find)) .")";
		
		$get_teacher_kids_class_id = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='".$get_logged_user_details['school_id_number']."' ".$user_teacher_class_names_auth_find);
		if(mysqli_num_rows($get_teacher_kids_class_id) > 0){
			while($kids_classes = mysqli_fetch_assoc($get_teacher_kids_class_id)){
				$teacher_class_id_raw .= $kids_classes["current_class"]." ";
				$user_admission_id_statement_auth_raw .= $kids_classes["admission_number"]." ";
				$user_bed_id_statement_auth_raw .= $kids_classes["bed_id_number"]." ";
				$user_bus_id_statement_auth_raw .= $kids_classes["bus_id_number"]." ";
				$user_session_statement_auth_raw .= $kids_classes["session"]." ";
			}
		}
		
		$user_class_id_name_auth = array_filter(explode(" ",trim($teacher_class_id_raw)));
		foreach($user_class_id_name_auth as $class_id){
			$user_class_statement_auth_raw .= "numeric_class_name='".$class_id."' ";
		}
		$user_class_statement_auth = "&& (".str_replace(" "," OR ",trim($user_class_statement_auth_raw)) .")";
		
		$user_admission_id_statement_auth_exp = array_filter(explode(" ",trim($user_admission_id_statement_auth_raw)));
		foreach($user_admission_id_statement_auth_exp as $admission_id){
			$user_admission_id_statement_auth_raw_2 .= "admission_number='".$admission_id."' ";
		}
		$user_admission_id_statement_auth = "&& (".str_replace(" "," OR ",trim($user_admission_id_statement_auth_raw_2)) .")";
		
		$user_bed_id_statement_auth_exp = array_filter(explode(" ",trim($user_bed_id_statement_auth_raw)));
		foreach($user_bed_id_statement_auth_exp as $bed_id){
			$user_bed_id_statement_auth_raw_2 .= "id_number='".$bed_id."' ";
		}
		$user_bed_statement_auth = "&& (".str_replace(" "," OR ",trim($user_bed_id_statement_auth_raw_2)) .")";
		
		$user_bus_id_statement_auth_exp = array_filter(explode(" ",trim($user_bus_id_statement_auth_raw)));
		foreach($user_bus_id_statement_auth_exp as $bus_id){
			$user_bus_id_statement_auth_raw_2 .= "id_number='".$bus_id."' ";
		}
		$user_bus_statement_auth = "&& (".str_replace(" "," OR ",trim($user_bus_id_statement_auth_raw_2)) .")";
		
		foreach($user_class_id_name_auth as $class_id){
			$user_notice_statement_auth_raw .= "numeric_class_name='".$class_id."' ";
		}
		$user_notice_statement_auth = "&& (".str_replace(" "," OR ",trim($user_notice_statement_auth_raw))." OR numeric_class_name='all') && (notice_for='teacher' OR notice_for='all')";
		
		
		$user_session_statement_auth_exp = array_filter(explode(" ",trim($user_session_statement_auth_raw)));
		foreach($user_class_id_name_auth as $index => $class_id){
			$user_notification_statement_class_auth_raw .= "numeric_class_name='".$class_id."' ";
			$user_notification_statement_user_admission_id_auth_raw .= "user='".$user_admission_id_statement_auth_exp[$index]."' ";
			$user_notification_statement_session_auth_raw .= "session='".$user_session_statement_auth_exp[$index]."' ";
		}
		$user_notification_statement_auth = "&& (".str_replace(" "," OR ",trim($user_notification_statement_class_auth_raw))." OR numeric_class_name='all') && (".str_replace(" "," OR ",trim($user_notification_statement_session_auth_raw))." OR session='all') && (".str_replace(" "," OR ",trim($user_notification_statement_user_admission_id_auth_raw))." OR user='all')";
		
		$user_profile_photo_auth = array("teacher_".$get_logged_user_details["school_id_number"]."_".$get_logged_user_details["id_number"].".png","Teacher.png");
		
		$user_account_table_name_auth = "sm_teachers";
		$user_account_table_id_auth = "&& id_number='".$get_logged_user_details["id_number"]."'";
		
	}
	
	if(isset($_SESSION["stu_par_session"])){
		$show_back_arrow = false;
		$show_item_auth = false;
		$user_class_statement_auth = "";
		$user_identifier_auth_id = "stu_par";
		$show_hd_add_button = false;

		//$user_class_id_name_auth = array();
		$get_parent_kids_class_id = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='".$get_logged_user_details['school_id_number']."' && parent_id_number='".$get_logged_user_details["id_number"]."'");
		if(mysqli_num_rows($get_parent_kids_class_id) > 0){
			while($kids_classes = mysqli_fetch_assoc($get_parent_kids_class_id)){
				$parent_class_id_raw .= $kids_classes["current_class"]." ";
				$user_admission_id_statement_auth_raw .= $kids_classes["admission_number"]." ";
				$user_bed_id_statement_auth_raw .= $kids_classes["bed_id_number"]." ";
				$user_bus_id_statement_auth_raw .= $kids_classes["bus_id_number"]." ";
				$user_session_statement_auth_raw .= $kids_classes["session"]." ";
			}
		}
		
		$user_class_id_name_auth = array_filter(explode(" ",trim($parent_class_id_raw)));
		foreach($user_class_id_name_auth as $class_id){
			$user_class_statement_auth_raw .= "numeric_class_name='".$class_id."' ";
		}
		$user_class_statement_auth = "&& (".str_replace(" "," OR ",trim($user_class_statement_auth_raw)) .")";
		
		$user_admission_id_statement_auth_exp = array_filter(explode(" ",trim($user_admission_id_statement_auth_raw)));
		foreach($user_admission_id_statement_auth_exp as $admission_id){
			$user_admission_id_statement_auth_raw_2 .= "admission_number='".$admission_id."' ";
		}
		$user_admission_id_statement_auth = "&& (".str_replace(" "," OR ",trim($user_admission_id_statement_auth_raw_2)) .")";
		
		$user_bed_id_statement_auth_exp = array_filter(explode(" ",trim($user_bed_id_statement_auth_raw)));
		foreach($user_bed_id_statement_auth_exp as $bed_id){
			$user_bed_id_statement_auth_raw_2 .= "id_number='".$bed_id."' ";
		}
		$user_bed_statement_auth = "&& (".str_replace(" "," OR ",trim($user_bed_id_statement_auth_raw_2)) .")";
		
		$user_bus_id_statement_auth_exp = array_filter(explode(" ",trim($user_bus_id_statement_auth_raw)));
		foreach($user_bus_id_statement_auth_exp as $bus_id){
			$user_bus_id_statement_auth_raw_2 .= "id_number='".$bus_id."' ";
		}
		$user_bus_statement_auth = "&& (".str_replace(" "," OR ",trim($user_bus_id_statement_auth_raw_2)) .")";
		
		foreach($user_class_id_name_auth as $class_id){
			$user_notice_statement_auth_raw .= "numeric_class_name='".$class_id."' ";
		}
		$user_notice_statement_auth = "&& (".str_replace(" "," OR ",trim($user_notice_statement_auth_raw))." OR numeric_class_name='all') && (notice_for='parent' OR notice_for='all')";
		
		
		$user_session_statement_auth_exp = array_filter(explode(" ",trim($user_session_statement_auth_raw)));
		foreach($user_class_id_name_auth as $index => $class_id){
			$user_notification_statement_class_auth_raw .= "numeric_class_name='".$class_id."' ";
			$user_notification_statement_user_admission_id_auth_raw .= "user='".$user_admission_id_statement_auth_exp[$index]."' ";
			$user_notification_statement_session_auth_raw .= "session='".$user_session_statement_auth_exp[$index]."' ";
		}
		$user_notification_statement_auth = "&& (".str_replace(" "," OR ",trim($user_notification_statement_class_auth_raw))." OR numeric_class_name='all') && (".str_replace(" "," OR ",trim($user_notification_statement_session_auth_raw))." OR session='all') && (".str_replace(" "," OR ",trim($user_notification_statement_user_admission_id_auth_raw))." OR user='all')";
		
		
		$user_profile_photo_auth = array("parent_".$get_logged_user_details["school_id_number"]."_".$get_logged_user_details["id_number"].".png","Parents.png");
		
		$user_account_table_name_auth = "sm_parents";
		$user_account_table_id_auth = "&& id_number='".$get_logged_user_details["id_number"]."'";
		
	}
	
	if(isset($_SESSION["stu_session"])){
		$show_back_arrow = false;
		$show_item_auth = false;
		$user_class_statement_auth = "&& numeric_class_name='".$get_logged_user_details["current_class"]."'";
		$user_identifier_auth_id = "stu";
		$show_hd_add_button = false;
		$user_class_id_name_auth = array($get_logged_user_details["current_class"]);
		$user_admission_id_auth = $get_logged_user_details["admission_number"];
		$user_admission_id_statement_auth = "&& admission_number='".$get_logged_user_details["admission_number"]."'";
		$user_bed_statement_auth = "&& id_number='".$get_logged_user_details["bed_id_number"]."'";
		
		$user_profile_photo_auth = array("student_".$get_logged_user_details["school_id_number"]."_".$get_logged_user_details["admission_number"].".png","Student.png");
		$user_bus_statement_auth = "&& id_number='".$get_logged_user_details["bus_id_number"]."'";
		$user_notice_statement_auth = "&& (numeric_class_name='".$get_logged_user_details["current_class"]."' OR numeric_class_name='all') && (notice_for='student' OR notice_for='all')";
		$user_notification_statement_auth = "&& (numeric_class_name='".$get_logged_user_details["current_class"]."' OR numeric_class_name='all') && (session='".$get_logged_user_details["session"]."' OR session='all') && (user='".$get_logged_user_details["admission_number"]."' OR user='all')";
		
		$user_account_table_name_auth = "sm_students";
		$user_account_table_id_auth = "&& admission_number='".$get_logged_user_details["admission_number"]."'";
	}
	
	if(strip_tags($_GET["page"]) == "smgt_parent_student"){
		$show_back_arrow = false;
		include("include/func/parent.php");
		include("include/func/admit-student.php");
	}

	if(strip_tags($_GET["page"]) == "smgt_session"){
		include("include/func/session.php");
	}
	
	if(strip_tags($_GET["page"]) == "smgt_class"){
		include("include/func/class.php");
	}

	if(strip_tags($_GET["page"]) == "smgt_class_category"){
		include("include/func/class-category.php");
	}

	if(strip_tags($_GET["page"]) == "smgt_time_table"){
		include("include/func/route.php");
	}

	if(strip_tags($_GET["page"]) == "smgt_student"){
		include("include/func/admit-student.php");
	}
	
	if(strip_tags($_GET["page"]) == "smgt_adminstaff"){
		include("include/func/admin-staff.php");
	}
	
	if(strip_tags($_GET["page"]) == "smgt_teacher"){
		include("include/func/teacher.php");
	}

	if(strip_tags($_GET["page"]) == "smgt_subject"){
		include("include/func/subject.php");
	}
	
	if(strip_tags($_GET["page"]) == "smgt_parent"){
		include("include/func/parent.php");
	}

	if(strip_tags($_GET["page"]) == "smgt_school"){
		include("include/func/manage-school.php");
	}
	
	if(strip_tags($_GET["page"]) == "smgt_cbt_activation"){
		include("include/func/cbt-activation.php");
	}
	
	if(strip_tags($_GET["page"]) == "smgt_exam"){
		include("include/func/add-exam.php");
	}

	if(strip_tags($_GET["page"]) == "smgt_hall"){
		include("include/func/hall.php");
	}

	if(strip_tags($_GET["page"]) == "smgt_result"){
		include("include/func/result.php");
	}
	
	if(strip_tags($_GET["page"]) == "smgt_grade"){
		include("include/func/grade.php");
	}
	
	if(strip_tags($_GET["page"]) == "smgt_migration"){
		include("include/func/migration.php");
	}

	if(strip_tags($_GET["page"]) == "smgt_student_homework"){
		include("include/func/homework.php");
	}

	if(strip_tags($_GET["page"]) == "smgt_cbt"){
		include("include/func/cbtest.php");
	}

	if(strip_tags($_GET["page"]) == "smgt_library"){
		include("include/func/library.php");
	}

	if(strip_tags($_GET["page"]) == "smgt_fees_payment"){
		include("include/func/fees.php");
	}

	if(strip_tags($_GET["page"]) == "smgt_payment"){
		include("include/func/payment.php");
	}
	
	if(strip_tags($_GET["page"]) == "smgt_hostel"){
		include("include/func/hostel.php");
	}
	
	if(strip_tags($_GET["page"]) == "smgt_room"){
		include("include/func/room.php");
	}
	
	if(strip_tags($_GET["page"]) == "smgt_bed"){
		include("include/func/bed.php");
	}

	if(strip_tags($_GET["page"]) == "smgt_notice"){
		include("include/func/notice.php");
	}

	if(strip_tags($_GET["page"]) == "smgt_holiday"){
		include("include/func/holiday.php");
	}
	
	if(strip_tags($_GET["page"]) == "smgt_notification"){
		include("include/func/notification.php");
	}
	
	if(strip_tags($_GET["page"]) == "smgt_transport"){
		include("include/func/transport.php");
	}
	
	if(strip_tags($_GET["page"]) == "smgt_general_settings"){
		include("include/func/general_settings.php");
	}

	if(strip_tags($_GET["page"]) == "smgt_user_settings"){
		include("include/func/account_settings.php");
	}
	
	if(strip_tags($_GET["page"]) == "smgt_admin_settings"){
		include("include/func/account_settings.php");
	}
	
	if(strip_tags($_GET["page"]) == "smgt_attendance"){
		include("include/func/attendance.php");
	}

	if(strip_tags($_GET["page"]) == "smgt_email_template"){
		include("include/func/email-template.php");
	}

	if(strip_tags($_GET["page"]) == "smgt_sms_settings"){
		include("include/func/sms-settings.php");
	}

	if(strip_tags($_GET["page"]) == "smgt_sms_sender_id"){
		include("include/func/sms-sender-id.php");
	}
	
	if(strip_tags($_GET["page"]) == "smgt_check_result"){
		include("include/func/view-result.php");
	}

	
	if(isset($_POST["login-as-user-btn"])){
		$userType = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["login-as-user-type-inp"])));
		
		if($userType === "school-admin"){
			$_SESSION["mod_adm_session"] = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["login-as-user-sch-inp"])));
			$_SESSION["sup_adm_session_temp"] = $_SESSION["sup_adm_session"];
			unset($_SESSION["sup_adm_session"]);
		}
		header("Location: /bc-admin.php?page=smgt_dashboard");
	}

	if(isset($_POST["switch-back-user-btn"])){
		$_SESSION["sup_adm_session"] = $_SESSION["sup_adm_session_temp"];
		unset($_SESSION["mod_adm_session"]);
		unset($_SESSION["sup_adm_session_temp"]);
		header("Location: /bc-admin.php?page=smgt_dashboard");
	}

	if(isset($_SESSION["sup_adm_session"])){
		$browser_page_title_detail = "School Management System";
		$browser_page_desc_detail = "Custom Multi-School Management System";
	}else{
		$get_page_details_sch_name = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='".$get_logged_user_details["school_id_number"]."' LIMIT 1"));
		$browser_page_title_detail = $get_page_details_sch_name["school_name"];
		$browser_page_desc_detail = $get_page_details_sch_name["school_motto"];
	}
?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo $browser_page_title_detail; ?> | Portal</title>
<meta charset="UTF-8" />
<meta name="description" content="<?php echo $browser_page_desc_detail; ?>" />
<meta http-equiv="Content-Type" content="text/html; " />
<meta name="theme-color" content="black" />
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<link rel="stylesheet" href="cssfile/font-family.css">
<link rel="stylesheet" href="cssfile/portal.css">
<link rel="stylesheet" href="cssfile/pell.min.css">
<script src="https://checkout.flutterwave.com/v3.js"></script>
<script src="js/popup.js"></script>
<script src="js/pell.min.js"></script>

<!-- Google Translate -->
<div id="google_translate_element" style="display: none;"></div>
<style>
        /* Hide the Google Translate toolbar and dropdown */
        .goog-te-banner-frame {
            display: none !important;
        }
        .goog-te-gadget {
            display: none !important;
        }
        .goog-te-combo {
            display: none !important;
        }

		body > .skiptranslate {
    display: none;
}

        body {
            top: 0 !important;
        }
    </style>

</head>
<body>
<?php include("./include/web-header.php"); ?>

	<?php
		if(strip_tags($_GET["page"]) == "smgt_dashboard"){
			include("include/dashboard.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_parent_student"){
			include("include/parent.php");
			include("include/admit-student.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_session"){
			include("include/session.php");
		}
		
		if(strip_tags($_GET["page"]) == "smgt_class"){
			include("include/class.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_class_category"){
			include("include/class-category.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_time_table"){
			include("include/route.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_student"){
			include("include/admit-student.php");
		}
		
		if(strip_tags($_GET["page"]) == "smgt_adminstaff"){
			include("include/admin-staff.php");
		}
		
		if(strip_tags($_GET["page"]) == "smgt_teacher"){
			include("include/teacher.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_teacher_students"){
			include("include/teacher-students.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_parent"){
			include("include/parent.php");
		}
		
		if(strip_tags($_GET["page"]) == "smgt_subject"){
			include("include/subject.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_school"){
			include("include/manage-school.php");
		}
		
		if(strip_tags($_GET["page"]) == "smgt_cbt_activation"){
			include("include/cbt-activation.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_student_homework"){
			include("include/homework.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_cbt"){
			include("include/cbtest.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_library"){
			include("include/library.php");
		}
		
		if(strip_tags($_GET["page"]) == "smgt_fees_payment"){
			include("include/fees.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_payment"){
			include("include/payment.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_exam"){
			include("include/add-exam.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_hall"){
			include("include/hall.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_result"){
			include("include/result.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_grade"){
			include("include/grade.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_migration"){
			include("include/migration.php");
		}
		
		if(strip_tags($_GET["page"]) == "smgt_hostel"){
			include("include/hostel.php");
		}
		
		if(strip_tags($_GET["page"]) == "smgt_room"){
			include("include/room.php");
		}
		
		if(strip_tags($_GET["page"]) == "smgt_bed"){
			include("include/bed.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_notice"){
			include("include/notice.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_holiday"){
			include("include/holiday.php");
		}
		
		if(strip_tags($_GET["page"]) == "smgt_notification"){
			include("include/notification.php");
		}
		
		if(strip_tags($_GET["page"]) == "smgt_transport"){
			include("include/transport.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_general_settings"){
			include("include/general_settings.php");
		}
		
		if(strip_tags($_GET["page"]) == "smgt_user_settings"){
			include("include/account_settings.php");
		}
		
		if(strip_tags($_GET["page"]) == "smgt_admin_settings"){
			include("include/account_settings.php");
		}
		
		if(strip_tags($_GET["page"]) == "smgt_attendance"){
			include("include/attendance.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_email_template"){
			include("include/email-template.php");
		}
		
		if(strip_tags($_GET["page"]) == "smgt_check_result"){
			include("include/view-result.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_sms_settings"){
			include("include/sms-settings.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_sms_payments"){
			include("include/sms-payments.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_sms_dashboard"){
			include("include/sms-dashboard.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_sms_purchase"){
			include("include/sms-purchase.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_sms_phonebook"){
			include("include/sms-phonebook.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_sms_send"){
			include("include/sms-send.php");
		}

		if(strip_tags($_GET["page"]) == "smgt_sms_sender_id"){
			include("include/sms-sender-id.php");
		}
		
		
	?>

	<?php if(isset($_SESSION["sup_adm_session"])){ ?>
	<form method="post">
		<input hidden type="text" name="login-as-user-type-inp" id="login-as-user-type-inp">
		<input hidden type="text" name="login-as-user-sch-inp" id="login-as-user-sch-inp">
		<button hidden type="submit" name="login-as-user-btn" id="login-as-user-btn">Login</button>
	<form>
	<?php } ?>

	<?php if(isset($_SESSION["mod_adm_session"]) && isset($_SESSION["sup_adm_session_temp"])){ ?>
	<form method="post">
		<button hidden type="submit" name="switch-back-user-btn" id="switch-back-user-btn">Switch Back</button>
	<form>
	<script>
		function switchBackUser(){
			document.getElementById("switch-back-user-btn").click();
		}
	</script>
	<?php } ?>
<?php
	// $all_existing_user_num_count = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='".$get_logged_user_details["school_id_number"]."'");
	// while($each_user_id_number = mysqli_fetch_array($all_existing_user_num_count)){
	// 	if(date("y") === substr($each_user_id_number["admission_number"],0,2)){
	// 		$last_user_id_number .= substr($each_user_id_number["admission_number"],2).",";
	// 	}
	// }
	// echo date("y").(sprintf("%04d",(max(array_filter(explode(",",trim($last_user_id_number)))))+1));
?>
<?php include("./include/web-footer.php"); ?>
<?php 

if($get_school_identification["school_id_number"] == true){
$select_school_det_for_google_translation = mysqli_query($connection_server, "SELECT `language` FROM sm_school_details WHERE school_id_number='".$get_school_identification["school_id_number"]."' LIMIT 1");
if(mysqli_num_rows($select_school_det_for_google_translation) == 1){echo $get_school_identification["school_id_number"]."sbeebay";
	$get_school_det_for_google_translation = mysqli_fetch_array($select_school_det_for_google_translation);
	?>
	<script>
        // Load the Google Translate API
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en', // The original language of the page
                autoDisplay: false // No toolbar display
            }, 'google_translate_element');

			// Trigger automatic translation to a preferred language
            setTimeout(() => {
                const preferredLanguage = '<?php echo $get_school_det_for_google_translation["language"]; ?>'; // Change 'es' to your target language code
                const selectBox = document.querySelector('.goog-te-combo');
                if (selectBox) {
                    selectBox.value = preferredLanguage;
					selectBox.dispatchEvent(new Event('change')); // Trigger the change event
                }
            }, 1000); // Delay to ensure Google Translate widget is fully initialized
        }

		
    </script>
    <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>



<?php } } ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Initialize Pell on all editors
    const editors = document.querySelectorAll('.pell');
    if (editors.length) {
        for (let i = 0; i < editors.length; i++) {
            const editorDiv = editors[i];
            const textareaId = editorDiv.id.replace('editor-', '') + '-textarea';
            const textarea = document.getElementById(textareaId);

            if (textarea) {
                const editor = pell.init({
                    element: editorDiv,
                    onChange: function (html) {
                        textarea.value = html;
                    },
                    defaultParagraphSeparator: 'p',
                    actions: [
                        'bold',
                        'italic',
                        'underline',
                        'strikethrough',
                        'heading1',
                        'heading2',
                        'paragraph',
                        'quote',
                        'olist',
                        'ulist',
                        'line'
                    ]
                });
                // Set initial content
                editor.content.innerHTML = textarea.value;
            }
        }
    }
});
</script>
</body>
</html>