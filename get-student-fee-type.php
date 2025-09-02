<?php session_start(); error_reporting(0);
    include("include/config-file.php");
    $get_statement_fee_list = json_decode(file_get_contents('php://input'),true);
    
    function feeTypeName($fee_info,$school_id){
        global $connection_server;
        
        $get_fee_name = mysqli_query($connection_server,"SELECT * FROM sm_fee_type WHERE school_id_number='$school_id' && id_number='$fee_info'");
        if(mysqli_num_rows($get_fee_name) == 1){
            while($fee_name_array = mysqli_fetch_array($get_fee_name)){
                $fee_name .= $fee_name_array["fee_name"];
            }
        }else{
            $fee_name = "N/A";
        }
        
        return $fee_name;
    }

    $get_fee_list_detail = mysqli_query($connection_server,"SELECT * FROM sm_fee_lists WHERE school_id_number='".$get_statement_fee_list["sch_no"]."' && numeric_class_name='".$get_statement_fee_list["class_id_no"]."' && session='".$get_statement_fee_list["session"]."'");
        $fee_listArray = array();
        if(mysqli_num_rows($get_fee_list_detail) >= 1){
            while($fee_details = mysqli_fetch_assoc($get_fee_list_detail)){
                $fee_listArray[$fee_details["fee_type_id"].' '.$fee_details["amount"]] = feeTypeName($fee_details["fee_type_id"], $fee_details["school_id_number"]);
            }
    
        echo json_encode(array("response"=>$fee_listArray),true);
    }else{
        echo json_encode(array("response"=>$fee_listArray),true);
    }
    
?>