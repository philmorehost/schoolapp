<?php session_start();
	include("include/config-file.php");
    $get_statement_text = json_decode(file_get_contents('php://input'),true);

    if($get_statement_text["type"] == "not_assigned"){
        $select_all_student_list = mysqli_query($connection_server, "SELECT * FROM sm_class_list WHERE school_id_number='".$get_statement_text["school_id"]."' && session='".$get_statement_text["session"]."' && numeric_class_name='".$get_statement_text["class"]."'");
        $student_array_child_details = array();
        if(mysqli_num_rows($select_all_student_list) > 0){
            while($student_detail = mysqli_fetch_assoc($select_all_student_list)){
                $get_student_name = mysqli_fetch_array(mysqli_query($connection_server,"SELECT * FROM sm_students WHERE school_id_number='".$get_statement_text["school_id"]."' && admission_number='".$student_detail["admission_number"]."' LIMIT 1"));
	            $checkmate_if_student_added_to_hall = mysqli_query($connection_server, "SELECT * FROM sm_subject_hall_receipts WHERE school_id_number='".$get_statement_text["school_id"]."' && admission_number='".$student_detail["admission_number"]."' && numeric_class_name='".$get_statement_text["class"]."' && term_id_number='".$get_statement_text["term"]."' && session='".$get_statement_text["session"]."' && subject_code='".$get_statement_text["subject"]."'");
                if(mysqli_num_rows($checkmate_if_student_added_to_hall) == 0){
                    $student_array_child_details[$get_student_name["firstname"].' '.$get_student_name["lastname"]] = $get_student_name["admission_number"];
                }
            }
            echo json_encode(array("response"=>$student_array_child_details),true);
        }else{
            echo json_encode(array("response"=>$student_array_child_details),true);
        }
    }

    if($get_statement_text["type"] == "assigned"){
        $select_all_student_list = mysqli_query($connection_server, "SELECT * FROM sm_class_list WHERE school_id_number='".$get_statement_text["school_id"]."' && session='".$get_statement_text["session"]."' && numeric_class_name='".$get_statement_text["class"]."'");
        $student_array_child_details = array();
        if(mysqli_num_rows($select_all_student_list) > 0){
            while($student_detail = mysqli_fetch_assoc($select_all_student_list)){
                $get_student_name = mysqli_fetch_array(mysqli_query($connection_server,"SELECT * FROM sm_students WHERE school_id_number='".$get_statement_text["school_id"]."' && admission_number='".$student_detail["admission_number"]."' LIMIT 1"));
	            $checkmate_if_student_added_to_hall = mysqli_query($connection_server, "SELECT * FROM sm_subject_hall_receipts WHERE school_id_number='".$get_statement_text["school_id"]."' && admission_number='".$student_detail["admission_number"]."' && numeric_class_name='".$get_statement_text["class"]."' && term_id_number='".$get_statement_text["term"]."' && session='".$get_statement_text["session"]."' && subject_code='".$get_statement_text["subject"]."'");
                if(mysqli_num_rows($checkmate_if_student_added_to_hall) == 1){
                    $student_array_child_details[$get_student_name["firstname"].' '.$get_student_name["lastname"]] = $get_student_name["admission_number"];
                }
            }
            echo json_encode(array("response"=>$student_array_child_details),true);
        }else{
            echo json_encode(array("response"=>$student_array_child_details),true);
        }
    }
?>