<?php
    
    $err_msg = "";
    if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
        $err_msg .= "Error: Empty Fields";
    }
    
    if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
        $err_msg .= "Error: Class with same Numeric Class Name / Session already exists in database";
    }
    
    if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
        $err_msg .= "Error: Another Class has been with same Numeric Class Name already exists in database";
    }
    
    $header_add_button = "add_class_category";
    $additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
    //$header_view_button = "view_class";
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
        $search_sqli_statement .= "class_category_name LIKE '%".$search_items."%'";
    
    }
    
    $search_sqli_statements .= "(".str_replace("\n"," && school_id_number=".$get_logged_user_details['school_id_number'].") OR (", trim($search_sqli_statement))." && school_id_number=".$get_logged_user_details['school_id_number'].")";
    
    if((isset($_GET["search"])) && (trim(strip_tags($_GET["search"])) !== "")){
        $select_class_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_class_category WHERE $search_sqli_statements LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
        $select_all_class_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_class_category WHERE $search_sqli_statements");
    }else{
        $select_class_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_class_category WHERE school_id_number='".trim(strip_tags($_GET['id']))."' LIMIT $page_pnum OFFSET ".((($current_page_no)-1)*$page_pnum));
        $select_all_class_table_lists = mysqli_query($connection_server, "SELECT * FROM sm_class_category WHERE school_id_number='".trim(strip_tags($_GET['id']))."'");
    }
    
    if(isset($_POST["add-class-category"])){
        $class_category_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class-category-name"])));
        $school_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["school-id"])));
        
        if(!empty($class_category_name) && !empty($school_id)){
            if(mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_class_category WHERE (school_id_number='$school_id' && class_category_name='$numeric_class_category_name')")) == 0){
                if(mysqli_query($connection_server, "INSERT INTO sm_class_category (school_id_number, class_category_name) VALUES ('$school_id','$class_category_name')") == true){
                    $redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page'])."&tab=true".$additional_back_tag;
                }
            }else{
                $redirect_url = $_SERVER["REQUEST_URI"]."&err=2";
            }
        }else{
            $redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
        }
        
        header("Location: ".$redirect_url);
    }
    
    if(isset($_POST["update-class-category"])){
        $class_category_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["class-category-name"])));
        $school_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["school-id"])));
        
        $current_numeric_class_category_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["edit"])));
                
        $search_class_with_id_numeric = mysqli_query($connection_server, "SELECT * FROM sm_class_category WHERE school_id_number='$school_id' && numeric_class_category_name='$current_numeric_class_category_name'");
        
        if(!empty($class_category_name) && !empty($school_id)){
            if(mysqli_num_rows($search_class_with_id_numeric) == 1){
                if(mysqli_query($connection_server, "UPDATE sm_class_category SET class_category_name='$class_category_name' WHERE (school_id_number='$school_id' && numeric_class_category_name='$current_numeric_class_category_name')") == true){
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
    
    if(isset($_POST["delete-class"])){
        $class_id = $_POST["class_category_id"];
        $school_id = $_POST["school_id"];
        foreach($class_id as $index => $class_id_no){
            $numeric_class_category_name = mysqli_real_escape_string($connection_server, $class_id[$index]);
            $sch_id_number = mysqli_real_escape_string($connection_server, $school_id[$index]);
            
            $delete_school_selected_class = mysqli_query($connection_server, "DELETE FROM sm_class_category WHERE (school_id_number='$sch_id_number' && numeric_class_category_name='$numeric_class_category_name')");
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