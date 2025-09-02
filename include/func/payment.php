<?php
    $show_back_arrow = false;
    /*$err_msg = "";
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
        $err_msg .= "Error: fee is currently not available";
    }   
    
    if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "5"){
        $err_msg .= "Error: fee Quantity is lesser than Issued fee Quantity";
    }   
    
    $header_add_button = "add_payment";
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
        $select_fee_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_fee_lists WHERE $search_sqli_statements && school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." ".$user_admission_id_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
        $select_all_fee_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_fee_lists WHERE $search_sqli_statements && school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." ".$user_admission_id_statement_auth);
        $select_fee_payment_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_fee_payment_lists WHERE $search_sqli_statements && school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." ".$user_admission_id_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
        $select_all_fee_payment_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_fee_payment_lists WHERE $search_sqli_statements && school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." ".$user_admission_id_statement_auth);
        
    }else{
        $select_fee_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_fee_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." ".$user_admission_id_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
        $select_all_fee_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_fee_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." ".$user_admission_id_statement_auth);
        $select_fee_payment_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_fee_payment_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." ".$user_admission_id_statement_auth." LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
        $select_all_fee_payment_list_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_fee_payment_lists WHERE school_id_number='".trim(strip_tags($_GET['id']))."' ".$user_class_statement_auth." ".$user_admission_id_statement_auth);
        
    }
    
    if(isset($_POST["update-payment"])){
        $flutterwave_public_key = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["flutterwave-public-key"])));
        $flutterwave_secret_key = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["flutterwave-secret-key"])));
        $flutterwave_encrypt_key = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["flutterwave-encrypt-key"])));
        $enable_flutterwave = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["enable-flutterwave"])));
        
        if($enable_flutterwave === '1'){
            $enable_flutterwave_status = $enable_flutterwave;
        }else{
            $enable_flutterwave_status = 0;
        }
        $school_id = $get_logged_user_details["school_id_number"];
        
        if(!empty($flutterwave_public_key) && !empty($flutterwave_secret_key) && !empty($flutterwave_encrypt_key) && !empty($school_id)){
            //Update Flutterwave Data
            $update_flutterwave_data = mysqli_query($connection_server, "UPDATE sm_fees_payment_gateway SET public_key='$flutterwave_public_key', secret_key='$flutterwave_secret_key', encrypt_key='$flutterwave_encrypt_key', status='$enable_flutterwave_status' WHERE school_id_number='$school_id' && gateway_name='flutterwave'");
            $redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=fees_payment_type".$additional_back_tag;
        }else{
            $redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
        }
        
        //header("Location: ".$redirect_url);
    }
    
    if(isset($_POST["create-fee-type"])){
        $fee_type = mysqli_real_escape_string($connection_server, trim(strip_tags(array_filter(explode(" ",trim($_POST["fee-type"])))[0])));
        $numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
        $session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class-session"])));
        $amount = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["amount"])));
        $desc = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["desc"])));
        
        $school_id = $get_logged_user_details["school_id_number"];
        
        if(!empty($fee_type) && !empty($numeric_class) && !empty($session) && !empty($amount) && !empty($school_id)){
            if(mysqli_query($connection_server, "INSERT INTO sm_fee_lists (school_id_number, fee_type_id, numeric_class_name, session, amount, description) VALUES ('$school_id','$fee_type', '$numeric_class', '$session', '$amount', '$desc')") == true){
                $redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=fees_list".$additional_back_tag;
            }
        }else{
            $redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
        }
        
        header("Location: ".$redirect_url);
    }
    
    if(isset($_POST["update-fee-type"])){
        $fee_type = mysqli_real_escape_string($connection_server, trim(strip_tags(array_filter(explode(" ",trim($_POST["fee-type"])))[0])));
        $numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
        $session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class-session"])));
        $amount = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["amount"])));
        $desc = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["desc"])));
        
        $current_fee_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["edit"])));
        $school_id = $get_logged_user_details["school_id_number"];
        
        $search_fee_with_id = mysqli_query($connection_server, "SELECT * FROM sm_fee_lists WHERE school_id_number='$school_id' && fee_id='$current_fee_id'");
        
        if(!empty($fee_type) && !empty($numeric_class) && !empty($session) && !empty($amount) && !empty($school_id)){
            if(mysqli_num_rows($search_fee_with_id) == 1){
                if(mysqli_query($connection_server, "UPDATE sm_fee_lists SET fee_type_id='$fee_type', numeric_class_name='$numeric_class', session='$session', amount='$amount', description='$desc' WHERE (school_id_number='$school_id' && fee_id='$current_fee_id')") == true){
                    $redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=fees_list".$additional_back_tag;
                }
            }else{
                $redirect_url = $_SERVER["REQUEST_URI"]."&err=3";
            }
        }else{
            $redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
        }
        
        header("Location: ".$redirect_url);
    }

    if(isset($_POST["create-invoice"])){
        $student_roll_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["student-roll-number"])));
        $numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
        $session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class-session"])));
        $fee_type = mysqli_real_escape_string($connection_server, trim(strip_tags(array_filter(explode(" ",trim($_POST["fee-type"])))[0])));
        $amount = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["amount"])));
        $amount_paid = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["amount-paid"])));
        $desc = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["desc"])));
        $starting_year = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["starting-year"])));
        $ending_year = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["ending-year"])));
        $status = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["status"])));
        $ref_char = "1234567890123456789012345678901234567890";
        $manual_ref = substr(str_shuffle($ref_char),0,10);

        $school_id = $get_logged_user_details["school_id_number"];
        
        $check_if_invoice_exists = mysqli_query($connection_server, "SELECT * FROM sm_fee_payment_lists WHERE school_id_number='$school_id' && admission_number='$student_roll_number' && numeric_class_name='$numeric_class' && session='$session' && fee_type_id='$fee_type' && starting_year='$starting_year'");
        if(!empty($student_roll_number) && !empty($numeric_class) && !empty($session) && !empty($fee_type) && !empty($amount) && !empty($starting_year) && ($ending_year >= 0) && !empty($school_id)){
            if(mysqli_num_rows($check_if_invoice_exists) == 0){
                if(mysqli_query($connection_server, "INSERT INTO sm_fee_payment_lists (school_id_number, admission_number, numeric_class_name, session, fee_type_id, manual_ref, amount, amount_paid, starting_year, ending_year, status, description) VALUES ('$school_id', '$student_roll_number', '$numeric_class', '$session', '$fee_type', '$manual_ref', '$amount', '$amount_paid', '$starting_year', '$ending_year', '$status', '$desc')") == true){
                    $redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=fees_payment_list".$additional_back_tag;
                }
            }else{
                $redirect_url = $_SERVER["REQUEST_URI"]."&err=2";
            }
        }else{
            $redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
        }
        
        header("Location: ".$redirect_url);
    }
    
    if(isset($_POST["update-invoice"])){
        $student_roll_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["student-roll-number"])));
        $numeric_class = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["numeric-class"])));
        $session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class-session"])));
        $fee_type = mysqli_real_escape_string($connection_server, trim(strip_tags(array_filter(explode(" ",trim($_POST["fee-type"])))[0])));
        $amount = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["amount"])));
        $amount_paid = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["amount-paid"])));
        $desc = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["desc"])));
        $starting_year = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["starting-year"])));
        $ending_year = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["ending-year"])));
        $status = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["status"])));
        
        $current_fee_payment_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["edit"])));
        $school_id = $get_logged_user_details["school_id_number"];
        
        $check_if_invoice_exists = mysqli_query($connection_server, "SELECT * FROM sm_fee_payment_lists WHERE school_id_number='$school_id' && admission_number='$student_roll_number' && numeric_class_name='$numeric_class' && session='$session' && fee_type_id='$fee_type' && starting_year='$starting_year'");
        $search_fee_payment_with_id = mysqli_query($connection_server, "SELECT * FROM sm_fee_payment_lists WHERE school_id_number='$school_id' && fee_payment_id='$current_fee_payment_id'");
        
        if(!empty($fee_type) && !empty($numeric_class) && !empty($session) && !empty($amount) && !empty($school_id)){
            if(mysqli_num_rows($search_fee_payment_with_id) == 1){
                if((mysqli_num_rows($check_if_invoice_exists) == 0) || ((mysqli_num_rows($check_if_invoice_exists) == 1) && (mysqli_fetch_array($check_if_invoice_exists)["fee_payment_id"] == $current_fee_payment_id))){
                    if(mysqli_query($connection_server, "UPDATE sm_fee_payment_lists SET admission_number='$student_roll_number', numeric_class_name='$numeric_class', session='$session', fee_type_id='$fee_type', amount_paid='$amount_paid', starting_year='$starting_year', ending_year='$ending_year', status='$status', description='$desc' WHERE (school_id_number='$school_id' && fee_payment_id='$current_fee_payment_id')") == true){
                        $redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=fees_payment_list".$additional_back_tag;
                    }
                }else{
                    $redirect_url = $_SERVER["REQUEST_URI"]."&err=2";
                }
            }else{
                $redirect_url = $_SERVER["REQUEST_URI"]."&err=3";
            }
        }else{
            $redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
        }
        
        header("Location: ".$redirect_url);
    }
    if(isset($_POST["delete-fee-list"])){
        $fee_id = $_POST["fee_id"];
        $school_id = $_POST["school_id"];
        foreach($fee_id as $index => $fee_id_no){
            $fee_id_num = mysqli_real_escape_string($connection_server, $fee_id[$index]);
            $sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
            $delete_school_selected_fee_list = mysqli_query($connection_server, "DELETE FROM sm_fee_lists WHERE (school_id_number='$sch_id_number' && fee_id='$fee_id_num')");
        }
        $redirect_url = $_SERVER["REQUEST_URI"];
        
        header("Location: ".$redirect_url);
    }

    if(isset($_POST["delete-fee-payment-list"])){
        $fee_payment_id = $_POST["fee_payment_id"];
        $school_id = $_POST["school_id"];
        foreach($fee_payment_id as $index => $fee_payment_id_no){
            $fee_payment_id_num = mysqli_real_escape_string($connection_server, $fee_payment_id[$index]);
            $sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
            $delete_school_selected_fee_payment_list = mysqli_query($connection_server, "DELETE FROM sm_fee_payment_lists WHERE (school_id_number='$sch_id_number' && fee_payment_id='$fee_payment_id_num')");
        }
        $redirect_url = $_SERVER["REQUEST_URI"];
        
        header("Location: ".$redirect_url);
    }
    
    if(isset($_POST["search-item"])){
        $search_item_text = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["search-item"])));
        
        $page_to_go_link = "/bc-admin.php?page=".trim(strip_tags($_GET["page"]))."&tab=".trim(strip_tags($_GET["tab"])).$additional_add_tag."&search=".$search_item_text."&pnum=".$page_pnum;
        header("Location: ".$page_to_go_link);
    }*/
?>
