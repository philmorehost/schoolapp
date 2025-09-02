<?php
	
	$err_msg = "";
	$show_back_arrow = false;
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: homework with the provided details doesnt exists in database";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: Another homework has been with same homework Numeric Name already exists in database";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "4"){
		$err_msg .= "Error: Unsupported file extension";
	}
	
	$header_add_button = "add_homework";
	$additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
	//$header_view_button = "view_homework";
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
		$search_sqli_statement .= "title LIKE '%".$search_items."%'"."\n"."numeric_class_name LIKE '%".$search_items."%'"."\n"."session LIKE '%".str_replace(["/","-"],"-",$search_items)."%'"."\n"."subject_code LIKE '%".$search_items."%'"."\n"."document_title LIKE '%".$search_items."%'"."\n"."document_link LIKE '%".$search_items."%'"."\n"."content LIKE '%".$search_items."%'"."\n"."submission_date LIKE '%".str_replace(["/","-"],"-",$search_items)."%'";
	
	}
	
	$search_sqli_statements .= "(".str_replace("\n"," && school_id_number=".$get_logged_user_details['school_id_number'].") OR (", trim($search_sqli_statement))." && school_id_number=".$get_logged_user_details['school_id_number'].")";
	
	if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
		$select_homework_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_homework_lists WHERE $search_sqli_statements ".$user_class_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_homework_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_homework_lists WHERE $search_sqli_statements ".$user_class_statement_auth);
	}else{
		$select_homework_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_homework_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_homework_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_homework_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth);
	}
	
	if(isset($_POST["add-homework"])){
		$title = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["title"])));
		$numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
		$class_session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class-session"])));
		$subject_code = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["subject-code"])));
		$submission_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["sub-date"])));
		$document_title = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["document-title"])));
		$content = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["content"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		
		if(!empty($title) && !empty($numeric_class) && !empty($class_session) && !empty($subject_code) && !empty($submission_date) && !empty($school_id)){
			$document_file = $_FILES["file"]["name"];
			$document_file_tmp = $_FILES["file"]["tmp_name"];
			$document_extension = pathinfo($_FILES["file"]["name"])["extension"];
			
			if(in_array(strtolower($document_extension), array("jpg", "jpeg", "png", "doc", "docx", "pdf", "pptx", "xlsx"))){
				if(!empty(trim(strip_tags($document_file)))){
					if(file_exists("homework/".$school_id."_".$document_file)){
						unlink("homework/".$school_id."_".$document_file);
						move_uploaded_file($document_file_tmp,"homework/".$school_id."_".$document_file);
						$document_link = "homework/".$school_id."_".$document_file;
					}else{
						move_uploaded_file($document_file_tmp,"homework/".$school_id."_".$document_file);
						$document_link = "homework/".$school_id."_".$document_file;
					}
				}else{
					$document_link = "";
				}
			}else{
				$document_link = "";
			}
			
			if(mysqli_query($connection_server, "INSERT INTO sm_homework_lists (school_id_number, title, numeric_class_name, session, subject_code, document_title, content, document_link, submission_date) VALUES ('$school_id', '$title', '$numeric_class', '$class_session', '$subject_code', '$document_title', '$content', '$document_link', '$submission_date')") == true){
				$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=homework_list".$additional_back_tag;
			}	
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["update-homework"])){
		$title = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["title"])));
		$numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
		$class_session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class-session"])));
		$subject_code = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["subject-code"])));
		$submission_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["sub-date"])));
		$document_title = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["document-title"])));
		$content = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["content"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		$current_homework_id = trim(strip_tags($_GET['edit']));
		
		$search_homework_with_id = mysqli_query($connection_server, "SELECT * FROM sm_homework_lists WHERE school_id_number='$school_id' && homework_id='$current_homework_id'");
		
		if(!empty($title) && !empty($numeric_class) && !empty($class_session) && !empty($subject_code) && !empty($submission_date) && !empty($school_id)){
			if(mysqli_num_rows($search_homework_with_id) == 1){
				$document_file = $_FILES["file"]["name"];
				$document_file_tmp = $_FILES["file"]["tmp_name"];
				$document_extension = pathinfo($_FILES["file"]["name"])["extension"];
				
				if(in_array(strtolower($document_extension), array("jpg", "jpeg", "png", "doc", "docx", "pdf", "pptx", "xlsx"))){
					if(!empty(trim(strip_tags($document_file)))){
						if(file_exists("homework/".$school_id."_".$document_file)){
							unlink("homework/".$school_id."_".$document_file);
							move_uploaded_file($document_file_tmp,"homework/".$school_id."_".$document_file);
							$document_link = "homework/".$school_id."_".$document_file;
						}else{
							move_uploaded_file($document_file_tmp,"homework/".$school_id."_".$document_file);
							$document_link = "homework/".$school_id."_".$document_file;
						}
					}else{
						$document_link = "";
					}
				}else{
					$document_link = "";
				}
				
				if(mysqli_query($connection_server, "UPDATE sm_homework_lists SET title='$title', numeric_class_name='$numeric_class', session='$class_session', subject_code='$subject_code', document_title='$document_title', content='$content', document_link='$document_link', submission_date='$submission_date' WHERE (school_id_number='$school_id' && homework_id='$current_homework_id')") == true){
					$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=homework_list".$additional_back_tag;
				}
			}else{
				$redirect_url = $_SERVER["REQUEST_URI"]."&err=3";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["submit-homework"])){
		$document_file = $_FILES["file"]["name"];
		$document_file_tmp = $_FILES["file"]["tmp_name"];
		$document_extension = pathinfo($_FILES["file"]["name"])["extension"];
		$date_submitted = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["date-sub"])));
		$admission_number = $get_logged_user_details["admission_number"];
		$homework_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["homework_id"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		$search_homework_with_id = mysqli_query($connection_server, "SELECT * FROM sm_homework_lists WHERE school_id_number='$school_id' && homework_id='$homework_id'");
		$search_submitted_homework_with_id = mysqli_query($connection_server, "SELECT * FROM sm_submitted_homework_lists WHERE school_id_number='$school_id' && homework_id_number='$homework_id' && admission_number='$admission_number'");
		
		if(!empty($document_file) && !empty($admission_number) && !empty($homework_id) && !empty($date_submitted) && !empty($school_id)){
			if((mysqli_num_rows($search_homework_with_id) == 1) && (mysqli_num_rows($search_submitted_homework_with_id) == 0)){
				if(in_array(strtolower($document_extension), array("jpg", "jpeg", "png"))){
					move_uploaded_file($document_file_tmp,"homework/".$school_id."_".$admission_number."_".$document_file);
					$document_link = "homework/".$school_id."_".$admission_number."_".$document_file;
					if(mysqli_query($connection_server, "INSERT INTO sm_submitted_homework_lists (school_id_number, homework_id_number, admission_number, document_link, date_submitted) VALUES ('$school_id', '$homework_id', '$admission_number', '$document_link', '$date_submitted')") == true){
						$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=view_submission".$additional_back_tag;
					}
				}else{
					$redirect_url = $_SERVER["REQUEST_URI"]."&err=4";
				}
			}	
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}
	if(isset($_POST["rem-submitted-homework"])){
		$school_id = $get_logged_user_details["school_id_number"];
		$admission_number = $get_logged_user_details["admission_number"];
		$homework_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["homework_id"])));
		
		$search_homework_with_id = mysqli_query($connection_server, "SELECT * FROM sm_homework_lists WHERE school_id_number='$school_id' && homework_id='$homework_id'");
		$search_submitted_homework_with_id = mysqli_query($connection_server, "SELECT * FROM sm_submitted_homework_lists WHERE school_id_number='$school_id' && homework_id_number='$homework_id' && admission_number='$admission_number'");
		if((mysqli_num_rows($search_homework_with_id) == 1) && (mysqli_num_rows($search_submitted_homework_with_id) == 1)){
			$delete_homework = mysqli_query($connection_server, "DELETE FROM sm_submitted_homework_lists WHERE school_id_number='$school_id' && homework_id_number='$homework_id' && admission_number='$admission_number'");
		}
		$redirect_url = $_SERVER["REQUEST_URI"];
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["view-submission"])){
		//$numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
		//$session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["session"])));
		$homework_id_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["homework-id"])));
		//$subject_code = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["subject-code"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		$redirect_url = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"]))."&id=".trim(strip_tags($_GET["id"]))."&view=".$homework_id_number;
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["delete-homework"])){
		$homework_id = $_POST["homework_id"];
		$school_id = $_POST["school_id"];
		foreach($homework_id as $index => $homework_id_no){
			$sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
			$homework_id_num = mysqli_real_escape_string($connection_server, $homework_id[$index]);
			
			$delete_school_selected_homework = mysqli_query($connection_server, "DELETE FROM sm_homework_lists WHERE (school_id_number='$sch_id_number' && homework_id='$homework_id_num')");
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