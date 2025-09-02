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
	
	if(isset($_POST["view-result"])){
		$numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
		$session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["session"])));
		$term_id_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["term"])));
		if(isset($_SESSION["stu_session"])){
			$admission_number = $get_logged_user_details["admission_number"];
		}else{
			$admission_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["admission-number"])));
		}
		
		$school_id = $get_logged_user_details["school_id_number"];
		
		$search_student_to_result_list_database = mysqli_query($connection_server, "SELECT * FROM sm_result_lists WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && term_id_number='$term_id_number' && admission_number='$admission_number'");
		if(mysqli_num_rows($search_student_to_result_list_database) == 1){
			$get_student_view_result_ref = mysqli_fetch_array($search_student_to_result_list_database);
			$redirect_url = "/bc-results.php?view=".$get_student_view_result_ref["result_ref"];
		}else{
			$redirect_url = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"]))."&id=".trim(strip_tags($_GET["id"]));
		}
		header("Location: ".$redirect_url);
	}

?>