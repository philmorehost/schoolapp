<?php
if (isset($_POST['save-sms-settings'])) {
    $sms_api_key = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['sms-api-key'])));
    $flutterwave_public_key = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['flutterwave-public-key'])));
    $flutterwave_secret_key = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['flutterwave-secret-key'])));
    $flutterwave_encryption_key = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['flutterwave-encryption-key'])));
    $bank_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['bank-name'])));
    $account_number = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['account-number'])));
    $account_name = mysqli_real_escape_string($connection_server, trim(strip_tags($_POST['account-name'])));

    // Check if settings already exist
    $check_settings = mysqli_query($connection_server, "SELECT * FROM sm_sms_settings LIMIT 1");
    if (mysqli_num_rows($check_settings) > 0) {
        $settings_row = mysqli_fetch_assoc($check_settings);
        $settings_id = $settings_row['id'];
        // Update existing settings
        $update_query = "UPDATE sm_sms_settings SET
            sms_api_key = '$sms_api_key',
            flutterwave_public_key = '$flutterwave_public_key',
            flutterwave_secret_key = '$flutterwave_secret_key',
            flutterwave_encryption_key = '$flutterwave_encryption_key',
            bank_name = '$bank_name',
            account_number = '$account_number',
            account_name = '$account_name'
        WHERE id = '$settings_id'";
        $result = mysqli_query($connection_server, $update_query);
    } else {
        // Insert new settings
        $insert_query = "INSERT INTO sm_sms_settings (
            sms_api_key,
            flutterwave_public_key,
            flutterwave_secret_key,
            flutterwave_encryption_key,
            bank_name,
            account_number,
            account_name
        ) VALUES (
            '$sms_api_key',
            '$flutterwave_public_key',
            '$flutterwave_secret_key',
            '$flutterwave_encryption_key',
            '$bank_name',
            '$account_number',
            '$account_name'
        )";
        $result = mysqli_query($connection_server, $insert_query);
    }

    if ($result) {
        $_SESSION['feedback_message'] = "Settings saved successfully.";
    } else {
        $_SESSION['feedback_message'] = "Error saving settings: " . mysqli_error($connection_server);
    }

    // Redirect to the same page to show the updated settings and feedback message
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit(); // It's a good practice to exit after a header redirect
}

// Fetch existing settings to populate the form
$get_settings = mysqli_query($connection_server, "SELECT * FROM sm_sms_settings LIMIT 1");
if (mysqli_num_rows($get_settings) > 0) {
    $sms_settings = mysqli_fetch_array($get_settings);
} else {
    $sms_settings = array(
        'sms_api_key' => '',
        'flutterwave_public_key' => '',
        'flutterwave_secret_key' => '',
        'flutterwave_encryption_key' => '',
        'bank_name' => '',
        'account_number' => '',
        'account_name' => ''
    );
}
?>
