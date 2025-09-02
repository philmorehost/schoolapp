<?php
    
    $err_msg = "";
    if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "1"){
        $err_msg .= "Error: Empty Fields";
    }
    
    if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "2"){
        $err_msg .= "Error: Cannot Continue Migration, Class is empty";
    }
    
    if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "3"){
        $err_msg .= "Success: Migration process successfully";
    }

    if(mysqli_real_escape_string($connection_server, trim(strip_tags($_GET["err"]))) === "4"){
        $err_msg .= "Error: Cannot Migrate to same class";
    }

    $header_add_button = "add_migration";
    $additional_add_tag = "&id=".$get_logged_user_details['school_id_number'];
    //$header_view_button = "view_class";
    $additional_back_tag .= "&id=".$get_logged_user_details['school_id_number'];
    
    
    if(isset($_POST["migrate"])){
        $current_class_session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["current-class"])));
        $current_class = array_filter(explode(" ",trim($current_class_session)))[0];
        $current_session = array_filter(explode(" ",trim($current_class_session)))[1];
        
        $next_class_session = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST["next-class"])));
        $next_class = array_filter(explode(" ",trim($next_class_session)))[0];
        $next_session = array_filter(explode(" ",trim($next_class_session)))[1];
        
        $school_id = $get_logged_user_details["school_id_number"];
        
        if(!empty($current_class) && !empty($current_session) && !empty($next_class) && !empty($next_session) && !empty($school_id)){
            if(($current_class != $next_class) || ($current_session != $next_session)){
                $get_student_in_class = mysqli_query($connection_server, "SELECT * FROM sm_students WHERE (school_id_number='$school_id' && current_class='$current_class' && session='$current_session')");
                if(mysqli_num_rows($get_student_in_class) > 0){
                	
                    mysqli_query($connection_server, "UPDATE sm_students SET current_class='$next_class', session='$next_session' WHERE (school_id_number='$school_id' && current_class='$current_class' && session='$current_session')");
                    
                    while($alter_student_class_list = mysqli_fetch_array($get_student_in_class)){
                    	$stud_admission_no = $alter_student_class_list["admission_number"];
                    	$check_student_exists = mysqli_query($connection_server, "SELECT * sm_class_list WHERE (school_id_number='$school_id' && admission_number='$stud_admission_no' && numeric_class_name='$next_class' && session='$next_session')");
                    	//$check_class_session_exists = mysqli_query($connection_server, "SELECT * sm_class_list WHERE (school_id_number='$school_id' && numeric_class_name='$current_class' && session='$current_session')");
                    	if(mysqli_num_rows($check_student_exists) == 0){
                    		/*if(mysqli_num_rows($check_class_session_exists) == 1){
                    			mysqli_query($connection_server, "DELETE FROM sm_class_list WHERE (school_id_number='$school_id' && numeric_class_name='$current_class' && session='$current_session')");
                    		}*/
                    		mysqli_query($connection_server, "INSERT INTO sm_class_list (school_id_number, admission_number, numeric_class_name, session) VALUES ('$school_id','$stud_admission_no','$next_class','$next_session')");
                    	}
                    }
                    $redirect_url = "/bc-admin.php?page=".strip_tags($_GET['page']).$additional_back_tag."&err=3";
                }else{
                    $redirect_url = $_SERVER["REQUEST_URI"]."&err=2";
                }
            }else{
                $redirect_url = $_SERVER["REQUEST_URI"]."&err=4";
            }
        }else{
            $redirect_url = $_SERVER["REQUEST_URI"]."&err=1";
        }
        
        header("Location: ".$redirect_url);
    }
    
?>