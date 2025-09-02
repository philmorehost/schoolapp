<?php
$school_id = $get_logged_user_details['school_id_number'];

// Get API key
$get_api_key = mysqli_query($connection_server, "SELECT sms_api_key FROM sm_sms_settings LIMIT 1");
$api_key = '';
if (mysqli_num_rows($get_api_key) > 0) {
    $api_key = mysqli_fetch_array($get_api_key)['sms_api_key'];
}

if (isset($_POST['register-sender-id'])) {
    $sender_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['sender-id'])));
    $sample_message = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['sample-message'])));

    if (!empty($sender_id) && !empty($sample_message) && !empty($api_key)) {
        // Submit Sender ID using PhilmoreSMS API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://app.philmoresms.com/api/senderID.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "token=$api_key&senderID=$sender_id&message=$sample_message");
        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result, true);
        if ($response['status'] == 'success') {
            // Save to database
            $insert_sender_id = mysqli_query($connection_server, "INSERT INTO sm_sms_sender_ids (school_id_number, sender_id, status) VALUES ('$school_id', '$sender_id', 'pending')");
            $alert_message = "Sender ID submitted successfully.";
        } else {
            $alert_message = "Failed to submit Sender ID. Error: " . $response['error_code'];
        }
    } else {
        $alert_message = "Please fill in all fields and ensure API key is set.";
    }
    echo "<script>alert('$alert_message');</script>";
}

if (isset($_POST['check-sender-id-status'])) {
    $sender_id_to_check = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['sender-id-to-check'])));

    if (!empty($sender_id_to_check) && !empty($api_key)) {
        // Check Sender ID status using PhilmoreSMS API
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://app.philmoresms.com/api/check_senderID.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "token=$api_key&senderID=$sender_id_to_check");
        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result, true);
        if ($response['status'] == 'success') {
            $status = $response['ID_status'];
            // Update status in database
            $update_status = mysqli_query($connection_server, "UPDATE sm_sms_sender_ids SET status = '$status' WHERE school_id_number = '$school_id' AND sender_id = '$sender_id_to_check'");
            $alert_message = "Sender ID status updated successfully.";
        } else {
            $alert_message = "Failed to check Sender ID status. Error: " . $response['error_code'];
        }
    } else {
        $alert_message = "Sender ID not specified or API key not set.";
    }
    echo "<script>alert('$alert_message');</script>";
}
?>
