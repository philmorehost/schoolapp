<?php
	
	$err_msg = "";
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: Exam with same details already exists in database";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: Another Exam with same details already exists in database";
	}
	
	$header_add_button = "add_exam";
	$additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
	//$header_view_button = "view_exam";
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
		$search_sqli_statement .= "subject_code LIKE '%".$search_items."%'"."\n"." numeric_class_name LIKE '%".$search_items."%'"."\n"." session LIKE '%".str_replace(["/","-"],"-",$search_items)."%'"."\n"." term_id_number LIKE '%".$search_items."%'"."\n"." pass_mark LIKE '%".$search_items."%'"."\n"." total_mark LIKE '%".$search_items."%'"."\n"." exam_start_date LIKE '%".str_replace(["/","-"],"-",$search_items)."%'"."\n"." exam_end_date LIKE '%".str_replace(["/","-"],"-",$search_items)."%'"."\n"." exam_comment LIKE '%".$search_items."%'";
	}
	
	$search_sqli_statements .= "(".str_replace("\n"," && school_id_number=".$get_logged_user_details['school_id_number'].") OR (", trim($search_sqli_statement))." && school_id_number=".$get_logged_user_details['school_id_number'].")";
	
	if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
		$select_exam_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_exams WHERE $search_sqli_statements ".$user_class_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_exam_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_exams WHERE $search_sqli_statements ".$user_class_statement_auth);
	}else{
		$select_exam_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_exams WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_exam_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_exams WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth);
	}
	
	if(isset($_POST["add-exam"])){
		$exam_code = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["exam-code"])));
		$numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
		$class_session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class-session"])));
		$term_id_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["term-id-name"])));
		$term_id = array_filter(explode(" ",trim($term_id_name)))[0];
		$term_name = array_filter(explode(" ",trim($term_id_name)))[1];
		$pass_mark = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["pass-mark"])));
		$total_mark = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["total-mark"])));
		$start_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["start-date"])));
		$end_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["end-date"])));
		$exam_comment = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["exam-comment"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		
		if(!empty($exam_code) && !empty($numeric_class) && !empty($class_session) && !empty($term_id) && !empty($pass_mark) && !empty($total_mark) && !empty($start_date) && !empty($end_date) && !empty($school_id)){
			if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_exams WHERE (school_id_number='$school_id' && subject_code='$exam_code' && numeric_class_name='$numeric_class' && session='$class_session' && term_id_number='$term_id')")) == 0){
				if(mysqli_query($connection_server, "INSERT INTO sm_exams (school_id_number, subject_code, numeric_class_name, session, term_id_number, pass_mark, total_mark, exam_start_date, exam_end_date, exam_comment) VALUES ('$school_id','$exam_code', '$numeric_class', '$class_session', '$term_id', '$pass_mark', '$total_mark', '$start_date', '$end_date', '$exam_comment')") == true){
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
	
	if(isset($_POST["update-exam"])){
		$exam_code = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["exam-code"])));
		$numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
		$class_session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class-session"])));
		$term_id_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["term-id-name"])));
		$term_id = array_filter(explode(" ",trim($term_id_name)))[0];
		$term_name = array_filter(explode(" ",trim($term_id_name)))[1];
		$pass_mark = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["pass-mark"])));
		$total_mark = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["total-mark"])));
		$start_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["start-date"])));
		$end_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["end-date"])));
		$exam_comment = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["exam-comment"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		
		$current_subject_code = array_filter(explode("_",trim(strip_tags($_GET['edit']))))[0];
		$current_numeric_class_name = array_filter(explode("_",trim(strip_tags($_GET['edit']))))[1];
		$current_session = array_filter(explode("_",trim(strip_tags($_GET['edit']))))[2];
		$current_term_id_number = array_filter(explode("_",trim(strip_tags($_GET['edit']))))[3];
		
		$search_exam_with_id_numeric = mysqli_query($connection_server, "SELECT * FROM sm_exams WHERE school_id_number='$school_id' && (subject_code='$exam_code' OR subject_code='$current_subject_code') && (numeric_class_name='$numeric_class' OR numeric_class_name='$current_numeric_class_name') && (session='$class_session' OR session='$current_session') && (term_id_number='$term_id' OR term_id_number='$current_term_id_number')");
		
		if(!empty($exam_code) && !empty($numeric_class) && !empty($class_session) && !empty($term_id) && !empty($pass_mark) && !empty($total_mark) && !empty($start_date) && !empty($end_date) && !empty($school_id)){
			if(mysqli_num_rows($search_exam_with_id_numeric) == 1){
				if(mysqli_query($connection_server, "UPDATE sm_exams SET school_id_number='$school_id', subject_code='$exam_code', numeric_class_name='$numeric_class', session='$class_session', term_id_number='$term_id', pass_mark='$pass_mark', total_mark='$total_mark', exam_start_date='$start_date', exam_end_date='$end_date', exam_comment='$exam_comment' WHERE (school_id_number='$school_id' && subject_code='$current_subject_code' && numeric_class_name='$current_numeric_class_name' && session='$current_session' && term_id_number='$current_term_id_number')") == true){
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
	
	if(isset($_POST["delete-exam"])){
		$exam_id = $_POST["exam_id"];
		$school_id = $_POST["school_id"];
		$class_id = $_POST["class_id"];
		$term_id = $_POST["term_id"];
		$session_id = $_POST["session_id"];
		foreach($exam_id as $index => $exam_id_no){
			$subject_code = mysqli_real_escape_string($connection_server, $exam_id[$index]);
			$sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
			$session = mysqli_real_escape_string($connection_server, $session_id[$index]);
			$num_class = mysqli_real_escape_string($connection_server, $class_id[$index]);
			$term_id_num = mysqli_real_escape_string($connection_server, $term_id[$index]);
			
			$delete_school_selected_exam = mysqli_query($connection_server, "DELETE FROM sm_exams WHERE (school_id_number='$sch_id_number' && subject_code='$subject_code' && numeric_class_name='$num_class' && session='$session' && term_id_number='$term_id_num')");
		}
		$redirect_url = $_SERVER["REQUEST_URI"];
		
		header("Location: ".$redirect_url);
	}

	if(isset($_POST["view-exam-time-table"])){
		$session_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["session-class"])));
		$term_id_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["term"])));
		
		$redirect_url = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"]))."&id=".trim(strip_tags($_GET["id"]))."&view=".$session_class."_".$term_id_number;
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["search-item"])){
		$search_item_text = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["search-item"])));
		
		$page_to_go_link = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"])).$additional_add_tag."&search=".$search_item_text."&pnum=".$page_pnum;
		header("Location: ".$page_to_go_link);
	}
?>