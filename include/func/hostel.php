<?php
	
	$err_msg = "";
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: hostel with same Numeric hostel Name / Session already exists in database";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: Another hostel has been with same Numeric hostel Name already exists in database";
	}
	
	$header_add_button = "add_hostel";
	$additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
	//$header_view_button = "view_hostel";
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
		$search_sqli_statement .= "id_number LIKE '%".$search_items."%'"."\n"."hostel_name LIKE '%".$search_items."%'"."\n"."hostel_type LIKE '%".$search_items."%'"."\n"."hostel_description LIKE '%".$search_items."%'";
	
	}
	
	$search_sqli_statements .= "(".str_replace("\n"," && school_id_number=".$get_logged_user_details['school_id_number'].") OR (", trim($search_sqli_statement))." && school_id_number=".$get_logged_user_details['school_id_number'].")";
	
	if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
		$select_hostel_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_hostels WHERE $search_sqli_statements LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_hostel_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_hostels WHERE $search_sqli_statements");
	}else{
		$select_hostel_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_hostels WHERE school_id_number='".trim(strip_tags($_GET['id']))."' LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_hostel_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_hostels WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
	}
	
	if(isset($_POST["add-hostel"])){
		$hostel_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["hostel-name"])));
		$hostel_type = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["hostel-type"])));
		$hostel_desc = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["hostel-desc"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		$all_hostel_num_count = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_hostels WHERE school_id_number='$school_id'"));
		$check_last_hostel = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_hostels WHERE school_id_number='$school_id' LIMIT 1 OFFSET ".($all_hostel_num_count-1)));
		$hostel_no = sprintf("%03d",(($check_last_hostel["id_number"]) + 1));
		
		if(!empty($hostel_name) && !empty($hostel_type) && !empty($hostel_no) && !empty($school_id)){
			if(mysqli_query($connection_server, "INSERT INTO sm_hostels (school_id_number, id_number, hostel_name, hostel_type, hostel_description) VALUES ('$school_id','$hostel_no','$hostel_name','$hostel_type','$hostel_desc')") == true){
				$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=true".$additional_back_tag;
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["update-hostel"])){
		$hostel_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["hostel-name"])));
		$hostel_type = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["hostel-type"])));
		$hostel_desc = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["hostel-desc"])));
		$school_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["id"])));
		
		$current_hostel_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["edit"])));
				
		$search_hostel_with_id = mysqli_query($connection_server, "SELECT * FROM sm_hostels WHERE school_id_number='$school_id' && id_number='$current_hostel_id'");
		
		if(!empty($hostel_name) && !empty($hostel_type) && !empty($current_hostel_id) && !empty($school_id)){
			if(mysqli_num_rows($search_hostel_with_id) == 1){
				if(mysqli_query($connection_server, "UPDATE sm_hostels SET hostel_name='$hostel_name', hostel_type='$hostel_type', hostel_description='$hostel_desc' WHERE (school_id_number='$school_id' && id_number='$current_hostel_id')") == true){
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
	
	if(isset($_POST["delete-hostel"])){
		$hostel_id = $_POST["hostel_id"];
		$school_id = $_POST["school_id"];
		foreach($hostel_id as $index => $hostel_id_no){
			$hostel_id_num = mysqli_real_escape_string($connection_server, $hostel_id[$index]);
			$sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
			
			$delete_school_selected_hostel = mysqli_query($connection_server, "DELETE FROM sm_hostels WHERE (school_id_number='$sch_id_number' && id_number='$hostel_id_num')");
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