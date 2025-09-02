<?php
// Fetch SMS settings
$get_settings = mysqli_query($connection_server, "SELECT * FROM sm_sms_settings LIMIT 1");
if (mysqli_num_rows($get_settings) > 0) {
    $sms_settings = mysqli_fetch_array($get_settings);
} else {
    $sms_settings = array(
        'bank_name' => 'Not Set',
        'account_number' => 'Not Set',
        'account_name' => 'Not Set'
    );
}

if (isset($_POST['submit-bank-transfer'])) {
    $amount = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['amount'])));
    $reference = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['reference'])));
    $school_id = $get_logged_user_details['school_id_number'];

    if (!empty($amount) && !empty($reference) && !empty($school_id)) {
        $insert_payment = mysqli_query($connection_server, "INSERT INTO sm_sms_payment_history (school_id_number, payment_method, amount, reference, status) VALUES ('$school_id', 'bank_transfer', '$amount', '$reference', 'pending')");
        if ($insert_payment) {
            $message = "Payment notification submitted successfully.";
        } else {
            $message = "Failed to submit payment notification.";
        }
    } else {
        $message = "Please fill in all fields.";
    }
    echo "<script>alert('$message');</script>";
}

if (isset($_POST['pay-with-flutterwave'])) {
    $amount = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['amount'])));
    $school_id = $get_logged_user_details['school_id_number'];
    $email = $get_logged_user_details['email'];
    $phone_number = $get_logged_user_details['phone_number'];
    $name = $get_logged_user_details['firstname'] . ' ' . $get_logged_user_details['lastname'];
    $ref = 'sms-' . time();

    // Get Flutterwave keys from sm_sms_settings
    $get_flutterwave_keys = mysqli_query($connection_server, "SELECT flutterwave_public_key FROM sm_sms_settings LIMIT 1");
    if (mysqli_num_rows($get_flutterwave_keys) > 0) {
        $flutterwave_keys = mysqli_fetch_array($get_flutterwave_keys);
        $public_key = $flutterwave_keys['flutterwave_public_key'];

        echo "
        <script src='https://checkout.flutterwave.com/v3.js'></script>
        <script>
            FlutterwaveCheckout({
                public_key: '$public_key',
                tx_ref: '$ref',
                amount: $amount,
                currency: 'NGN',
                payment_options: 'card, banktransfer, ussd',
                redirect_url: '',
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
                    smsPaymentCallBackRecord('$school_id', $amount, '$ref');
                }
            });
        </script>
        ";
    } else {
        echo "<script>alert('Flutterwave public key not set.');</script>";
    }
}
?>
