<?php
	
	$err_msg = "";
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: Hall with same Hall Numeric Name already exists in database";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: Another Hall has been with same Hall Numeric Name already exists in database";
	}
	
	$header_add_button = "add_hall";
	$additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
	//$header_view_button = "view_hall";
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
		$search_sqli_statement .= "hall_name LIKE '%".$search_items."%'"."\n"."hall_numeric_name LIKE '%".$search_items."%'"."\n"."hall_capacity LIKE '%".$search_items."%'"."\n"."description LIKE '%".$search_items."%'";
	
	}
	
	$search_sqli_statements .= "(".str_replace("\n"," && school_id_number=".$get_logged_user_details['school_id_number'].") OR (", trim($search_sqli_statement))." && school_id_number=".$get_logged_user_details['school_id_number'].")";
	
	if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
		$select_hall_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_halls WHERE $search_sqli_statements LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_hall_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_halls WHERE $search_sqli_statements");
	}else{
		$select_hall_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_halls WHERE school_id_number='".trim(strip_tags($_GET['id']))."' LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_hall_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_halls WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
	}
	
	if(isset($_POST["add-hall"])){
		$hall_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["hall-name"])));
		$hall_numeric_name = mysqli_real_escape_string($connection_server, trim(str_replace([".","-"],"",strip_tags($_POST["hall-num-name"]))));
		$hall_capacity = mysqli_real_escape_string($connection_server, trim(str_replace([".","-"],"",strip_tags($_POST["hall-capacity"]))));
		$description = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["description"])));
		$school_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["id"])));
		
		if(!empty($hall_name) && !empty($hall_numeric_name) && !empty($hall_capacity) && !empty($school_id)){
			if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_halls WHERE (school_id_number='$school_id' && hall_numeric_name='$hall_numeric_name')")) == 0){
				if(mysqli_query($connection_server, "INSERT INTO sm_halls (school_id_number, hall_name, hall_numeric_name, hall_capacity, description) VALUES ('$school_id','$hall_name','$hall_numeric_name','$hall_capacity','$description')") == true){
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
	
	if(isset($_POST["update-hall"])){
		$hall_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["hall-name"])));
		$hall_numeric_name = mysqli_real_escape_string($connection_server, trim(str_replace([".","-"],"",strip_tags($_POST["hall-num-name"]))));
		$hall_capacity = mysqli_real_escape_string($connection_server, trim(str_replace([".","-"],"",strip_tags($_POST["hall-capacity"]))));
		$description = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["description"])));
		$school_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["id"])));
		
		
		$current_hall_numeric_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["edit"])));
				
		$search_hall_with_id_numeric = mysqli_query($connection_server, "SELECT * FROM sm_halls WHERE school_id_number='$school_id' && (hall_numeric_name='$hall_numeric_name' OR hall_numeric_name='$current_hall_numeric_name')");
		
		if(!empty($hall_name) && !empty($hall_numeric_name) && !empty($hall_capacity) && !empty($school_id)){
			if(mysqli_num_rows($search_hall_with_id_numeric) == 1){
				if(mysqli_query($connection_server, "UPDATE sm_halls SET hall_name='$hall_name', hall_numeric_name='$hall_numeric_name', hall_capacity='$hall_capacity', description='$description' WHERE (school_id_number='$school_id' && hall_numeric_name='$current_hall_numeric_name')") == true){
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
	
	if(isset($_POST["delete-hall"])){
		$hall_id = $_POST["hall_id"];
		$school_id = $_POST["school_id"];
		foreach($hall_id as $index => $hall_id_no){
			$hall_num_name = mysqli_real_escape_string($connection_server, $hall_id[$index]);
			$sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
			
			$delete_school_selected_hall = mysqli_query($connection_server, "DELETE FROM sm_halls WHERE (school_id_number='$sch_id_number' && hall_numeric_name='$hall_num_name')");
		}
		$redirect_url = $_SERVER["REQUEST_URI"];
		
		header("Location: ".$redirect_url);
	}

	if(isset($_POST["view-hall-info"])){
		$session_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["session-class"])));
		$term_id_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["term"])));
		$subject_code = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["subject"])));
		
		$redirect_url = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"]))."&id=".trim(strip_tags($_GET["id"]))."&view=".$session_class."_".$term_id_number."_".$subject_code;
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["search-item"])){
		$search_item_text = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["search-item"])));
		
		$page_to_go_link = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"])).$additional_add_tag."&search=".$search_item_text."&pnum=".$page_pnum;
		header("Location: ".$page_to_go_link);
	}
?>