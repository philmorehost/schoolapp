<?php session_start();
	include("include/config-file.php");
	$get_statement_text = json_decode(file_get_contents('php://input'),true);
	if(mysqli_query($connection_server,$get_statement_text["text"]) == true){
		echo json_encode(array("response"=>$get_statement_text["text"]),true);
	}
?>