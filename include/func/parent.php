<?php
	
	$err_msg = "";
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: Parent with same details already exists in database";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: Parent details already exists in database";
	}
	
	$header_add_button = "add_parent";
	$additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
	$header_view_button = "view_parent";
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
		$search_sqli_statement .= "email LIKE '%".$search_items."%'"."\n"."id_number LIKE '%".$search_items."%'"."\n"."father_last_name LIKE '%".$search_items."%'"."\n"."father_first_name LIKE '%".$search_items."%'"."\n"."mother_last_name LIKE '%".$search_items."%'"."\n"."mother_first_name LIKE '%".$search_items."%'"."\n"."father_phone_number LIKE '%".$search_items."%'"."\n"."mother_phone_number LIKE '%".$search_items."%'"."\n"."father_occupation LIKE '%".$search_items."%'"."\n"."mother_occupation LIKE '%".$search_items."%'"."\n"."home_address LIKE '%".$search_items."%'"."\n"."city LIKE '%".$search_items."%'"."\n"."state LIKE '%".$search_items."%'"."\n"."country LIKE '%".$search_items."%'";
	
	}
	
	$search_sqli_statements .= "(".str_replace("\n"," && school_id_number=".$get_logged_user_details['school_id_number'].") OR (", trim($search_sqli_statement))." && school_id_number=".$get_logged_user_details['school_id_number'].")";
	
	if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
		$select_parent_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE $search_sqli_statements LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_parent_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE $search_sqli_statements");
	}else{
		$select_parent_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number='".trim(strip_tags($_GET['id']))."' LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_parent_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
	}
	
	if(isset($_POST["add-parent"])){
		$f_last = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["f_first"])));
		$f_first = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["f_last"])));
		$m_last = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["m_first"])));
		$m_first = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["m_last"])));
		$address = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["address"])));
		$city = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["city"])));
		$state = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["state"])));
		$country = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["country"])));
		$f_phone = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["f_phone"])));
		$m_phone = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["m_phone"])));
		$f_occupation = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["f_occupation"])));
		$m_occupation = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["m_occupation"])));
		$email = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email"])));
		$password = md5(mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["password"]))));
		$school_id = $get_logged_user_details["school_id_number"];
		
		// $all_parent_num_count = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number='$school_id'"));
		// $check_last_parent = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number='$school_id' LIMIT 1 OFFSET ".($all_parent_num_count-1)));
		// $id_number = sprintf("%03d",(($check_last_parent["id_number"]) + 1));
		
		$all_existing_user_num_count = mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number='$school_id'");
		if(mysqli_num_rows($all_existing_user_num_count) > 0){
			while($each_user_id_number = mysqli_fetch_array($all_existing_user_num_count)){
				if(date("y") === substr($each_user_id_number["id_number"],0,2)){
					$last_user_id_number .= substr($each_user_id_number["id_number"],2).",";
				}
			}
			$id_number = date("y").(sprintf("%04d",(max(array_filter(explode(",",trim($last_user_id_number)))))+1));
		}else{
			$id_number = date("y").(sprintf("%04d",1));
		}
		
		if(!empty($f_last) && !empty($f_first) && !empty($m_last) && !empty($m_first) && !empty($address) && !empty($city) && !empty($state) && !empty($country) && !empty($f_phone) && !empty($m_phone) && !empty($f_occupation) && !empty($m_occupation) && !empty($email) && !empty($password) && !empty($school_id)){
			if(mysqli_query($connection_server, "INSERT INTO sm_parents (email, password, school_id_number, id_number, father_last_name, father_first_name, mother_last_name, mother_first_name, father_phone_number, mother_phone_number, father_occupation, mother_occupation, home_address, city, state, country) VALUES ('$email','$password','$school_id','$id_number','$f_last','$f_first','$m_first','$m_first','$f_phone','$m_phone','$f_occupation','$m_occupation','$address','$city','$state','$country')") == true){
				
				$get_mail_sch_name = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='$school_id' LIMIT 1"));
				
				// Always set content-type when sending HTML email
				$mail_headers = "MIME-Version: 1.0" . "\r\n";
				$mail_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
				
				// More headers
				$mail_headers .= 'From: <'.$get_mail_sch_name["email"].'>' . "\r\n";
				$mail_headers .= 'Cc: '.$get_mail_sch_name["email"]."\r\n";
				
				$email_title = 
				str_replace("{{username}}","PA/".$school_id."/".$id_number,
					str_replace("{{user_name}}","Mr/Mrs ".$f_last,
						str_replace("{{role}}","Parent",
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
				str_replace("{{username}}","PA/".$school_id."/".$id_number,
					str_replace("{{user_name}}","Mr/Mrs ".$f_last,
						str_replace("{{role}}","Parent",
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
				
				if(file_exists("dataimg/parent_".$school_id."_".$id_number.".png")){
					unlink("dataimg/parent_".$school_id."_".$id_number.".png");
					$photo_tmp_name = $_FILES["photo"]["tmp_name"];
					move_uploaded_file($photo_tmp_name,"dataimg/parent_".$school_id."_".$id_number.".png");
				}else{
					$photo_tmp_name = $_FILES["photo"]["tmp_name"];
					move_uploaded_file($photo_tmp_name,"dataimg/parent_".$school_id."_".$id_number.".png");
				}

				if((strip_tags($_GET['page']) == 'smgt_parent') && (strip_tags($_GET['tab']) == 'add_parent')){
					$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=true".$additional_back_tag;
				}

				if((strip_tags($_GET['page']) == 'smgt_parent_student') && (strip_tags($_GET['tab']) == 'parent_reg')){
					$redirect_url = "/bc-admin.php?page=smgt_parent_student&tab=student_reg&id=".$school_id."&parent_id=".$id_number;
				}
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["update-parent"])){
		$f_last = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["f_first"])));
		$f_first = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["f_last"])));
		$m_last = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["m_first"])));
		$m_first = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["m_last"])));
		$address = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["address"])));
		$city = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["city"])));
		$state = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["state"])));
		$country = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["country"])));
		$f_phone = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["f_phone"])));
		$m_phone = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["m_phone"])));
		$f_occupation = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["f_occupation"])));
		$m_occupation = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["m_occupation"])));
		$email = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["email"])));
		$password = md5(mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["password"]))));
		$school_id = $get_logged_user_details["school_id_number"];
		
		$current_account_id_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["edit"])));
		
		$search_parent_with_id_email_phone = mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE (school_id_number='$school_id' && id_number='$current_account_id_number')");
		
		if(!empty($f_last) && !empty($f_first) && !empty($m_last) && !empty($m_first) && !empty($address) && !empty($city) && !empty($state) && !empty($country) && !empty($f_phone) && !empty($m_phone) && !empty($f_occupation) && !empty($m_occupation) && !empty($email) && !empty($password) && !empty($school_id)){
			if(mysqli_num_rows($search_parent_with_id_email_phone) == 1){
				
				if(mysqli_query($connection_server, "UPDATE sm_parents SET email='$email', password='$password', school_id_number='$school_id', father_last_name='$f_last', father_first_name='$f_first', mother_last_name='$m_last', mother_first_name='$m_first', father_phone_number='$f_phone', mother_phone_number='$m_phone', father_occupation='$f_occupation', mother_occupation='$m_occupation', home_address='$address', city='$city', state='$state', country='$country' WHERE (school_id_number='$school_id' && id_number='$current_account_id_number')") == true){
					if(!empty($_FILES["photo"]["tmp_name"])){
						if(file_exists("dataimg/parent_".$school_id."_".$current_account_id_number.".png")){
							unlink("dataimg/parent_".$school_id."_".$current_account_id_number.".png");
							$photo_tmp_name = $_FILES["photo"]["tmp_name"];
							move_uploaded_file($photo_tmp_name,"dataimg/parent_".$school_id."_".$current_account_id_number.".png");
						}else{
							$photo_tmp_name = $_FILES["photo"]["tmp_name"];
							move_uploaded_file($photo_tmp_name,"dataimg/parent_".$school_id."_".$current_account_id_number.".png");
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
				str_replace("{{username}}","PA/".$school_id."/".$current_account_id_number,
					str_replace("{{user_name}}","Mr/Mrs ".$f_last,
						str_replace("{{role}}","Parent",
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
				str_replace("{{username}}","PA/".$school_id."/".$id_number,
					str_replace("{{user_name}}","Mr/Mrs ".$f_last,
						str_replace("{{role}}","Parent",
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
	
	if(isset($_POST["delete-parent"])){
		$parent_id = $_POST["parent_id"];
		$school_id = $_POST["school_id"];
		foreach($parent_id as $index => $parent_id_no){
			$parent = mysqli_real_escape_string($connection_server, $parent_id[$index]);
			$sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
			$delete_parent_detail_1 = mysqli_query($connection_server, "DELETE FROM sm_parents WHERE (school_id_number='$sch_id_number' && id_number='$parent')");
			$delete_parent_detail_2 = mysqli_query($connection_server, "UPDATE sm_students SET parent_id_number='' WHERE (school_id_number='$sch_id_number' && parent_id_number='$parent')");
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