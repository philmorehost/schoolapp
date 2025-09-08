<?php
if (isset($_POST['approve-payment'])) {
    $payment_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['payment-id'])));
    $price_per_sms = isset($sms_settings['price_per_sms']) ? floatval($sms_settings['price_per_sms']) : 0;

    if ($price_per_sms <= 0) {
        $_SESSION['feedback_message'] = "Cannot approve payment: Price per SMS is not set or is invalid.";
    } else {
        $get_payment = mysqli_query($connection_server, "SELECT * FROM sm_sms_payment_history WHERE id = '$payment_id' AND status = 'pending'");
        if (mysqli_num_rows($get_payment) > 0) {
            $payment = mysqli_fetch_assoc($get_payment);
            $school_id = $payment['school_id_number'];
            $amount = floatval($payment['amount']);

            // The 'amount' stored is the amount for credits. The user is instructed to pay this amount plus the fee.
            // So, we just convert the base amount to credits.
            $credits_to_add = floor($amount / $price_per_sms);

            if ($credits_to_add > 0) {
                // Using 'wallet_balance' as the column name based on existing code.
                // It semantically holds the SMS credit balance for the school.
                $update_balance_query = "UPDATE sm_school_details SET wallet_balance = wallet_balance + $credits_to_add WHERE school_id_number = '$school_id'";
                $update_balance_result = mysqli_query($connection_server, $update_balance_query);

                $update_payment_query = "UPDATE sm_sms_payment_history SET status = 'completed' WHERE id = '$payment_id'";
                $update_payment_result = mysqli_query($connection_server, $update_payment_query);

                if ($update_balance_result && $update_payment_result) {
                    $_SESSION['feedback_message'] = "Payment approved. $credits_to_add SMS credits have been added to school $school_id.";
                } else {
                    $_SESSION['feedback_message'] = "Error approving payment: " . mysqli_error($connection_server);
                }
            } else {
                $_SESSION['feedback_message'] = "Payment amount is too low to purchase any credits. Payment has been marked as completed without adding credits.";
                mysqli_query($connection_server, "UPDATE sm_sms_payment_history SET status = 'completed' WHERE id = '$payment_id'");
            }
        } else {
            $_SESSION['feedback_message'] = "Invalid or already processed payment ID.";
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

if (isset($_POST['reject-payment'])) {
    $payment_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['payment-id'])));

    $update_payment = mysqli_query($connection_server, "UPDATE sm_sms_payment_history SET status = 'rejected' WHERE id = '$payment_id'");
    if ($update_payment) {
        $_SESSION['feedback_message'] = "Payment has been rejected.";
    } else {
        $_SESSION['feedback_message'] = "Error rejecting payment: " . mysqli_error($connection_server);
    }
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>
