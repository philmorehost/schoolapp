<?php
if (isset($_POST['send-sms'])) {
    $sender_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['sender-id'])));
    $recipients = implode(',', $_POST['recipients']);
    $message = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['message'])));
    $school_id = $get_logged_user_details['school_id_number'];

    // Get API key
    $get_api_key = mysqli_query($connection_server, "SELECT sms_api_key FROM sm_sms_settings LIMIT 1");
    if (mysqli_num_rows($get_api_key) > 0) {
        $api_key = mysqli_fetch_array($get_api_key)['sms_api_key'];

        // Send SMS using PhilmoreSMS API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://app.philmoresms.com/api/sms.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "token=$api_key&senderID=$sender_id&recipients=$recipients&message=$message");
        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result, true);
        $status = $response['status'];

        // Log SMS to history
        $log_sms = mysqli_query($connection_server, "INSERT INTO sm_sms_history (school_id_number, sender_id, recipients, message, status) VALUES ('$school_id', '$sender_id', '$recipients', '$message', '$status')");

        if ($status == 'success') {
            $alert_message = "SMS sent successfully.";
        } else {
            $alert_message = "Failed to send SMS. Error: " . $response['error_code'];
        }
    } else {
        $alert_message = "API key not set.";
    }
    echo "<script>alert('$alert_message');</script>";
}
?>
