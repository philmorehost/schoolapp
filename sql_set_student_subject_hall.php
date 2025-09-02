<?php session_start();
	include("include/config-file.php");
    $get_statement_text = json_decode(file_get_contents('php://input'),true);
    if($get_statement_text["type"] == "not_assigned"){
        $checkmate_student_list = mysqli_query($connection_server, "SELECT * FROM sm_subject_hall_receipts WHERE school_id_number='".$get_statement_text["school_id"]."' && hall_numeric_name='".$get_statement_text["hall_no"]."' && numeric_class_name='".$get_statement_text["class"]."' && term_id_number='".$get_statement_text["term"]."' && session='".$get_statement_text["session"]."' && subject_code='".$get_statement_text["subject"]."' && admission_number='".$get_statement_text["admission_number"]."'");
        $checkmate_student_list_other_hall = mysqli_query($connection_server, "SELECT * FROM sm_subject_hall_receipts WHERE school_id_number='".$get_statement_text["school_id"]."' && numeric_class_name='".$get_statement_text["class"]."' && term_id_number='".$get_statement_text["term"]."' && session='".$get_statement_text["session"]."' && subject_code='".$get_statement_text["subject"]."' && admission_number='".$get_statement_text["admission_number"]."'");
        
        $count_hall_no_occupied = mysqli_num_rows(mysqli_query($connection_server, "SELECT * FROM sm_subject_hall_receipts WHERE school_id_number='".$get_statement_text["school_id"]."' && hall_numeric_name='".$get_statement_text["hall_no"]."' && numeric_class_name='".$get_statement_text["class"]."' && term_id_number='".$get_statement_text["term"]."' && session='".$get_statement_text["session"]."' && subject_code='".$get_statement_text["subject"]."'"));
        $hall_capacity = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_halls WHERE school_id_number='".$get_statement_text["school_id"]."' && hall_numeric_name='".$get_statement_text["hall_no"]."'"));
        
        if((mysqli_num_rows($checkmate_student_list) == 0) && (mysqli_num_rows($checkmate_student_list_other_hall) == 0)){
            if($hall_capacity["hall_capacity"] > $count_hall_no_occupied){
                if(mysqli_query($connection_server, "INSERT INTO sm_subject_hall_receipts (school_id_number, hall_numeric_name, numeric_class_name, term_id_number, session, subject_code, admission_number) VALUES ('".$get_statement_text["school_id"]."', '".$get_statement_text["hall_no"]."', '".$get_statement_text["class"]."', '".$get_statement_text["term"]."', '".$get_statement_text["session"]."', '".$get_statement_text["subject"]."', '".$get_statement_text["admission_number"]."')") == true){
                    echo json_encode(array("response"=>true),true);
                }
            }else{
                echo json_encode(array("response"=>"Hall Limit Exceeded"),true);
            }
        }else{
            echo json_encode(array("response"=>"Student already added to the hall"),true);
        }
    }

    if($get_statement_text["type"] == "assigned"){
        //$checkmate_student_list = mysqli_query($connection_server, "SELECT * FROM sm_subject_hall_receipts WHERE school_id_number='".$get_statement_text["school_id"]."' && hall_numeric_name='".$get_statement_text["hall_no"]."' && term_id_number='".$get_statement_text["term"]."' && session='".$get_statement_text["session"]."' && subject_code='".$get_statement_text["subject"]."' && admission_number='".$get_statement_text["admission_number"]."'");
        $checkmate_student_list_other_hall = mysqli_query($connection_server, "SELECT * FROM sm_subject_hall_receipts WHERE school_id_number='".$get_statement_text["school_id"]."' && numeric_class_name='".$get_statement_text["class"]."' && term_id_number='".$get_statement_text["term"]."' && session='".$get_statement_text["session"]."' && subject_code='".$get_statement_text["subject"]."' && admission_number='".$get_statement_text["admission_number"]."'");
        
        if((mysqli_num_rows($checkmate_student_list_other_hall) == 1)){
            if(mysqli_query($connection_server, "DELETE FROM sm_subject_hall_receipts WHERE school_id_number='".$get_statement_text["school_id"]."' && numeric_class_name='".$get_statement_text["class"]."' && term_id_number='".$get_statement_text["term"]."' && session='".$get_statement_text["session"]."' && subject_code='".$get_statement_text["subject"]."' && admission_number='".$get_statement_text["admission_number"]."'") == true){
                echo json_encode(array("response"=>true),true);
            }
        }else{
            echo json_encode(array("response"=>"Error: Cannot Delete, Student doesnt exists in Hall"),true);
        }
    }
?>