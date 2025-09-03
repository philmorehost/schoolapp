<?php
if (isset($_POST['send-sms'])) {
    $sender_id = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['sender-id'])));
    $recipient_list = isset($_POST['recipients']) && is_array($_POST['recipients']) ? $_POST['recipients'] : [];
    $message = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['message'])));
    $school_id = $get_logged_user_details['school_id_number'];

    $sms_cost = count($recipient_list);

    if (empty($sender_id) || empty($recipient_list) || empty($message)) {
        $_SESSION['feedback_message'] = "Please provide a Sender ID, at least one recipient, and a message.";
    } else {
        // Fetch school's balance
        $balance_query = mysqli_query($connection_server, "SELECT wallet_balance FROM sm_school_details WHERE school_id_number = '$school_id'");
        $school_balance = 0;
        if (mysqli_num_rows($balance_query) > 0) {
            $school_balance = (int)mysqli_fetch_assoc($balance_query)['wallet_balance'];
        }

        if ($school_balance < $sms_cost) {
            $_SESSION['feedback_message'] = "Insufficient SMS credits. You have $school_balance, but this message requires $sms_cost credits.";
        } else {
            // Get API key
            $get_api_key = mysqli_query($connection_server, "SELECT sms_api_key FROM sm_sms_settings LIMIT 1");
            if (mysqli_num_rows($get_api_key) > 0) {
                $api_key = mysqli_fetch_assoc($get_api_key)['sms_api_key'];
                $recipients_str = implode(',', $recipient_list);

                // Send SMS using PhilmoreSMS API
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://app.philmoresms.com/api/sms.php');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "token=$api_key&senderID=$sender_id&recipients=$recipients_str&message=$message");
                $result = curl_exec($ch);
                curl_close($ch);

                $response = json_decode($result, true);
                $status = isset($response['status']) ? $response['status'] : 'failed';

                // Log SMS to history
                $log_sms = mysqli_query($connection_server, "INSERT INTO sm_sms_history (school_id_number, sender_id, recipients, message, status, date) VALUES ('$school_id', '$sender_id', '$recipients_str', '$message', '$status', NOW())");

                if ($status == 'success') {
                    // Deduct credits from school's balance
                    $new_balance = $school_balance - $sms_cost;
                    mysqli_query($connection_server, "UPDATE sm_school_details SET wallet_balance = '$new_balance' WHERE school_id_number = '$school_id'");
                    $_SESSION['feedback_message'] = "SMS sent successfully to $sms_cost recipients. Your new balance is $new_balance credits.";
                } else {
                    $error_code = isset($response['error_code']) ? $response['error_code'] : 'N/A';
                    $raw_response = htmlspecialchars(print_r($response, true));
                    $_SESSION['feedback_message'] = "Failed to send SMS. Error Code: " . $error_code . "<br><br>Full API Response: <pre>" . $raw_response . "</pre>";
                }
            } else {
                $_SESSION['feedback_message'] = "SMS sending is not configured. Please contact support.";
            }
        }
    }
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>
