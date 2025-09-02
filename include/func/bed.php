<?php
	
	$err_msg = "";
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: Bed with same details already exists in database";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: Another Bed has been with same details already exists in database";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "4"){
		$err_msg .= "Error: Bed space not available";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "5"){
		$err_msg .= "Bed Assigned Successfully";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "6"){
		$err_msg .= "The Bed has been assigned to this student already";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "7"){
		$err_msg .= "Bed has be to another user already";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "8"){
		$err_msg .= "Error: Bed space utilized but has been reassign to the student";
	}
	
	
	$header_add_button = "add_bed";
	$additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
	//$header_view_button = "view_bed";
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
		$search_sqli_statement .= "id_number LIKE '%".str_replace("bd","",strtolower($search_items))."%'"."\n"." room_id_number LIKE '%".str_replace("rm","",strtolower($search_items))."%'"."\n"." bed_description LIKE '%".$search_items."%'";
	
	}
	
	$search_sqli_statements .= "(".str_replace("\n"," && school_id_number=".$get_logged_user_details['school_id_number'].") OR (", trim($search_sqli_statement))." && school_id_number=".$get_logged_user_details['school_id_number'].")";
	
	if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
		$select_bed_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_beds WHERE $search_sqli_statements ".$user_bed_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_bed_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_beds WHERE $search_sqli_statements ".$user_bed_statement_auth);
	}else{
		$select_bed_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_beds WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_bed_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_bed_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_beds WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_bed_statement_auth);
	}
	
	if(isset($_POST["add-bed"])){
		$room = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["room"])));
		$bed_desc = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["bed-desc"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		$all_bed_num_count = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_beds WHERE school_id_number='$school_id'"));
		$check_last_bed = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_beds WHERE school_id_number='$school_id' LIMIT 1 OFFSET ".($all_bed_num_count-1)));
		$bed_no = sprintf("%03d",(($check_last_bed["id_number"]) + 1));
		
		$search_bed_with_id = mysqli_query($connection_server, "SELECT * FROM sm_beds WHERE school_id_number='$school_id' && id_number='$bed_no' && room_id_number='$room'");
		$count_bed_capacity_with_room_id = mysqli_query($connection_server, "SELECT * FROM sm_rooms WHERE school_id_number='$school_id' && id_number='$room'");
		$count_bed_created_with_room_id = mysqli_query($connection_server, "SELECT * FROM sm_beds WHERE school_id_number='$school_id' && room_id_number='$room'");
		$fetch_bed_capacity_detail = mysqli_fetch_array($count_bed_capacity_with_room_id);
		
		if(!empty($room) && !empty($bed_no) && !empty($school_id)){
			if(mysqli_num_rows($search_bed_with_id) == 0){
				if((mysqli_num_rows($count_bed_capacity_with_room_id) > 0) && ($fetch_bed_capacity_detail["bed_capacity"] > mysqli_num_rows($count_bed_created_with_room_id))){
					if(mysqli_query($connection_server, "INSERT INTO sm_beds (school_id_number, id_number, room_id_number, bed_description) VALUES ('$school_id','$bed_no','$room','$bed_desc')") == true){
						$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=true".$additional_back_tag;
					}
				}else{
					$redirect_url = $_SERVER["REQUEST_URI"]."&err=4";
				}
			}else{
				$redirect_url = $_SERVER["REQUEST_URI"]."&err=2";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["update-bed"])){
		$room = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["room"])));
		$bed_desc = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["bed-desc"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		$current_bed_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["edit"])));
		$current_room_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["room"])));
		
		$search_bed_with_id = mysqli_query($connection_server, "SELECT * FROM sm_beds WHERE school_id_number='$school_id' && id_number='$current_bed_id' && (room_id_number='$room' OR room_id_number='$current_room_id')");
		$count_bed_capacity_with_room_id = mysqli_query($connection_server, "SELECT * FROM sm_rooms WHERE school_id_number='$school_id' && id_number='$room'");
		$count_bed_created_with_room_id = mysqli_query($connection_server, "SELECT * FROM sm_beds WHERE school_id_number='$school_id' && room_id_number='$room'");
		$fetch_bed_capacity_detail = mysqli_fetch_array($count_bed_capacity_with_room_id);
		if(!empty($room) && !empty($current_room_id) && !empty($current_bed_id) && !empty($school_id)){
			if(mysqli_num_rows($search_bed_with_id) == 1){
				if(((mysqli_num_rows($count_bed_capacity_with_room_id) > 0) && ($fetch_bed_capacity_detail["bed_capacity"] > mysqli_num_rows($count_bed_created_with_room_id))) || ($current_room_id == $room)){
					if(mysqli_query($connection_server, "UPDATE sm_beds SET school_id_number='$school_id', id_number='$current_bed_id', room_id_number='$room', bed_description='$bed_desc' WHERE (school_id_number='$school_id' && id_number='$current_bed_id' && room_id_number='$current_room_id')") == true){
						$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=true".$additional_back_tag;
					}
				}else{
					$redirect_url = $_SERVER["REQUEST_URI"]."&err=4";
				}
			}else{
				$redirect_url = $_SERVER["REQUEST_URI"]."&err=3";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["assign-bed"])){
		$admission_no = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["admission-number"])));
		
		$bed_room_value_explode = array_filter(explode(" ",trim(mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["bed-room"]))))));
		$bed_id = $bed_room_value_explode[0];
		$room_id = $bed_room_value_explode[1];
		
		$school_id = $get_logged_user_details["school_id_number"];
		
		$search_bed_with_id = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$school_id' && bed_id_number='$bed_id'");
		$fetch_bed_with_id_detail = mysqli_fetch_array($search_bed_with_id);
		$count_bed_capacity_with_room_id = mysqli_query($connection_server, "SELECT * FROM sm_rooms WHERE school_id_number='$school_id' && id_number='$room_id'");
		$count_bed_created_with_room_id = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$school_id' && bed_id_number='$bed_id'");
		$fetch_bed_capacity_detail = mysqli_fetch_array($count_bed_capacity_with_room_id);
		
		if(mysqli_num_rows($search_bed_with_id) == 0){
			if(((mysqli_num_rows($count_bed_capacity_with_room_id) == 1) && ($fetch_bed_capacity_detail["bed_capacity"] > mysqli_num_rows($count_bed_created_with_room_id)))){
				if(mysqli_query($connection_server, "UPDATE sm_students SET bed_id_number='$bed_id' WHERE school_id_number='$school_id' && admission_number='$admission_no'") == true){
					
					$get_mail_stu_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$school_id' && admission_number='$admission_no' LIMIT 1"));
					$get_mail_room_id_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_rooms WHERE school_id_number='$school_id' && id_number='$room_id' LIMIT 1"));
					$get_mail_hostel_name_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_hostels WHERE school_id_number='$school_id' && id_number='".$get_mail_room_id_detail["hostel_id_number"]."' LIMIT 1"));
					$get_mail_sch_name = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='$school_id' LIMIT 1"));
					
					// Always set content-type when sending HTML email
					$mail_headers = "MIME-Version: 1.0" . "\r\n";
					$mail_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					
					// More headers
					$mail_headers .= 'From: <'.$get_mail_sch_name["email"].'>' . "\r\n";
					$mail_headers .= 'Cc: '.$get_mail_sch_name["email"]."\r\n";
					
					$email_title = 
					str_replace("{{student_name}}",$get_mail_stu_detail["firstname"]." ".$get_mail_stu_detail["lastname"]." ".$get_mail_stu_detail["othername"],
						str_replace("{{hostel_name}}",$get_mail_hostel_name_detail["hostel_name"],
							str_replace("{{room_id}}",$room_id,
								str_replace("{{bed_id}}",$bed_id,
									str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
										emailTemplateTableExist('hostel-bed','title','data')
									)
								)
							)
						)
					);
					
					$email_message = 
					mailDesignTemplate($email_title,
					str_replace("{{student_name}}",$get_mail_stu_detail["firstname"]." ".$get_mail_stu_detail["lastname"]." ".$get_mail_stu_detail["othername"],
						str_replace("{{hostel_name}}",$get_mail_hostel_name_detail["hostel_name"],
							str_replace("{{room_id}}",$room_id,
								str_replace("{{bed_id}}",$bed_id,
									str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
										emailTemplateTableExist('hostel-bed','message','data')
									)
								)
							)
						)
					),'');
					customBCMailSender('',$get_mail_stu_detail["email"],$email_title,$email_message,$mail_headers);

					$redirect_url = str_replace(["&student_id=".$admission_no,"room_id=".trim(strip_tags($_GET['room_id'])),"bed_id=".trim(strip_tags($_GET['bed_id'])),"err=8","err=5","err=6","err=7"],"",$_SERVER["REQUEST_URI"])."&student_id=".$admission_no."&room_id=".$room_id."&bed_id=".$bed_id."&err=5";
				}
			}
		}else{
			if((mysqli_num_rows($search_bed_with_id) == 1) && ($fetch_bed_with_id_detail["admission_number"] == $admission_no)){
				$redirect_url = str_replace(["&student_id=".$admission_no,"room_id=".trim(strip_tags($_GET['room_id'])),"bed_id=".trim(strip_tags($_GET['bed_id'])),"err=8","err=5","err=6","err=7"],"",$_SERVER["REQUEST_URI"])."&student_id=".$admission_no."&room_id=".$room_id."&bed_id=".$bed_id."&err=6";
			}else{
				if(mysqli_query($connection_server, "UPDATE sm_students SET bed_id_number='' WHERE school_id_number='$school_id' && admission_number='".$fetch_bed_with_id_detail["admission_number"]."'") == true){
					if(mysqli_query($connection_server, "UPDATE sm_students SET bed_id_number='$bed_id' WHERE school_id_number='$school_id' && admission_number='$admission_no'") == true){
						
						$get_mail_stu_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$school_id' && admission_number='$admission_no' LIMIT 1"));
						$get_mail_room_id_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_rooms WHERE school_id_number='$school_id' && id_number='$room_id' LIMIT 1"));
						$get_mail_hostel_name_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_hostels WHERE school_id_number='$school_id' && id_number='".$get_mail_room_id_detail["hostel_id_number"]."' LIMIT 1"));
						$get_mail_sch_name = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='$school_id' LIMIT 1"));
						
						// Always set content-type when sending HTML email
						$mail_headers = "MIME-Version: 1.0" . "\r\n";
						$mail_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						
						// More headers
						$mail_headers .= 'From: <'.$get_mail_sch_name["email"].'>' . "\r\n";
						$mail_headers .= 'Cc: '.$get_mail_sch_name["email"]."\r\n";
						
						$email_title = 
						str_replace("{{student_name}}",$get_mail_stu_detail["firstname"]." ".$get_mail_stu_detail["lastname"]." ".$get_mail_stu_detail["othername"],
							str_replace("{{hostel_name}}",$get_mail_hostel_name_detail["hostel_name"],
								str_replace("{{room_id}}",$room_id,
									str_replace("{{bed_id}}",$bed_id,
										str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
											emailTemplateTableExist('hostel-bed','title','data')
										)
									)
								)
							)
						);
						
						$email_message = 
						str_replace("{{student_name}}",$get_mail_stu_detail["firstname"]." ".$get_mail_stu_detail["lastname"]." ".$get_mail_stu_detail["othername"],
							str_replace("{{hostel_name}}",$get_mail_hostel_name_detail["hostel_name"],
								str_replace("{{room_id}}",$room_id,
									str_replace("{{bed_id}}",$bed_id,
										str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
											emailTemplateTableExist('hostel-bed','message','data')
										)
									)
								)
							)
						);
						customBCMailSender('',$get_mail_stu_detail["email"],"UPDATED: ".$email_title,$email_message,$mail_headers);
	
						$redirect_url = str_replace(["&student_id=".$admission_no,"room_id=".trim(strip_tags($_GET['room_id'])),"bed_id=".trim(strip_tags($_GET['bed_id'])),"err=8","err=5","err=6","err=7"],"",$_SERVER["REQUEST_URI"])."&student_id=".$admission_no."&room_id=".$room_id."&bed_id=".$bed_id."&err=8";
					}
				}
			}
		}
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["delete-bed"])){
		$bed_id = $_POST["bed_id"];
		$room_id = $_POST["room_id"];
		$school_id = $_POST["school_id"];
		foreach($bed_id as $index => $bed_id_no){
			$bed_id_num = mysqli_real_escape_string($connection_server, $bed_id[$index]);
			$room_id_number = mysqli_real_escape_string($connection_server, $room_id[$index]);
			$sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
			$remove_student_bed_id_number = mysqli_query($connection_server, "UPDATE sm_students SET bed_id_number='' WHERE (school_id_number='$sch_id_number' && bed_id_number='$bed_id_num')");
			$delete_school_selected_bed = mysqli_query($connection_server, "DELETE FROM sm_beds WHERE (school_id_number='$sch_id_number' && id_number='$bed_id_num' && room_id_number='$room_id_number')");
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