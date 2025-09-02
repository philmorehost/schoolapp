<?php session_start(); error_reporting(0);
    include("include/config-file.php");
    $get_statement_class_exam = json_decode(file_get_contents('php://input'),true);
    $delete_class_exam_detail = mysqli_query($connection_server,"DELETE FROM sm_exam_lists WHERE school_id_number='".$get_statement_class_exam["sch_no"]."' && numeric_class_name='".$get_statement_class_exam["class_id_no"]."' && day_code='".$get_statement_class_exam["day"]."' && subject_code='".$get_statement_class_exam["subject"]."'");
    if($delete_class_exam_detail == true){
        echo json_encode(array("response"=>1),true);
    }else{
        echo json_encode(array("response"=>2),true);
    }
?>