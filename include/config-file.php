<?php
	date_default_timezone_set('Africa/Lagos');
	include("db-dtl.php");
	include("country-details.php");
	$connection = mysqli_connect($mySqlServer,$mySqlUser,$mySqlPass);
	
	if($connection){
		if(mysqli_query($connection,"CREATE DATABASE IF NOT EXISTS ".$mySqlDBName)){
			/*echo "DB Created Successfully";*/
		}
	}else{
		/*echo mysqli_connect_error($connection);*/
	}
	
	$db_connection_check = mysqli_connect($mySqlServer,$mySqlUser,$mySqlPass,$mySqlDBName);
	if($db_connection_check){
		$connection_server = mysqli_connect($mySqlServer,$mySqlUser,$mySqlPass,$mySqlDBName);
	}else{
		/*echo mysqli_connect_error($db_connection_check);*/
	}

	
	//Create Super Moderator Table
	$def_super_mod_email = 'admin@example.com';
	$create_super_mod_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_super_moderators (email VARCHAR(225) NOT NULL, password VARCHAR(225) NOT NULL, firstname VARCHAR(225) NOT NULL, lastname VARCHAR(225) NOT NULL, phone_number VARCHAR(225) NOT NULL, gender VARCHAR(225) NOT NULL, marital_status VARCHAR(225) NOT NULL, home_address VARCHAR(225) NOT NULL, office_address VARCHAR(225) NOT NULL, city VARCHAR(225) NOT NULL, state VARCHAR(225) NOT NULL, country VARCHAR(225) NOT NULL)");
	$count_super_mods_table = mysqli_query($connection_server, "SELECT * FROM sm_super_moderators WHERE email='$def_super_mod_email'");
	if(mysqli_num_rows($count_super_mods_table) < 1){
		$def_super_mod_pass = md5("12345678");
		mysqli_query($connection_server, "INSERT INTO sm_super_moderators (email, password, firstname, lastname, phone_number, gender, marital_status, home_address, office_address, city, state, country) VALUES ('$def_super_mod_email','$def_super_mod_pass','Administrator','SMT','08124232128','male','single','nil','nil','ilorin','kwara','nigeria')");
	}else{
		/*echo mysqli_error($connection_server);*/
	}
	
	//Create School Detail Table
	$create_school_detail = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_school_details (email VARCHAR(225) NOT NULL, school_name VARCHAR(225) NOT NULL, school_id_number VARCHAR(225) NOT NULL, school_motto VARCHAR(225) NOT NULL, school_address VARCHAR(225) NOT NULL, school_phone_number VARCHAR(225) NOT NULL, city VARCHAR(225) NOT NULL, state VARCHAR(225) NOT NULL, country VARCHAR(225) NOT NULL)");
	
	//Alter School Table (Add currency, language column)
	$result = mysqli_query($connection_server, "SHOW COLUMNS FROM `sm_school_details` LIKE 'currency'");
	$exists = (mysqli_num_rows($result)) ? TRUE : FALSE;
	if (!$exists) {
		mysqli_query($connection_server, "ALTER TABLE sm_school_details ADD COLUMN currency VARCHAR(225) NOT NULL");
	}
	$result = mysqli_query($connection_server, "SHOW COLUMNS FROM `sm_school_details` LIKE 'language'");
	$exists = (mysqli_num_rows($result)) ? TRUE : FALSE;
	if (!$exists) {
		mysqli_query($connection_server, "ALTER TABLE sm_school_details ADD COLUMN `language` VARCHAR(225) NOT NULL");
	}

	//Create Moderator Table
	$create_mod_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_moderators (email VARCHAR(225) NOT NULL, password VARCHAR(225) NOT NULL, school_id_number VARCHAR(225) NOT NULL, firstname VARCHAR(225) NOT NULL, lastname VARCHAR(225) NOT NULL, phone_number VARCHAR(225) NOT NULL, gender VARCHAR(225) NOT NULL, marital_status VARCHAR(225) NOT NULL, home_address VARCHAR(225) NOT NULL, office_address VARCHAR(225) NOT NULL, city VARCHAR(225) NOT NULL, state VARCHAR(225) NOT NULL, country VARCHAR(225) NOT NULL)");
	
	//Create Admin-Staff Table
	$create_admin_staff_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_admin_staffs (email VARCHAR(225) NOT NULL, password VARCHAR(225) NOT NULL, school_id_number VARCHAR(225) NOT NULL, id_number VARCHAR(225) NOT NULL, firstname VARCHAR(225) NOT NULL, lastname VARCHAR(225) NOT NULL, phone_number VARCHAR(225) NOT NULL, gender VARCHAR(225) NOT NULL, marital_status VARCHAR(225) NOT NULL, home_address VARCHAR(225) NOT NULL, dob VARCHAR(225) NOT NULL, city VARCHAR(225) NOT NULL, state VARCHAR(225) NOT NULL, country VARCHAR(225) NOT NULL)");
	
	//Create Teacher Table
	$create_teacher_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_teachers (email VARCHAR(225) NOT NULL, password VARCHAR(225) NOT NULL, school_id_number VARCHAR(225) NOT NULL, id_number VARCHAR(225) NOT NULL, class VARCHAR(225) NOT NULL, firstname VARCHAR(225) NOT NULL, lastname VARCHAR(225) NOT NULL, phone_number VARCHAR(225) NOT NULL, gender VARCHAR(225) NOT NULL, marital_status VARCHAR(225) NOT NULL, home_address VARCHAR(225) NOT NULL, dob VARCHAR(225) NOT NULL, city VARCHAR(225) NOT NULL, state VARCHAR(225) NOT NULL, country VARCHAR(225) NOT NULL)");
	
	//Create Parent Table
	$create_parent_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_parents (email VARCHAR(225) NOT NULL, password VARCHAR(225) NOT NULL, school_id_number VARCHAR(225) NOT NULL, id_number VARCHAR(225) NOT NULL, father_first_name VARCHAR(225) NOT NULL, father_last_name VARCHAR(225) NOT NULL, mother_first_name VARCHAR(225) NOT NULL, mother_last_name VARCHAR(225) NOT NULL, father_phone_number VARCHAR(225) NOT NULL, mother_phone_number VARCHAR(225) NOT NULL, father_occupation VARCHAR(225) NOT NULL, mother_occupation VARCHAR(225) NOT NULL, home_address VARCHAR(225) NOT NULL, city VARCHAR(225) NOT NULL, state VARCHAR(225) NOT NULL, country VARCHAR(225) NOT NULL)");
	
	//Create Student Table
	$create_student_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_students (email VARCHAR(225) NOT NULL, password VARCHAR(225) NOT NULL, school_id_number VARCHAR(225) NOT NULL, parent_id_number VARCHAR(225) NOT NULL, phone_number VARCHAR(225) NOT NULL, firstname VARCHAR(225) NOT NULL, lastname VARCHAR(225) NOT NULL, othername VARCHAR(225), gender VARCHAR(225) NOT NULL, dob VARCHAR(225) NOT NULL, blood_group VARCHAR(225), home_address VARCHAR(225) NOT NULL, city VARCHAR(225) NOT NULL, lga VARCHAR(225), origin_state VARCHAR(225) NOT NULL, resident_state VARCHAR(225) NOT NULL, origin_country VARCHAR(225) NOT NULL, resident_country VARCHAR(225) NOT NULL, admission_year VARCHAR(225) NOT NULL, admission_number VARCHAR(225) NOT NULL, current_class VARCHAR(225) NOT NULL, numeric_class_category_name INT NOT NULL, previous_school VARCHAR(225), previous_class VARCHAR(225), session VARCHAR(225) NOT NULL, bus_id_number VARCHAR(225), bed_id_number VARCHAR(225))");
	
	//Create Class Table
	$create_class_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_classes (school_id_number VARCHAR(225) NOT NULL, class_name VARCHAR(225) NOT NULL, numeric_class_name VARCHAR(225) NOT NULL, student_capacity VARCHAR(225) NOT NULL, session VARCHAR(225) NOT NULL)");
	
	//Create Class-List Table
	$create_class_list_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_class_list (school_id_number VARCHAR(225) NOT NULL, admission_number VARCHAR(225) NOT NULL, numeric_class_name VARCHAR(225) NOT NULL, session VARCHAR(225) NOT NULL)");
	
	//Create Class Category Table
	$create_class_category_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_class_category (school_id_number VARCHAR(225) NOT NULL, class_category_name VARCHAR(225) NOT NULL, numeric_class_category_name INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(numeric_class_category_name))");
	
	//Create Session Table
	$create_session_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_sessions (school_id_number VARCHAR(225) NOT NULL, session VARCHAR(225) NOT NULL)");
	
	//Create Subject Table
	$create_subject_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_subjects (school_id_number VARCHAR(225) NOT NULL, subject_name VARCHAR(225) NOT NULL, subject_code VARCHAR(225) NOT NULL, teacher_id_number VARCHAR(225) NOT NULL, numeric_class_name VARCHAR(225) NOT NULL, session VARCHAR(225) NOT NULL)");
	
	//Create Exam Table
	$create_exam_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_exams (school_id_number VARCHAR(225) NOT NULL, subject_code VARCHAR(225) NOT NULL, numeric_class_name VARCHAR(225) NOT NULL, session VARCHAR(225) NOT NULL, term_id_number VARCHAR(225) NOT NULL, pass_mark VARCHAR(225) NOT NULL, total_mark VARCHAR(225) NOT NULL, exam_start_date VARCHAR(225) NOT NULL, exam_end_date VARCHAR(225) NOT NULL, exam_comment VARCHAR(225))");
	
	//Create Term Table
	$create_term_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_terms (school_id_number VARCHAR(225) NOT NULL, id_number VARCHAR(225) NOT NULL, term_name VARCHAR(225) NOT NULL)");
	
	//Create Hostel Table
	$create_hostel_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_hostels (school_id_number VARCHAR(225) NOT NULL, id_number VARCHAR(225) NOT NULL, hostel_name VARCHAR(225) NOT NULL, hostel_type VARCHAR(225) NOT NULL, hostel_description VARCHAR(225))");
	
	//Create Room Table
	$create_room_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_rooms (school_id_number VARCHAR(225) NOT NULL, id_number VARCHAR(225) NOT NULL, hostel_id_number VARCHAR(225) NOT NULL, category_number VARCHAR(225) NOT NULL, bed_capacity VARCHAR(225) NOT NULL, room_description VARCHAR(225))");
	
	//Create Room Category Table
	$create_room_category_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_room_list (school_id_number VARCHAR(225) NOT NULL, category_number VARCHAR(225) NOT NULL, room_category VARCHAR(225) NOT NULL)");
	
	//Create Bed Table
	$create_bed_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_beds (school_id_number VARCHAR(225) NOT NULL, id_number VARCHAR(225) NOT NULL, room_id_number VARCHAR(225) NOT NULL, bed_description VARCHAR(225))");
	
	//Create Hall Table
	$create_hall_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_halls (school_id_number VARCHAR(225) NOT NULL, hall_name VARCHAR(225) NOT NULL, hall_numeric_name VARCHAR(225) NOT NULL, hall_capacity VARCHAR(225) NOT NULL, description VARCHAR(225))");
	
	//Create Subject Hall Receipt Table
	$create_subject_hall_receipt_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_subject_hall_receipts (school_id_number VARCHAR(225) NOT NULL, hall_numeric_name VARCHAR(225) NOT NULL, numeric_class_name VARCHAR(225) NOT NULL, term_id_number VARCHAR(225) NOT NULL, session VARCHAR(225) NOT NULL, subject_code VARCHAR(225) NOT NULL, admission_number VARCHAR(225) NOT NULL)");
	
	//Create Notice Table
	$create_notice_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_notices (notice_id int NOT NULL AUTO_INCREMENT, school_id_number VARCHAR(225) NOT NULL, notice_title VARCHAR(225) NOT NULL, notice_comment VARCHAR(225), numeric_class_name VARCHAR(225) NOT NULL, start_date VARCHAR(225) NOT NULL, end_date VARCHAR(225) NOT NULL, notice_for VARCHAR(225) NOT NULL, PRIMARY KEY (notice_id))");
	
	//Create Transport Table
	$create_transport_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_transports (school_id_number VARCHAR(225) NOT NULL, route_name VARCHAR(225) NOT NULL, id_number VARCHAR(225) NOT NULL, reg_number VARCHAR(225) NOT NULL, driver_name VARCHAR(225) NOT NULL, phone_number VARCHAR(225) NOT NULL, home_address VARCHAR(225) NOT NULL, route_fares VARCHAR(225) NOT NULL, description VARCHAR(225))");
	
	//Create Notification Table
	$create_notification_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_notifications (notification_id int NOT NULL AUTO_INCREMENT, school_id_number VARCHAR(225) NOT NULL, numeric_class_name VARCHAR(225) NOT NULL, session VARCHAR(225) NOT NULL, user VARCHAR(225) NOT NULL, title VARCHAR(225) NOT NULL, message VARCHAR(225) NOT NULL, PRIMARY KEY (notification_id))");
	
	//Create Result Table
	$create_result_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_results (school_id_number VARCHAR(225) NOT NULL, numeric_class_name VARCHAR(225) NOT NULL, session VARCHAR(225) NOT NULL, term_id_number VARCHAR(225) NOT NULL, subject_code VARCHAR(225) NOT NULL, admission_number VARCHAR(225) NOT NULL, first_ca VARCHAR(225) NOT NULL, second_ca VARCHAR(225) NOT NULL, third_ca VARCHAR(225) NOT NULL, exam VARCHAR(225) NOT NULL, comment VARCHAR(225) NOT NULL)");
	// mysqli_query($connection_server, "DROP TABLE sm_results");
	
	//Create Result Remark Table
	$create_result_remark_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_result_remarks (school_id_number VARCHAR(225) NOT NULL, numeric_class_name VARCHAR(225) NOT NULL, session VARCHAR(225) NOT NULL, term_id_number VARCHAR(225) NOT NULL, admission_number VARCHAR(225) NOT NULL, principal_remark VARCHAR(225) NOT NULL)");
	// mysqli_query($connection_server, "DROP TABLE sm_result_remarks");
	
	//Create Result List Table
	$create_result_list_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_result_lists (school_id_number VARCHAR(225) NOT NULL, result_ref VARCHAR(225) NOT NULL, numeric_class_name VARCHAR(225) NOT NULL, session VARCHAR(225) NOT NULL, term_id_number VARCHAR(225) NOT NULL, admission_number VARCHAR(225) NOT NULL)");
	// mysqli_query($connection_server, "DROP TABLE sm_result_lists");
	
	//Create Result Release Date Table
	$create_result_release_date_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_result_release_dates (school_id_number VARCHAR(225) NOT NULL, numeric_class_name VARCHAR(225) NOT NULL, session VARCHAR(225) NOT NULL, term_id_number VARCHAR(225) NOT NULL, release_date VARCHAR(225) NOT NULL)");
	
	//Create Grade Table
	$create_grade_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_grades (school_id_number VARCHAR(225) NOT NULL, grade_auto_number int NOT NULL AUTO_INCREMENT, grade_name VARCHAR(225) NOT NULL, mark_from VARCHAR(225) NOT NULL, mark_upto VARCHAR(225) NOT NULL, grade_comment VARCHAR(225), PRIMARY KEY (grade_auto_number))");
	
	//Create Book Category Table
	$create_book_category_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_book_category (school_id_number VARCHAR(225) NOT NULL, id_number VARCHAR(225) NOT NULL, category_name VARCHAR(225) NOT NULL)");
	
	//Create Book Rack Location Name Table
	$create_book_rack_location_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_book_rack_location (school_id_number VARCHAR(225) NOT NULL, id_number VARCHAR(225) NOT NULL, rack_name VARCHAR(225) NOT NULL)");
	
	//Create Book List Table
	$create_book_list_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_book_lists (book_id int NOT NULL AUTO_INCREMENT, school_id_number VARCHAR(225) NOT NULL, isbn VARCHAR(225) NOT NULL, book_category_id VARCHAR(225) NOT NULL, book_name VARCHAR(225) NOT NULL, author_name VARCHAR(225) NOT NULL, rack_location VARCHAR(225) NOT NULL, price VARCHAR(225) NOT NULL, quantity VARCHAR(225) NOT NULL, description VARCHAR(225), PRIMARY KEY (book_id))");
	
	//Create Issue List Table
	$create_issue_list_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_issue_lists (issue_id int NOT NULL AUTO_INCREMENT, school_id_number VARCHAR(225) NOT NULL, numeric_class_name VARCHAR(225) NOT NULL, session VARCHAR(225) NOT NULL, admission_number VARCHAR(225) NOT NULL, issue_date VARCHAR(225) NOT NULL, return_date VARCHAR(225) NOT NULL, book_category_id VARCHAR(225) NOT NULL, book_id_number VARCHAR(225) NOT NULL, PRIMARY KEY (issue_id))");
	
	//Create Fees Payment Gateway Table
	$create_fees_payment_gateway_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_fees_payment_gateway (school_id_number VARCHAR(225) NOT NULL, gateway_name VARCHAR(225) NOT NULL, public_key VARCHAR(225), secret_key VARCHAR(225), encrypt_key VARCHAR(225), status VARCHAR(225))");
	
	//Create Fee Type Table
	$create_fee_type_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_fee_type (school_id_number VARCHAR(225) NOT NULL, id_number VARCHAR(225) NOT NULL, fee_name VARCHAR(225) NOT NULL)");
	
	//Create Fee List Table
	$create_fee_list_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_fee_lists (fee_id int NOT NULL AUTO_INCREMENT, school_id_number VARCHAR(225) NOT NULL, fee_type_id VARCHAR(225) NOT NULL, numeric_class_name VARCHAR(225) NOT NULL, session VARCHAR(225) NOT NULL, amount VARCHAR(225) NOT NULL, description VARCHAR(225), PRIMARY KEY (fee_id))");
	
	//Create Fees Payment List Table
	$create_fee_payment_list_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_fee_payment_lists (fee_payment_id int NOT NULL AUTO_INCREMENT, school_id_number VARCHAR(225) NOT NULL, admission_number VARCHAR(225) NOT NULL, numeric_class_name VARCHAR(225) NOT NULL, session VARCHAR(225) NOT NULL, fee_type_id VARCHAR(225) NOT NULL, online_ref VARCHAR(225), manual_ref VARCHAR(225), amount VARCHAR(225) NOT NULL, amount_paid VARCHAR(225) NOT NULL, starting_year VARCHAR(225) NOT NULL, ending_year VARCHAR(225) NOT NULL, status VARCHAR(225) NOT NULL, description VARCHAR(225), date TIMESTAMP DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY (fee_payment_id))");
	
	//Create Online Pre Fees Payment List Table
	$create_online_pre_fee_payment_list_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_online_pre_fee_payment_lists (school_id_number VARCHAR(225) NOT NULL, fee_type_id VARCHAR(225) NOT NULL, online_ref VARCHAR(225) NOT NULL, admission_number VARCHAR(225) NOT NULL, numeric_class_name VARCHAR(225) NOT NULL, session VARCHAR(225) NOT NULL, amount VARCHAR(225) NOT NULL, amount_paid VARCHAR(225) NOT NULL, date TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
	
	//Create Holiday Table
	$create_holiday_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_holidays (holiday_id int NOT NULL AUTO_INCREMENT, school_id_number VARCHAR(225) NOT NULL, holiday_title VARCHAR(225) NOT NULL, description VARCHAR(225), start_date VARCHAR(225) NOT NULL, end_date VARCHAR(225) NOT NULL, status VARCHAR(225) NOT NULL, PRIMARY KEY (holiday_id))");
	
	//Create Student Attendance Table
	$create_student_attendance_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_student_attendances (school_id_number VARCHAR(225) NOT NULL, numeric_class_name VARCHAR(225) NOT NULL, session VARCHAR(225) NOT NULL, date_taken VARCHAR(225) NOT NULL, admission_number VARCHAR(225) NOT NULL, attendance_remark VARCHAR(225) NOT NULL, comment VARCHAR(225) NOT NULL)");
	
	//Create Teacher Attendance Table
	$create_teacher_attendance_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_teacher_attendances (school_id_number VARCHAR(225) NOT NULL, date_taken VARCHAR(225) NOT NULL, teacher_id_number VARCHAR(225) NOT NULL, attendance_remark VARCHAR(225) NOT NULL, comment VARCHAR(225) NOT NULL)");
	
	//Create Route List Table
	$create_route_list_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_route_lists (school_id_number VARCHAR(225) NOT NULL, numeric_class_name VARCHAR(225) NOT NULL, subject_code VARCHAR(225) NOT NULL, day_code VARCHAR(225) NOT NULL, start_time VARCHAR(225) NOT NULL, end_time VARCHAR(225) NOT NULL)");

	//Alter Route List Table (Add id_number column)
	$result = mysqli_query($connection_server, "SHOW COLUMNS FROM `sm_route_lists` LIKE 'id_number'");
	$exists = (mysqli_num_rows($result)) ? TRUE : FALSE;
	if (!$exists) {
		mysqli_query($connection_server, "ALTER TABLE sm_route_lists ADD id_number INT(225) NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (id_number)");
	}
	
	//Create Exam List Table
	$create_exam_list_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_exam_lists (school_id_number VARCHAR(225) NOT NULL, numeric_class_name VARCHAR(225) NOT NULL, subject_code VARCHAR(225) NOT NULL, day_code VARCHAR(225) NOT NULL, exam_date VARCHAR(225) NOT NULL, start_time VARCHAR(225) NOT NULL, end_time VARCHAR(225) NOT NULL)");
	
	//Create Homework List Table
	$create_homework_list_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_homework_lists (homework_id int NOT NULL AUTO_INCREMENT, school_id_number VARCHAR(225) NOT NULL, title VARCHAR(225) NOT NULL, numeric_class_name VARCHAR(225) NOT NULL, session VARCHAR(225) NOT NULL, subject_code VARCHAR(225) NOT NULL, document_title VARCHAR(225), document_link VARCHAR(225), content LONGTEXT, submission_date VARCHAR(225) NOT NULL, PRIMARY KEY (homework_id))");
	
	//Create Submitted Homework List Table
	$create_submitted_homework_list_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_submitted_homework_lists (school_id_number VARCHAR(225) NOT NULL, homework_id_number VARCHAR(225) NOT NULL, admission_number VARCHAR(225) NOT NULL, document_link VARCHAR(225) NOT NULL, date_submitted VARCHAR(225) NOT NULL)");
	
	//Create CBT Scheldule List Table
	$create_cbt_scheldule_list_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_cbt_scheldule_lists (cbt_id int NOT NULL AUTO_INCREMENT, school_id_number VARCHAR(225) NOT NULL, paper_title VARCHAR(225) NOT NULL, numeric_class_name VARCHAR(225) NOT NULL, session VARCHAR(225) NOT NULL, term_id_number VARCHAR(225) NOT NULL, subject_code VARCHAR(225) NOT NULL, cbt_type VARCHAR(225) NOT NULL, exam_json LONGTEXT, exam_date VARCHAR(225) NOT NULL, exam_time VARCHAR(225) NOT NULL, exam_questions INT NOT NULL, exam_duration VARCHAR(225) NOT NULL, PRIMARY KEY (cbt_id))");
	
	//Alter CBT Schedule List Table
	$result = mysqli_query($connection_server, "SHOW COLUMNS FROM `sm_cbt_scheldule_lists` LIKE 'exam_question_attempts'");
	$exists = (mysqli_num_rows($result)) ? TRUE : FALSE;
	if (!$exists) {
		mysqli_query($connection_server, "ALTER TABLE sm_cbt_scheldule_lists ADD COLUMN exam_question_attempts INT NOT NULL AFTER exam_questions");
	}
	
	//Create Started CBT List Table
	$create_started_cbt_list_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_started_cbt_lists (school_id_number VARCHAR(225) NOT NULL, cbt_id_number VARCHAR(225) NOT NULL, admission_number VARCHAR(225) NOT NULL, date_started TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
	
	//Create Submitted CBT List Table
	$create_submitted_cbt_list_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_submitted_cbt_lists (school_id_number VARCHAR(225) NOT NULL, cbt_id_number VARCHAR(225) NOT NULL, admission_number VARCHAR(225) NOT NULL, date_submitted TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
	
	//Create CBT Activated School Table
	$create_cbt_activated_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_cbt_activated_schools (school_id_number VARCHAR(225) NOT NULL, date_activated TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");
	
	//Create Email Template Table
	$create_email_template_table = mysqli_query($connection_server, "CREATE TABLE IF NOT EXISTS sm_email_templates (school_id_number VARCHAR(225) NOT NULL, template_name VARCHAR(225) NOT NULL, template_title VARCHAR(225) NOT NULL, template_message LONGTEXT NOT NULL)");
	
	
	if(isset($_SESSION["sup_adm_session"])){
		if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_super_moderators WHERE email='".$_SESSION["sup_adm_session"]."'")) == 0){
			unset($_SESSION["sup_adm_session"]);
			header("Location: /bc-login.php");
		}
	}
	
	if(isset($_SESSION["mod_adm_session"])){
		if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".$_SESSION["mod_adm_session"]."'")) == 0){
			unset($_SESSION["mod_adm_session"]);
			header("Location: /bc-login.php");
		}
	}
	
	if(isset($_SESSION["adm_staff_session"])){
		if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_admin_staffs WHERE school_id_number='".$_SESSION["school_id"]."' && id_number='".$_SESSION["adm_staff_session"]."'")) == 0){
			unset($_SESSION["adm_staff_session"]);
			header("Location: /bc-login.php");
		}
	}
	
	if(isset($_SESSION["teacher_session"])){
		if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_teachers WHERE school_id_number='".$_SESSION["school_id"]."' && id_number='".$_SESSION["teacher_session"]."'")) == 0){
			unset($_SESSION["teacher_session"]);
			header("Location: /bc-login.php");
		}
	}
	
	if(isset($_SESSION["stu_par_session"])){
		if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number='".$_SESSION["school_id"]."' && id_number='".$_SESSION["stu_par_session"]."'")) == 0){
			unset($_SESSION["stu_par_session"]);
			header("Location: /bc-login.php");
		}
	}
	
	if(isset($_SESSION["stu_session"])){
		if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='".$_SESSION["school_id"]."' && admission_number='".$_SESSION["stu_session"]."'")) == 0){
			unset($_SESSION["stu_session"]);
			header("Location: /bc-login.php");
		}
	}
	
	
	//mysqli_query($connection_server, "drop TABLE sm_email_templates");
	if(isset($_SESSION["sup_adm_session"])){
		$get_logged_user_details = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_super_moderators WHERE email='".$_SESSION["sup_adm_session"]."'"));
	}
	if(isset($_SESSION["mod_adm_session"])){
		$get_logged_user_details = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='".$_SESSION["mod_adm_session"]."'"));
		
		$check_if_flutterwave_row_exists = mysqli_query($connection_server, "SELECT * FROM sm_fees_payment_gateway WHERE school_id_number='".$get_logged_user_details["school_id_number"]."' && gateway_name='flutterwave'");
		if(mysqli_num_rows($check_if_flutterwave_row_exists) == 0){
			$insert_flutterwave_row = mysqli_query($connection_server, "INSERT INTO sm_fees_payment_gateway (school_id_number, gateway_name, status) VALUES ('".$get_logged_user_details["school_id_number"]."', 'flutterwave', '0')");
		}
	}
	if(isset($_SESSION["adm_staff_session"])){
		$get_logged_user_details = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_admin_staffs WHERE school_id_number='".$_SESSION["school_id"]."' && id_number='".$_SESSION["adm_staff_session"]."'"));
	}
	if(isset($_SESSION["teacher_session"])){
		$get_logged_user_details = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_teachers WHERE school_id_number='".$_SESSION["school_id"]."' && id_number='".$_SESSION["teacher_session"]."'"));
	}
	if(isset($_SESSION["stu_par_session"])){
		$get_logged_user_details = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number='".$_SESSION["school_id"]."' && id_number='".$_SESSION["stu_par_session"]."'"));
	}
	if(isset($_SESSION["stu_session"])){
		$get_logged_user_details = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='".$_SESSION["school_id"]."' && admission_number='".$_SESSION["stu_session"]."'"));
	}
	
	function checkIfEmpty($text){
		if(!empty(trim($text))){
			return $text;
		}else{
			return "N/A";
		}
	}
	
	function formDate($date_time){
        $exp_date_time = array_filter(explode(" ",trim($date_time)));
        $date = $exp_date_time[0];
        $time = $exp_date_time[1];
        
        $month = array("01"=>"January","02"=>"Febuary","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December");
        $exp_date = explode("-",trim($date));
        $post_date = $month[$exp_date[1]].", ".$exp_date[2]." ".$exp_date[0];
        $exp_time = explode(":",trim($time));
        if($exp_time[0] > 12){
            $hour = ($exp_time[0]-12);
            $period = "pm";
        }else{
            $hour = $exp_time[0];
            $period = "am";
        }
        $min = $exp_time[1];
    
        return $post_date." ".$hour.":".$min.$period;
    
    }

	function formDateWithoutTime($date){
        
        $month = array("01"=>"January","02"=>"Febuary","03"=>"March","04"=>"April","05"=>"May","06"=>"June","07"=>"July","08"=>"August","09"=>"September","10"=>"October","11"=>"November","12"=>"December");
        $exp_date = explode("-",trim($date));
        $post_date = $month[$exp_date[1]]." ".$exp_date[2].", ".$exp_date[0];
        
        return $post_date;
    
    }

	function timeFrame($time){
		$exp_time = array_filter(explode(":",trim($time)));
		$hr = $exp_time[0];
        $min = $exp_time[1];

		if(in_array($hr,range(0,11))){
			return $hr.":".$min."am";
		}
		if(in_array($hr,range(12,24))){
			return ($hr-12).":".$min."pm";
		}
	}

	if(!is_dir("homework/")){
		mkdir("homework/", 0777);
	}

	function emailTemplateTableExist($template_name, $type, $mode){
		global $connection_server;
		global $get_logged_user_details;
		if($mode == "verify"){
			$count_template = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_email_templates WHERE school_id_number='".$get_logged_user_details["school_id_number"]."' && template_name='$template_name'"));

			if($count_template >= 1){
				return true;
			}else{
				return false;
			}
		}

		if(($mode == "data") && (!empty(trim($type)))){
			if($type == "title"){
				$tem_type = "template_title";
			}

			if($type == "message"){
				$tem_type = "template_message";
			}
			$template_detail = mysqli_query($connection_server, "SELECT * FROM sm_email_templates WHERE school_id_number='".$get_logged_user_details["school_id_number"]."' && template_name='$template_name'");

			if(mysqli_num_rows($template_detail) == 1){
				return mysqli_fetch_array($template_detail)[$tem_type];
			}else{
				if(mysqli_num_rows($template_detail) > 1){
					return "Data is more than one";
				}else{
					return "Data is not available";
				}
			}
		}

	}
	
	if(emailTemplateTableExist('student-reg','','verify') == false){
		mysqli_query($connection_server, "INSERT INTO sm_email_templates (school_id_number, template_name, template_title, template_message) VALUES ('".$get_logged_user_details["school_id_number"]."', 'student-reg', 'Student Registration', 'Hello {{student_name}} ,\n\nYour registration has been successful with {{school_name}}. You can now access your account. \n\nUser Name : {{user_name}}\nClass Name : {{class_name}}\nEmail : {{email}}\n\n\nRegards From {{school_name}}.')");
	}
	if(emailTemplateTableExist('add-user','','verify') == false){
		mysqli_query($connection_server, "INSERT INTO sm_email_templates (school_id_number, template_name, template_title, template_message) VALUES ('".$get_logged_user_details["school_id_number"]."', 'add-user', 'Your have been assigned role of {{role}} in {{school_name}}.', 'Dear {{user_name}},\n\n         You are Added by admin in {{school_name}} . Your have been assigned role of {{role}} in {{school_name}}.  You can sign in using this link. {{login_link}}\n\nUserName : {{username}}\nPassword : {{password}}\n\nRegards From {{school_name}}.')");
	}
	if(emailTemplateTableExist('fees-alert','','verify') == false){
		mysqli_query($connection_server, "INSERT INTO sm_email_templates (school_id_number, template_name, template_title, template_message) VALUES ('".$get_logged_user_details["school_id_number"]."', 'fees-alert', 'Fees Alert', 'Dear {{parent_name}},\n\n        You have a new invoice.  You can check the invoice on your portal.\n.')");
	}
	if(emailTemplateTableExist('student-assign-teacher','','verify') == false){
		mysqli_query($connection_server, "INSERT INTO sm_email_templates (school_id_number, template_name, template_title, template_message) VALUES ('".$get_logged_user_details["school_id_number"]."', 'student-assign-teacher', 'New Student has been assigned to you.', 'Dear {{teacher_name}},\n\n         New Student {{student_name}} has been assigned to you.\n \nRegards From {{school_name}}.')");
	}
	if(emailTemplateTableExist('student-assigned-teacher','','verify') == false){
		mysqli_query($connection_server, "INSERT INTO sm_email_templates (school_id_number, template_name, template_title, template_message) VALUES ('".$get_logged_user_details["school_id_number"]."', 'student-assigned-teacher', 'You have been Assigned {{teacher_name}} at {{school_name}}', 'Dear {{student_name}},\n\n         You are assigned to  {{teacher_name}}. {{teacher_name}} belongs to {{class_name}}.\n \nRegards From {{school_name}}.')");
	}
	if(emailTemplateTableExist('attendance-absent','','verify') == false){
		mysqli_query($connection_server, "INSERT INTO sm_email_templates (school_id_number, template_name, template_title, template_message) VALUES ('".$get_logged_user_details["school_id_number"]."', 'attendance-absent', 'Your Child {{child_name}} is absent today', 'Your Child {{child_name}} is absent today.\n\nRegards From {{school_name}}.')");
	}
	if(emailTemplateTableExist('payment-invoice','','verify') == false){
		mysqli_query($connection_server, "INSERT INTO sm_email_templates (school_id_number, template_name, template_title, template_message) VALUES ('".$get_logged_user_details["school_id_number"]."', 'payment-invoice', 'Payment Received against Invoice', 'Dear {{student_name}},\n\n        Your have successfully paid your invoice {{invoice_no}}. You can check the invoice receipt on your portal.\n \nRegards From {{school_name}}.')");
	}
	if(emailTemplateTableExist('notice','','verify') == false){
		mysqli_query($connection_server, "INSERT INTO sm_email_templates (school_id_number, template_name, template_title, template_message) VALUES ('".$get_logged_user_details["school_id_number"]."', 'notice', 'New Notice For You', 'New Notice For You.\n\nNotice Title : {{notice_title}}\n\nNotice Date  : {{notice_date}}\n\nNotice For  : {{notice_for}}\n\nNotice Comment :  {{notice_comment}}\n\nRegards From {{school_name}}\n')");
	}
	if(emailTemplateTableExist('holiday','','verify') == false){
		mysqli_query($connection_server, "INSERT INTO sm_email_templates (school_id_number, template_name, template_title, template_message) VALUES ('".$get_logged_user_details["school_id_number"]."', 'holiday', 'Holiday Announcement', 'Holiday Announcement\n\nHoliday Title : {{holiday_title}}\n\nHoliday Date : {{holiday_date}}\n\nRegards From {{school_name}}\n')");
	}
	if(emailTemplateTableExist('school-bus','','verify') == false){
		mysqli_query($connection_server, "INSERT INTO sm_email_templates (school_id_number, template_name, template_title, template_message) VALUES ('".$get_logged_user_details["school_id_number"]."', 'school-bus', 'School Bus Allocation', 'School Bus Allocation\n	\n	Route Name : {{route_name}}\n	\n	Vehicle Identifier : {{vehicle_identifier}}\n	\n	Vehicle Registration Number : {{vehicle_registration_number}}\n	\n	Driver Name : {{driver_name}}\n	\n	Driver Phone Number : {{driver_phone_number}}\n	\n	Driver Address : {{driver_address}}\n	\n	Route Fare  : {{route_fare}}\n	\n	Regards From {{school_name}}\n\n')");
	}
	if(emailTemplateTableExist('hostel-bed','','verify') == false){
		mysqli_query($connection_server, "INSERT INTO sm_email_templates (school_id_number, template_name, template_title, template_message) VALUES ('".$get_logged_user_details["school_id_number"]."', 'hostel-bed', 'Hostel Bed Assigned', 'Hello {{student_name}} ,\n\n		You have been assigned new hostel bed in {{school_name}}.\n\nHostel Name : {{hostel_name}}\nRoom Number : {{room_id}}\nBed Number : {{bed_id}}\n\nRegards From {{school_name}}.')");
	}
	if(emailTemplateTableExist('subject-assigned','','verify') == false){
		mysqli_query($connection_server, "INSERT INTO sm_email_templates (school_id_number, template_name, template_title, template_message) VALUES ('".$get_logged_user_details["school_id_number"]."', 'subject-assigned', 'New subject has been assigned to you', 'Dear {{teacher_name}},\n\nNew subject {{subject_name}} has been assigned to you.\n\nRegards From \n{{school_name}}')");
	}
	if(emailTemplateTableExist('issue-book','','verify') == false){
		mysqli_query($connection_server, "INSERT INTO sm_email_templates (school_id_number, template_name, template_title, template_message) VALUES ('".$get_logged_user_details["school_id_number"]."', 'issue-book', 'New book has been issue to you', 'Dear {{student_name}},\n\nNew book {{book_name}} has been issue to you.\n\nRegards From \n{{school_name}}')");
	}
	
	include("./email-design.php");
	
?>
