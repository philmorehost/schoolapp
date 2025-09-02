<?php session_start(); error_reporting(0);
	include("include/config-file.php");
	$get_statement_book = json_decode(file_get_contents('php://input'),true);
	$get_book_detail = mysqli_query($connection_server,"SELECT * FROM sm_book_lists WHERE school_id_number='".$get_statement_book["sch_no"]."' && book_category_id='".$get_statement_book["category"]."'");
    $bookArray = array();
    if(mysqli_num_rows($get_book_detail) >= 1){
        while($book_details = mysqli_fetch_assoc($get_book_detail)){
            $bookArray[$book_details["book_id"]] = $book_details["book_name"];
        }

		echo json_encode(array("response"=>$bookArray),true);
	}else{
		echo json_encode(array("response"=>$bookArray),true);
	}
?>