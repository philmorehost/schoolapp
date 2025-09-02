<?php session_start(); error_reporting(0);
	include("include/config-file.php");
	$get_statement_class_route = json_decode(file_get_contents('php://input'),true);
	$delete_class_route_detail = mysqli_query($connection_server,"DELETE FROM sm_route_lists WHERE school_id_number='".$get_statement_class_route["sch_no"]."' && numeric_class_name='".$get_statement_class_route["class_id_no"]."' && day_code='".$get_statement_class_route["day"]."' && subject_code='".$get_statement_class_route["subject"]."'");
    if($delete_class_route_detail == true){
		echo json_encode(array("response"=>1),true);
	}else{
        echo json_encode(array("response"=>2),true);
    }
?>