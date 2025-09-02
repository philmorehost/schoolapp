<?php session_start(); error_reporting(0);
	include("include/config-file.php");
	$get_statement_student = json_decode(file_get_contents('php://input'),true);
	$get_student_detail = mysqli_query($connection_server,"SELECT * FROM sm_students WHERE school_id_number='".$get_statement_student["sch_no"]."' && admission_number='".$get_statement_student["student_ad_no"]."'");
    if(mysqli_num_rows($get_student_detail) == 1){
        $bed_id = mysqli_fetch_array($get_student_detail)["bed_id_number"];
		echo json_encode(array("response"=>$bed_id),true);
	}
?>