<?php
    
    $err_msg = "";
    if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
        $err_msg .= "Error: Empty Fields";
    }
    
    if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
        $err_msg .= "Error: Holiday with same details already exists in database";
    }
    
    if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
        $err_msg .= "Error: Another Holiday has been with same details already exists in database";
    }
    
    $header_add_button = "add_holiday";
    $additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
    //$header_view_button = "view_holiday";
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
        $search_sqli_statement .= "holiday_title LIKE '%".$search_items."%'"."\n"."description LIKE '%".$search_items."%'"."\n"."start_date LIKE '%".str_replace(["/","-"],"-",$search_items)."%'"."\n"."end_date LIKE '%".str_replace(["/","-"],"-",$search_items)."%'"."\n"."status LIKE '%".$search_items."%'";
    
    }
    
    $search_sqli_statements .= "(".str_replace("\n"," && school_id_number=".$get_logged_user_details['school_id_number'].") OR (", trim($search_sqli_statement))." && school_id_number=".$get_logged_user_details['school_id_number'].")";
    
    if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
        $select_holiday_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_holidays WHERE $search_sqli_statements LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
        $select_all_holiday_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_holidays WHERE $search_sqli_statements");
    }else{
        $select_holiday_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_holidays WHERE school_id_number='".trim(strip_tags($_GET['id']))."' LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
        $select_all_holiday_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_holidays WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
    }
    
    if(isset($_POST["add-holiday"])){
        $holiday_title = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["holiday-title"])));
        $desc = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["desc"])));
        $start_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["start-date"])));
        $end_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["end-date"])));
        $school_id = $get_logged_user_details["school_id_number"];
        
        if(!empty($holiday_title) && !empty($start_date) && !empty($end_date) && !empty($school_id)){
            if(mysqli_query($connection_server, "INSERT INTO sm_holidays (school_id_number, holiday_title, description, start_date, end_date, status) VALUES ('$school_id', '$holiday_title', '$desc', '$start_date', '$end_date', 'approve')") == true){
               
            $get_mail_sch_name = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='$school_id' LIMIT 1"));
            
			$sel_teacher_query = mysqli_query($connection_server, "SELECT * FROM sm_teachers WHERE school_id_number='$school_id'");
			if(mysqli_num_rows($sel_teacher_query) > 0){
				while($teachers_detail = mysqli_fetch_array($sel_teacher_query)){
					$eteacher_email .= $teachers_detail["email"]."\n";
				}
			}
			
			$sel_student_query = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$school_id'");
			if(mysqli_num_rows($sel_student_query) > 0){
				while($students_detail = mysqli_fetch_array($sel_student_query)){
					$estudent_email .= $students_detail["email"]."\n";
				}
			}
			
			$sel_parent_query = mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number='$school_id'");
			if(mysqli_num_rows($sel_parent_query) > 0){
				while($parents_detail = mysqli_fetch_array($sel_parent_query)){
					$eparent_email .= $parents_detail["email"]."\n";
				}
			}
			
			$sel_admin_staff_query = mysqli_query($connection_server, "SELECT * FROM sm_admin_staffs WHERE school_id_number='$school_id'");
			if(mysqli_num_rows($sel_admin_staff_query) > 0){
				while($admin_staffs_detail = mysqli_fetch_array($sel_admin_staff_query)){
					$eadmin_staff_email .= $admin_staffs_detail["email"]."\n";
				}
			}
			
			
			$all_exp_mails = array_filter(explode("\n",trim($eteacher_email."\n".$estudent_email."\n".$eparent_email."\n".$eadmin_staff_email)));
			
			// Always set content-type when sending HTML email
			$mail_headers = "MIME-Version: 1.0" . "\r\n";
			$mail_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			
			// More headers
			$mail_headers .= 'From: <'.$get_mail_sch_name["email"].'>' . "\r\n";
			$mail_headers .= 'Cc: '.$get_mail_sch_name["email"]."\r\n";
			
			foreach($all_exp_mails as $index => $raw_mail){
			$email_title = 
			str_replace("{{holiday_title}}",$holiday_title,
				str_replace("{{holiday_date}}",str_replace("-","/",$start_date." till ".$end_date),
					str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
						emailTemplateTableExist('holiday','title','data')
					)
				)
			);
			
			$email_message = 
			mailDesignTemplate($email_title,
			str_replace("{{holiday_title}}",$holiday_title,
				str_replace("{{holiday_date}}",str_replace("-","/",$start_date." till ".$end_date),
					str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
						emailTemplateTableExist('holiday','message','data')
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
    
    if(isset($_POST["update-holiday"])){
        $holiday_title = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["holiday-title"])));
        $desc = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["desc"])));
        $start_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["start-date"])));
        $end_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["end-date"])));
        $status = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["status"])));
        $school_id = $get_logged_user_details["school_id_number"];
            
        $current_holiday_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["edit"])));
        $search_holiday_with_id = mysqli_query($connection_server, "SELECT * FROM sm_holidays WHERE school_id_number='$school_id' && holiday_id='$current_holiday_id'");
        
        if(!empty($holiday_title) && !empty($start_date) && !empty($end_date) && !empty($school_id)){
            if(mysqli_num_rows($search_holiday_with_id) == 1){
                if(mysqli_query($connection_server, "UPDATE sm_holidays SET holiday_title='$holiday_title', description='$desc', start_date='$start_date', end_date='$end_date', status='$status' WHERE (school_id_number='$school_id' && holiday_id='$current_holiday_id')") == true){
                    
					$get_mail_sch_name = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='$school_id' LIMIT 1"));
					
					$sel_teacher_query = mysqli_query($connection_server, "SELECT * FROM sm_teachers WHERE school_id_number='$school_id'");
					if(mysqli_num_rows($sel_teacher_query) > 0){
						while($teachers_detail = mysqli_fetch_array($sel_teacher_query)){
							$eteacher_email .= $teachers_detail["email"]."\n";
						}
					}
					
					$sel_student_query = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$school_id'");
					if(mysqli_num_rows($sel_student_query) > 0){
						while($students_detail = mysqli_fetch_array($sel_student_query)){
							$estudent_email .= $students_detail["email"]."\n";
						}
					}
					
					$sel_parent_query = mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number='$school_id'");
					if(mysqli_num_rows($sel_parent_query) > 0){
						while($parents_detail = mysqli_fetch_array($sel_parent_query)){
							$eparent_email .= $parents_detail["email"]."\n";
						}
					}
					
					$sel_admin_staff_query = mysqli_query($connection_server, "SELECT * FROM sm_admin_staffs WHERE school_id_number='$school_id'");
					if(mysqli_num_rows($sel_admin_staff_query) > 0){
						while($admin_staffs_detail = mysqli_fetch_array($sel_admin_staff_query)){
							$eadmin_staff_email .= $admin_staffs_detail["email"]."\n";
						}
					}
					
					
					$all_exp_mails = array_filter(explode("\n",trim($eteacher_email."\n".$estudent_email."\n".$eparent_email."\n".$eadmin_staff_email)));
					
					// Always set content-type when sending HTML email
					$mail_headers = "MIME-Version: 1.0" . "\r\n";
					$mail_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					
					// More headers
					$mail_headers .= 'From: <'.$get_mail_sch_name["email"].'>' . "\r\n";
					$mail_headers .= 'Cc: '.$get_mail_sch_name["email"]."\r\n";
					
					foreach($all_exp_mails as $index => $raw_mail){
					$email_title = 
					str_replace("{{holiday_title}}",$holiday_title,
						str_replace("{{holiday_date}}",str_replace("-","/",$start_date." till ".$end_date),
							str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
								emailTemplateTableExist('holiday','title','data')
							)
						)
					);
					
					$email_message = 
					mailDesignTemplate($email_title,
					str_replace("{{holiday_title}}",$holiday_title,
						str_replace("{{holiday_date}}",str_replace("-","/",$start_date." till ".$end_date),
							str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
								emailTemplateTableExist('holiday','message','data')
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
    
    if(isset($_POST["delete-holiday"])){
        $holiday_id = $_POST["holiday_id"];
        $school_id = $_POST["school_id"];
        foreach($holiday_id as $index => $holiday_id_no){
            $holiday_id_no = mysqli_real_escape_string($connection_server, $holiday_id[$index]);
            $sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
            
            $delete_school_selected_holiday = mysqli_query($connection_server, "DELETE FROM sm_holidays WHERE (school_id_number='$sch_id_number' && holiday_id='$holiday_id_no')");
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