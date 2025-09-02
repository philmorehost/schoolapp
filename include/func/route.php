<?php
    $show_back_arrow = false;
    $err_msg = "";
    if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
        $err_msg .= "Error: Empty Fields";
    }
    
    if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
        $err_msg .= "Error: Same Invoice details already exists in database";
    }
    
    if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
        $err_msg .= "Error: Invoice with same details already exists in database";
    }   
    
    if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "4"){
        $err_msg .= "Error: route is currently not available";
    }   
    
    if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "5"){
        $err_msg .= "Error: route Quantity is lesser than Issued route Quantity";
    }   
    
    //$header_add_button = "add_payment";
    $additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
    //$header_view_button = "view_payment";
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
        $search_sqli_statement .= "id_number LIKE '%".str_replace("bd","",strtolower($search_items))."%'"."\n"." room_id_number LIKE '%".str_replace("rm","",strtolower($search_items))."%'"."\n"." library_description LIKE '%".$search_items."%'";
    
    }
    
    $search_sqli_statements .= str_replace("\n"," OR ", trim($search_sqli_statement));
    
    if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
        $select_route_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_route_lists WHERE $search_sqli_statements && school_id_number='".trim(strip_tags($_GET['id']))."' LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
        $select_all_route_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_route_lists WHERE $search_sqli_statements && school_id_number='".trim(strip_tags($_GET['id']))."'");
        // $select_route_payment_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_route_payment_lists WHERE $search_sqli_statements && school_id_number='".trim(strip_tags($_GET['id']))."' LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
        // $select_all_route_payment_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_route_payment_lists WHERE $search_sqli_statements && school_id_number='".trim(strip_tags($_GET['id']))."'");
        
    }else{
        $select_route_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_route_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
        $select_all_route_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_route_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
        // $select_route_payment_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_route_payment_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
        // $select_all_route_payment_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_route_payment_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
        
    }
    
    if(isset($_POST["add-route"])){
        $numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
        // $session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class-session"])));
        $subject_code = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["subject-code"])));
        // $term_id_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["term"])));
        $day_code = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["day-code"])));
        $start_time = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["start-time"])));
        $end_time = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["end-time"])));
        
        $school_id = $get_logged_user_details["school_id_number"];
        
        $check_route_exists = mysqli_query($connection_server, "SELECT * FROM sm_route_lists WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && subject_code='$subject_code' && day_code='$day_code'");
        if(!empty($numeric_class) && !empty($subject_code) && !empty($day_code) && !empty($start_time) && !empty($end_time) && !empty($school_id)){
            if(mysqli_num_rows($check_route_exists) == 0){
                if(mysqli_query($connection_server, "INSERT INTO sm_route_lists (school_id_number, numeric_class_name, subject_code, day_code, start_time, end_time) VALUES ('$school_id', '$numeric_class', '$subject_code', '$day_code', '$start_time', '$end_time')") == true){
                    $redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=route_list".$additional_back_tag;
                }
            }
            
            if(mysqli_num_rows($check_route_exists) == 1){
                if(mysqli_query($connection_server, "UPDATE sm_route_lists SET numeric_class_name='$numeric_class', subject_code='$subject_code', day_code='$day_code', start_time='$start_time', end_time='$end_time' WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && subject_code='$subject_code' && term_id_number='$term_id_number' && day_code='$day_code'") == true){
                    $redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=route_list".$additional_back_tag;
                }
            }
        }else{
            $redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
        }
        
        header("Location: ".$redirect_url);
    }
    
    if(isset($_POST["add-exam"])){
        $numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
        // $session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class-session"])));
        $subject_code = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["subject-code"])));
        // $term_id_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["term"])));
        $day_code = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["day-code"])));
        $exam_date = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["date"])));
        $start_time = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["start-time"])));
        $end_time = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["end-time"])));
        
        $school_id = $get_logged_user_details["school_id_number"];
        
        $check_exam_exists = mysqli_query($connection_server, "SELECT * FROM sm_exam_lists WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && subject_code='$subject_code' && day_code='$day_code'");
        if(!empty($numeric_class) && !empty($subject_code) && !empty($day_code) && !empty($exam_date) && !empty($start_time) && !empty($end_time) && !empty($school_id)){
            if(mysqli_num_rows($check_exam_exists) == 0){
                if(mysqli_query($connection_server, "INSERT INTO sm_exam_lists (school_id_number, numeric_class_name, subject_code, day_code, exam_date, start_time, end_time) VALUES ('$school_id', '$numeric_class', '$subject_code', '$day_code', '$exam_date', '$start_time', '$end_time')") == true){
                    $redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=exam_list".$additional_back_tag;
                }
            }
            
            if(mysqli_num_rows($check_exam_exists) == 1){
                if(mysqli_query($connection_server, "UPDATE sm_exam_lists SET numeric_class_name='$numeric_class', subject_code='$subject_code', day_code='$day_code', exam_date='$exam_date', start_time='$start_time', end_time='$end_time' WHERE school_id_number='$school_id' && numeric_class_name='$numeric_class' && session='$session' && subject_code='$subject_code' && term_id_number='$term_id_number' && day_code='$day_code'") == true){
                    $redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=exam_list".$additional_back_tag;
                }
            }
        }else{
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