<?php session_start(); error_reporting(0);
	
	if(isset($_SESSION["stu_session"])){
        include("include/config-file.php");
        $get_post_info = json_decode(file_get_contents('php://input'),true);
        $get_cbt_id = mysqli_real_escape_string($connection_server, preg_replace("/[^0-9]+/", "", trim($get_post_info["id"])));
                            
        if(is_numeric($get_cbt_id)){
            $check_cbt_scheldule_list = mysqli_query($connection_server,"SELECT * FROM sm_cbt_scheldule_lists WHERE cbt_id='".$get_cbt_id."' && school_id_number='".$get_logged_user_details["school_id_number"]."' && numeric_class_name='".$get_logged_user_details["current_class"]."' && session='".$get_logged_user_details["session"]."'");
            if(mysqli_num_rows($check_cbt_scheldule_list) == 1){
                $check_cbt_started_list = mysqli_query($connection_server,"SELECT * FROM sm_started_cbt_lists WHERE cbt_id_number='".$get_cbt_id."' && school_id_number='".$get_logged_user_details["school_id_number"]."' && admission_number='".$get_logged_user_details["admission_number"]."'");
                if(mysqli_num_rows($check_cbt_started_list) == 0){
                    mysqli_query($connection_server, "INSERT INTO sm_started_cbt_lists (school_id_number, cbt_id_number, admission_number) VALUES ('".$get_logged_user_details["school_id_number"]."','".$get_cbt_id."','".$get_logged_user_details["admission_number"]."')");
                    echo json_encode(array("response"=>2),true);
                }
            }else{
                echo json_encode(array("response"=>2),true);
            }
        }else{
            echo json_encode(array("response"=>2),true);
        }
    }

?>