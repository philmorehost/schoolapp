<?php
	
	$err_msg = "";
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: Notification with same details already exists in database";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: Another Notification has been with same details already exists in database";
	}
	
	$header_add_button = "add_notification";
	$additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
	//$header_view_button = "view_notification";
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
		$search_sqli_statement .= "numeric_class_name LIKE '%".$search_items."%'"."\n"."session LIKE '%".str_replace(["/","-"],"-",$search_items)."%'"."\n"."user LIKE '%".$search_items."%'"."\n"."title LIKE '%".$search_items."%'"."\n"."message LIKE '%".$search_items."%'";
	
	}
	
	$search_sqli_statements .= "(".str_replace("\n"," && school_id_number=".$get_logged_user_details['school_id_number'].") OR (", trim($search_sqli_statement))." && school_id_number=".$get_logged_user_details['school_id_number'].")";
	
	if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
		$select_notification_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_notifications WHERE $search_sqli_statements ".$user_notification_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_notification_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_notifications WHERE $search_sqli_statements ".$user_notification_statement_auth);
	}else{
		$select_notification_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_notifications WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_notification_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_notification_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_notifications WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_notification_statement_auth);
	}
	
	if(isset($_POST["add-notification"])){
		$title = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["title"])));
		$message = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["message"])));
		$session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["session"])));
		$user = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["user"])));
		$numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		if(!empty($title) && !empty($message) && !empty($session) && !empty($user) && !empty($numeric_class) && !empty($school_id)){
			if(mysqli_query($connection_server, "INSERT INTO sm_notifications (school_id_number, title, message, numeric_class_name, session, user) VALUES ('$school_id', '$title', '$message', '$numeric_class', '$session', '$user')") == true){
				$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=true".$additional_back_tag;
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["update-notification"])){
		$title = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["title"])));
		$message = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["message"])));
		$session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["session"])));
		$user = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["user"])));
		$numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		$current_notification_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["edit"])));
		$search_notification_with_id = mysqli_query($connection_server, "SELECT * FROM sm_notifications WHERE school_id_number='$school_id' && notification_id='$current_notification_id'");
		
		if(!empty($title) && !empty($message) && !empty($session) && !empty($user) && !empty($numeric_class) && !empty($school_id)){
			if(mysqli_num_rows($search_notification_with_id) == 1){
				if(mysqli_query($connection_server, "UPDATE sm_notifications SET title='$title', message='$message', numeric_class_name='$numeric_class', session='$session', user='$user' WHERE (school_id_number='$school_id' && notification_id='$current_notification_id')") == true){
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
	
	if(isset($_POST["delete-notification"])){
		$notification_id = $_POST["notification_id"];
		$school_id = $_POST["school_id"];
		foreach($notification_id as $index => $notification_id_no){
			$notification_id_no = mysqli_real_escape_string($connection_server, $notification_id[$index]);
			$sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
			
			$delete_school_selected_notification = mysqli_query($connection_server, "DELETE FROM sm_notifications WHERE (school_id_number='$sch_id_number' && notification_id='$notification_id_no')");
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