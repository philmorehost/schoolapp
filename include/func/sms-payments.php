<?php
if (isset($_POST['approve-payment'])) {
    $payment_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['payment-id'])));

    // Get payment details
    $get_payment = mysqli_query($connection_server, "SELECT * FROM sm_sms_payment_history WHERE id = '$payment_id'");
    if (mysqli_num_rows($get_payment) > 0) {
        $payment = mysqli_fetch_array($get_payment);
        $school_id = $payment['school_id_number'];
        $amount = $payment['amount'];

        // Update payment status
        $update_payment = mysqli_query($connection_server, "UPDATE sm_sms_payment_history SET status = 'completed' WHERE id = '$payment_id'");

        // Update wallet balance
        $update_wallet = mysqli_query($connection_server, "UPDATE sm_school_details SET wallet_balance = wallet_balance + '$amount' WHERE school_id_number = '$school_id'");
    }

    // Redirect to the same page
    header("Location: " . $_SERVER['REQUEST_URI']);
}

if (isset($_POST['reject-payment'])) {
    $payment_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['payment-id'])));

    // Update payment status
    $update_payment = mysqli_query($connection_server, "UPDATE sm_sms_payment_history SET status = 'rejected' WHERE id = '$payment_id'");

    // Redirect to the same page
    header("Location: " . $_SERVER['REQUEST_URI']);
}
?>
