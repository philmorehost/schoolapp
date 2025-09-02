<?php
	$show_back_arrow = false;
	$err_msg = "";
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
		$err_msg .= "Error: Empty Fields";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
		$err_msg .= "Error: List with same details already exists in database";
	}
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
		$err_msg .= "Error: Another List has been with same details already exists in database";
	}	
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "4"){
		$err_msg .= "Error: Book is currently not available";
	}	
	
	if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "5"){
		$err_msg .= "Error: Book Quantity is lesser than Issued Book Quantity";
	}	
	
	$header_add_button = "add_library";
	$additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
	//$header_view_button = "view_library";
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
		$book_list_search_sqli_statement .= "isbn LIKE '%".$search_items."%'"."\n"."book_category_id LIKE '%".$search_items."%'"."\n"."book_name LIKE '%".$search_items."%'"."\n"."author_name LIKE '%".$search_items."%'"."\n"."rack_location LIKE '%".$search_items."%'"."\n"."price LIKE '%".$search_items."%'"."\n"."quantity LIKE '%".$search_items."%'"."\n"."description LIKE '%".$search_items."%'";
		$issue_list_search_sqli_statement .= "numeric_class_name LIKE '%".$search_items."%'"."\n"."session LIKE '%".str_replace(["/","-"],"-",$search_items)."%'"."\n"."admission_number LIKE '%".$search_items."%'"."\n"."issue_date LIKE '%".str_replace(["/","-"],"-",$search_items)."%'"."\n"."return_date LIKE '%".str_replace(["/","-"],"-",$search_items)."%'";	
	}
	
	$book_list_search_sqli_statements .= "(".str_replace("\n"," && school_id_number=".$get_logged_user_details['school_id_number'].") OR (", trim($book_list_search_sqli_statement))." && school_id_number=".$get_logged_user_details['school_id_number'].")";
	$issue_list_search_sqli_statements .= "(".str_replace("\n"," && school_id_number=".$get_logged_user_details['school_id_number'].") OR (", trim($issue_list_search_sqli_statement))." && school_id_number=".$get_logged_user_details['school_id_number'].")";
	
	if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
		$select_book_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_book_lists WHERE $book_list_search_sqli_statements ".$user_admission_id_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_book_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_book_lists WHERE $book_list_search_sqli_statements ".$user_admission_id_statement_auth);
		$select_issue_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_issue_lists WHERE $issue_list_search_sqli_statements ".$user_class_statement_auth." ".$user_admission_id_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_issue_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_issue_lists WHERE $issue_list_search_sqli_statements ".$user_class_statement_auth." ".$user_admission_id_statement_auth);
		
	}else{
		$select_book_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_book_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_admission_id_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_book_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_book_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_admission_id_statement_auth);
		$select_issue_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_issue_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." ".$user_admission_id_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
		$select_all_issue_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_issue_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." ".$user_admission_id_statement_auth);
		
	}
	
	if(isset($_POST["add-book"])){
		$isbn = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["isbn"])));
		$book_category = mysqli_real_escape_string($connection_server, trim(strip_tags(array_filter(explode(" ",trim($_POST["book-category"])))[0])));
		$book_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["book-name"])));
		$author_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["author-name"])));
		$rack_location = mysqli_real_escape_string($connection_server, trim(strip_tags(array_filter(explode(" ",trim($_POST["rack-location"])))[0])));
		$price = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["price"])));
		$quantity = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["quantity"])));
		$desc = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["desc"])));
		
		$school_id = $get_logged_user_details["school_id_number"];
		
		if(!empty($isbn) && !empty($book_category) && !empty($book_name) && !empty($author_name) && !empty($rack_location) && !empty($price) && !empty($quantity) && !empty($school_id)){
			if(mysqli_query($connection_server, "INSERT INTO sm_book_lists (school_id_number, isbn, book_category_id, book_name, author_name, rack_location, price, quantity, description) VALUES ('$school_id','$isbn','$book_category','$book_name','$author_name','$rack_location','$price','$quantity','$desc')") == true){
				$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=book_list".$additional_back_tag;
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["update-book"])){
		$isbn = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["isbn"])));
		$book_category = mysqli_real_escape_string($connection_server, trim(strip_tags(array_filter(explode(" ",trim($_POST["book-category"])))[0])));
		$book_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["book-name"])));
		$author_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["author-name"])));
		$rack_location = mysqli_real_escape_string($connection_server, trim(strip_tags(array_filter(explode(" ",trim($_POST["rack-location"])))[0])));
		$price = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["price"])));
		$quantity = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["quantity"])));
		$desc = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["desc"])));
		
		$current_book_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["edit"])));
		$school_id = $get_logged_user_details["school_id_number"];
		
		$search_book_with_id = mysqli_query($connection_server, "SELECT * FROM sm_book_lists WHERE school_id_number='$school_id' && book_id='$current_book_id'");
		$count_issued_books = mysqli_num_rows(mysqli_query($connection_server,"SELECT * FROM sm_issue_lists WHERE school_id_number='$school_id' && book_id_number='$current_book_id'"));
		
		if(!empty($isbn) && !empty($book_category) && !empty($book_name) && !empty($author_name) && !empty($rack_location) && !empty($price) && !empty($quantity) && !empty($school_id)){
			if($quantity >= $count_issued_books){	
				if(mysqli_num_rows($search_book_with_id) == 1){
					if(mysqli_query($connection_server, "UPDATE sm_book_lists SET isbn='$isbn', book_category_id='$book_category', book_name='$book_name', author_name='$author_name', rack_location='$rack_location', price='$price', quantity='$quantity', description='$desc' WHERE (school_id_number='$school_id' && book_id='$current_book_id')") == true){
						$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=book_list".$additional_back_tag;
					}
				}else{
					$redirect_url = $_SERVER["REQUEST_URI"]."&err=3";
				}
			}else{
				$redirect_url = $_SERVER["REQUEST_URI"]."&err=5";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["issue-book"])){
		$class_numeric = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
		$session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class-session"])));
		$student_admission_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["student-roll-number"])));
		$issue_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["issue-date"])));
		$return_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["return-date"])));
		$book_category = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["book-category"])));
		$book_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["book-id"])));
		
		$school_id = $get_logged_user_details["school_id_number"];
		
		$get_books_quantity = mysqli_fetch_array(mysqli_query($connection_server,"SELECT * FROM sm_book_lists WHERE school_id_number='$school_id' && book_id='$book_id'"))["quantity"];
		$count_issued_books = mysqli_num_rows(mysqli_query($connection_server,"SELECT * FROM sm_issue_lists WHERE school_id_number='$school_id' && book_id_number='$book_id'"));
		
		if(!empty($class_numeric) && !empty($session) && !empty($student_admission_number) && !empty($issue_date) && !empty($return_date) && !empty($book_category) && !empty($book_id) && !empty($school_id)){
			if($get_books_quantity > $count_issued_books){
				if(mysqli_query($connection_server, "INSERT INTO sm_issue_lists (school_id_number, numeric_class_name, session, admission_number, issue_date, return_date, book_category_id, book_id_number) VALUES ('$school_id','$class_numeric', '$session', '$student_admission_number', '$issue_date', '$return_date', '$book_category', '$book_id')") == true){
					
					$get_mail_stu_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$school_id' && admission_number='$student_admission_number' LIMIT 1"));
					$get_mail_sch_name = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='$school_id' LIMIT 1"));
					$get_mail_book_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_book_lists WHERE school_id_number='$school_id' && book_id='$book_id' LIMIT 1"));
					
					// Always set content-type when sending HTML email
					$mail_headers = "MIME-Version: 1.0" . "\r\n";
					$mail_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					
					// More headers
					$mail_headers .= 'From: <'.$get_mail_sch_name["email"].'>' . "\r\n";
					$mail_headers .= 'Cc: '.$get_mail_sch_name["email"]."\r\n";
					
					$email_title = 
					str_replace("{{student_name}}",$get_mail_stu_detail["firstname"]." ".$get_mail_stu_detail["lastname"]." ".$get_mail_stu_detail["othername"],
						str_replace("{{book_name}}",$get_mail_book_detail["book_name"],
							str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
								emailTemplateTableExist('issue-book','title','data')
							)
						)
					);
					
					$email_message = 
					mailDesignTemplate($email_title,
					str_replace("{{student_name}}",$get_mail_stu_detail["firstname"]." ".$get_mail_stu_detail["lastname"]." ".$get_mail_stu_detail["othername"],
						str_replace("{{book_name}}",$get_mail_book_detail["book_name"],
							str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
								emailTemplateTableExist('issue-book','message','data')
							)
						)
					),'');

					customBCMailSender('',$get_mail_stu_detail["email"],$email_title,$email_message,$mail_headers);
					
					$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=issue_list".$additional_back_tag;
				}
			}else{
				$redirect_url = $_SERVER["REQUEST_URI"]."&err=4";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["re-issue-book"])){
		$class_numeric = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
		$session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class-session"])));
		$student_admission_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["student-roll-number"])));
		$issue_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["issue-date"])));
		$return_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["return-date"])));
		$book_category = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["book-category"])));
		$book_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["book-id"])));
		
		$current_issue_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["edit"])));
		$school_id = $get_logged_user_details["school_id_number"];
		$search_issue_with_id = mysqli_query($connection_server, "SELECT * FROM sm_issue_lists WHERE school_id_number='$school_id' && issue_id='$current_issue_id'");
		
		$get_books_quantity = mysqli_fetch_array(mysqli_query($connection_server,"SELECT * FROM sm_book_lists WHERE school_id_number='$school_id' && book_id='$book_id'"))["quantity"];
		$count_issued_books = mysqli_num_rows(mysqli_query($connection_server,"SELECT * FROM sm_issue_lists WHERE school_id_number='$school_id' && book_id_number='$book_id'"));
		$count_current_issued_books = mysqli_num_rows(mysqli_query($connection_server,"SELECT * FROM sm_issue_lists WHERE school_id_number='$school_id' && book_id_number='$book_id' && admission_number='$student_admission_number'"));
		
		if(!empty($class_numeric) && !empty($session) && !empty($student_admission_number) && !empty($issue_date) && !empty($return_date) && !empty($book_category) && !empty($book_id) && !empty($school_id)){
			if(($get_books_quantity > $count_issued_books) || ($count_current_issued_books == 1)){
				if(mysqli_num_rows($search_issue_with_id) == 1){
					if(mysqli_query($connection_server, "UPDATE sm_issue_lists SET numeric_class_name='$class_numeric', session='$session', admission_number='$student_admission_number', issue_date='$issue_date', return_date='$return_date', book_category_id='$book_category', book_id_number='$book_id' WHERE (school_id_number='$school_id' && issue_id='$current_issue_id')") == true){
						
						$get_mail_stu_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$school_id' && admission_number='$student_admission_number' LIMIT 1"));
						$get_mail_sch_name = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='$school_id' LIMIT 1"));
						$get_mail_book_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_book_lists WHERE school_id_number='$school_id' && book_id='$book_id' LIMIT 1"));
						
						// Always set content-type when sending HTML email
						$mail_headers = "MIME-Version: 1.0" . "\r\n";
						$mail_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						
						// More headers
						$mail_headers .= 'From: <'.$get_mail_sch_name["email"].'>' . "\r\n";
						$mail_headers .= 'Cc: '.$get_mail_sch_name["email"]."\r\n";
						
						$email_title = 
						str_replace("{{student_name}}",$get_mail_stu_detail["firstname"]." ".$get_mail_stu_detail["lastname"]." ".$get_mail_stu_detail["othername"],
							str_replace("{{book_name}}",$get_mail_book_detail["book_name"],
								str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
									emailTemplateTableExist('issue-book','title','data')
								)
							)
						);
						
						$email_message = 
						mailDesignTemplate($email_title,
						str_replace("{{student_name}}",$get_mail_stu_detail["firstname"]." ".$get_mail_stu_detail["lastname"]." ".$get_mail_stu_detail["othername"],
							str_replace("{{book_name}}",$get_mail_book_detail["book_name"],
								str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
									emailTemplateTableExist('issue-book','message','data')
								)
							)
						),'');
	
						customBCMailSender('',$get_mail_stu_detail["email"],"UPDATED: ".$email_title,$email_message,$mail_headers);
						
						$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=issue_list".$additional_back_tag;
					}
				}else{
					$redirect_url = $_SERVER["REQUEST_URI"]."&err=3";
				}
			}else{
				$redirect_url = $_SERVER["REQUEST_URI"]."&err=4";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["delete-book-list"])){
		$book_id = $_POST["book_id"];
		$school_id = $_POST["school_id"];
		foreach($book_id as $index => $book_id_no){
			$book_id_num = mysqli_real_escape_string($connection_server, $book_id[$index]);
			$sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
			$delete_school_selected_book_list = mysqli_query($connection_server, "DELETE FROM sm_book_lists WHERE (school_id_number='$sch_id_number' && book_id='$book_id_num')");
		}
		$redirect_url = $_SERVER["REQUEST_URI"];
		
		header("Location: ".$redirect_url);
	}
	
	if(isset($_POST["delete-issue-list"])){
		$issue_id = $_POST["issue_id"];
		$school_id = $_POST["school_id"];
		foreach($issue_id as $index => $issue_id_no){
			$issue_id_num = mysqli_real_escape_string($connection_server, $issue_id[$index]);
			$sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
			$delete_school_selected_issue_list = mysqli_query($connection_server, "DELETE FROM sm_issue_lists WHERE (school_id_number='$sch_id_number' && issue_id='$issue_id_num')");
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