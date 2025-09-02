<?php
	
	$err_msg = "";
	$show_back_arrow = false;
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: Result with the provided details doesnt exists in database";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: Another result has been with same result Numeric Name already exists in database";
	}
	
	$header_add_button = "add_result";
	$additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
	//$header_view_button = "view_result";
	$additional_back_tag .= "&id=".$get_logged_user_details['school_id_number'];
	
	/*if((isset($_GET["prevnext"])) && (trim(strip_tags($_GET["prevnext"])) > 0) && (trim(strip_tags($_GET["prevnext"])) !== "")){
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
		$search_sqli_statement .= "subject_code LIKE '%".$search_items."%'"."\n"." numeric_class_name LIKE '%".$search_items."%'"."\n"." term_id_number LIKE '%".$search_items."%'"."\n"." session LIKE '%".str_replace(["/","-"],"-",$search_items)."%'"."\n"." result_start_date LIKE '%".str_replace(["/","-"],"-",$search_items)."%'"."\n"." result_end_date LIKE '%".str_replace(["/","-"],"-",$search_items)."%'"."\n"." result_comment LIKE '%".$search_items."%'";
	
	}
	
	$search_sqli_statements .= str_replace("\n"," OR ", trim($search_sqli_statement));
	
	if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
		$select_result_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_results WHERE $search_sqli_statements && school_id_number='".trim(strip_tags($_GET['id']))."' LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_result_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_results WHERE $search_sqli_statements && school_id_number='".trim(strip_tags($_GET['id']))."'");
	}else{
		$select_result_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_results WHERE school_id_number='".trim(strip_tags($_GET['id']))."' LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_result_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_results WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
	}*/
	
	if(isset($_POST["manage-marks"])){
		$numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
		$session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["session"])));
		$term_id_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["term"])));
		$subject_code = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["subject-code"])));
		$class_category = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class-category"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		$search_student_result_release_date_database = mysqli_query($connection_server, "SELECT * FROM sm_result_release_dates WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && term_id_number='$term_id_number'");
		if(mysqli_num_rows($search_student_result_release_date_database) < 1){
			$insert_student_result_release_date_database = mysqli_query($connection_server, "INSERT INTO sm_result_release_dates (school_id_number, numeric_class_name, session, term_id_number, release_date) VALUES ('$school_id','$numeric_class','$session','$term_id_number','')");
		}
		
		$get_all_students_in_class = mysqli_query($connection_server, "SELECT * FROM sm_class_list WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session'");
		if(mysqli_num_rows($get_all_students_in_class) > 0){
			
			while($add_student_to_result_database = mysqli_fetch_array($get_all_students_in_class)){
				$get_if_student_exists_in_result_database = mysqli_query($connection_server, "SELECT * FROM sm_results WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && term_id_number='$term_id_number' && subject_code='$subject_code' && admission_number='".$add_student_to_result_database["admission_number"]."'");
				if(mysqli_num_rows($get_if_student_exists_in_result_database) == 0){
					
					$search_student_to_result_list_database = mysqli_query($connection_server, "SELECT * FROM sm_result_lists WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && term_id_number='$term_id_number' && admission_number='".$add_student_to_result_database["admission_number"]."'");
					if(mysqli_num_rows($search_student_to_result_list_database) == 0){
						$ref_char = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
						$result_ref = substr(str_shuffle($ref_char),0,20);
						$insert_student_to_result_list_database = mysqli_query($connection_server, "INSERT INTO sm_result_lists (school_id_number, result_ref, numeric_class_name, session, term_id_number, admission_number) VALUES ('$school_id','$result_ref','$numeric_class','$session','$term_id_number','".$add_student_to_result_database["admission_number"]."')");
					}
					
					$insert_student_to_result_database = mysqli_query($connection_server, "INSERT INTO sm_results (school_id_number, numeric_class_name, session, term_id_number, subject_code, admission_number, first_ca, second_ca, third_ca, exam, comment) VALUES ('$school_id','$numeric_class','$session','$term_id_number','$subject_code','".$add_student_to_result_database["admission_number"]."','','','','','')");
					if($insert_student_to_result_database == false){
						echo "<script> alert(".mysqli_error($connection_server)."); </script>";
					}
				}
			}
		}
		$redirect_url = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"]))."&id=$school_id&view=".$session."_".$numeric_class."_".$term_id_number."_".$subject_code."&&class_category=".$class_category;
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["add-remarks"])){
		$numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
		$session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["session"])));
		$term_id_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["term"])));
		$class_category = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class-category"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		$get_all_students_in_class = mysqli_query($connection_server, "SELECT * FROM sm_class_list WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session'");
		
		if(mysqli_num_rows($get_all_students_in_class) > 0){
			while($add_student_to_result_database = mysqli_fetch_array($get_all_students_in_class)){
				$get_if_student_exists_in_result_database = mysqli_query($connection_server, "SELECT * FROM sm_result_remarks WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && term_id_number='$term_id_number' && admission_number='".$add_student_to_result_database["admission_number"]."'");
				if(mysqli_num_rows($get_if_student_exists_in_result_database) == 0){
					$insert_student_to_result_remark_database = mysqli_query($connection_server, "INSERT INTO sm_result_remarks (school_id_number, numeric_class_name, session, term_id_number, admission_number, principal_remark) VALUES ('$school_id','$numeric_class','$session','$term_id_number','".$add_student_to_result_database["admission_number"]."','')");
					if($insert_student_to_result_remark_database == false){
						echo "<script> alert(".mysqli_error($connection_server)."); </script>";
					}
				}
			}
		}
		
		$redirect_url = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"]))."&id=$school_id&view=".$session."_".$numeric_class."_".$term_id_number."&&class_category=".$class_category;
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["view-result"])){
		$numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
		$session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["session"])));
		$term_id_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["term"])));
		$admission_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["admission-number"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		if($admission_number == "all"){
			$show_all_results = true;
			$all_students_results = mysqli_query($connection_server, "SELECT * FROM sm_results WHERE school_id_number='$school_id' AND numeric_class_name='$numeric_class' AND session='$session' AND term_id_number='$term_id_number'");
		}else{
			$search_student_to_result_list_database = mysqli_query($connection_server, "SELECT * FROM sm_result_lists WHERE school_id_number='$school_id' AND numeric_class_name='$numeric_class' AND session='$session' AND term_id_number='$term_id_number' AND admission_number='$admission_number'");
			if(mysqli_num_rows($search_student_to_result_list_database) == 1){
				$get_student_view_result_ref = mysqli_fetch_array($search_student_to_result_list_database);
				$redirect_url = "/bc-results.php?view=".$get_student_view_result_ref["result_ref"];
			}else{
				$redirect_url = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"]))."&id=".trim(strip_tags($_GET["id"]))."&view=".$session."_".$numeric_class."_".$term_id_number."_".$admission_number;
			}
			header("Location: ".$redirect_url);
		}
	}

	if(isset($_POST["save-marks"])){
		$all_view_detail_array = array_filter(explode("_",trim(strip_tags($_GET['view']))));
		$session = $all_view_detail_array[0];
		$numeric_class = $all_view_detail_array[1];
		$term_id_number = $all_view_detail_array[2];
		$subject_code = $all_view_detail_array[3];
		$release_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["release_date"])));
		
		$first_ca_array = $_POST["first-ca"];
		$second_ca_array = $_POST["second-ca"];
		$third_ca_array = $_POST["third-ca"];
		$exam_array = $_POST["exam"];
		$comment_array = $_POST["comment"];
		$admission_number_array = $_POST["admission-number"];
		
		if(isset($_GET["class_category"]) && is_numeric($_GET["class_category"]) && ($_GET["class_category"] >= 1)){
			$class_category = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["class_category"])));
		}else{
			$class_category = "";
		}
		$school_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["id"])));
		
		if(!empty($numeric_class) && !empty($session) && !empty($term_id_number) && !empty($subject_code) && (count($first_ca_array) > 0) && !empty($admission_number_array) && !empty($school_id)){
			$update_student_result_release_date_database = mysqli_query($connection_server, "UPDATE sm_result_release_dates SET release_date='$release_date' WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && term_id_number='$term_id_number'");
			
			foreach($first_ca_array as $index => $first_ca){
				$first_ca = mysqli_real_escape_string($connection_server, trim(strip_tags($first_ca_array[$index])));
				$second_ca = mysqli_real_escape_string($connection_server, trim(strip_tags($second_ca_array[$index])));
				$third_ca = mysqli_real_escape_string($connection_server, trim(strip_tags($third_ca_array[$index])));
				$exam = mysqli_real_escape_string($connection_server, trim(strip_tags($exam_array[$index])));
				$comment = mysqli_real_escape_string($connection_server, trim(strip_tags($comment_array[$index])));
				$admission_number = mysqli_real_escape_string($connection_server, trim(strip_tags($admission_number_array[$index])));
				
				if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_results WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && term_id_number='$term_id_number' && subject_code='$subject_code' && admission_number='".$admission_number_array[$index]."'")) == 1){
					if(mysqli_query($connection_server, "UPDATE sm_results SET first_ca='$first_ca', second_ca='$second_ca', third_ca='$third_ca', exam='$exam', comment='$comment' WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && term_id_number='$term_id_number' && subject_code='$subject_code' && admission_number='$admission_number'") == true){
						$redirect_url = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"]))."&id=".trim(strip_tags($_GET["id"]))."&view=".$session."_".$numeric_class."_".$term_id_number."_".$subject_code."&&class_category=".$class_category;
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

	if(isset($_POST["save-remarks"])){
		$all_view_detail_array = array_filter(explode("_",trim(strip_tags($_GET['view']))));
		$session = $all_view_detail_array[0];
		$numeric_class = $all_view_detail_array[1];
		$term_id_number = $all_view_detail_array[2];
		
		$principal_remark_array = $_POST["principal-remark"];
		$admission_number_array = $_POST["admission-number"];
		
		$school_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["id"])));
		
		if(!empty($numeric_class) && !empty($session) && !empty($term_id_number) && !empty($admission_number_array) && !empty($school_id)){
			foreach($principal_remark_array as $index => $principal_remark){
				$principal_remark = mysqli_real_escape_string($connection_server, trim(strip_tags($principal_remark_array[$index])));
				$admission_number = mysqli_real_escape_string($connection_server, trim(strip_tags($admission_number_array[$index])));
				
				if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_result_remarks WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && term_id_number='$term_id_number' && admission_number='$admission_number'")) == 1){
					if(mysqli_query($connection_server, "UPDATE sm_result_remarks SET principal_remark='$principal_remark' WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && term_id_number='$term_id_number' && admission_number='$admission_number'") == true){
						$redirect_url = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"]))."&id=".trim(strip_tags($_GET["id"]))."&view=".$session."_".$numeric_class."_".$term_id_number;
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
	
	if(isset($_POST["save-multiple-subject-marks"])){
		$all_view_detail_array = array_filter(explode("_",trim(strip_tags($_GET['view']))));
		$session = $all_view_detail_array[0];
		$numeric_class = $all_view_detail_array[1];
		$term_id_number = $all_view_detail_array[2];
		
		$subject_code = $_POST["subject-code"];
		$release_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["release_date"])));
		
		$first_ca_array = $_POST["first-ca"];
		$second_ca_array = $_POST["second-ca"];
		$third_ca_array = $_POST["third-ca"];
		$exam_array = $_POST["exam"];
		$comment_array = $_POST["comment"];
		$admission_number_array = $_POST["admission-number"];
		
		if(isset($_GET["class_category"]) && is_numeric($_GET["class_category"]) && ($_GET["class_category"] >= 1)){
			$class_category = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["class_category"])));
		}else{
			$class_category = "";
		}
		$school_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["id"])));
		
		if(!empty($numeric_class) && !empty($session) && !empty($term_id_number) && (count($subject_code) > 0) && (count($first_ca_array) > 0) && !empty($admission_number_array) && !empty($school_id)){
			$update_student_result_release_date_database = mysqli_query($connection_server, "UPDATE sm_result_release_dates SET release_date='$release_date' WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && term_id_number='$term_id_number'");
			
			foreach($subject_code as $index => $sub_code){
				$all_subject_code = mysqli_real_escape_string($connection_server, trim(strip_tags($subject_code[$index])));
				$all_subject_code_spc .=  mysqli_real_escape_string($connection_server, trim(strip_tags($subject_code[$index])))." ";
				
				$first_ca = mysqli_real_escape_string($connection_server, trim(strip_tags($first_ca_array[$index])));
				$second_ca = mysqli_real_escape_string($connection_server, trim(strip_tags($second_ca_array[$index])));
				$third_ca = mysqli_real_escape_string($connection_server, trim(strip_tags($third_ca_array[$index])));
				$exam = mysqli_real_escape_string($connection_server, trim(strip_tags($exam_array[$index])));
				$comment = mysqli_real_escape_string($connection_server, trim(strip_tags($comment_array[$index])));
				$admission_number = mysqli_real_escape_string($connection_server, trim(strip_tags($admission_number_array[$index])));
				
				if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_results WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && term_id_number='$term_id_number' && subject_code='$all_subject_code' && admission_number='".$admission_number."'")) == 1){
					if(mysqli_query($connection_server, "UPDATE sm_results SET first_ca='$first_ca', second_ca='$second_ca', third_ca='$third_ca', exam='$exam', comment='$comment' WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && term_id_number='$term_id_number' && subject_code='$all_subject_code' && admission_number='$admission_number'") == true){
						$redirect_url = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"]))."&id=".trim(strip_tags($_GET["id"]))."&view=".$session."_".$numeric_class."_".$term_id_number."&subjects=".str_replace(" ","_",trim(strip_tags($all_subject_code_spc)))."&&class_category=".$class_category;
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

	if(isset($_POST["manage-multiple-subject-marks"])){
		$numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
		$session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["session"])));
		$term_id_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["term"])));
		$subject_code = $_POST["subject-code"];
		$class_category = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class-category"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		$search_student_result_release_date_database = mysqli_query($connection_server, "SELECT * FROM sm_result_release_dates WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && term_id_number='$term_id_number'");
		if(mysqli_num_rows($search_student_result_release_date_database) < 1){
			$insert_student_result_release_date_database = mysqli_query($connection_server, "INSERT INTO sm_result_release_dates (school_id_number, numeric_class_name, session, term_id_number, release_date) VALUES ('$school_id','$numeric_class','$session','$term_id_number','')");
		}
		
		foreach($subject_code as $index => $sub_code){
			$all_subject_code = mysqli_real_escape_string($connection_server, trim(strip_tags($subject_code[$index])));
			$all_subject_code_spc .=  mysqli_real_escape_string($connection_server, trim(strip_tags($subject_code[$index])))." ";
			
			$get_all_students_in_class = mysqli_query($connection_server, "SELECT * FROM sm_class_list WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session'");
			if(mysqli_num_rows($get_all_students_in_class) > 0){
				while($add_student_to_result_database = mysqli_fetch_array($get_all_students_in_class)){
					$get_if_student_exists_in_result_database = mysqli_query($connection_server, "SELECT * FROM sm_results WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && term_id_number='$term_id_number' && subject_code='$all_subject_code' && admission_number='".$add_student_to_result_database["admission_number"]."'");
					if(mysqli_num_rows($get_if_student_exists_in_result_database) == 0){
						
						$search_student_to_result_list_database = mysqli_query($connection_server, "SELECT * FROM sm_result_lists WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && term_id_number='$term_id_number' && admission_number='".$add_student_to_result_database["admission_number"]."'");
						if(mysqli_num_rows($search_student_to_result_list_database) == 0){
							$ref_char = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
							$result_ref = substr(str_shuffle($ref_char),0,20);
							$insert_student_to_result_list_database = mysqli_query($connection_server, "INSERT INTO sm_result_lists (school_id_number, result_ref, numeric_class_name, session, term_id_number, admission_number) VALUES ('$school_id','$result_ref','$numeric_class','$session','$term_id_number','".$add_student_to_result_database["admission_number"]."')");
						}
						$insert_student_to_result_database = mysqli_query($connection_server, "INSERT INTO sm_results (school_id_number, numeric_class_name, session, term_id_number, subject_code, admission_number, first_ca, second_ca, third_ca, exam, comment) VALUES ('$school_id','$numeric_class','$session','$term_id_number','$all_subject_code','".$add_student_to_result_database["admission_number"]."','','','','','')");
						
						if($insert_student_to_result_database == false){
							echo "<script> alert(".mysqli_error($connection_server)."); </script>";
						}
					}
				}
			}
		}
		$redirect_url = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"]))."&id=".trim(strip_tags($_GET["id"]))."&view=".$session."_".$numeric_class."_".$term_id_number."&subjects=".str_replace(" ","_",trim(strip_tags($all_subject_code_spc)))."&&class_category=".$class_category;
		header("Location: ".$redirect_url);
	}
	
	/*if(isset($_POST["update-result"])){
		$result_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["result-name"])));
		$result_numeric_name = mysqli_real_escape_string($connection_server, trim(str_replace([".","-"],"",strip_tags($_POST["result-num-name"]))));
		$result_capacity = mysqli_real_escape_string($connection_server, trim(str_replace([".","-"],"",strip_tags($_POST["result-capacity"]))));
		$description = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["description"])));
		$school_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["id"])));
		
		
		$current_result_numeric_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["edit"])));
				
		$search_result_with_id_numeric = mysqli_query($connection_server, "SELECT * FROM sm_results WHERE school_id_number='$school_id' && (result_numeric_name='$result_numeric_name' OR result_numeric_name='$current_result_numeric_name')");
		
		if(!empty($result_name) && !empty($result_numeric_name) && !empty($result_capacity) && !empty($school_id)){
			if(mysqli_num_rows($search_result_with_id_numeric) == 1){
				if(mysqli_query($connection_server, "UPDATE sm_results SET result_name='$result_name', result_numeric_name='$result_numeric_name', result_capacity='$result_capacity', description='$description' WHERE (school_id_number='$school_id' && result_numeric_name='$current_result_numeric_name')") == true){
					$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=true".$additional_back_tag;
				}
			}else{
				$redirect_url = $_SERVER["REQUEST_URI"]."&err=3";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}*/
	
	if(isset($_POST["delete-result"])){
		$result_id = $_POST["result_id"];
		$school_id = $_POST["school_id"];
		foreach($result_id as $index => $result_id_no){
			$result_num_name = mysqli_real_escape_string($connection_server, $result_id[$index]);
			$sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
			
			$delete_school_selected_result = mysqli_query($connection_server, "DELETE FROM sm_results WHERE (school_id_number='$sch_id_number' && result_numeric_name='$result_num_name')");
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