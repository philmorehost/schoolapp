<?php session_start(); error_reporting(0);
	include("include/config-file.php");
	$get_statement_student = json_decode(file_get_contents('php://input'),true);
	/*$get_student_detail = mysqli_query($connection_server,"SELECT * FROM sm_students WHERE school_id_number='".$get_statement_student["sch_no"]."' && current_class='".$get_statement_student["class_id_no"]."' && session='".$get_statement_student["session"]."'");
    $studentArray = array();
    if(mysqli_num_rows($get_student_detail) >= 1){
        while($stu_details = mysqli_fetch_assoc($get_student_detail)){
            $studentArray[$stu_details["admission_number"]] = $stu_details["firstname"]." ".$stu_details["lastname"];
        }

		echo json_encode(array("response"=>$studentArray),true);
	}else{
		echo json_encode(array("response"=>$studentArray),true);
	}*/
	
	$get_student_detail = mysqli_query($connection_server,"SELECT * FROM sm_class_list WHERE school_id_number='".$get_statement_student["sch_no"]."' && numeric_class_name='".$get_statement_student["class_id_no"]."' && session='".$get_statement_student["session"]."' ".$get_statement_student["student"]);
	    $studentArray = array();
	    if(mysqli_num_rows($get_student_detail) >= 1){
	        while($stu_details = mysqli_fetch_assoc($get_student_detail)){
	        	$get_student_name = mysqli_fetch_array(mysqli_query($connection_server,"SELECT * FROM sm_students WHERE school_id_number='".$get_statement_student["sch_no"]."' && admission_number='".$stu_details["admission_number"]."' LIMIT 1"));
	            $studentArray[$stu_details["admission_number"]] = $get_student_name["firstname"]." ".$get_student_name["lastname"];
	        }
	
		echo json_encode(array("response"=>$studentArray),true);
	}else{
		echo json_encode(array("response"=>$studentArray),true);
	}
	
?>