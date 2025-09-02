<?php session_start();
	include("include/config-file.php");
	$get_statement_text = json_decode(file_get_contents('php://input'),true);
	if(mysqli_query($connection_server,$get_statement_text["text"]) == true){
		$sql_count = mysqli_num_rows(mysqli_query($connection_server,$get_statement_text["text"]));
		
		echo json_encode(array("response"=>$sql_count),true);
	}
?>