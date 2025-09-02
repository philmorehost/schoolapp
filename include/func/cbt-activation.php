<?php

	$err_msg = "";
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}

	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: School CBT already Activated";
	}

	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: Invalid Activation Type";
	}

	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "4"){
		$err_msg .= "Error: School CBT already Deactivated";
	}

	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "5"){
		$err_msg .= "Error: School doesn't exists in database";
	}
	
    //$header_add_button = "add_school";
	//$header_view_button = "view_school";

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
	$page_list_number_link = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"])).$prev_next."&search=".$search_text."&pnum=";
	$page_prevnext_link = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"]))."&search=".$search_text."&pnum=".$page_pnum;
	
	$chopped_search_text_array = array_filter(explode(" ",trim($search_text)));
	foreach($chopped_search_text_array as $search_items){
		$search_sqli_statement .= "email LIKE '%".$search_items."%'"."\n"." school_name LIKE '%".$search_items."%'"."\n"." school_id_number LIKE '%".$search_items."%'"."\n"." school_phone_number LIKE '%".$search_items."%'"."\n"." school_motto LIKE '%".$search_items."%'"."\n"." school_address LIKE '%".$search_items."%'"."\n"." city LIKE '%".$search_items."%'"."\n"." state LIKE '%".$search_items."%'"."\n"." country LIKE '%".$search_items."%'";

	}

	$search_sqli_statements .= str_replace("\n"," OR ", trim($search_sqli_statement));

	if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
		$select_school_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE $search_sqli_statements LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_school_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE $search_sqli_statements");
	}else{
		$select_school_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_school_details LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_school_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_school_details");
	}
	

	if(isset($_POST["activation-btn"])){
		$activation_id = mysqli_real_escape_string($connection_server, preg_replace("/[^0-9]+/","",trim(strip_tags($_POST["activation-id"]))));
		$school_id = mysqli_real_escape_string($connection_server, preg_replace("/[^0-9]+/","",strip_tags($_POST["school-id"])));
		$activation_array = array(1, 2);
		if(!empty($activation_id) && in_array($activation_id, $activation_array) && !empty($school_id)){
			$search_school_with_details = mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='$school_id'");
			if(mysqli_num_rows($search_school_with_details) == 1){
				$search_cbt_activated_schools = mysqli_query($connection_server, "SELECT * FROM sm_cbt_activated_schools WHERE school_id_number='$school_id'");
				if($activation_id == 1){
					if(mysqli_num_rows($search_cbt_activated_schools) == 0){
						mysqli_query($connection_server, "INSERT INTO sm_cbt_activated_schools (school_id_number) VALUES ('$school_id')");
						$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=true".$additional_back_tag;
					}else{
						$redirect_url = $_SERVER["REQUEST_URI"]."&err=2";
					}
				}else{
					if($activation_id == 2){
						if(mysqli_num_rows($search_cbt_activated_schools) == 1){
							mysqli_query($connection_server, "DELETE FROM sm_cbt_activated_schools WHERE school_id_number='$school_id'");
							$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=true".$additional_back_tag;
						}else{
							$redirect_url = $_SERVER["REQUEST_URI"]."&err=4";
						}
					}else{
						$redirect_url = $_SERVER["REQUEST_URI"]."&err=3";
					}
				}
			}else{
				$redirect_url = $_SERVER["REQUEST_URI"]."&err=5";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
	
		header("Location: ".$redirect_url);
	}

	if(isset($_POST["search-item"])){
		$search_item_text = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["search-item"])));
		
		$page_to_go_link = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"]))."&search=".$search_item_text."&pnum=".$page_pnum;
		header("Location: ".$page_to_go_link);
	}
?>