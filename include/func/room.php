<?php
	
	$err_msg = "";
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: Room with same details already exists in database";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: Another Room has been with same details already exists in database";
	}
	
	$header_add_button = "add_room";
	$additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
	//$header_view_button = "view_room";
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
		$search_sqli_statement .= "id_number LIKE '%".str_replace("rm","",$search_items)."%'"."\n"."hostel_id_number LIKE '%".$search_items."%'"."\n"."category_number LIKE '%".$search_items."%'"."\n"."bed_capacity LIKE '%".$search_items."%'"."\n"."room_description LIKE '%".$search_items."%'";
	
	}
	
	$search_sqli_statements .= "(".str_replace("\n"," && school_id_number=".$get_logged_user_details['school_id_number'].") OR (", trim($search_sqli_statement))." && school_id_number=".$get_logged_user_details['school_id_number'].")";
	
	if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
		$select_room_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_rooms WHERE $search_sqli_statements LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_room_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_rooms WHERE $search_sqli_statements");
	}else{
		$select_room_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_rooms WHERE school_id_number='".trim(strip_tags($_GET['id']))."' LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_room_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_rooms WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
	}
	
	if(isset($_POST["add-room"])){
		$hostel = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["hostel"])));
		
		$category = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["room-category"])));
		$category_number = array_filter(explode(" ",trim($category)))[0];
		$room_category = trim(substr($category,strlen($category_number)));
		
		$bed_capacity = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["bed-capacity"])));
		$room_desc = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["room-desc"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		$all_room_num_count = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_rooms WHERE school_id_number='$school_id'"));
		$check_last_room = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_rooms WHERE school_id_number='$school_id' LIMIT 1 OFFSET ".($all_room_num_count-1)));
		$room_no = sprintf("%03d",(($check_last_room["id_number"]) + 1));
		
		$search_room_with_id = mysqli_query($connection_server, "SELECT * FROM sm_rooms WHERE school_id_number='$school_id' && id_number='$room_no' && category_number='$category_number' && hostel_id_number='$hostel'");
		$search_room_list_with_id = mysqli_query($connection_server, "SELECT * FROM sm_room_list WHERE school_id_number='$school_id' && category_number='$category_number'");
		
		if(!empty($hostel) && !empty($category_number) && !empty($room_category) && !empty($bed_capacity) && !empty($room_no) && !empty($school_id)){
			if(mysqli_num_rows($search_room_with_id) == 0){
				if(mysqli_query($connection_server, "INSERT INTO sm_rooms (school_id_number, id_number, hostel_id_number, category_number, bed_capacity, room_description) VALUES ('$school_id','$room_no','$hostel','$category_number','$bed_capacity','$room_desc')") == true){
					/*if(mysqli_num_rows($search_room_list_with_id) == 0){
						if(mysqli_query($connection_server, "INSERT INTO sm_room_list (school_id_number, category_number, room_category) VALUES ('$school_id','$category_number','$room_category')") == true){
							
						}
					}*/
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
	
	if(isset($_POST["update-room"])){
		$hostel = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["hostel"])));
		
		$category = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["room-category"])));
		$category_number = array_filter(explode(" ",trim($category)))[0];
		$room_category = trim(substr($category,strlen($category_number)));
		
		$bed_capacity = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["bed-capacity"])));
		$room_desc = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["room-desc"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		$current_room_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["edit"])));
		$current_category_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["category"])));
		$current_hostel_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["hostel"])));
		
		$search_room_with_id = mysqli_query($connection_server, "SELECT * FROM sm_rooms WHERE school_id_number='$school_id' && id_number='$current_room_id' && (category_number='$category_number' OR category_number='$current_category_id') && (hostel_id_number='$hostel' OR hostel_id_number='$current_hostel_id')");
		$search_room_list_with_id = mysqli_query($connection_server, "SELECT * FROM sm_room_list WHERE school_id_number='$school_id' && category_number='$category_number'");
		
		if(!empty($hostel) && !empty($category_number) && !empty($room_category) && !empty($bed_capacity) && !empty($current_room_id) && !empty($school_id)){
			if(mysqli_num_rows($search_room_with_id) == 1){
				if(mysqli_query($connection_server, "UPDATE sm_rooms SET school_id_number='$school_id', id_number='$current_room_id', hostel_id_number='$hostel', category_number='$category_number', bed_capacity='$bed_capacity', room_description='$room_desc' WHERE (school_id_number='$school_id' && id_number='$current_room_id' && category_number='$current_category_id' && hostel_id_number='$current_hostel_id')") == true){
					/*if(mysqli_num_rows($search_room_list_with_id) == 0){
						if(mysqli_query($connection_server, "INSERT INTO sm_room_list (school_id_number, category_number, room_category) VALUES ('$school_id','$category_number','$room_category')") == true){
						
						}
					}else{
						if(mysqli_query($connection_server, "UPDATE sm_room_list SET school_id_number='$school_id', category_number='$category_number', room_category='$room_category' WHERE school_id_number='$school_id' && category_number='$category_number'") == true){
							
						}
					}*/
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
	
	if(isset($_POST["delete-room"])){
		$room_id = $_POST["room_id"];
		$category_no = $_POST["category_no"];
		$school_id = $_POST["school_id"];
		foreach($room_id as $index => $room_id_no){
			$room_id_num = mysqli_real_escape_string($connection_server, $room_id[$index]);
			$category_number = mysqli_real_escape_string($connection_server, $category_no[$index]);
			$sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
			
			
			if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_rooms WHERE (school_id_number='$sch_id_number' && category_number='$category_number')")) == 1){
				$delete_school_selected_room_list = mysqli_query($connection_server, "DELETE FROM sm_room_list WHERE (school_id_number='$sch_id_number' && category_number='$category_number')");
			}
			$delete_school_selected_room = mysqli_query($connection_server, "DELETE FROM sm_rooms WHERE (school_id_number='$sch_id_number' && id_number='$room_id_num')");
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