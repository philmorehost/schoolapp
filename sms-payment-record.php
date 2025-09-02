<?php
include("include/config-file.php");
$get_statement_sms_payment = json_decode(file_get_contents('php://input'), true);

$school_id = $get_statement_sms_payment['sch_no'];
$amount = $get_statement_sms_payment['amount'];
$reference = $get_statement_sms_payment['ref'];

if (!empty($school_id) && !empty($amount) && !empty($reference)) {
    // Insert into payment history
    $insert_payment = mysqli_query($connection_server, "INSERT INTO sm_sms_payment_history (school_id_number, payment_method, amount, reference, status) VALUES ('$school_id', 'flutterwave', '$amount', '$reference', 'completed')");

    // Update wallet balance
    $update_wallet = mysqli_query($connection_server, "UPDATE sm_school_details SET wallet_balance = wallet_balance + '$amount' WHERE school_id_number = '$school_id'");

    if ($insert_payment && $update_wallet) {
        echo json_encode(array("response" => 1), true);
    } else {
        echo json_encode(array("response" => 0), true);
    }
} else {
    echo json_encode(array("response" => 0), true);
}
?>
