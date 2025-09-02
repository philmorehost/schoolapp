<?php

// Globally define helper functions for use in all views within this file.
if (!function_exists('homeworkSchoolName')) {
	function homeworkSchoolName($school_id)
	{
		global $connection_server;
		$school_name = "N/A";
		$get_school_name = mysqli_query($connection_server, "SELECT school_name FROM sm_school_details WHERE school_id_number='$school_id'");
		if ($school_name_array = mysqli_fetch_array($get_school_name)) {
			$school_name = $school_name_array["school_name"];
		}
		return $school_name;
	}
}
if (!function_exists('homeworkSubjectName')) {
	function homeworkSubjectName($subject_info, $school_id)
	{
		global $connection_server;
		$subject_name = "N/A"; // Initialize to prevent errors
		$get_subject_name = mysqli_query($connection_server, "SELECT subject_name FROM sm_subjects WHERE school_id_number='$school_id' AND subject_code='$subject_info'");
		if ($subject_name_array = mysqli_fetch_array($get_subject_name)) {
			$subject_name = $subject_name_array["subject_name"];
		}
		return $subject_name;
	}
}
if (!function_exists('cbtType')) {
	function cbtType($type_info) {
		$cbt_exam_type_array = array("1ca" => "1st C.A", "2ca" => "2nd C.A", "3ca" => "3rd C.A", "exam" => "Main Exam");
		return $cbt_exam_type_array[$type_info] ?? "Invalid Type";
	}
}
if (!function_exists('termName')) {
	function termName($terms_info, $school_id) {
		global $connection_server;
		$term_name = "N/A";
		$get_term_name = mysqli_query($connection_server, "SELECT term_name FROM sm_terms WHERE school_id_number='$school_id' AND id_number='$terms_info'");
		if($term_name_array = mysqli_fetch_array($get_term_name)){
			$term_name = $term_name_array["term_name"];
		}
		return $term_name;
	}
}
if (!function_exists('homeworkClassName')) {
	function homeworkClassName($class_info, $session_info, $school_id) {
		global $connection_server;
		$class_name = "N/A"; // Initialize to prevent errors
		$get_class_name = mysqli_query($connection_server, "SELECT class_name FROM sm_classes WHERE school_id_number='$school_id' AND numeric_class_name='$class_info' AND session='$session_info'");
		if ($class_name_array = mysqli_fetch_array($get_class_name)) {
			$class_name = $class_name_array["class_name"];
		}
		return $class_name;
	}
}
    
    $err_msg = "";
    $show_back_arrow = false;
    if((isset($_GET["err"])) && (mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1")){
        $err_msg .= "Error: Empty Fields";
    }
    
    if((isset($_GET["err"])) && (mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2")){
        $err_msg .= "Error: homework with the provided details doesnt exists in database";
    }
    
    if((isset($_GET["err"])) && (mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3")){
        $err_msg .= "Error: Another homework has been with same homework Numeric Name already exists in database";
    }
    
    if((isset($_GET["err"])) && (mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "4")){
        $err_msg .= "Error: Unsupported file extension";
    }
    
    $header_add_button = "add_cbt";
    $additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
    //$header_view_button = "view_cbt_test";
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
    
    // --- Robust Query Builder ---
    $where_clauses = array();
    $where_clauses[] = "school_id_number='" . trim(strip_tags($_GET['id'] ?? '')) . "'";

    // Add role-specific clauses and filters
    if ($user_identifier_auth_id == "stu") {
        // For students, always filter by their current class
        $where_clauses[] = "numeric_class_name='" . $get_logged_user_details['current_class'] . "'";

        if (strip_tags($_GET['tab'] ?? '') == 'cbt_tests') {
        // The 'CBT Tests' tab should show exams for all sessions.
    } else if (strip_tags($_GET['tab'] ?? '') == 'past_questions') {
        // The 'Past Questions' tab should show exams for all sessions.
        } else {
            // Other student tabs (like 'Past Questions') can be filtered by session and term.
            if (isset($_GET['session']) && !empty($_GET['session'])) {
                $session_filter = mysqli_real_escape_string($connection_server, $_GET['session']);
                $where_clauses[] = "session='$session_filter'";
            }
            if (isset($_GET['term']) && !empty($_GET['term'])) {
                $term_filter = mysqli_real_escape_string($connection_server, $_GET['term']);
                $where_clauses[] = "term_id_number='$term_filter'";
            }
        }
    } else {
        // For admins/teachers, apply session and term filters if they exist.
        if (isset($_GET['session']) && !empty($_GET['session'])) {
            $session_filter = mysqli_real_escape_string($connection_server, $_GET['session']);
            $where_clauses[] = "session='$session_filter'";
        }
        if (isset($_GET['term']) && !empty($_GET['term'])) {
            $term_filter = mysqli_real_escape_string($connection_server, $_GET['term']);
            $where_clauses[] = "term_id_number='$term_filter'";
        }
    }

    // Handle search query for admins/teachers
    if ($user_identifier_auth_id != "stu" && (isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
        $search_text = trim(strip_tags($_GET["search"]));
        $search_terms = array_filter(explode(" ", $search_text));
        $search_conditions = array();
        $search_columns = ["paper_title", "numeric_class_name", "session", "subject_code", "exam_time", "exam_date"];

        foreach ($search_terms as $term) {
            $term_conditions = array();
            $escaped_term = mysqli_real_escape_string($connection_server, $term);
            foreach($search_columns as $col){
                $term_conditions[] = "$col LIKE '%$escaped_term%'";
            }
            $search_conditions[] = "(" . implode(' OR ', $term_conditions) . ")";
        }
        if(!empty($search_conditions)){
            $where_clauses[] = "(" . implode(' AND ', $search_conditions) . ")";
        }
    }

    $where_sql = "WHERE " . implode(' AND ', $where_clauses);

    // The admin-specific auth statement should only apply to admins/teachers
    if ($user_identifier_auth_id != "stu" && !empty(trim($user_class_statement_auth))) {
        $where_sql .= " " . $user_class_statement_auth;
    }

    // Final queries
    $count_query = "SELECT COUNT(*) as total FROM sm_cbt_scheldule_lists $where_sql";
    $total_results_query = mysqli_query($connection_server, $count_query);
    $total_results = mysqli_fetch_assoc($total_results_query)['total'];

    // This variable is used in the view, so we create a fake result set for it.
    // This is a bit of a hack to match the original code's structure.
    $select_all_cbt_test_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_cbt_scheldule_lists $where_sql");

    $paginated_query = "SELECT * FROM sm_cbt_scheldule_lists $where_sql LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum);
    $select_cbt_test_table_lists = mysqli_query($connection_server, $paginated_query);
    // --- End Robust Query Builder ---
    
    if(isset($_POST["reschedule-btn"])){
		$student_id = mysqli_real_escape_string($connection_server, preg_replace("/[^0-9]+/","",trim(strip_tags($_POST["reschedule-id"] ?? ''))));
		$school_id = $get_logged_user_details["school_id_number"];
		$current_homework_id = trim(strip_tags($_GET['view'] ?? ''));
		
		if(!empty($student_id) && !empty($current_homework_id) && !empty($school_id)){
			$search_homework_started_with_details = mysqli_query($connection_server, "SELECT * FROM sm_started_cbt_lists WHERE school_id_number='$school_id' && cbt_id_number='$current_homework_id' && admission_number='$student_id'");
            $search_homework_submitted_with_details = mysqli_query($connection_server, "SELECT * FROM sm_submitted_cbt_lists WHERE school_id_number='$school_id' && cbt_id_number='$current_homework_id' && admission_number='$student_id'");
            if((mysqli_num_rows($search_homework_started_with_details) == 1) || (mysqli_num_rows($search_homework_submitted_with_details) == 1)){
                mysqli_query($connection_server, "DELETE FROM sm_started_cbt_lists WHERE school_id_number='$school_id' && cbt_id_number='$current_homework_id' && admission_number='$student_id'");
                mysqli_query($connection_server, "DELETE FROM sm_submitted_cbt_lists WHERE school_id_number='$school_id' && cbt_id_number='$current_homework_id' && admission_number='$student_id'");
				$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'] ?? '')."&tab=view_cbt".$additional_back_tag."&view=".$current_homework_id;
            }else{
                $redirect_url = $_SERVER["REQUEST_URI"]."&err=2";
            }
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}

    if(isset($_POST["add-cbt"])){
		$paper_title = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["paper-title"] ?? '')));
		$numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"] ?? '')));
		$class_session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class-session"] ?? '')));
		$term_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["term-id"] ?? '')));
		$term_id = array_filter(explode(" ", trim($term_id)));
		$term_id = $term_id[0];
		
		$subject_code = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["subject-code"] ?? '')));
		$cbt_type = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["cbt-type"] ?? '')));
		$exam_time = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["exam-time"] ?? '')));
		$exam_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["exam-date"] ?? '')));
		$exam_question_no = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["exam-questions"] ?? '')));
		
        $exam_question_attempts = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["exam-question-attempts"] ?? '')));
        $exam_question_attempts = ($exam_question_attempts > $exam_question_no) ? $exam_question_no : $exam_question_attempts;
        
        $exam_duration = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["exam-duration"] ?? '')));
		$cbt_exam_type_array = array("1ca" => "1st C.A","2ca" => "2nd C.A","3ca" => "3rd C.A","exam" => "Main Exam");
        $school_id = $get_logged_user_details["school_id_number"];

        
		if(!empty($paper_title) && !empty($numeric_class) && !empty($class_session) && !empty($subject_code) && !empty($exam_time) && !empty($exam_date) && in_array($cbt_type, array_keys($cbt_exam_type_array)) && !empty($school_id)){
			$search_homework_with_details = mysqli_query($connection_server, "SELECT * FROM sm_cbt_scheldule_lists WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$class_session' && term_id_number='$term_id' && subject_code='$subject_code' && cbt_type='$cbt_type'");
            if(mysqli_num_rows($search_homework_with_details) == 0){
                if(mysqli_query($connection_server, "INSERT INTO sm_cbt_scheldule_lists (school_id_number, paper_title, numeric_class_name, session, term_id_number, subject_code, cbt_type, exam_time, exam_date, exam_questions, exam_question_attempts, exam_duration) VALUES ('$school_id', '$paper_title', '$numeric_class', '$class_session', '$term_id', '$subject_code', '$cbt_type', '$exam_time', '$exam_date', '$exam_question_no', '$exam_question_attempts', '$exam_duration')") == true){
				    $redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'] ?? '')."&tab=add_cbt".$additional_back_tag;
			    }
            }else{
                $redirect_url = $_SERVER["REQUEST_URI"]."&err=3";
            }
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}
	
    if(isset($_POST["update-cbt"])){
    	
		$paper_title = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["paper-title"] ?? '')));
		$numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"] ?? '')));
		$class_session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class-session"] ?? '')));
		$term_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["term-id"] ?? '')));
		$term_id = array_filter(explode(" ", trim($term_id)));
		$term_id = $term_id[0];
		
		$subject_code = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["subject-code"] ?? '')));
		$cbt_type = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["cbt-type"] ?? '')));
		$exam_time = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["exam-time"] ?? '')));
		$exam_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["exam-date"] ?? '')));
		$exam_question_no = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["exam-questions"] ?? '')));
		
        $exam_question_attempts = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["exam-question-attempts"] ?? '')));
        $exam_question_attempts = ($exam_question_attempts > $exam_question_no) ? $exam_question_no : $exam_question_attempts;

        $exam_duration = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["exam-duration"] ?? '')));
		$cbt_exam_type_array = array("1ca" => "1st C.A","2ca" => "2nd C.A","3ca" => "3rd C.A","exam" => "Main Exam");
        $school_id = $get_logged_user_details["school_id_number"];

		$current_homework_id = trim(strip_tags($_GET['edit'] ?? ''));
		
		$search_homework_with_id = mysqli_query($connection_server, "SELECT * FROM sm_cbt_scheldule_lists WHERE school_id_number='$school_id' && cbt_id='$current_homework_id'");
		
		if(!empty($paper_title) && !empty($numeric_class) && !empty($class_session) && !empty($subject_code) && !empty($exam_time) && !empty($exam_date) && in_array($cbt_type, array_keys($cbt_exam_type_array)) && !empty($school_id)){
			if(mysqli_num_rows($search_homework_with_id) == 1){
				$search_homework_with_details = mysqli_query($connection_server, "SELECT * FROM sm_cbt_scheldule_lists WHERE school_id_number='$school_id' && cbt_id!='$current_homework_id' && numeric_class_name='$numeric_class' && session='$class_session' && term_id_number='$term_id' && subject_code='$subject_code' && cbt_type='$cbt_type'");
                if(mysqli_num_rows($search_homework_with_details) == 0){
                	$get_homework_details = mysqli_fetch_array($search_homework_with_id);
                	$decode_homework_exam_json = json_decode($get_homework_details["exam_json"], true);
                	
                	if(($decode_homework_exam_json["quiz"] == true) && (count($decode_homework_exam_json["quiz"]) > 0) && !empty(trim($get_homework_details["exam_json"]))){
                		$create_exam_array = array("exams" => $decode_homework_exam_json["exams"], "time" => $exam_duration, "examAttempts" => $exam_question_attempts, "quiz" => array_splice($decode_homework_exam_json["quiz"], 0, $exam_question_no));
                		$create_exam_array_encode = json_encode($create_exam_array, true);
                	}else{
                		$create_exam_array_encode = "";
                	}
                    if(mysqli_query($connection_server, "UPDATE sm_cbt_scheldule_lists SET paper_title='$paper_title', numeric_class_name='$numeric_class', session='$class_session', term_id_number='$term_id', subject_code='$subject_code', cbt_type='$cbt_type', exam_time='$exam_time', exam_date='$exam_date', exam_questions='$exam_question_no', exam_question_attempts='$exam_question_attempts', exam_duration='$exam_duration', exam_json='$create_exam_array_encode' WHERE (school_id_number='$school_id' && cbt_id='$current_homework_id')") == true){
                        if(isset($create_exam_array['quiz']) && count($create_exam_array["quiz"]) == $exam_question_no && count($create_exam_array["quiz"]) >= $exam_question_attempts){
				$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'] ?? '')."&tab=scheldule_list".$additional_back_tag;
                    	}else{
				$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'] ?? '')."&tab=add_cbt_quiz".$additional_back_tag."&edit=".$current_homework_id;
                    	}
                    }
                }else{
                    $redirect_url = $_SERVER["REQUEST_URI"]."&err=3";
                }
			}else{
				$redirect_url = $_SERVER["REQUEST_URI"]."&err=3";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}

    if(isset($_POST["update-cbt-question"])){

        function maintainAllowedTags($inputted_text){
            return strip_tags($inputted_text, "<span><p><b><i><u><strong><em><sup><sub><br><hr><h1><h2><h3><h4><h5><h6><ol><ul><li><blockquote><strike>");
        }

		$exam_question = $_POST["exam_question"];
		$option_1 = $_POST["option_1"];
		$option_2 = $_POST["option_2"];
        $option_3 = $_POST["option_3"];
        $option_4 = $_POST["option_4"];
		
        
		$school_id = $get_logged_user_details["school_id_number"];

		$current_homework_id = trim(strip_tags($_GET['edit'] ?? ''));
		
		$search_homework_with_id = mysqli_query($connection_server, "SELECT * FROM sm_cbt_scheldule_lists WHERE school_id_number='$school_id' && cbt_id='$current_homework_id'");
		
		if((count($exam_question) >= 1) && (count($exam_question) == count($option_1)) && (count($option_1) == count($option_2)) && (count($option_2) == count($option_3)) && (count($option_3) == count($option_4)) && !empty($school_id)){
			if(mysqli_num_rows($search_homework_with_id) == 1){
                $homework_details = mysqli_fetch_array($search_homework_with_id);
                if(count($exam_question) == $homework_details["exam_questions"]){

                    
                    $quiz_question_json_array = array();
                    for ($i=0; $i < $homework_details["exam_questions"]; $i++) {
                        $exam_question_wrong_answer_array = array();
                        // Apply stripslashes to remove any auto-added escaping before sanitizing and encoding.
                        $each_exam_question =  trim(maintainAllowedTags(stripslashes($exam_question[$i])));
                        $each_correct_answer = trim(maintainAllowedTags(stripslashes($option_1[$i])));
                        $each_wrong_answer_1 = trim(maintainAllowedTags(stripslashes($option_2[$i])));
                        $each_wrong_answer_2 = trim(maintainAllowedTags(stripslashes($option_3[$i])));
                        $each_wrong_answer_3 = trim(maintainAllowedTags(stripslashes($option_4[$i])));

                        if(!empty($each_exam_question) && !empty($each_correct_answer) && !empty($each_wrong_answer_1) && !empty($each_wrong_answer_2) && !empty($each_wrong_answer_3)){
                            array_push($exam_question_wrong_answer_array, base64_encode($each_wrong_answer_1));
                            array_push($exam_question_wrong_answer_array, base64_encode($each_wrong_answer_2));
                            array_push($exam_question_wrong_answer_array, base64_encode($each_wrong_answer_3));

                            $question_str = base64_encode($each_exam_question); 
                            $correct_answers_array = base64_encode($each_correct_answer);
                            $wrong_answers_array = $exam_question_wrong_answer_array;
                            $answers_array = array("correct" => $correct_answers_array, "wrong" => $wrong_answers_array);
                            $answers_json = $answers_array;
                            $sample_create_question_array = array("question" => $question_str, "answers" => $answers_json);
                            $sample_create_question_json = $sample_create_question_array;
                            array_push($quiz_question_json_array, $sample_create_question_json);
                        }
                    }
                    
                    $sample_create_exam_array = array("exams" => [homeworkSubjectName($homework_details["subject_code"] ,$homework_details["school_id_number"])], "time" => $homework_details["exam_duration"], "examAttempts" => $homework_details["exam_questions"], "quiz" => $quiz_question_json_array);
                    $sample_create_exam_json_encode = json_encode($sample_create_exam_array, true);
                    $sample_create_exam_json_decode = json_decode($sample_create_exam_json_encode, true);
                    
                    if(mysqli_query($connection_server, "UPDATE sm_cbt_scheldule_lists SET exam_questions='".count($sample_create_exam_json_decode["quiz"])."', exam_json='$sample_create_exam_json_encode' WHERE (school_id_number='$school_id' && cbt_id='$current_homework_id')") == true){
                        $redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'] ?? '')."&tab=scheldule_list".$additional_back_tag;
                    }
                }else{
                    $redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
                }
			}else{
				$redirect_url = $_SERVER["REQUEST_URI"]."&err=3";
			}
		}else{
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		
		header("Location: ".$redirect_url);
	}

    if(isset($_POST["submit-cbt-test"])){
        $document_file = $_FILES["file"]["name"];
        $document_file_tmp = $_FILES["file"]["tmp_name"];
        $document_extension = pathinfo($_FILES["file"]["name"])["extension"];
        $date_submitted = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["date-sub"] ?? '')));
        $admission_number = $get_logged_user_details["admission_number"];
        $cbt_test_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["cbt_test_id"] ?? '')));
        $school_id = $get_logged_user_details["school_id_number"];
        
        $search_cbt_test_with_id = mysqli_query($connection_server, "SELECT * FROM sm_cbt_test_lists WHERE school_id_number='$school_id' && cbt_test_id='$cbt_test_id'");
        $search_submitted_cbt_test_with_id = mysqli_query($connection_server, "SELECT * FROM sm_submitted_cbt_test_lists WHERE school_id_number='$school_id' && cbt_test_id_number='$cbt_test_id' && admission_number='$admission_number'");
        
        if(!empty($document_file) && !empty($admission_number) && !empty($cbt_test_id) && !empty($date_submitted) && !empty($school_id)){
            if((mysqli_num_rows($search_cbt_test_with_id) == 1) && (mysqli_num_rows($search_submitted_cbt_test_with_id) == 0)){
                if(in_array(strtolower($document_extension), array("jpg", "jpeg", "png"))){
                    move_uploaded_file($document_file_tmp,"homework/".$school_id."_".$admission_number."_".$document_file);
                    $document_link = "homework/".$school_id."_".$admission_number."_".$document_file;
                    if(mysqli_query($connection_server, "INSERT INTO sm_submitted_cbt_test_lists (school_id_number, cbt_test_id_number, admission_number, document_link, date_submitted) VALUES ('$school_id', '$cbt_test_id', '$admission_number', '$document_link', '$date_submitted')") == true){
                        $redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'] ?? '')."&tab=view_submission".$additional_back_tag;
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
    if(isset($_POST["rem-submitted-cbt-test"])){
        $school_id = $get_logged_user_details["school_id_number"];
        $admission_number = $get_logged_user_details["admission_number"];
        $cbt_test_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["cbt_test_id"] ?? '')));
        
        $search_cbt_test_with_id = mysqli_query($connection_server, "SELECT * FROM sm_cbt_test_lists WHERE school_id_number='$school_id' && cbt_test_id='$cbt_test_id'");
        $search_submitted_cbt_test_with_id = mysqli_query($connection_server, "SELECT * FROM sm_submitted_cbt_test_lists WHERE school_id_number='$school_id' && cbt_test_id_number='$cbt_test_id' && admission_number='$admission_number'");
        if((mysqli_num_rows($search_cbt_test_with_id) == 1) && (mysqli_num_rows($search_submitted_cbt_test_with_id) == 1)){
            $delete_cbt_test = mysqli_query($connection_server, "DELETE FROM sm_submitted_cbt_test_lists WHERE school_id_number='$school_id' && cbt_test_id_number='$cbt_test_id' && admission_number='$admission_number'");
        }
        $redirect_url = $_SERVER["REQUEST_URI"];
        header("Location: ".$redirect_url);
    }
    
    if(isset($_POST["delete-cbt"])){
        $cbt_test_id = $_POST["cbt_id"];
        $school_id = $_POST["school_id"];
        foreach($cbt_test_id as $index => $cbt_test_id_no){
            $sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
            $cbt_test_id_num = mysqli_real_escape_string($connection_server, $cbt_test_id[$index]);
            
            $delete_school_selected_cbt_test = mysqli_query($connection_server, "DELETE FROM sm_cbt_scheldule_lists WHERE (school_id_number='$sch_id_number' && cbt_id='$cbt_test_id_num')");
        }
        $redirect_url = $_SERVER["REQUEST_URI"];
        
        header("Location: ".$redirect_url);
    }
    
    if(isset($_POST["search-item"])){
        $search_item_text = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["search-item"] ?? '')));
        
        $page_to_go_link = "/bc-admin.php?page=".trim(strip_tags($_GET["page"] ?? ''))."&tab=".trim(strip_tags($_GET["tab"] ?? '')).$additional_add_tag."&search=".$search_item_text."&pnum=".$page_pnum;
        header("Location: ".$page_to_go_link);
    }

	if(isset($_POST["confirm-clone-cbt"])){
		$clone_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["clone_id"] ?? '')));
		$new_title = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["paper-title"] ?? '')));
		$new_session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["new-session"] ?? '')));
		$new_term = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["new-term"] ?? '')));
		$school_id = $get_logged_user_details["school_id_number"];

		if(!empty($clone_id) && !empty($new_title) && !empty($new_session) && !empty($new_term) && !empty($school_id)){
			// Fetch the original CBT details
			$original_cbt_query = mysqli_query($connection_server, "SELECT * FROM sm_cbt_scheldule_lists WHERE cbt_id='$clone_id' AND school_id_number='$school_id'");

			if(mysqli_num_rows($original_cbt_query) == 1){
				$original_cbt = mysqli_fetch_assoc($original_cbt_query);

				// Escape all original data before inserting
				$numeric_class_name = mysqli_real_escape_string($connection_server, $original_cbt['numeric_class_name']);
				$subject_code = mysqli_real_escape_string($connection_server, $original_cbt['subject_code']);
				$cbt_type = mysqli_real_escape_string($connection_server, $original_cbt['cbt_type']);
				$exam_time = mysqli_real_escape_string($connection_server, $original_cbt['exam_time']);
				$exam_date = mysqli_real_escape_string($connection_server, $original_cbt['exam_date']);
				$exam_questions = mysqli_real_escape_string($connection_server, $original_cbt['exam_questions']);
				$exam_question_attempts = mysqli_real_escape_string($connection_server, $original_cbt['exam_question_attempts']);
				$exam_duration = mysqli_real_escape_string($connection_server, $original_cbt['exam_duration']);
				$exam_json = mysqli_real_escape_string($connection_server, $original_cbt['exam_json']);

				// Check if a CBT with the exact same new details already exists to avoid exact duplicates
				$check_duplicate_query = "SELECT * FROM sm_cbt_scheldule_lists WHERE school_id_number='$school_id' AND numeric_class_name='$numeric_class_name' AND session='$new_session' AND term_id_number='$new_term' AND subject_code='$subject_code' AND cbt_type='$cbt_type'";
				$check_duplicate_result = mysqli_query($connection_server, $check_duplicate_query);

				if(mysqli_num_rows($check_duplicate_result) == 0){
					$insert_query = "INSERT INTO sm_cbt_scheldule_lists (school_id_number, paper_title, numeric_class_name, session, term_id_number, subject_code, cbt_type, exam_time, exam_date, exam_questions, exam_question_attempts, exam_duration, exam_json)
									 VALUES ('$school_id', '$new_title', '$numeric_class_name', '$new_session', '$new_term', '$subject_code', '$cbt_type', '$exam_time', '$exam_date', '$exam_questions', '$exam_question_attempts', '$exam_duration', '$exam_json')";

					if(mysqli_query($connection_server, $insert_query) === TRUE){
						// Redirect to the schedule list, filtered to the new term and session
						$redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'] ?? '')."&tab=scheldule_list&id=".$school_id."&session=".$new_session."&term=".$new_term;
					} else {
						// Database insert error
						$redirect_url = $_SERVER["REQUEST_URI"]."&err=db_error"; // Need to handle this err
					}
				} else {
					// A CBT with these details already exists for the new term/session
					$redirect_url = $_SERVER["REQUEST_URI"]."&err=3"; // Re-use existing "already exists" error
				}
			} else {
				// Original CBT not found
				$redirect_url = $_SERVER["REQUEST_URI"]."&err=2"; // Re-use existing "doesn't exist" error
			}
		} else {
			// Empty fields
			$redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
		}
		header("Location: ".$redirect_url);
	}

?>