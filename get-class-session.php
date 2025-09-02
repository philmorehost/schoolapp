<?php session_start(); error_reporting(0);
	include("include/config-file.php");
	$get_statement_class_session = json_decode(file_get_contents('php://input'),true);
	$get_class_session_detail = mysqli_query($connection_server,"SELECT * FROM sm_classes WHERE school_id_number='".$get_statement_class_session["sch_no"]."' && numeric_class_name='".$get_statement_class_session["class_id_no"]."'");
    if(mysqli_num_rows($get_class_session_detail) > 0){
        $each_session = "";
        while($class_sessions = mysqli_fetch_array($get_class_session_detail)){
            $each_session .= $class_sessions["session"]."\n";
        }
        $all_each_sessions = explode(",",str_replace("\n",",",trim($each_session)));
        
		echo json_encode(array("response"=>$all_each_sessions),true);
	}
?>