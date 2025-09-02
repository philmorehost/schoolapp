<?php
	
	$err_msg = "";
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: Grade with same details (Grade Name/Mark From/Mark Upto) already exists in database";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: Another Grade has been with same details already exists in database";
	}
	
	
	$header_add_button = "add_grade";
	$additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
	//$header_view_button = "view_grade";
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
		$search_sqli_statement .= "grade_name LIKE '%".$search_items."%'"."\n"."mark_from LIKE '%".$search_items."%'"."\n"."mark_upto LIKE '%".$search_items."%'"."\n"."grade_comment LIKE '%".$search_items."%'";
	
	}
	
	$search_sqli_statements .= "(".str_replace("\n"," && school_id_number=".$get_logged_user_details['school_id_number'].") OR (", trim($search_sqli_statement))." && school_id_number=".$get_logged_user_details['school_id_number'].")";
	
	if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
		$select_grade_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_grades WHERE $search_sqli_statements LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_grade_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_grades WHERE $search_sqli_statements");
	}else{
		$select_grade_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_grades WHERE school_id_number='".trim(strip_tags($_GET['id']))."' LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_grade_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_grades WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
	}
	
	if(isset($_POST["add-grade"])){
		$grade_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["grade-name"])));
		$mark_from = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mark-from"])));
		$mark_upto = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mark-upto"])));
		$grade_comment = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["grade-comment"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		$search_grade_with_mark = mysqli_query($connection_server, "SELECT * FROM sm_grades WHERE school_id_number='$school_id' && (grade_name='$grade_name' OR mark_from='$mark_from' OR mark_from='$mark_upto' OR mark_upto='$mark_upto' OR mark_upto='$mark_from')");
		
		if(!empty($grade_name) && !empty($mark_from) && !empty($mark_upto) && !empty($school_id)){
			if(mysqli_num_rows($search_grade_with_mark) == 0){
				if(mysqli_query($connection_server, "INSERT INTO sm_grades (school_id_number, grade_name, mark_from, mark_upto, grade_comment) VALUES ('$school_id','$grade_name','$mark_from','$mark_upto','$grade_comment')") == true){
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
	
	if(isset($_POST["update-grade"])){
		$grade_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["grade-name"])));
		$mark_from = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mark-from"])));
		$mark_upto = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mark-upto"])));
		$grade_comment = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["grade-comment"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		$search_grade_with_mark = mysqli_query($connection_server, "SELECT * FROM sm_grades WHERE school_id_number='$school_id' && (grade_name='$grade_name' OR mark_from='$mark_from' OR mark_from='$mark_upto' OR mark_upto='$mark_upto' OR mark_upto='$mark_from')");
		
		$current_grade_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["edit"])));
		
		$search_grade_with_id = mysqli_query($connection_server, "SELECT * FROM sm_grades WHERE school_id_number='$school_id' && grade_auto_number='$current_grade_id'");
		
		if(!empty($grade_name) && !empty($mark_from) && !empty($mark_upto) && !empty($school_id)){
			if((mysqli_num_rows($search_grade_with_id) == 1) && (mysqli_num_rows($search_grade_with_mark) == 1) && (mysqli_fetch_array($search_grade_with_mark)["grade_auto_number"] == $current_grade_id)){
					if(mysqli_query($connection_server, "UPDATE sm_grades SET school_id_number='$school_id', grade_name='$grade_name', mark_from='$mark_from', mark_upto='$mark_upto', grade_comment='$grade_comment' WHERE (school_id_number='$school_id' && grade_auto_number='$current_grade_id')") == true){
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
	
	if(isset($_POST["delete-grade"])){
		$grade_id = $_POST["grade_id"];
		$school_id = $_POST["school_id"];
		foreach($grade_id as $index => $grade_id_no){
			$grade_id_num = mysqli_real_escape_string($connection_server, $grade_id[$index]);
			$sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
			$delete_school_selected_grade = mysqli_query($connection_server, "DELETE FROM sm_grades WHERE (school_id_number='$sch_id_number' && grade_auto_number='$grade_id_num')");
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