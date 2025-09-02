<?php
	
	$err_msg = "";
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}

	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: School details already exists in database";
	}

	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: Cannot update School, Moderator details already exists in database";
	}

	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "4"){
		$err_msg .= "Error: Other Schools with same Email or Phone number already exists in database";
	}

	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "5"){
		$err_msg .= "Error: School doesn't exists in database";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "6"){
		$err_msg .= "Error: Mismatched password";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "7"){
		$err_msg .= "Success: Account details updated successfully";
	}

	$header_add_button = "add_student";
	$additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
	$header_view_button = "view_student";
	$additional_back_tag .= "&id=".$get_logged_user_details['school_id_number'];
	
		if(isset($_POST["update-school"])){
		$mod_first = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-first"])));
		$mod_last = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-last"])));
		$mod_acc_pass = md5(mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-acc-pass"]))));
		$mod_gender = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-gender"])));
        $mod_marital = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-marital"])));
		$mod_phone = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-phone"])));
		$mod_city = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-city"])));
		$mod_state = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-state"])));
		$mod_country = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-country"])));
		$mod_home_address = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-home-address"])));
		$mod_office_address = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["mod-office-address"])));
		
		$sch_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["name"])));
		$sch_motto = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["motto"])));
		$sch_address = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["address"])));
        $sch_phone = $mod_phone;
        $sch_city = $mod_city;
		$sch_state = $mod_state;
		$sch_country = $mod_country;
		
        
        $sch_id_no = $get_logged_user_details["school_id_number"];
		
        
		$search_school_with_id = mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='$sch_id_no'");
		$search_school_moderator_with_id = mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number='$sch_id_no'");
		
		if(!empty($mod_first) && !empty($mod_last) && !empty($mod_acc_pass) && !empty($mod_gender) && !empty($mod_marital) && !empty($mod_phone) && !empty($mod_city) && !empty($mod_state) && !empty($mod_country) && !empty($mod_home_address) && !empty($mod_office_address) && !empty($sch_name) && !empty($sch_motto) && !empty($sch_address) && !empty($sch_phone) && !empty($sch_city) && !empty($sch_state) && !empty($sch_country) && !empty($sch_id_no)){
			if(mysqli_num_rows($search_school_with_id) == 1){
				if(mysqli_num_rows($search_school_moderator_with_id) == 1){
					if(mysqli_fetch_array($search_school_moderator_with_id)["password"] == $mod_acc_pass){
						if(mysqli_query($connection_server, "UPDATE sm_school_details SET email='$mod_email', school_name='$sch_name', school_motto='$sch_motto', school_address='$sch_address', school_phone_number='$sch_phone', city='$sch_city', state='$sch_state', country='$sch_country' WHERE school_id_number='$sch_id_no'") == true){
							if(!empty($_FILES["photo"]["tmp_name"])){
								if(file_exists("dataimg/school_".$sch_id_no.".png")){
									unlink("dataimg/school_".$sch_id_no.".png");
									$photo_tmp_name = $_FILES["photo"]["tmp_name"];
									move_uploaded_file($photo_tmp_name,"dataimg/school_".$sch_id_no.".png");
								}else{
									$photo_tmp_name = $_FILES["photo"]["tmp_name"];
									move_uploaded_file($photo_tmp_name,"dataimg/school_".$sch_id_no.".png");
								}
							}
							
							if(mysqli_query($connection_server, "UPDATE sm_moderators SET firstname='$mod_first', lastname='$mod_last', phone_number='$mod_phone', gender='$mod_gender', marital_status='$mod_marital', home_address='$mod_home_address', office_address='$mod_office_address', city='$mod_city', state='$mod_state', country='$mod_country' WHERE school_id_number='$sch_id_no'") == true){
								$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&id=".$sch_id_no."&err=7";
							}
							
						}
					}else{
						//pasword doesnt match
						$redirect_url = $_SERVER["REQUEST_URI"]."&err=6";
					}
				}else{
					//another user exists
					$redirect_url = $_SERVER["REQUEST_URI"]."&err=4";
				}
			}else{
				//user doesnt exists
				$redirect_url = $_SERVER["REQUEST_URI"]."&err=5";
			}
		}else{
			//empty fields
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["search-item"])){
		$search_item_text = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["search-item"])));
		
		$page_to_go_link = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"])).$additional_add_tag."&search=".$search_item_text."&pnum=".$page_pnum;
		header("Location: ".$page_to_go_link);
	}
?>