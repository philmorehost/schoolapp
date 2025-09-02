<?php
	
	$err_msg = "";
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: Notice with same details already exists in database";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: Another Notice has been with same details already exists in database";
	}
	
	$header_add_button = "add_notice";
	$additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
	//$header_view_button = "view_notice";
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
		$search_sqli_statement .= "notice_title LIKE '%".$search_items."%'"."\n"."notice_comment LIKE '%".$search_items."%'"."\n"."numeric_class_name LIKE '%".$search_items."%'"."\n"."start_date LIKE '%".str_replace(["/","-"],"-",$search_items)."%'"."\n"."end_date LIKE '%".str_replace(["/","-"],"-",$search_items)."%'"."\n"."notice_for LIKE '%".$search_items."%'";
	}
	
	$search_sqli_statements .= "(".str_replace("\n"," && school_id_number=".$get_logged_user_details['school_id_number'].") OR (", trim($search_sqli_statement))." && school_id_number=".$get_logged_user_details['school_id_number'].")";
	
	if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
		$select_notice_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_notices WHERE $search_sqli_statements ".$user_notice_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_notice_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_notices WHERE $search_sqli_statements ".$user_notice_statement_auth);
	}else{
		$select_notice_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_notices WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_notice_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_notice_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_notices WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_notice_statement_auth);
	}
	
	if(isset($_POST["add-notice"])){
		$notice_title = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["notice-title"])));
		$notice_comment = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["notice-comment"])));
		$start_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["start-date"])));
		$end_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["end-date"])));
		$notice_for = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["notice-for"])));
		$numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		if(!empty($notice_title) && !empty($start_date) && !empty($end_date) && !empty($notice_for) && !empty($numeric_class) && !empty($school_id)){
			if(mysqli_query($connection_server, "INSERT INTO sm_notices (school_id_number, notice_title, notice_comment, numeric_class_name, start_date, end_date, notice_for) VALUES ('$school_id', '$notice_title', '$notice_comment', '$numeric_class', '$start_date', '$end_date', '$notice_for')") == true){
				
				$sel_teacher_query = mysqli_query($connection_server, "SELECT * FROM sm_teachers WHERE school_id_number='$school_id'");
				if(mysqli_num_rows($sel_teacher_query) > 0){
					while($teachers_detail = mysqli_fetch_array($sel_teacher_query)){
						if(((in_array($numeric_class,array_filter(explode("\n",trim($teachers_detail["class"]))))) || ($numeric_class == "all")) && (($notice_for == "all") || ($notice_for == "teacher"))){
							$eteacher_email .= $teachers_detail["email"]."\n";
						}
					}
				}
				
				$sel_student_query = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$school_id'");
				if(mysqli_num_rows($sel_student_query) > 0){
					while($students_detail = mysqli_fetch_array($sel_student_query)){
						if((($numeric_class == $students_detail["current_class"]) || ($numeric_class == "all")) && (($notice_for == "all") || ($notice_for == "student"))){
							$estudent_email .= $students_detail["email"]."\n";
						}
					}
				}
				
				$sel_parent_query = mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number='$school_id'");
				if(mysqli_num_rows($sel_parent_query) > 0){
					while($parents_detail = mysqli_fetch_array($sel_parent_query)){
						if(!empty($numeric_class) && ($numeric_class != "all")){
							$parent_kids_numeric_class = " && current_class='$numeric_class'";
						}else{
							$parent_kids_numeric_class = "";
						}
						$src_parent_kids = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$school_id' && parent_id_number='".$parents_detail["id_number"]."' ".$parent_kids_numeric_class." LIMIT 1");
						if(((mysqli_num_rows($src_parent_kids) >= 1) || ($numeric_class == "all")) && (($notice_for == "all") || ($notice_for == "parent"))){
							$eparent_email .= $parents_detail["email"]."\n";
						}
					}
				}
				
				$all_exp_mails = array_filter(explode("\n",trim($eteacher_email."\n".$estudent_email."\n".$eparent_email)));
				
				// Always set content-type when sending HTML email
				$mail_headers = "MIME-Version: 1.0" . "\r\n";
				$mail_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				
				// More headers
				$mail_headers .= 'From: <'.$get_mail_sch_name["email"].'>' . "\r\n";
				$mail_headers .= 'Cc: '.$get_mail_sch_name["email"]."\r\n";
				
				foreach($all_exp_mails as $index => $raw_mail){
				$email_title = 
				str_replace("{{notice_title}}",$notice_title,
					str_replace("{{notice_date}}",str_replace("-","/",$start_date." till ".$end_date),
						str_replace("{{notice_for}}",ucwords($notice_for),
							str_replace("{{notice_comment}}",$notice_comment,
								emailTemplateTableExist('notice','title','data')
							)
						)
					)
				);
				
				$email_message = 
				mailDesignTemplate($email_title,
				str_replace("{{notice_title}}",$notice_title,
					str_replace("{{notice_date}}",str_replace("-","/",$start_date." till ".$end_date),
						str_replace("{{notice_for}}",ucwords($notice_for),
							str_replace("{{notice_comment}}",$notice_comment,
								emailTemplateTableExist('notice','message','data')
							)
						)
					)
				),'');
				customBCMailSender('',$all_exp_mails[$index],$email_title,$email_message,$mail_headers);
				}
				
				$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=true".$additional_back_tag;
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["update-notice"])){
		$notice_title = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["notice-title"])));
		$notice_comment = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["notice-comment"])));
		$start_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["start-date"])));
		$end_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["end-date"])));
		$notice_for = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["notice-for"])));
		$numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
		$school_id = $get_logged_user_details["school_id_number"];
			
		$current_notice_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["edit"])));
		$search_notice_with_id = mysqli_query($connection_server, "SELECT * FROM sm_notices WHERE school_id_number='$school_id' && notice_id='$current_notice_id'");
		
		if(!empty($notice_title) && !empty($start_date) && !empty($end_date) && !empty($notice_for) && !empty($numeric_class) && !empty($school_id)){
			if(mysqli_num_rows($search_notice_with_id) == 1){
				if(mysqli_query($connection_server, "UPDATE sm_notices SET notice_title='$notice_title', notice_comment='$notice_comment', numeric_class_name='$numeric_class', start_date='$start_date', end_date='$end_date', notice_for='$notice_for' WHERE (school_id_number='$school_id' && notice_id='$current_notice_id')") == true){
					
				$sel_teacher_query = mysqli_query($connection_server, "SELECT * FROM sm_teachers WHERE school_id_number='$school_id'");
				if(mysqli_num_rows($sel_teacher_query) > 0){
					while($teachers_detail = mysqli_fetch_array($sel_teacher_query)){
						if(((in_array($numeric_class,array_filter(explode("\n",trim($teachers_detail["class"]))))) || ($numeric_class == "all")) && (($notice_for == "all") || ($notice_for == "teacher"))){
							$eteacher_email .= $teachers_detail["email"]."\n";
						}
					}
				}
				
				$sel_student_query = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$school_id'");
				if(mysqli_num_rows($sel_student_query) > 0){
					while($students_detail = mysqli_fetch_array($sel_student_query)){
						if((($numeric_class == $students_detail["current_class"]) || ($numeric_class == "all")) && (($notice_for == "all") || ($notice_for == "student"))){
							$estudent_email .= $students_detail["email"]."\n";
						}
					}
				}
				
				$sel_parent_query = mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number='$school_id'");
				if(mysqli_num_rows($sel_parent_query) > 0){
					while($parents_detail = mysqli_fetch_array($sel_parent_query)){
						if(!empty($numeric_class) && ($numeric_class != "all")){
							$parent_kids_numeric_class = " && current_class='$numeric_class'";
						}else{
							$parent_kids_numeric_class = "";
						}
						$src_parent_kids = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$school_id' && parent_id_number='".$parents_detail["id_number"]."' ".$parent_kids_numeric_class." LIMIT 1");
						if(((mysqli_num_rows($src_parent_kids) >= 1) || ($numeric_class == "all")) && (($notice_for == "all") || ($notice_for == "parent"))){
							$eparent_email .= $parents_detail["email"]."\n";
						}
					}
				}
				
				$all_exp_mails = array_filter(explode("\n",trim($eteacher_email."\n".$estudent_email."\n".$eparent_email)));
				
				// Always set content-type when sending HTML email
				$mail_headers = "MIME-Version: 1.0" . "\r\n";
				$mail_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				
				// More headers
				$mail_headers .= 'From: <'.$get_mail_sch_name["email"].'>' . "\r\n";
				$mail_headers .= 'Cc: '.$get_mail_sch_name["email"]."\r\n";
				
				foreach($all_exp_mails as $index => $raw_mail){
				$email_title = 
				str_replace("{{notice_title}}",$notice_title,
					str_replace("{{notice_date}}",str_replace("-","/",$start_date." till ".$end_date),
						str_replace("{{notice_for}}",ucwords($notice_for),
							str_replace("{{notice_comment}}",$notice_comment,
								emailTemplateTableExist('notice','title','data')
							)
						)
					)
				);
				
				$email_message = 
				mailDesignTemplate($email_title,
				str_replace("{{notice_title}}",$notice_title,
					str_replace("{{notice_date}}",str_replace("-","/",$start_date." till ".$end_date),
						str_replace("{{notice_for}}",ucwords($notice_for),
							str_replace("{{notice_comment}}",$notice_comment,
								emailTemplateTableExist('notice','message','data')
							)
						)
					)
				),'');
				customBCMailSender('',$all_exp_mails[$index],"UPDATED: ".$email_title,$email_message,$mail_headers);
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
	
	if(isset($_POST["delete-notice"])){
		$notice_id = $_POST["notice_id"];
		$school_id = $_POST["school_id"];
		foreach($notice_id as $index => $notice_id_no){
			$notice_id_no = mysqli_real_escape_string($connection_server, $notice_id[$index]);
			$sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
			
			$delete_school_selected_notice = mysqli_query($connection_server, "DELETE FROM sm_notices WHERE (school_id_number='$sch_id_number' && notice_id='$notice_id_no')");
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