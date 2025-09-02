<?php
	
	$err_msg = "";
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: Transport with same Vehicle Identifier already exists in database";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: Another Transport has been with same details already exists in database";
	}
	
	$header_add_button = "add_transport";
	$additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
	//$header_view_button = "view_transport";
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
		$search_sqli_statement .= "route_name LIKE '%".$search_items."%'"."\n"." id_number LIKE '%".$search_items."%'"."\n"." reg_number LIKE '%".$search_items."%'"."\n"." driver_name LIKE '%".$search_items."%'"."\n"." phone_number LIKE '%".$search_items."%'"."\n"." home_address LIKE '%".$search_items."%'"."\n"." route_fares LIKE '%".$search_items."%'"."\n"." description LIKE '%".$search_items."%'";
	}
	
	$search_sqli_statements .= "(".str_replace("\n"," && school_id_number=".$get_logged_user_details['school_id_number'].") OR (", trim($search_sqli_statement))." && school_id_number=".$get_logged_user_details['school_id_number'].")";
	
	if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
		$select_transport_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_transports WHERE $search_sqli_statements ".$user_bus_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_transport_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_transports WHERE $search_sqli_statements ".$user_bus_statement_auth);
	}else{
		$select_transport_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_transports WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_bus_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_transport_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_transports WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_bus_statement_auth);
	}
	
	if(isset($_POST["add-transport"])){
		$route_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["route-name"])));
		$id_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["id-number"])));
		$reg_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["reg-number"])));
		$driver_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["driver-name"])));
		$phone = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["phone"])));
		$address = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["address"])));
		$description = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["description"])));
		$route_fares = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["route-fares"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		if(!empty($route_name) && !empty($id_number) && !empty($reg_number) && !empty($driver_name) && !empty($phone) && !empty($address) && !empty($route_fares) && !empty($school_id)){
			if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_transports WHERE (school_id_number='$school_id' && id_number='$id_number')")) == 0){
				if(mysqli_query($connection_server, "INSERT INTO sm_transports (school_id_number, route_name, id_number, reg_number, driver_name, phone_number, home_address, description, route_fares) VALUES ('$school_id', '$route_name', '$id_number', '$reg_number', '$driver_name', '$phone', '$address', '$description', '$route_fares')") == true){
					if(file_exists("dataimg/transport_".$school_id."_".$phone.".png")){
						unlink("dataimg/transport_".$school_id."_".$phone.".png");
						$photo_tmp_name = $_FILES["photo"]["tmp_name"];
						move_uploaded_file($photo_tmp_name,"dataimg/transport_".$school_id."_".$phone.".png");
					}else{
						$photo_tmp_name = $_FILES["photo"]["tmp_name"];
						move_uploaded_file($photo_tmp_name,"dataimg/transport_".$school_id."_".$phone.".png");
					}
					$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=true".$additional_back_tag;
				}
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["update-transport"])){
		$route_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["route-name"])));
		$id_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["id-number"])));
		$reg_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["reg-number"])));
		$driver_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["driver-name"])));
		$phone = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["phone"])));
		$address = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["address"])));
		$description = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["description"])));
		$route_fares = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["route-fares"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		$current_transport_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["edit"])));
		$search_transport_with_id = mysqli_query($connection_server, "SELECT * FROM sm_transports WHERE school_id_number='$school_id' && (id_number='$current_transport_id' OR id_number='$id_number')");
		
		if(!empty($route_name) && !empty($id_number) && !empty($reg_number) && !empty($driver_name) && !empty($phone) && !empty($address) && !empty($route_fares) && !empty($school_id)){
			if(mysqli_num_rows($search_transport_with_id) == 1){
				if(mysqli_query($connection_server, "UPDATE sm_transports SET route_name='$route_name', id_number='$id_number', reg_number='$reg_number', driver_name='$driver_name', phone_number='$phone', home_address='$address', description='$description', route_fares='$route_fares' WHERE (school_id_number='$school_id' && id_number='$current_transport_id')") == true){
					if(!empty($_FILES["photo"]["tmp_name"])){
						if(file_exists("dataimg/transport_".$school_id."_".$phone.".png")){
							unlink("dataimg/transport_".$school_id."_".$phone.".png");
							$photo_tmp_name = $_FILES["photo"]["tmp_name"];
							move_uploaded_file($photo_tmp_name,"dataimg/transport_".$school_id."_".$phone.".png");
						}else{
							$photo_tmp_name = $_FILES["photo"]["tmp_name"];
							move_uploaded_file($photo_tmp_name,"dataimg/transport_".$school_id."_".$phone.".png");
						}
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
	
	if(isset($_POST["delete-transport"])){
		$transport_id = $_POST["transport_id"];
		$school_id = $_POST["school_id"];
		foreach($transport_id as $index => $transport_id_no){
			$transport_id_no = mysqli_real_escape_string($connection_server, $transport_id[$index]);
			$sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
			
			$delete_school_selected_transport = mysqli_query($connection_server, "DELETE FROM sm_transports WHERE (school_id_number='$sch_id_number' && id_number='$transport_id_no')");
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