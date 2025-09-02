<?php
    
    $err_msg = "";
    $show_back_arrow = false;
    if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
        $err_msg .= "Error: Empty Fields";
    }
    
    if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
        $err_msg .= "Error: Attendance with the provided details doesnt exists in database";
    }
    
    if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
        $err_msg .= "Error: Another attendance has been with same attendance Numeric Name already exists in database";
    }
    
    $header_add_button = "add_attendance";
    $additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
    //$header_view_button = "view_attendance";
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
        $search_sqli_statement .= "numeric_class_name LIKE '%".$search_items."%'"."\n"."session LIKE '%".str_replace(["/","-"],"-",$search_items)."%'"."\n"."date_taken LIKE '%".str_replace(["/","-"],"-",$search_items)."%'"."\n"."admission_number LIKE '%".$search_items."%'"."\n"."attendance_remark LIKE '%".$search_items."%'"."\n"."comment LIKE '%".$search_items."%'";
    
    }
    
    $search_sqli_statements .= str_replace("\n"," OR ", trim($search_sqli_statement));
    
    if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
        $select_attendance_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_student_attendances WHERE $search_sqli_statements && school_id_number='".trim(strip_tags($_GET['id']))."' LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
        $select_all_attendance_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_student_attendances WHERE $search_sqli_statements && school_id_number='".trim(strip_tags($_GET['id']))."'");
    }else{
        $select_attendance_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_student_attendances WHERE school_id_number='".trim(strip_tags($_GET['id']))."' LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
        $select_all_attendance_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_student_attendances WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
    }
    
    if(isset($_POST["student-manage-attendance"])){
        $numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
        $session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["session"])));
        $date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["date"])));
        $school_id = $get_logged_user_details["school_id_number"];
        
        $get_all_students_in_class = mysqli_query($connection_server, "SELECT * FROM sm_class_list WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session'");

        if(mysqli_num_rows($get_all_students_in_class) > 0){
            while($add_student_to_attendance_database = mysqli_fetch_array($get_all_students_in_class)){
                $get_if_student_exists_in_attendance_database = mysqli_query($connection_server, "SELECT * FROM sm_student_attendances WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && date_taken='$date' && admission_number='".$add_student_to_attendance_database["admission_number"]."'");
                if(mysqli_num_rows($get_if_student_exists_in_attendance_database) == 0){
                    $insert_student_to_attendance_database = mysqli_query($connection_server, "INSERT INTO sm_student_attendances (school_id_number, numeric_class_name, session, date_taken, admission_number, attendance_remark, comment) VALUES ('$school_id','$numeric_class','$session','$date','".$add_student_to_attendance_database["admission_number"]."','','')");
                    if($insert_student_to_attendance_database == false){
                        echo "<script> alert(".mysqli_error($connection_server)."); </script>";
                    }
                }
            }
        }
        $redirect_url = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"]))."&id=".trim(strip_tags($_GET["id"]))."&view=".$session."_".$numeric_class."_".$date;
        header("Location: ".$redirect_url);
    }

    if(isset($_POST["save-student-attendance"])){
        $all_view_detail_array = array_filter(explode("_",trim(strip_tags($_GET['view']))));
        $session = $all_view_detail_array[0];
        $numeric_class = $all_view_detail_array[1];
        $date = $all_view_detail_array[2];
        
        $comment_array = $_POST["comment"];
        $admission_number_array = $_POST["admission-number"];
        
        $school_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["id"])));
        
        if(!empty($numeric_class) && !empty($session) && !empty($date) && (count($admission_number_array) > 0) && !empty($school_id)){
            foreach($admission_number_array as $index => $admission_no){
                $comment = mysqli_real_escape_string($connection_server, trim(strip_tags($comment_array[$index])));
                $admission_number = mysqli_real_escape_string($connection_server, trim(strip_tags($admission_number_array[$index])));
                $attendance_remark = $_POST[$admission_number."_attendance_remark"];
                
                if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_student_attendances WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && date_taken='$date' && admission_number='".$admission_number_array[$index]."'")) == 1){
                    if(mysqli_query($connection_server, "UPDATE sm_student_attendances SET attendance_remark='$attendance_remark', comment='$comment' WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && date_taken='$date' && admission_number='".$admission_number."'") == true){
                        if(strtolower($attendance_remark) == "absent"){
							$get_mail_stu_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$school_id' && admission_number='$admission_number' LIMIT 1"));
							$get_mail_par_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number='$school_id' && id_number='".$get_mail_stu_detail["parent_id_number"]."' LIMIT 1"));
							$get_mail_sch_name = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='$school_id' LIMIT 1"));
					
							// Always set content-type when sending HTML email
							$mail_headers = "MIME-Version: 1.0" . "\r\n";
							$mail_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					
							// More headers
							$mail_headers .= 'From: <'.$get_mail_sch_name["email"].'>' . "\r\n";
							$mail_headers .= 'Cc: '.$get_mail_sch_name["email"]."\r\n";
									
							$email_title = 
							str_replace("{{child_name}}",$get_mail_stu_detail["firstname"]." ".$get_mail_stu_detail["lastname"]." ".$get_mail_stu_detail["othername"],
								str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
									emailTemplateTableExist('attendance-absent','title','data')
								)
							);
					
							$email_message = 
							mailDesignTemplate($email_title,
							str_replace("{{child_name}}",$get_mail_stu_detail["firstname"]." ".$get_mail_stu_detail["lastname"]." ".$get_mail_stu_detail["othername"],
								str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
									emailTemplateTableExist('attendance-absent','message','data')
								)
							),'');
							
							customBCMailSender('',$get_mail_par_detail["email"],$email_title,$email_message,$mail_headers);
						}
                        $redirect_url = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"]))."&id=".trim(strip_tags($_GET["id"]))."&view=".$session."_".$numeric_class."_".$date;
                    }
                }else{
                    $redirect_url = $_SERVER["REQUEST_URI"]."&err=2";
                }
            }
        }else{
            $redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
        }
        
        header("Location: ".$redirect_url);
    }

    if(isset($_POST["teacher-manage-attendance"])){
        $date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["date"])));
        $school_id = $get_logged_user_details["school_id_number"];
        
        $get_all_teachers_in_class = mysqli_query($connection_server, "SELECT * FROM sm_teachers WHERE school_id_number='$school_id'");

        if(mysqli_num_rows($get_all_teachers_in_class) > 0){
            while($add_teacher_to_attendance_database = mysqli_fetch_array($get_all_teachers_in_class)){
                $get_if_teacher_exists_in_attendance_database = mysqli_query($connection_server, "SELECT * FROM sm_teacher_attendances WHERE school_id_number='$school_id' && date_taken='$date' && teacher_id_number='".$add_teacher_to_attendance_database["id_number"]."'");
                if(mysqli_num_rows($get_if_teacher_exists_in_attendance_database) == 0){
                    $insert_teacher_to_attendance_database = mysqli_query($connection_server, "INSERT INTO sm_teacher_attendances (school_id_number, date_taken, teacher_id_number, attendance_remark, comment) VALUES ('$school_id','$date','".$add_teacher_to_attendance_database["id_number"]."','','')");
                    if($insert_teacher_to_attendance_database == false){
                        echo "<script> alert(".mysqli_error($connection_server)."); </script>";
                    }
                }
            }
        }
        $redirect_url = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"]))."&id=".trim(strip_tags($_GET["id"]))."&view=".$date;
        header("Location: ".$redirect_url);
    }

    if(isset($_POST["save-teacher-attendance"])){
        $all_view_detail_array = array_filter(explode("_",trim(strip_tags($_GET['view']))));
        $date = $all_view_detail_array[0];
        
        $comment_array = $_POST["comment"];
        $teacher_id_number_array = $_POST["id-number"];
        
        $school_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["id"])));
        
        if(!empty($date) && (count($teacher_id_number_array) > 0) && !empty($school_id)){
            foreach($teacher_id_number_array as $index => $teacher_no){
                $comment = mysqli_real_escape_string($connection_server, trim(strip_tags($comment_array[$index])));
                $teacher_id_number = mysqli_real_escape_string($connection_server, trim(strip_tags($teacher_id_number_array[$index])));
                $attendance_remark = $_POST[$teacher_id_number."_attendance_remark"];
                
                if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_teacher_attendances WHERE school_id_number='$school_id' && date_taken='$date' && teacher_id_number='".$teacher_id_number_array[$index]."'")) == 1){
                    if(mysqli_query($connection_server, "UPDATE sm_teacher_attendances SET attendance_remark='$attendance_remark', comment='$comment' WHERE school_id_number='$school_id' && date_taken='$date' && teacher_id_number='".$teacher_id_number."'") == true){
                        $redirect_url = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"]))."&id=".trim(strip_tags($_GET["id"]))."&view=".$date;
                    }
                }else{
                    $redirect_url = $_SERVER["REQUEST_URI"]."&err=2";
                }
            }
        }else{
            $redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
        }
        
        header("Location: ".$redirect_url);
    }
    
    if(isset($_POST["search-item"])){
        $search_item_text = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["search-item"])));
        
        $page_to_go_link = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"])).$additional_add_tag."&search=".$search_item_text."&pnum=".$page_pnum;
        header("Location: ".$page_to_go_link);
    }
?>