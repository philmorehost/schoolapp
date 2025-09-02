<?php
	header("HTTP/1.1 200");
	include("../config-file.php");
	
	$catch_incoming_request = json_decode(file_get_contents("php://input"),true);
	$flutterwave_keys = mysqli_fetch_assoc(mysqli_query($connection_server,"SELECT * FROM sm_fees_payment_gateway WHERE gateway_name='flutterwave'"));
	$flutterwave_verify_transaction = json_decode(verifyFlutterwavePaymentWebhook("GET","https://api.flutterwave.com/v3/transactions/".$catch_incoming_request["data"]["id"]."/verify",["Authorization: Bearer ".$flutterwave_keys["secret_key"]],""),true);
	
	$customer_name = $catch_incoming_request["data"]["customer"]["name"];
	$customer_phone_number = $catch_incoming_request["data"]["customer"]["phone_number"];
	$customer_email = $catch_incoming_request["data"]["customer"]["email"];
	$customer_id = $catch_incoming_request["data"]["customer"]["id"];
	$charged_amount = ($catch_incoming_request["data"]["charged_amount"]-$catch_incoming_request["data"]["app_fee"]);
	$transaction_id = $catch_incoming_request["data"]["tx_ref"];
	
	$explode_transaction_id = array_filter(explode("-",trim($transaction_id)));
	$school_id = $explode_transaction_id[0];
	$trans_ref = $explode_transaction_id[1];
	
	if(($flutterwave_verify_transaction["status"] == "success") && ($catch_incoming_request["data"]["status"] == "successful")){
		
		$search_fee_payment_list = mysqli_query($connection_server, "SELECT * FROM sm_fee_payment_lists WHERE school_id_number='".$school_id."' && online_ref='".$trans_ref."'");
		$search_online_pre_payment = mysqli_query($connection_server, "SELECT * FROM sm_online_pre_fee_payment_lists WHERE school_id_number='".$school_id."' && online_ref='".$trans_ref."'");
		
		if(mysqli_num_rows($search_fee_payment_list) == 0){
			if(mysqli_num_rows($search_online_pre_payment) == 1){
				$online_pre_details = mysqli_fetch_array($search_online_pre_payment);
				$session_year_exp = array_filter(explode("-",trim($online_pre_details['session'])));
				$starting_year = $session_year_exp[0];
				$ending_year = "1";
				$description = $catch_incoming_request["data"]["narration"]."\n"."IP Address: ".$catch_incoming_request["data"]["ip"]."\n"."Masked Card: ".$catch_incoming_request["data"]["card"]["first_6digits"]."****".$catch_incoming_request["data"]["card"]["last_4digits"];
				
				//Pre payment exists
				if(mysqli_query($connection_server, "INSERT INTO sm_fee_payment_lists (school_id_number, admission_number, numeric_class_name, session, fee_type_id, online_ref, amount, amount_paid, starting_year, ending_year, status, description) VALUES ('$school_id', '".$online_pre_details['admission_number']."', '".$online_pre_details['numeric_class_name']."', '".$online_pre_details['session']."', '".$online_pre_details['fee_type_id']."', '".$online_pre_details['online_ref']."', '".$online_pre_details['amount']."', '".$online_pre_details['amount_paid']."', '".$starting_year."', '".$ending_year."', 'full paid', '$description')") == true){
					//Delete Online Pre Payment Details
					$delete_online_pre_payment = mysqli_query($connection_server, "DELETE FROM sm_online_pre_fee_payment_lists WHERE school_id_number='".$school_id."' && online_ref='".$trans_ref."'");
					
					$get_mail_stu_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_students WHERE school_id_number='$school_id' && admission_number='".$online_pre_details['admission_number']."' LIMIT 1"));
					$get_mail_par_detail = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number='$school_id' && id_number='".$get_mail_stu_detail["parent_id_number"]."' LIMIT 1"));
					$get_mail_sch_name = mysqli_fetch_array(mysqli_query($connection_server, "SELECT * FROM sm_school_details WHERE school_id_number='$school_id' LIMIT 1"));
					
					// Always set content-type when sending HTML email
					$mail_headers = "MIME-Version: 1.0" . "\r\n";
					$mail_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					
					// More headers
					$mail_headers .= 'From: <'.$get_mail_sch_name["email"].'>' . "\r\n";
					$mail_headers .= 'Cc: '.$get_mail_sch_name["email"]."\r\n";
					
					$email_title = 
					str_replace("{{student_name}}",$get_mail_stu_detail["firstname"]." ".$get_mail_stu_detail["lastname"]." ".$get_mail_stu_detail["othername"],
						str_replace("{{invoice_no}}",$online_pre_details['online_ref'],
							str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
								emailTemplateTableExist('payment-invoice','title','data')
							)
						)
					);
					
					$email_message = 
					mailDesignTemplate($email_title,
					str_replace("{{student_name}}",$get_mail_stu_detail["firstname"]." ".$get_mail_stu_detail["lastname"]." ".$get_mail_stu_detail["othername"],
						str_replace("{{invoice_no}}",$online_pre_details['online_ref'],
							str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
								emailTemplateTableExist('payment-invoice','message','data')
							)
						)
					),'');
					customBCMailSender('',$get_mail_stu_detail["email"],$email_title,$email_message,$mail_headers);
					
					$email_title_2 = 
					str_replace("{{parent_name}}","Mr/Mrs ".$get_mail_par_detail["father_last_name"],
						str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
							emailTemplateTableExist('fees-alert','title','data')
						)
					);
					
					$email_message_2 = 
					mailDesignTemplate($email_title_2,
					str_replace("{{parent_name}}","Mr/Mrs ".$get_mail_par_detail["father_last_name"],
						str_replace("{{school_name}}",$get_mail_sch_name["school_name"],
							emailTemplateTableExist('fees-alert','message','data')
						)
					),'');
					
					customBCMailSender('',$get_mail_par_detail["email"],$email_title_2,$email_message_2,$mail_headers);
					
				}
				
				
			}
		}
		
	}

	function verifyFlutterwavePaymentWebhook($method,$url,$header,$json){
	$apiwalletBalance = curl_init($url);
	$apiwalletBalanceUrl = $url;
	curl_setopt($apiwalletBalance,CURLOPT_URL,$apiwalletBalanceUrl);
	curl_setopt($apiwalletBalance,CURLOPT_RETURNTRANSFER,true);
	if($method == "POST"){
		curl_setopt($apiwalletBalance,CURLOPT_POST,true);
	}
	
	if($method == "GET"){
	curl_setopt($apiwalletBalance,CURLOPT_HTTPGET,true);
	}
	
	if($header == true){
		curl_setopt($apiwalletBalance,CURLOPT_HTTPHEADER,$header);
	}
	if($json == true){
		curl_setopt($apiwalletBalance,CURLOPT_POSTFIELDS,$json);
	}
	curl_setopt($apiwalletBalance, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($apiwalletBalance, CURLOPT_SSL_VERIFYPEER, false);
	
	$verifyFlutterwavePaymentWebhookJSON = curl_exec($apiwalletBalance);
	return $verifyFlutterwavePaymentWebhookJSON;
	}

?>