<?php
if (isset($_POST['submit-bank-transfer'])) {
    $amount = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['amount'])));
    $reference = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['reference'])));
    $school_id = $get_logged_user_details['school_id_number'];

    if (!empty($amount) && !empty($reference) && !empty($school_id)) {
        $insert_payment = mysqli_query($connection_server, "INSERT INTO sm_sms_payment_history (school_id_number, payment_method, amount, reference, status, date) VALUES ('$school_id', 'bank_transfer', '$amount', '$reference', 'pending', NOW())");
        if ($insert_payment) {
            $_SESSION['feedback_message'] = "Bank transfer notification submitted successfully. Your payment will be processed shortly.";
        } else {
            $_SESSION['feedback_message'] = "Error submitting payment notification: " . mysqli_error($connection_server);
        }
    } else {
        $_SESSION['feedback_message'] = "Please fill in all fields for the bank transfer.";
    }
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

if (isset($_POST['pay-with-flutterwave'])) {
    $amount = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['amount'])));
    $school_id = $get_logged_user_details['school_id_number'];
    $email = $get_logged_user_details['email'];
    $phone_number = $get_logged_user_details['phone_number'];
    $name = $get_logged_user_details['firstname'] . ' ' . $get_logged_user_details['lastname'];
    $ref = 'sms-' . time();

    if (empty($amount) || !is_numeric($amount) || $amount <= 0) {
        $_SESSION['feedback_message'] = "Please enter a valid amount for the Flutterwave payment.";
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }

    $charge_percentage = isset($sms_settings['payment_charges']) ? floatval($sms_settings['payment_charges']) : 0;
    $charge_amount = ($amount * $charge_percentage) / 100;
    $final_amount = $amount + $charge_amount;

    $public_key = isset($sms_settings['flutterwave_public_key']) ? $sms_settings['flutterwave_public_key'] : '';

    if (!empty($public_key)) {
        echo "
        <script src='https://checkout.flutterwave.com/v3.js'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                FlutterwaveCheckout({
                    public_key: '$public_key',
                    tx_ref: '$ref',
                    amount: $final_amount,
                    currency: 'NGN',
                    payment_options: 'card, banktransfer, ussd',
                    redirect_url: '', // Add a proper redirect URL if needed
                    customer: {
                        email: '$email',
                        phone_number: '$phone_number',
                        name: '$name',
                    },
                    customizations: {
                        title: 'SMS Credit Purchase',
                        description: 'Payment for SMS credits',
                        logo: '',
                    },
                    callback: function(payment) {
                        // This function needs to be defined globally
                        // It should likely be an AJAX call to a PHP script to record the payment
                        // For now, we'll assume a function `smsPaymentCallBackRecord` exists
                        console.log('Payment successful', payment);
                        // smsPaymentCallBackRecord('$school_id', $amount, '$ref');
                        window.location.href = window.location.pathname + '?page=smgt_sms_purchase&payment_status=success&ref=' + '$ref';
                    },
                    onclose: function() {
                        console.log('Payment modal closed.');
                        window.location.href = window.location.pathname + '?page=smgt_sms_purchase&payment_status=closed';
                    }
                });
            });
        </script>
        ";
    } else {
        $_SESSION['feedback_message'] = "Flutterwave payment gateway is not configured. Please contact support.";
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}
?>
