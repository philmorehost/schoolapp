<?php
	
	$err_msg = "";
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: Admin Staff with same details already exists in database";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: Admin Staff details already exists in database";
	}
	
	$header_add_button = "add_admin_staff";
	$additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
	$header_view_button = "view_admin_staff";
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
		$search_sqli_statement .= "email LIKE '%".$search_items."%'"."\n"."id_number LIKE '%".$search_items."%'"."\n"."lastname LIKE '%".$search_items."%'"."\n"."firstname LIKE '%".$search_items."%'"."\n"."phone_number LIKE '%".$search_items."%'"."\n"."gender LIKE '%".$search_items."%'"."\n"."marital_status LIKE '%".$search_items."%'"."\n"."home_address LIKE '%".$search_items."%'"."\n"."dob LIKE '%".str_replace(["/","-"],"-",$search_items)."%'"."\n"."city LIKE '%".$search_items."%'"."\n"."state LIKE '%".$search_items."%'"."\n"."country LIKE '%".$search_items."%'";
	
	}
	
	$search_sqli_statements .= "(".str_replace("\n"," && school_id_number=".$get_logged_user_details['school_id_number'].") OR (", trim($search_sqli_statement))." && school_id_number=".$get_logged_user_details['school_id_number'].")";
	
	if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
		$select_admin_staff_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_admin_staffs WHERE $search_sqli_statements LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_admin_staff_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_admin_staffs WHERE $search_sqli_statements");
	}else{
		$select_admin_staff_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_admin_staffs WHERE school_id_number='".trim(strip_tags($_GET['id']))."' LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_admin_staff_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_admin_staffs WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
	}
	
	if(isset($_POST["add-admin-staff"])){
		$last = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["first"])));
		$first = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["last"])));
		$gender = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["gender"])));
		$dob = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["dob"])));
		$address = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["address"])));
		$city = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["city"])));
		$state = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["state"])));
		$country = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["country"])));
		$phone = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["phone"])));
		$marital = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["marital"])));
		$email = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email"])));
		$password = md5(mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["password"]))));
		$school_id = $get_logged_user_details["school_id_number"];
		
		// $all_admin_staff_num_count = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_admin_staffs WHERE school_id_number='$school_id'"));
		// $check_last_admin_staff = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_admin_staffs WHERE school_id_number='$school_id' LIMIT 1 OFFSET ".($all_admin_staff_num_count-1)));
		// $admin_staff_no = sprintf("%03d",(($check_last_admin_staff["id_number"]) + 1));
		
		$all_existing_user_num_count = mysqli_query($connection_server, "SELECT * FROM sm_admin_staffs WHERE school_id_number='$school_id'");
		if(mysqli_num_rows($all_existing_user_num_count) > 0){
			while($each_user_id_number = mysqli_fetch_array($all_existing_user_num_count)){
				if(date("y") === substr($each_user_id_number["id_number"],0,2)){
					$last_user_id_number .= substr($each_user_id_number["id_number"],2).",";
				}
			}
			$admin_staff_no = date("y").(sprintf("%04d",(max(array_filter(explode(",",trim($last_user_id_number)))))+1));
		}else{
			$admin_staff_no = date("y").(sprintf("%04d",1));
		}
		
		if(!empty($last) && !empty($first) && !empty($admin_staff_no) && !empty($gender) && !empty($dob) && !empty($address) && !empty($city) && !empty($state) && !empty($country) && !empty($phone) && !empty($email) && !empty($password) && !empty($school_id)){
			if(mysqli_query($connection_server, "INSERT INTO sm_admin_staffs (email, password, school_id_number, id_number, lastname, firstname, phone_number, gender, marital_status, home_address, dob, city, state, country) VALUES ('$email','$password','$school_id','$admin_staff_no','$last','$first','$phone','$gender','$marital','$address','$dob','$city','$state','$country')") == true){
				
				$get_mail_sch_name = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='$school_id' LIMIT 1"));
				
				// Always set content-type when sending HTML email
				$mail_headers = "MIME-Version: 1.0" . "\r\n";
				$mail_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				
				// More headers
				$mail_headers .= 'From: <'.$get_mail_sch_name["email"].'>' . "\r\n";
				$mail_headers .= 'Cc: '.$get_mail_sch_name["email"]."\r\n";
				
				$email_title = 
				str_replace("{{username}}","AS/".$school_id."/".$admin_staff_no,
					str_replace("{{user_name}}",$last." ".$first,
						str_replace("{{role}}","Admin Staff",
							str_replace("{{login_link}}",$_SERVER["HTTP_HOST"]."/bc-login.php",
								str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
									str_replace("{{password}}",trim(strip_tags($_POST["password"])),
										emailTemplateTableExist('add-user','title','data')
									)
								)
							)
						)
					)
				);
				
				$email_message = 
				mailDesignTemplate($email_title,
				str_replace("{{username}}","AS/".$school_id."/".$admin_staff_no,
					str_replace("{{user_name}}",$last." ".$first,
						str_replace("{{role}}","Admin Staff",
							str_replace("{{login_link}}",$_SERVER["HTTP_HOST"]."/bc-login.php",
								str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
									str_replace("{{password}}",trim(strip_tags($_POST["password"])),
										emailTemplateTableExist('add-user','message','data')
									)
								)
							)
						)
					)
				),'');
				
				customBCMailSender('',$email,$email_title,$email_message,$mail_headers);
				
				if(file_exists("dataimg/adminstaff_".$phone.".png")){
					unlink("dataimg/adminstaff_".$phone.".png");
					$photo_tmp_name = $_FILES["photo"]["tmp_name"];
					move_uploaded_file($photo_tmp_name,"dataimg/adminstaff_".$school_id."_".$admin_staff_no.".png");
				}else{
					$photo_tmp_name = $_FILES["photo"]["tmp_name"];
					move_uploaded_file($photo_tmp_name,"dataimg/adminstaff_".$school_id."_".$admin_staff_no.".png");
				}
				$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=true".$additional_back_tag;
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}
		
	if(isset($_POST["update-admin-staff"])){
		$last = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["first"])));
		$first = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["last"])));
		$gender = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["gender"])));
		$dob = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["dob"])));
		$address = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["address"])));
		$city = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["city"])));
		$state = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["state"])));
		$country = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["country"])));
		$phone = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["phone"])));
        $marital = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["marital"])));
		$email = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email"])));
		$password = md5(mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["password"]))));
		$school_id = $get_logged_user_details["school_id_number"];
		
		$current_account_id_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["edit"])));
		$search_admin_staff_with_id_email_phone = mysqli_query($connection_server, "SELECT * FROM sm_admin_staffs WHERE school_id_number='$school_id' && id_number='$current_account_id_number'");
		
		if(!empty($last) && !empty($first) && !empty($gender) && !empty($dob) && !empty($address) && !empty($city) && !empty($state) && !empty($country) && !empty($phone) && !empty($email) && !empty($password) && !empty($school_id)){
			if(mysqli_num_rows($search_admin_staff_with_id_email_phone) == 1){
				if(mysqli_query($connection_server, "UPDATE sm_admin_staffs SET email='$email', password='$password', lastname='$last', firstname='$first', phone_number='$phone', gender='$gender', marital_status='$marital', home_address='$address', dob='$dob', city='$city', state='$state', country='$country' WHERE (school_id_number='$school_id' && id_number='$current_account_id_number')") == true){
					if(!empty($_FILES["photo"]["tmp_name"])){
						if(file_exists("dataimg/adminstaff_".$phone.".png")){
							unlink("dataimg/adminstaff_".$phone.".png");
							$photo_tmp_name = $_FILES["photo"]["tmp_name"];
							move_uploaded_file($photo_tmp_name,"dataimg/adminstaff_".$school_id."_".$current_account_id_number.".png");
						}else{
							$photo_tmp_name = $_FILES["photo"]["tmp_name"];
							move_uploaded_file($photo_tmp_name,"dataimg/adminstaff_".$school_id."_".$current_account_id_number.".png");
						}
					}
					
					$get_mail_sch_name = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='$school_id' LIMIT 1"));
					
					// Always set content-type when sending HTML email
					$mail_headers = "MIME-Version: 1.0" . "\r\n";
					$mail_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					
					// More headers
					$mail_headers .= 'From: <'.$get_mail_sch_name["email"].'>' . "\r\n";
					$mail_headers .= 'Cc: '.$get_mail_sch_name["email"]."\r\n";
					
					$email_title = 
					mailDesignTemplate($email_title,
					str_replace("{{username}}","AS/".$school_id."/".$current_account_id_number,
						str_replace("{{user_name}}",$last." ".$first,
							str_replace("{{role}}","Admin Staff",
								str_replace("{{login_link}}",$_SERVER["HTTP_HOST"]."/bc-login.php",
									str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
										str_replace("{{password}}",trim(strip_tags($_POST["password"])),
											emailTemplateTableExist('add-user','title','data')
										)
									)
								)
							)
						)
					),'');
					
					$email_message = 
					str_replace("{{username}}","AS/".$school_id."/".$admin_staff_no,
						str_replace("{{user_name}}",$last." ".$first,
							str_replace("{{role}}","Admin Staff",
								str_replace("{{login_link}}",$_SERVER["HTTP_HOST"]."/bc-login.php",
									str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
										str_replace("{{password}}",trim(strip_tags($_POST["password"])),
											emailTemplateTableExist('add-user','message','data')
										)
									)
								)
							)
						)
					);
					
					customBCMailSender('',$email,"UPDATED: ".$email_title,$email_message,$mail_headers);
					
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
	
	if(isset($_POST["delete-admin-staff"])){
		$admin_staff_id = $_POST["admin_staff_id"];
		$school_id = $_POST["school_id"];
		foreach($admin_staff_id as $index => $admin_staff_id_no){
			$admin_staff = mysqli_real_escape_string($connection_server, $admin_staff_id[$index]);
			$sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
			$delete_admin_staff_selected_class = mysqli_query($connection_server, "DELETE FROM sm_admin_staffs WHERE (school_id_number='$sch_id_number' && id_number='$admin_staff')");
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