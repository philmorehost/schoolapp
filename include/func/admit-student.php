<?php
	
	$err_msg = "";
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: Student with same details already exists in database";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: Student details already exists in database";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "4"){
		$err_msg .= "Error: Duplicate class exists";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "5"){
		$err_msg .= "Error: Student Class Capacity have been exceeded, increase class capacity limit! ";
	}
	
	
	$header_add_button = "add_student";
	$additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
	$header_view_button = "view_student";
	$additional_back_tag .= "&id=".$get_logged_user_details['school_id_number'];
	
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
	$page_list_number_link = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"])).$additional_add_tag.$prev_next."&search=".$search_text."&pnum=";
	$page_prevnext_link = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"])).$additional_add_tag."&search=".$search_text."&pnum=".$page_pnum;
	
	$chopped_search_text_array = array_filter(explode(" ",trim($search_text)));
	foreach($chopped_search_text_array as $search_items){
		$search_sqli_statement .= "email LIKE '%".$search_items."%'"."\n"."parent_id_number LIKE '%".$search_items."%'"."\n"."phone_number LIKE '%".$search_items."%'"."\n"."lastname LIKE '%".$search_items."%'"."\n"."firstname LIKE '%".$search_items."%'"."\n"."othername LIKE '%".$search_items."%'"."\n"."gender LIKE '%".$search_items."%'"."\n"."dob LIKE '%".str_replace(["/","-"],"-",$search_items)."%'"."\n"."blood_group LIKE '%".$search_items."%'"."\n"."home_address LIKE '%".$search_items."%'"."\n"."city LIKE '%".$search_items."%'"."\n"."lga LIKE '%".$search_items."%'"."\n"."origin_state LIKE '%".$search_items."%'"."\n"."resident_state LIKE '%".$search_items."%'"."\n"."origin_country LIKE '%".$search_items."%'"."\n"."resident_country LIKE '%".$search_items."%'"."\n"."admission_year LIKE '%".$search_items."%'"."\n"."admission_number LIKE '%".$search_items."%'"."\n"."current_class LIKE '%".$search_items."%'"."\n"."previous_school LIKE '%".$search_items."%'"."\n"."previous_class LIKE '%".$search_items."%'"."\n"."session LIKE '%".str_replace(["/","-"],"-",$search_items)."%'"."\n"."bus_id_number LIKE '%".$search_items."%'"."\n"."bed_id_number LIKE '%".$search_items."%'";
	
	}
	
	$search_sqli_statements .= "(".str_replace("\n"," && school_id_number=".$get_logged_user_details['school_id_number'].") OR (", trim($search_sqli_statement))." && school_id_number=".$get_logged_user_details['school_id_number'].")";
	
	if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
		$select_student_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE $search_sqli_statements LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_student_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE $search_sqli_statements");
	}else{
		$select_student_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='".trim(strip_tags($_GET['id']))."' LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_student_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
	}
	
	if(isset($_POST["add-student"])){
		$last = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["first"])));
		$first = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["last"])));
		$other = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["other"])));
		$gender = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["gender"])));
		$dob = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["dob"])));
		$blood_group = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["blood-group"])));
		$res_address = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["res-address"])));
		$city = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["city"])));
		$lga = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["lga"])));
		$res_state = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["res-state"])));
		$ori_state = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["ori-state"])));
		$res_country = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["res-country"])));
		$ori_country = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["ori-country"])));
		$phone = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["phone"])));
		$email = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email"])));
		$admission_year = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["admission-year"])));
		$parent_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["parent_id"])));
		$class_session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class"])));
		$class = array_filter(explode(" ",trim($class_session)))[0];
		$session = array_filter(explode(" ",trim($class_session)))[1];
		$prev_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["prev-class"])));
		$prev_sch = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["prev-sch"])));
		/*$bed = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["bed"])));*/
		$bus = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["bus"])));
		$class_category = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class-category"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		// $all_student_num_count = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$school_id' && numeric_class_name='$class' && session='$session'"));
		// $check_last_student = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$school_id' && numeric_class_name='$class' && session='$session' LIMIT 1 OFFSET ".($all_student_num_count-1)));
		// $admission_no = date('y').sprintf("%03d",((substr($check_last_student["admission_number"],2)) + 1));
		
		$all_existing_user_num_count = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$school_id'");
		if(mysqli_num_rows($all_existing_user_num_count) > 0){
			while($each_user_id_number = mysqli_fetch_array($all_existing_user_num_count)){
				if(date("y") === substr($each_user_id_number["admission_number"],0,2)){
					$last_user_id_number .= substr($each_user_id_number["admission_number"],2).",";
				}
			}
			$admission_no = date("y").(sprintf("%04d",(max(array_filter(explode(",",trim($last_user_id_number)))))+1));
		}else{
			$admission_no = date("y").(sprintf("%04d",1));
		}
		
		$password = md5(mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["password"]))));
		
		if(!empty($last) && !empty($first) && !empty($class) && !empty($class_category) && is_numeric($class_category) && !empty($session) && !empty($gender) && !empty($dob) && !empty($parent_id) && !empty($res_address) && !empty($city) && !empty($res_state) && !empty($ori_state) && !empty($res_country) && !empty($ori_country) && !empty($phone) && !empty($email) && !empty($password) && !empty($admission_year) && !empty($admission_no) && !empty($school_id)){
			$search_student_capacity = mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE (school_id_number='$school_id' && numeric_class_name='$class' && session='$session')");
			if(mysqli_num_rows($search_student_capacity) == 1){
				$count_students_in_class = mysqli_query($connection_server, "SELECT * FROM sm_class_list WHERE (school_id_number='$school_id' && numeric_class_name='$class' && session='$session')");
				$student_capacity_detail = mysqli_fetch_array($search_student_capacity);
				if($student_capacity_detail["student_capacity"] > mysqli_num_rows($count_students_in_class)){
					if(mysqli_query($connection_server, "INSERT INTO sm_students (email, password, school_id_number, parent_id_number, phone_number, lastname, firstname, othername, gender, dob, blood_group, home_address, city, lga, origin_state, resident_state, origin_country, resident_country, admission_year, admission_number, current_class, numeric_class_category_name, previous_school, previous_class, session, bus_id_number) VALUES ('$email','$password','$school_id','$parent_id','$phone','$last','$first','$other','$gender','$dob','$blood_group','$res_address','$city','$lga','$ori_state','$res_state','$ori_country','$res_country','$admission_year','$admission_no','$class','$class_category','$prev_sch','$prev_class','$session','$bed')") == true){
						if(mysqli_query($connection_server, "INSERT INTO sm_class_list (school_id_number, admission_number, numeric_class_name, session) VALUES ('$school_id','$admission_no','$class','$session')")){
							

							$get_mail_stu_class_name = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='$school_id' && numeric_class_name='$class' && session='$session' LIMIT 1"));
							$get_mail_sch_name = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='$school_id' LIMIT 1"));
							$get_mail_transport = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_transports WHERE school_id_number='$school_id' && id_number='$bus' LIMIT 1"));
							
							// Always set content-type when sending HTML email
							$mail_headers = "MIME-Version: 1.0" . "\r\n";
							$mail_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
							
							// More headers
							$mail_headers .= 'From: <'.$get_mail_sch_name["email"].'>' . "\r\n";
							$mail_headers .= 'Cc: '.$get_mail_sch_name["email"]."\r\n";
							
							$email_title = 
							str_replace("{{student_name}}",$last." ".$first." ".$other,
								str_replace("{{user_name}}","ST/".$school_id."/".$admission_no,
									str_replace("{{class_name}}",$get_mail_stu_class_name["class_name"],
										str_replace("{{email}}",$email,
											str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
												emailTemplateTableExist('student-reg','title','data')
											)
										)
									)
								)
							);
							
							$email_message = 
							mailDesignTemplate($email_title,
							str_replace("{{student_name}}",$last." ".$first." ".$other,
								str_replace("{{user_name}}","ST/".$school_id."/".$admission_no,
									str_replace("{{class_name}}",$get_mail_stu_class_name["class_name"],
										str_replace("{{email}}",$email,
											str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
												emailTemplateTableExist('student-reg','message','data')
											)
										)
									)
								)
							),'');
							customBCMailSender('',$email,$email_title,$email_message,$mail_headers);
							
							$sel_teacher_query = mysqli_query($connection_server, "SELECT * FROM sm_teachers WHERE school_id_number='$school_id'");
							if(mysqli_num_rows($sel_teacher_query) > 0){
								while($teachers_detail = mysqli_fetch_array($sel_teacher_query)){
									if(in_array($class,array_filter(explode("\n",trim($teachers_detail["class"]))))){
										$eteacher_email .= $teachers_detail["email"]."\n";
										$eteacher_ids .= $teachers_detail["id_number"]."\n";
										$eteacher_name .= $teachers_detail["lastname"]." ".$teachers_detail["firstname"]."\n";
									}
								}
							}
							
							$eteacher_email_exp = array_filter(explode("\n",trim($eteacher_email)));
							$eteacher_ids_exp = array_filter(explode("\n",trim($eteacher_ids)));
							$eteacher_name_exp = array_filter(explode("\n",trim($eteacher_name)));
							
							foreach($eteacher_email_exp as $index => $temail){
							$email_title_2 = 
							str_replace("{{student_name}}",$last." ".$first." ".$other,
								str_replace("{{teacher_name}}",$eteacher_name_exp[$index],
									str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
										emailTemplateTableExist('student-assign-teacher','title','data')
									)
								)
							);
							
							$email_message_2 = 
							mailDesignTemplate($email_title_2,
							str_replace("{{student_name}}",$last." ".$first." ".$other,
								str_replace("{{teacher_name}}",$eteacher_name_exp[$index],
									str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
										emailTemplateTableExist('student-assign-teacher','message','data')
									)
								)
							),'');
							customBCMailSender('',$eteacher_email_exp[$index],$email_title_2,$email_message_2,$mail_headers);
							
							}
							
							if(!empty(trim($bus))){
							$email_title_3 = 
							str_replace("{{route_name}}",$get_mail_transport["route_name"],
								str_replace("{{vehicle_identifier}}",$get_mail_transport["id_number"],
									str_replace("{{vehicle_registration_number}}",$get_mail_transport["reg_number"],
										str_replace("{{driver_name}}",$get_mail_transport["driver_name"],
											str_replace("{{driver_phone_number}}",$get_mail_transport["phone_number"],
												str_replace("{{driver_address}}",$get_mail_transport["home_address"],
													str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
														str_replace("{{route_fare}}",$get_mail_transport["route_fares"],
															emailTemplateTableExist('school-bus','title','data')
														)
													)
												)
											)
										)
									)
								)
							);
							
							$email_message_3 = 
							mailDesignTemplate($email_title_3,
							str_replace("{{route_name}}",$get_mail_transport["route_name"],
								str_replace("{{vehicle_identifier}}",$get_mail_transport["id_number"],
									str_replace("{{vehicle_registration_number}}",$get_mail_transport["reg_number"],
										str_replace("{{driver_name}}",$get_mail_transport["driver_name"],
											str_replace("{{driver_phone_number}}",$get_mail_transport["phone_number"],
												str_replace("{{driver_address}}",$get_mail_transport["home_address"],
													str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
														str_replace("{{route_fare}}",$get_mail_transport["route_fares"],
															emailTemplateTableExist('school-bus','message','data')
														)
													)
												)
											)
										)
									)
								)
							),'');
							customBCMailSender('',$email,$email_title_3,$email_message_3,$mail_headers);
							}
							
							if(file_exists("dataimg/student_".$school_id."_".$admission_no.".png")){
								unlink("dataimg/student_".$school_id."_".$admission_no.".png");
								$photo_tmp_name = $_FILES["photo"]["tmp_name"];
								move_uploaded_file($photo_tmp_name,"dataimg/student_".$school_id."_".$admission_no.".png");
							}else{
								$photo_tmp_name = $_FILES["photo"]["tmp_name"];
								move_uploaded_file($photo_tmp_name,"dataimg/student_".$school_id."_".$admission_no.".png");
							}
							
							if((strip_tags($_GET['page']) == 'smgt_student') && (strip_tags($_GET['tab']) == 'add_student')){
								$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=true".$additional_back_tag;
							}
							
							if((strip_tags($_GET['page']) == 'smgt_parent_student') && (strip_tags($_GET['tab']) == 'student_reg')){
								$redirect_url = "/bc-admin.php?page=smgt_student&tab=true&id=".$school_id;
							}
						}
					}
				}else{
					$redirect_url = $_SERVER["REQUEST_URI"]."&err=5";
				}
			}else{
				$redirect_url = $_SERVER["REQUEST_URI"]."&err=4";
			}
			
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["update-student"])){
		$last = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["first"])));
		$first = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["last"])));
		$other = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["other"])));
		$gender = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["gender"])));
		$dob = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["dob"])));
		$blood_group = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["blood-group"])));
		$res_address = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["res-address"])));
		$city = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["city"])));
		$lga = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["lga"])));
		$res_state = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["res-state"])));
		$ori_state = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["ori-state"])));
		$res_country = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["res-country"])));
		$ori_country = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["ori-country"])));
		$phone = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["phone"])));
		$email = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email"])));
		$admission_year = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["admission-year"])));
		$parent_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["parent_id"])));
		$class_session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class"])));
		$class = trim(array_filter(explode(" ",trim($class_session)))[0]);
		$session = trim(array_filter(explode(" ",trim($class_session)))[1]);
		$prev_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["prev-class"])));
		$prev_sch = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["prev-sch"])));
		/*$bed = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["bed"])));*/
		$bus = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["bus"])));
		
		$class_category = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class-category"])));
		$password = md5(mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["password"]))));
		$school_id = $get_logged_user_details["school_id_number"];
		
		$current_account_id_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["edit"])));
		
		$search_student_with_id_email_phone = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE (school_id_number='$school_id' && admission_number='$current_account_id_number')");
		
		if(!empty($last) && !empty($first) && !empty($class) && !empty($class_category) && is_numeric($class_category) && !empty($session) && !empty($gender) && !empty($dob) && !empty($parent_id) && !empty($res_address) && !empty($city) && !empty($res_state) && !empty($ori_state) && !empty($res_country) && !empty($ori_country) && !empty($phone) && !empty($email) && !empty($password) && !empty($admission_year) && !empty($school_id)){
			if(mysqli_num_rows($search_student_with_id_email_phone) == 1){
				while($student_detail = mysqli_fetch_array($search_student_with_id_email_phone)){
				if(mysqli_query($connection_server, "UPDATE sm_students SET email='$email', password='$password', school_id_number='$school_id', parent_id_number='$parent_id', phone_number='$phone', lastname='$last', firstname='$first', othername='$other', gender='$gender', dob='$dob', blood_group='$blood_group', home_address='$res_address', city='$city', lga='$lga', origin_state='$ori_state', resident_state='$res_state', origin_country='$ori_country', resident_country='$res_country', admission_year='$admission_year', current_class='$class', numeric_class_category_name='$class_category', previous_school='$prev_sch', previous_class='$prev_class', session='$session', bus_id_number='$bus' WHERE (school_id_number='$school_id' && admission_number='$current_account_id_number')") == true){
					if(mysqli_query($connection_server, "UPDATE sm_class_list SET school_id_number='$school_id', numeric_class_name='$class', session='$session' WHERE (school_id_number='$school_id' && admission_number='".$student_detail["admission_number"]."' && numeric_class_name='".$student_detail["current_class"]."' && session='".$student_detail["session"]."')") == true){
						
					$get_mail_stu_class_name = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_classes WHERE school_id_number='$school_id' && numeric_class_name='$class' && session='$session' LIMIT 1"));
					$get_mail_sch_name = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='$school_id' LIMIT 1"));
					$get_mail_transport = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_transports WHERE school_id_number='$school_id' && id_number='$bus' LIMIT 1"));
					
					// Always set content-type when sending HTML email
					$mail_headers = "MIME-Version: 1.0" . "\r\n";
					$mail_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					
					// More headers
					$mail_headers .= 'From: <'.$get_mail_sch_name["email"].'>' . "\r\n";
					$mail_headers .= 'Cc: '.$get_mail_sch_name["email"]."\r\n";
					
					$email_title = 
					str_replace("{{student_name}}",$last." ".$first." ".$other,
						str_replace("{{user_name}}","ST/".$school_id."/".$current_account_id_number,
							str_replace("{{class_name}}",$get_mail_stu_class_name["class_name"],
								str_replace("{{email}}",$email,
									str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
										emailTemplateTableExist('student-reg','title','data')
									)
								)
							)
						)
					);
					
					$email_message = 
					mailDesignTemplate($email_title,
					str_replace("{{student_name}}",$last." ".$first." ".$other,
						str_replace("{{user_name}}","ST/".$school_id."/".$admission_no,
							str_replace("{{class_name}}",$get_mail_stu_class_name["class_name"],
								str_replace("{{email}}",$email,
									str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
										emailTemplateTableExist('student-reg','message','data')
									)
								)
							)
						)
					),'');
					customBCMailSender('',$email,"UPDATED: ".$email_title,$email_message,$mail_headers);
					
					$sel_teacher_query = mysqli_query($connection_server, "SELECT * FROM sm_teachers WHERE school_id_number='$school_id'");
					if(mysqli_num_rows($sel_teacher_query) > 0){
						while($teachers_detail = mysqli_fetch_array($sel_teacher_query)){
							if(in_array($class,array_filter(explode("\n",trim($teachers_detail["class"]))))){
								$eteacher_email .= $teachers_detail["email"]."\n";
								$eteacher_ids .= $teachers_detail["id_number"]."\n";
								$eteacher_name .= $teachers_detail["lastname"]." ".$teachers_detail["firstname"]."\n";
							}
						}
					}
					
					$eteacher_email_exp = array_filter(explode("\n",trim($eteacher_email)));
					$eteacher_ids_exp = array_filter(explode("\n",trim($eteacher_ids)));
					$eteacher_name_exp = array_filter(explode("\n",trim($eteacher_name)));
					
					foreach($eteacher_email_exp as $index => $temail){
					$email_title_2 = 
					str_replace("{{student_name}}",$last." ".$first." ".$other,
						str_replace("{{teacher_name}}",$eteacher_name_exp[$index],
							str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
								emailTemplateTableExist('student-assign-teacher','title','data')
							)
						)
					);
					
					$email_message_2 = 
					mailDesignTemplate($email_title_2,
					str_replace("{{student_name}}",$last." ".$first." ".$other,
						str_replace("{{teacher_name}}",$eteacher_name_exp[$index],
							str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
								emailTemplateTableExist('student-assign-teacher','message','data')
							)
						)
					),'');
					customBCMailSender('',$eteacher_email_exp[$index],"UPDATED: ".$email_title_2,$email_message_2,$mail_headers);
					
					}
					
					if(!empty(trim($bus))){
					$email_title_3 = 
					str_replace("{{route_name}}",$get_mail_transport["route_name"],
						str_replace("{{vehicle_identifier}}",$get_mail_transport["id_number"],
							str_replace("{{vehicle_registration_number}}",$get_mail_transport["reg_number"],
								str_replace("{{driver_name}}",$get_mail_transport["driver_name"],
									str_replace("{{driver_phone_number}}",$get_mail_transport["phone_number"],
										str_replace("{{driver_address}}",$get_mail_transport["home_address"],
											str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
												str_replace("{{route_fare}}",$get_mail_transport["route_fares"],
													emailTemplateTableExist('school-bus','title','data')
												)
											)
										)
									)
								)
							)
						)
					);
					
					$email_message_3 = 
					mailDesignTemplate($email_title_3,
					str_replace("{{route_name}}",$get_mail_transport["route_name"],
						str_replace("{{vehicle_identifier}}",$get_mail_transport["id_number"],
							str_replace("{{vehicle_registration_number}}",$get_mail_transport["reg_number"],
								str_replace("{{driver_name}}",$get_mail_transport["driver_name"],
									str_replace("{{driver_phone_number}}",$get_mail_transport["phone_number"],
										str_replace("{{driver_address}}",$get_mail_transport["home_address"],
											str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
												str_replace("{{route_fare}}",$get_mail_transport["route_fares"],
													emailTemplateTableExist('school-bus','message','data')
												)
											)
										)
									)
								)
							)
						)
					),'');
					customBCMailSender('',$email,"UPDATED: ".$email_title_3,$email_message_3,$mail_headers);
					}
						if(!empty($_FILES["photo"]["tmp_name"])){
							if(file_exists("dataimg/student_".$school_id."_".$current_account_id_number.".png")){
								unlink("dataimg/student_".$school_id."_".$current_account_id_number.".png");
								$photo_tmp_name = $_FILES["photo"]["tmp_name"];
								move_uploaded_file($photo_tmp_name,"dataimg/student_".$school_id."_".$current_account_id_number.".png");
							}else{
								$photo_tmp_name = $_FILES["photo"]["tmp_name"];
								move_uploaded_file($photo_tmp_name,"dataimg/student_".$school_id."_".$current_account_id_number.".png");
							}
						}
						$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=true".$additional_back_tag;
					}
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
	
	if(isset($_POST["delete-student"])){
		$student_id = $_POST["student_id"];
		$school_id = $_POST["school_id"];
		foreach($student_id as $index => $student_id_no){
			$student = mysqli_real_escape_string($connection_server, $student_id[$index]);
			$sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
			
			$search_student_with_id_email_phone = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE (school_id_number='$sch_id_number' && admission_number='$student')");
			if(mysqli_num_rows($search_student_with_id_email_phone) == 1){
				while($student_detail = mysqli_fetch_array($search_student_with_id_email_phone)){
					$delete_student_selected_class_list = mysqli_query($connection_server, "DELETE FROM sm_class_list WHERE (school_id_number='$sch_id_number' && admission_number='".$student_detail["admission_number"]."')");
				}
			}
		
			$delete_student_detail_1 = mysqli_query($connection_server, "DELETE FROM sm_students WHERE (school_id_number='$sch_id_number' && admission_number='$student')");
			$delete_student_detail_2 = mysqli_query($connection_server, "DELETE FROM sm_submitted_homework_lists WHERE (school_id_number='$sch_id_number' && admission_number='$student')");
			$delete_student_detail_3 = mysqli_query($connection_server, "DELETE FROM sm_subject_hall_receipts WHERE (school_id_number='$sch_id_number' && admission_number='$student')");
			$delete_student_detail_4 = mysqli_query($connection_server, "DELETE FROM sm_results WHERE (school_id_number='$sch_id_number' && admission_number='$student')");
			$delete_student_detail_5 = mysqli_query($connection_server, "DELETE FROM sm_result_lists WHERE (school_id_number='$sch_id_number' && admission_number='$student')");
			$delete_student_detail_6 = mysqli_query($connection_server, "DELETE FROM sm_issue_lists WHERE (school_id_number='$sch_id_number' && admission_number='$student')");
			$delete_student_detail_7 = mysqli_query($connection_server, "DELETE FROM sm_fee_payment_lists WHERE (school_id_number='$sch_id_number' && admission_number='$student')");
			$delete_student_detail_8 = mysqli_query($connection_server, "DELETE FROM sm_online_pre_fee_payment_lists WHERE (school_id_number='$sch_id_number' && admission_number='$student')");
			$delete_student_detail_9 = mysqli_query($connection_server, "DELETE FROM sm_student_attendances WHERE (school_id_number='$sch_id_number' && admission_number='$student')");
			
		}
				
		$redirect_url = $_SERVER["REQUEST_URI"];
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["search-item"])){
		$search_item_text = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["search-item"])));
		
		$page_to_go_link = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"])).$additional_add_tag."&search=".$search_item_text."&pnum=".$page_pnum;
		header("Location: ".$page_to_go_link);
	}
?>