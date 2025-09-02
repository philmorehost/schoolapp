<?php session_start(); error_reporting(0);
	include("include/config-file.php");
	$get_statement_fee_payment = json_decode(file_get_contents('php://input'),true);
		
	$function_type = strip_tags(trim($_GET["type"]));
	
	if($function_type == "check"){
		$search_fee_payment_list = mysqli_query($connection_server, "SELECT * FROM sm_fee_payment_lists WHERE school_id_number='".$get_statement_fee_payment['sch_no']."' && fee_type_id='".$get_statement_fee_payment['fee_type']."' && admission_number='".$get_statement_fee_payment['admission_no']."' && numeric_class_name='".$get_statement_fee_payment['class_id_no']."' && session='".$get_statement_fee_payment['session']."'");
		$search_online_pre_payment = mysqli_query($connection_server, "SELECT * FROM sm_online_pre_fee_payment_lists WHERE school_id_number='".$get_statement_fee_payment['sch_no']."' && fee_type_id='".$get_statement_fee_payment['fee_type']."' && admission_number='".$get_statement_fee_payment['admission_no']."' && numeric_class_name='".$get_statement_fee_payment['class_id_no']."' && session='".$get_statement_fee_payment['session']."'");
		
		if(mysqli_num_rows($search_fee_payment_list) < 1){
			if(mysqli_num_rows($search_online_pre_payment) < 1){
				//No Pre payment
				echo json_encode(array("response"=>1),true);
			}else{
				//Pre payment exists
				echo json_encode(array("response"=>2),true);
			}
		}else{
			//Fee payment exists
			echo json_encode(array("response"=>3),true);
	    }
    }
    
	if($function_type == "record"){
		$search_online_pre_payment = mysqli_query($connection_server, "SELECT * FROM sm_online_pre_fee_payment_lists WHERE school_id_number='".$get_statement_fee_payment['sch_no']."' && fee_type_id='".$get_statement_fee_payment['fee_type']."' && admission_number='".$get_statement_fee_payment['admission_no']."' && numeric_class_name='".$get_statement_fee_payment['class_id_no']."' && session='".$get_statement_fee_payment['session']."' && online_ref='".$get_statement_fee_payment['ref']."'");
		
		if(mysqli_num_rows($search_online_pre_payment) == 0){
			if(mysqli_query($connection_server, "INSERT INTO sm_online_pre_fee_payment_lists (school_id_number, fee_type_id, online_ref, admission_number, numeric_class_name, session, amount, amount_paid) VALUES ('".$get_statement_fee_payment['sch_no']."','".$get_statement_fee_payment['fee_type']."','".$get_statement_fee_payment['ref']."','".$get_statement_fee_payment['admission_no']."','".$get_statement_fee_payment['class_id_no']."','".$get_statement_fee_payment['session']."','".$get_statement_fee_payment['amount']."','".$get_statement_fee_payment['amount']."')") == true){
				echo json_encode(array("response"=>1),true);
			}
    	}
    }

?>