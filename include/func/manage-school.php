<?php

	$err_msg = "";
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}

	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: School details already exists in database";
	}

	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: Cannot update School, Moderator details already exists in database";
	}

	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "4"){
		$err_msg .= "Error: Other Schools with same Email or Phone number already exists in database";
	}

	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "5"){
		$err_msg .= "Error: School doesn't exists in database";
	}
	
    $header_add_button = "add_school";
	$header_view_button = "view_school";

	if((isset($_GET["prevnext"])) && (trim(strip_tags($_GET["prevnext"])) > 0) && (trim(strip_tags($_GET["prevnext"])) !== "")){
		$prev_next = "&prevnext=".trim(strip_tags($_GET["prevnext"]));
		$current_page_no = trim(strip_tags($_GET["prevnext"]));
		if((trim(strip_tags($_GET["prevnext"]))-1) >= 1){
			$prev_btn = (trim(strip_tags($_GET["prevnext"]))-1);
		}else{
			$prev_btn = 1;
		}
		
		if((trim(strip_tags($_GET["prevnext"]))+1) == 1){
			$next_btn = (trim(strip_tags($_GET["prevnext"]))+2);
		}else{
			if((trim(strip_tags($_GET["prevnext"]))+1) < 1){
				$next_btn = 2;
			}else{
				$next_btn = (trim(strip_tags($_GET["prevnext"]))+1);
			}
		}
	}else{
		$prev_next = "&prevnext=1";
		$current_page_no = "1";
		$prev_btn = 1;
		$next_btn = 2;
		
	}

	if(isset($_GET["search"])){
		$search_text = trim(strip_tags($_GET["search"]));
	}else{
		$search_text = "";
	}

	if((isset($_GET["pnum"])) && (trim(strip_tags($_GET["pnum"])) > 0) && (trim(strip_tags($_GET["pnum"])) !== "")){
		$page_pnum = trim(strip_tags($_GET["pnum"]));
	}else{
		$page_pnum = "10";
	}
	$page_list_number_link = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"])).$prev_next."&search=".$search_text."&pnum=";
	$page_prevnext_link = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"]))."&search=".$search_text."&pnum=".$page_pnum;
	
	$chopped_search_text_array = array_filter(explode(" ",trim($search_text)));
	foreach($chopped_search_text_array as $search_items){
		$search_sqli_statement .= "email LIKE '%".$search_items."%'"."\n"." school_name LIKE '%".$search_items."%'"."\n"." school_id_number LIKE '%".$search_items."%'"."\n"." school_phone_number LIKE '%".$search_items."%'"."\n"." school_motto LIKE '%".$search_items."%'"."\n"." school_address LIKE '%".$search_items."%'"."\n"." city LIKE '%".$search_items."%'"."\n"." state LIKE '%".$search_items."%'"."\n"." country LIKE '%".$search_items."%'";

	}

	$search_sqli_statements .= str_replace("\n"," OR ", trim($search_sqli_statement));

	if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
		$select_school_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE $search_sqli_statements LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_school_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE $search_sqli_statements");
	}else{
		$select_school_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_school_details LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_school_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_school_details");
	}
	

	if(isset($_POST["create-school"])){
		$mod_first = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-first"])));
		$mod_last = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-last"])));
		$mod_email = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-email"])));
		$mod_gender = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-gender"])));
        $mod_marital = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-marital"])));
		$mod_password = md5(mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-pass"]))));
		$mod_phone = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-phone"])));
        $mod_city = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-city"])));
        $mod_state = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-state"])));
        $mod_country = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-country"])));
        $mod_home_address = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-home-address"])));
        $mod_office_address = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-office-address"])));
        
		$sch_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["name"])));
		$sch_motto = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["motto"])));
		$sch_address = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["address"])));
        $sch_phone = $mod_phone;
        $sch_city = $mod_city;
		$sch_state = $mod_state;
		$sch_country = $mod_country;
		
        $mod_currency = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-currency"])));
        $mod_language = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-language"])));
        
		
        $all_sch_num_count = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_school_details"));
		if($all_sch_num_count > 0){
			$check_last_school = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_school_details LIMIT 1 OFFSET ".($all_sch_num_count-1)));
			$sch_id_no = sprintf("%03d",(($check_last_school["school_id_number"]) + 1));
		}else{
			$sch_id_no = sprintf("%03d",1);
		}

		if(!empty($mod_first) && !empty($mod_last) && !empty($mod_email) && !empty($mod_password) && !empty($mod_gender) && !empty($mod_marital) && !empty($mod_phone) && !empty($mod_city) && !empty($mod_state) && !empty($mod_country) && !empty($mod_home_address) && !empty($mod_office_address) && !empty($sch_name) && !empty($sch_motto) && !empty($sch_address) && !empty($sch_phone) && !empty($sch_city) && !empty($sch_state) && !empty($sch_country) && !empty($sch_id_no) && !empty($mod_currency) && !empty($mod_language)){
			if(mysqli_query($connection_server, "INSERT INTO sm_school_details (email, school_name, school_id_number, school_motto, school_address, school_phone_number, city, `state`, country, currency, `language`) VALUES ('$mod_email','$sch_name','$sch_id_no','$sch_motto','$sch_address','$sch_phone','$sch_city','$sch_state','$sch_country', '$mod_currency', '$mod_language')") == true){
				if(file_exists("dataimg/school_".$sch_id_no.".png")){
					unlink("dataimg/school_".$sch_id_no.".png");
					$photo_tmp_name = $_FILES["photo"]["tmp_name"];
					move_uploaded_file($photo_tmp_name,"dataimg/school_".$sch_id_no.".png");
				}else{
					$photo_tmp_name = $_FILES["photo"]["tmp_name"];
					move_uploaded_file($photo_tmp_name,"dataimg/school_".$sch_id_no.".png");
				}
				
				if(mysqli_query($connection_server, "INSERT INTO sm_moderators (email, password, school_id_number, firstname, lastname, phone_number, gender, marital_status, home_address, office_address, city, `state`, country) VALUES ('$mod_email','$mod_password','$sch_id_no','$mod_first','$mod_last','$sch_phone','$mod_gender','$mod_marital','$mod_home_address','$mod_office_address','$sch_city','$sch_state','$sch_country')") == true){
					$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=true";
				}
			}else{
				$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		header("Location: ".$redirect_url);
	}

	if(isset($_POST["update-school"])){
		$mod_first = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-first"])));
		$mod_last = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-last"])));
		$mod_email = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-email"])));
		$mod_gender = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-gender"])));
        $mod_marital = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-marital"])));
		$mod_password = md5(mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-pass"]))));
		$mod_phone = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-phone"])));
		$mod_city = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-city"])));
		$mod_state = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-state"])));
		$mod_country = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-country"])));
		$mod_home_address = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-home-address"])));
		$mod_office_address = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-office-address"])));
		
		$sch_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["name"])));
		$sch_motto = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["motto"])));
		$sch_address = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["address"])));
        $sch_phone = $mod_phone;
        $sch_city = $mod_city;
		$sch_state = $mod_state;
		$sch_country = $mod_country;
		$mod_currency = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-currency"])));
        $mod_language = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-language"])));
        
        
        $sch_id_no = trim(strip_tags($_GET['edit']));
		
        
		$search_school_with_id = mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='$sch_id_no'");
		$search_school_moderator_with_id = mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='$sch_id_no'");
		
		if(!empty($mod_first) && !empty($mod_last) && !empty($mod_email) && !empty($mod_password) && !empty($mod_gender) && !empty($mod_marital) && !empty($mod_phone) && !empty($mod_city) && !empty($mod_state) && !empty($mod_country) && !empty($mod_home_address) && !empty($mod_office_address) && !empty($sch_name) && !empty($sch_motto) && !empty($sch_address) && !empty($sch_phone) && !empty($sch_city) && !empty($sch_state) && !empty($sch_country) && !empty($sch_id_no) && !empty($mod_currency) && !empty($mod_language)){
			if(mysqli_num_rows($search_school_with_id) == 1){
				if(mysqli_num_rows($search_school_moderator_with_id) == 1){
					if(mysqli_query($connection_server, "UPDATE sm_school_details SET email='$mod_email', school_name='$sch_name', school_motto='$sch_motto', school_address='$sch_address', school_phone_number='$sch_phone', city='$sch_city', `state`='$sch_state', country='$sch_country', currency='$mod_currency', `language`='$mod_language' WHERE school_id_number='$sch_id_no'") == true){
						if(!empty($_FILES["photo"]["tmp_name"])){
							if(file_exists("dataimg/school_".$sch_id_no.".png")){
								unlink("dataimg/school_".$sch_id_no.".png");
								$photo_tmp_name = $_FILES["photo"]["tmp_name"];
								move_uploaded_file($photo_tmp_name,"dataimg/school_".$sch_id_no.".png");
							}else{
								$photo_tmp_name = $_FILES["photo"]["tmp_name"];
								move_uploaded_file($photo_tmp_name,"dataimg/school_".$sch_id_no.".png");
							}
						}
						
						if(mysqli_query($connection_server, "UPDATE sm_moderators SET email='$mod_email', password='$mod_password', firstname='$mod_first', lastname='$mod_last', phone_number='$mod_phone', gender='$mod_gender', marital_status='$mod_marital', home_address='$mod_home_address', office_address='$mod_office_address', city='$mod_city', state='$mod_state', country='$mod_country' WHERE school_id_number='$sch_id_no'") == true){
							$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=true";
						}
						
					}
				}else{
					//another user exists
					$redirect_url = $_SERVER["REQUEST_URI"]."&err=4";
				}
			}else{
				//user doesnt exists
				$redirect_url = $_SERVER["REQUEST_URI"]."&err=5";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		header("Location: ".$redirect_url);
	}

	if(isset($_POST["delete-school"])){
		$sch_id = $_POST["school_id"];
		foreach($sch_id as $index => $sch_id_no){
			$sch_id_number = mysqli_real_escape_string($connection_server, $sch_id[$index]);
			//Delete School Detail Table
			$delete_school_detail = mysqli_query($connection_server, "DELETE FROM sm_school_details WHERE school_id_number='$sch_id_number'");
    
			//Delete Moderator Table
			$delete_mod_table = mysqli_query($connection_server, "DELETE FROM sm_moderators WHERE school_id_number='$sch_id_number'");
			
			//Delete Admin-Staff Table
			$delete_admin_staff_table = mysqli_query($connection_server, "DELETE FROM sm_admin_staffs WHERE school_id_number='$sch_id_number'");
			
			//Delete Teacher Table
			$delete_teacher_table = mysqli_query($connection_server, "DELETE FROM sm_teachers WHERE school_id_number='$sch_id_number'");
			
			//Delete Parent Table
			$delete_parent_table = mysqli_query($connection_server, "DELETE FROM sm_parents WHERE school_id_number='$sch_id_number'");
			
			//Delete Student Table
			$delete_student_table = mysqli_query($connection_server, "DELETE FROM sm_students WHERE school_id_number='$sch_id_number'");
			
			//Delete Class Table
			$delete_class_table = mysqli_query($connection_server, "DELETE FROM sm_classes WHERE school_id_number='$sch_id_number'");
			
			//Delete Class-List Table
			$delete_class_list_table = mysqli_query($connection_server, "DELETE FROM sm_class_list WHERE school_id_number='$sch_id_number'");
			
			//Delete Session Table
			$delete_session_table = mysqli_query($connection_server, "DELETE FROM sm_sessions WHERE school_id_number='$sch_id_number'");
			
			//Delete Subject Table
			$delete_subject_table = mysqli_query($connection_server, "DELETE FROM sm_subjects WHERE school_id_number='$sch_id_number'");
			
			//Delete Exam Table
			$delete_exam_table = mysqli_query($connection_server, "DELETE FROM sm_exams WHERE school_id_number='$sch_id_number'");
			
			//Delete Term Table
			$delete_term_table = mysqli_query($connection_server, "DELETE FROM sm_terms WHERE school_id_number='$sch_id_number'");
			
			//Delete Hostel Table
			$delete_hostel_table = mysqli_query($connection_server, "DELETE FROM sm_hostels WHERE school_id_number='$sch_id_number'");
			
			//Delete Room Table
			$delete_room_table = mysqli_query($connection_server, "DELETE FROM sm_rooms WHERE school_id_number='$sch_id_number'");
			
			//Delete Room Category Table
			$delete_room_category_table = mysqli_query($connection_server, "DELETE FROM sm_room_list WHERE school_id_number='$sch_id_number'");
			
			//Delete Bed Table
			$delete_bed_table = mysqli_query($connection_server, "DELETE FROM sm_beds WHERE school_id_number='$sch_id_number'");
			
			//Delete Hall Table
			$delete_hall_table = mysqli_query($connection_server, "DELETE FROM sm_halls WHERE school_id_number='$sch_id_number'");
			
			//Delete Subject Hall Receipt Table
			$delete_subject_hall_receipt_table = mysqli_query($connection_server, "DELETE FROM sm_subject_hall_receipts WHERE school_id_number='$sch_id_number'");
			
			//Delete Notice Table
			$delete_notice_table = mysqli_query($connection_server, "DELETE FROM sm_notices WHERE school_id_number='$sch_id_number'");
			
			//Delete Transport Table
			$delete_transport_table = mysqli_query($connection_server, "DELETE FROM sm_transports WHERE school_id_number='$sch_id_number'");
			
			//Delete Notification Table
			$delete_notification_table = mysqli_query($connection_server, "DELETE FROM sm_notifications WHERE school_id_number='$sch_id_number'");
			
			//Delete Result Table
			$delete_result_table = mysqli_query($connection_server, "DELETE FROM sm_results WHERE school_id_number='$sch_id_number'");
		
			//Delete Result List Table
			$delete_result_list_table = mysqli_query($connection_server, "DELETE FROM sm_result_lists WHERE school_id_number='$sch_id_number'");
		
			//Delete Grade Table
			$delete_grade_table = mysqli_query($connection_server, "DELETE FROM sm_grades WHERE school_id_number='$sch_id_number'");
			
			//Delete Book Category Table
			$delete_book_category_table = mysqli_query($connection_server, "DELETE FROM sm_book_category WHERE school_id_number='$sch_id_number'");
			
			//Delete Book Rack Location Name Table
			$delete_book_rack_location_table = mysqli_query($connection_server, "DELETE FROM sm_book_rack_location WHERE school_id_number='$sch_id_number'");
			
			//Delete Book List Table
			$delete_book_list_table = mysqli_query($connection_server, "DELETE FROM sm_book_lists WHERE school_id_number='$sch_id_number'");
			
			//Delete Issue List Table
			$delete_issue_list_table = mysqli_query($connection_server, "DELETE FROM sm_issue_lists WHERE school_id_number='$sch_id_number'");
			
			//Delete Fees Payment Gateway Table
			$delete_fees_payment_gateway_table = mysqli_query($connection_server, "DELETE FROM sm_fees_payment_gateway WHERE school_id_number='$sch_id_number'");
			
			//Delete Fee Type Table
			$delete_fee_type_table = mysqli_query($connection_server, "DELETE FROM sm_fee_type WHERE school_id_number='$sch_id_number'");
			
			//Delete Fee List Table
			$delete_fee_list_table = mysqli_query($connection_server, "DELETE FROM sm_fee_lists WHERE school_id_number='$sch_id_number'");
			
			//Delete Fees Payment List Table
			$delete_fee_payment_list_table = mysqli_query($connection_server, "DELETE FROM sm_fee_payment_lists WHERE school_id_number='$sch_id_number'");
			
			//Delete Online Pre Fees Payment List Table
			$delete_online_pre_fee_payment_list_table = mysqli_query($connection_server, "DELETE FROM sm_online_pre_fee_payment_lists WHERE school_id_number='$sch_id_number'");
			
			//Delete Holiday Table
			$delete_holiday_table = mysqli_query($connection_server, "DELETE FROM sm_holidays WHERE school_id_number='$sch_id_number'");
			
			//Delete Student Attendance Table
			$delete_student_attendance_table = mysqli_query($connection_server, "DELETE FROM sm_student_attendances WHERE school_id_number='$sch_id_number'");
			
			//Delete Teacher Attendance Table
			$delete_teacher_attendance_table = mysqli_query($connection_server, "DELETE FROM sm_teacher_attendances WHERE school_id_number='$sch_id_number'");   
		 
			//Delete Route List Table
			$delete_route_list_table = mysqli_query($connection_server, "DELETE FROM sm_route_lists WHERE school_id_number='$sch_id_number'");    
		
			//Delete Exam List Table
			$delete_exam_list_table = mysqli_query($connection_server, "DELETE FROM sm_exam_lists WHERE school_id_number='$sch_id_number'");
			
			//Delete Homework List Table
			$delete_homework_list_table = mysqli_query($connection_server, "DELETE FROM sm_homework_lists WHERE school_id_number='$sch_id_number'");
			
			//Delete Submitted Homework List Table
			$delete_submitted_homework_list_table = mysqli_query($connection_server, "DELETE FROM sm_submitted_homework_lists WHERE school_id_number='$sch_id_number'");
			
			//Delete Email Template Table
			$delete_email_template_table = mysqli_query($connection_server, "DELETE FROM sm_email_templates WHERE school_id_number='$sch_id_number'");
					
		}
		$redirect_url = $_SERVER["REQUEST_URI"];
		header("Location: ".$redirect_url);
	}

	if(isset($_POST["search-item"])){
		$search_item_text = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["search-item"])));
		
		$page_to_go_link = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"]))."&search=".$search_item_text."&pnum=".$page_pnum;
		header("Location: ".$page_to_go_link);
	}
?>