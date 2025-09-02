<?php
	
	$err_msg = "";
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: Subject with same details already exists in database";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: Subject details already exists in database";
	}

	$header_add_button = "add_subject";
	$additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
	//$header_view_button = "view_class";
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
		$search_sqli_statement .= "subject_name LIKE '%".$search_items."%'"."\n"." subject_code LIKE '%".$search_items."%'"."\n"." teacher_id_number LIKE '%".$search_items."%'"."\n"." numeric_class_name LIKE '%".$search_items."%'"."\n"." session LIKE '%".str_replace(["/","-"],"-",$search_items)."%'";
	
	}
	
	$search_sqli_statements .= "(".str_replace("\n"," && school_id_number=".$get_logged_user_details['school_id_number'].") OR (", trim($search_sqli_statement))." && school_id_number=".$get_logged_user_details['school_id_number'].")";
	
	if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
		$select_subject_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_subjects WHERE $search_sqli_statements ".$user_class_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_subject_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_subjects WHERE $search_sqli_statements ".$user_class_statement_auth);
	}else{
		$select_subject_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_subjects WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_subject_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_subjects WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth);
	}
	
	if(isset($_POST["add-subject"])){
		$code = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["code"])));
		$subject = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["name"])));
		$class_session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class"])));
		$class = array_filter(explode(" ",trim($class_session)))[0];
		$session = array_filter(explode(" ",trim($class_session)))[1];
		$school_id = $get_logged_user_details["school_id_number"];
		
		$teacher = $_POST["teacher"];
		foreach($teacher as $index => $teachers){
			$all_teachers .= $teacher[$index]."\n";
		}
		
		$all_selected_teacher = trim($all_teachers);
		
		if(!empty($code) && !empty($subject) && !empty($class) && !empty($session) && ($teacher > 0) && !empty($school_id)){
			if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_subjects WHERE (school_id_number='$school_id' && subject_code='$code')")) == 0){
				if(mysqli_query($connection_server, "INSERT INTO sm_subjects (school_id_number, subject_name, subject_code, teacher_id_number, numeric_class_name, session) VALUES ('$school_id','$subject','$code','$all_selected_teacher','$class','$session')") == true){
					
					$get_mail_sch_name = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='$school_id' LIMIT 1"));
					$sel_teacher_query = mysqli_query($connection_server, "SELECT * FROM sm_teachers WHERE school_id_number='$school_id'");
					
					// Always set content-type when sending HTML email
					$mail_headers = "MIME-Version: 1.0" . "\r\n";
					$mail_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					
					// More headers
					$mail_headers .= 'From: <'.$get_mail_sch_name["email"].'>' . "\r\n";
					$mail_headers .= 'Cc: '.$get_mail_sch_name["email"]."\r\n";
					
					if(mysqli_num_rows($sel_teacher_query) > 0){
						while($teachers_detail = mysqli_fetch_array($sel_teacher_query)){
							if(in_array($class,array_filter(explode("\n",trim($teachers_detail["class"]))))){
								$eteacher_email .= $teachers_detail["email"]."\n";
								$eteacher_ids .= $teachers_detail["id_number"]."\n";
								$eteacher_name .= $teachers_detail["firstname"]." ".$teachers_detail["lastname"]."\n";
							}
						}
					}
					
					$eteacher_email_exp = array_filter(explode("\n",trim($eteacher_email)));
					$eteacher_ids_exp = array_filter(explode("\n",trim($eteacher_ids)));
					$eteacher_name_exp = array_filter(explode("\n",trim($eteacher_name)));
					
					foreach($eteacher_email_exp as $index => $temail){
					$email_title = 
					str_replace("{{teacher_name}}",$eteacher_name_exp[$index],
						str_replace("{{subject_name}}",$subject,
							str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
								emailTemplateTableExist('subject-assigned','title','data')
							)
						)
					);
					
					$email_message = 
					mailDesignTemplate($email_title,
					str_replace("{{teacher_name}}",$eteacher_name_exp[$index],
						str_replace("{{subject_name}}",$subject,
							str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
								emailTemplateTableExist('subject-assigned','message','data')
							)
						)
					),'');
					customBCMailSender('',$eteacher_email_exp[$index],$email_title,$email_message,$mail_headers);
					
					}

					$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=true".$additional_back_tag;
				}
			}else{
				$redirect_url = $_SERVER["REQUEST_URI"]."&err=2";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["update-subject"])){
		$code = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["code"])));
		$subject = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["name"])));
		$class_session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class"])));
		$class = array_filter(explode(" ",trim($class_session)))[0];
		$session = array_filter(explode(" ",trim($class_session)))[1];
		$school_id = $get_logged_user_details["school_id_number"];
		
		$teacher = $_POST["teacher"];
		foreach($teacher as $index => $teachers){
			$all_teachers .= $teacher[$index]."\n";
		}
		
		$all_selected_teacher = trim($all_teachers);

		$current_session = array_filter(explode("_",trim(strip_tags($_GET['edit']))))[0];
		$current_numeric_class_name = array_filter(explode("_",trim(strip_tags($_GET['edit']))))[1];
		$current_subject_code = array_filter(explode("_",trim(strip_tags($_GET['edit']))))[2];

		
		$search_subject_with_id_code_session = mysqli_query($connection_server, "SELECT * FROM sm_subjects WHERE (subject_code='$code' OR subject_code='$current_subject_code' && (numeric_class_name='$current_numeric_class_name' && session='$current_session'))");
		
		if(!empty($code) && !empty($subject) && !empty($class) && !empty($session) && ($teacher > 0) && !empty($school_id)){
			if(mysqli_num_rows($search_subject_with_id_code_session) == 1){
				if(mysqli_query($connection_server, "UPDATE sm_subjects SET subject_name='$subject', subject_code='$code', teacher_id_number='$all_selected_teacher', numeric_class_name='$class', session='$session' WHERE (school_id_number='$school_id' && subject_code='$current_subject_code' && numeric_class_name='$current_numeric_class_name' && session='$current_session')") == true){
					mysqli_query($connection_server, "UPDATE sm_exams SET subject_code='$code' WHERE school_id_number='$school_id' && subject_code='$current_subject_code'");
					mysqli_query($connection_server, "UPDATE sm_subject_hall_receipts SET subject_code='$code' WHERE school_id_number='$school_id' && subject_code='$current_subject_code'");
					mysqli_query($connection_server, "UPDATE sm_results SET subject_code='$code' WHERE school_id_number='$school_id' && subject_code='$current_subject_code'");
					mysqli_query($connection_server, "UPDATE sm_route_lists SET subject_code='$code' WHERE school_id_number='$school_id' && subject_code='$current_subject_code'");
					mysqli_query($connection_server, "UPDATE sm_exam_lists SET subject_code='$code' WHERE school_id_number='$school_id' && subject_code='$current_subject_code'");
					mysqli_query($connection_server, "UPDATE sm_homework_lists SET subject_code='$code' WHERE school_id_number='$school_id' && subject_code='$current_subject_code'");
					
					$get_mail_sch_name = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='$school_id' LIMIT 1"));
					$sel_teacher_query = mysqli_query($connection_server, "SELECT * FROM sm_teachers WHERE school_id_number='$school_id'");
					
					// Always set content-type when sending HTML email
					$mail_headers = "MIME-Version: 1.0" . "\r\n";
					$mail_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					
					// More headers
					$mail_headers .= 'From: <'.$get_mail_sch_name["email"].'>' . "\r\n";
					$mail_headers .= 'Cc: '.$get_mail_sch_name["email"]."\r\n";
					
					if(mysqli_num_rows($sel_teacher_query) > 0){
						while($teachers_detail = mysqli_fetch_array($sel_teacher_query)){
							if(in_array($class,array_filter(explode("\n",trim($teachers_detail["class"]))))){
								$eteacher_email .= $teachers_detail["email"]."\n";
								$eteacher_ids .= $teachers_detail["id_number"]."\n";
								$eteacher_name .= $teachers_detail["firstname"]." ".$teachers_detail["lastname"]."\n";
							}
						}
					}
					
					$eteacher_email_exp = array_filter(explode("\n",trim($eteacher_email)));
					$eteacher_ids_exp = array_filter(explode("\n",trim($eteacher_ids)));
					$eteacher_name_exp = array_filter(explode("\n",trim($eteacher_name)));
					
					foreach($eteacher_email_exp as $index => $temail){
					$email_title = 
					str_replace("{{teacher_name}}",$eteacher_name_exp[$index],
						str_replace("{{subject_name}}",$subject,
							str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
								emailTemplateTableExist('subject-assigned','title','data')
							)
						)
					);
					
					$email_message = 
					mailDesignTemplate($email_title,
					str_replace("{{teacher_name}}",$eteacher_name_exp[$index],
						str_replace("{{subject_name}}",$subject,
							str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
								emailTemplateTableExist('subject-assigned','message','data')
							)
						)
					),'');
					customBCMailSender('',$eteacher_email_exp[$index],"UPDATED: ".$email_title,$email_message,$mail_headers);
					
					}

					$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=true".$additional_back_tag;
				}
			}else{
				$redirect_url = $_SERVER["REQUEST_URI"]."&err=3";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["delete-subject"])){
		$subject_id = $_POST["subject_id"];
		$session_id = $_POST["session_id"];
		$class_id = $_POST["class_id"];
		$school_id = $_POST["school_id"];
		
		foreach($subject_id as $index => $subject_id_no){
			$subject = mysqli_real_escape_string($connection_server, $subject_id[$index]);
			$session = mysqli_real_escape_string($connection_server, $session_id[$index]);
			$class = mysqli_real_escape_string($connection_server, $class_id[$index]);
			$sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
			$delete_school_selected_subject = mysqli_query($connection_server, "DELETE FROM sm_subjects WHERE (school_id_number='$sch_id_number' && session='$session' && numeric_class_name='$class' && subject_code='$subject')");
			mysqli_query($connection_server, "DELETE FROM sm_exams WHERE school_id_number='$sch_id_number' && session='$session' && numeric_class_name='$class' && subject_code='$subject'");
			mysqli_query($connection_server, "DELETE FROM sm_subject_hall_receipts WHERE school_id_number='$sch_id_number' && session='$session' && numeric_class_name='$class' && subject_code='$subject'");
			mysqli_query($connection_server, "DELETE FROM sm_results WHERE school_id_number='$sch_id_number' && session='$session' && numeric_class_name='$class' && subject_code='$subject'");
			mysqli_query($connection_server, "DELETE FROM sm_route_lists WHERE school_id_number='$sch_id_number' && session='$session' && numeric_class_name='$class' && subject_code='$subject'");
			mysqli_query($connection_server, "DELETE FROM sm_exam_lists WHERE school_id_number='$sch_id_number' && session='$session' && numeric_class_name='$class' && subject_code='$subject'");
			mysqli_query($connection_server, "DELETE FROM sm_homework_lists WHERE school_id_number='$sch_id_number' && session='$session' && numeric_class_name='$class' && subject_code='$subject'");
			
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