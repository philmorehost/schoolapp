<?php
$school_id = $get_logged_user_details['school_id_number'];

// Get API key
$get_api_key_query = mysqli_query($connection_server, "SELECT sms_api_key FROM sm_sms_settings LIMIT 1");
$api_key = '';
if (mysqli_num_rows($get_api_key_query) > 0) {
    $api_key_row = mysqli_fetch_assoc($get_api_key_query);
    $api_key = $api_key_row['sms_api_key'];
}

function process_form_submission($post_data, $api_url, $fields, $success_callback) {
    global $connection_server, $api_key, $school_id;

    if (empty($api_key)) {
        $_SESSION['feedback_message'] = "SMS API Key is not configured in SMS Settings.";
        return;
    }

    foreach ($fields as $field) {
        if (empty($post_data[$field])) {
            $_SESSION['feedback_message'] = "Please fill in all required fields.";
            return;
        }
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    $result = curl_exec($ch);

    if (curl_errno($ch)) {
        $_SESSION['feedback_message'] = 'cURL error: ' . curl_error($ch);
        curl_close($ch);
        return;
    }
    curl_close($ch);

    $response = json_decode($result, true);
    if ($response === null) {
        $_SESSION['feedback_message'] = "Failed to decode API response. Raw response: " . htmlspecialchars($result);
        return;
    }

    if (isset($response['status']) && $response['status'] == 'success') {
        $success_callback($response);
    } else {
        $error_message = isset($response['error_code']) ? $response['error_code'] : 'Unknown API error.';
        $_SESSION['feedback_message'] = "API call failed. Error: " . $error_message;
    }
}

if (isset($_POST['register-sender-id'])) {
    $sender_id = trim(strip_tags($_POST['sender-id']));
    $sample_message = trim(strip_tags($_POST['sample-message']));

    $post_data = [
        'token' => $api_key,
        'senderID' => $sender_id,
        'message' => $sample_message,
    ];

    process_form_submission($post_data, 'https://app.philmoresms.com/api/senderID.php', ['sender-id', 'sample-message'], function($response) {
        global $connection_server, $school_id, $sender_id;
        $escaped_sender_id = mysqli_real_escape_string($connection_server, $sender_id);
        $insert_query = "INSERT INTO sm_sms_sender_ids (school_id_number, sender_id, status, date_submitted) VALUES ('$school_id', '$escaped_sender_id', 'pending', NOW()) ON DUPLICATE KEY UPDATE status='pending', date_submitted=NOW()";

        if (mysqli_query($connection_server, $insert_query)) {
            $_SESSION['feedback_message'] = "Sender ID submitted successfully. It is currently pending approval.";
        } else {
            $_SESSION['feedback_message'] = "Failed to save Sender ID to the database: " . mysqli_error($connection_server);
        }
    });

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

if (isset($_POST['check-sender-id-status'])) {
    $sender_id_to_check = trim(strip_tags($_POST['sender-id-to-check']));

    $post_data = [
        'token' => $api_key,
        'senderID' => $sender_id_to_check,
    ];

    process_form_submission($post_data, 'https://app.philmoresms.com/api/check_senderID.php', ['sender-id-to-check'], function($response) {
        global $connection_server, $school_id, $sender_id_to_check;
        $status = mysqli_real_escape_string($connection_server, $response['ID_status']);
        $escaped_sender_id = mysqli_real_escape_string($connection_server, $sender_id_to_check);

        $update_query = "UPDATE sm_sms_sender_ids SET status = '$status' WHERE school_id_number = '$school_id' AND sender_id = '$escaped_sender_id'";
        if (mysqli_query($connection_server, $update_query)) {
            $_SESSION['feedback_message'] = "Sender ID status updated to: " . htmlspecialchars($status);
        } else {
            $_SESSION['feedback_message'] = "Failed to update Sender ID status in the database: " . mysqli_error($connection_server);
        }
    });

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}
?>
