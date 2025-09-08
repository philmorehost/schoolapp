<?php
// This script is intended to be run weekly by a cron job.
// It generates and emails a usage report to each school admin.

// Set the timezone to avoid potential warnings
date_default_timezone_set('UTC');

// Include necessary files
// Assuming the script is in the root directory
include("include/config-file.php");
include("include/bc-mailer.php"); // For mailDesignTemplate() and customBCMailSender()

// --- Start of Report Generation ---

// 1. Get all schools
$all_schools_query = mysqli_query($connection_server, "SELECT * FROM sm_school_details");

if (mysqli_num_rows($all_schools_query) == 0) {
    echo "No schools found. Exiting.\n";
    exit;
}

echo "Starting weekly report generation for " . mysqli_num_rows($all_schools_query) . " school(s)...\n";

// 2. Loop through each school
while ($school = mysqli_fetch_assoc($all_schools_query)) {
    $school_id = $school['school_id_number'];
    $school_name = $school['school_name'];

    echo "Processing school: $school_name (ID: $school_id)\n";

    // 3. Get the school admin (moderator) for the email address
    $admin_query = mysqli_query($connection_server, "SELECT * FROM sm_moderators WHERE school_id_number = '$school_id' LIMIT 1");
    if (mysqli_num_rows($admin_query) == 0) {
        echo "  - Warning: No admin found for this school. Skipping.\n";
        continue; // Skip to the next school
    }
    $admin = mysqli_fetch_assoc($admin_query);
    $admin_email = $admin['email'];
    $admin_name = $admin['firstname'] . ' ' . $admin['lastname'];

    // 4. Gather the data for the report

    // a) Weekly SMS Sent
    $sms_count_query = mysqli_query($connection_server, "SELECT COUNT(*) as sms_count FROM sm_sms_history WHERE school_id_number = '$school_id' AND date >= DATE_SUB(NOW(), INTERVAL 7 DAY)");
    $sms_count_result = mysqli_fetch_assoc($sms_count_query);
    $weekly_sms_sent = $sms_count_result['sms_count'];

    // b) Current Credit Balance
    $credit_balance = $school['wallet_balance'];

    // c) Last Login
    $last_login = $admin['last_login'];
    if (is_null($last_login)) {
        $last_login_display = "Never";
    } else {
        $last_login_display = date("F j, Y, g:i a", strtotime($last_login));
    }

    // 5. Format and send the email
    $email_title = "Your Weekly SMS Usage Report for $school_name";

    $email_content = "
        <p>Hi $admin_name,</p>
        <p>Here is your weekly summary for your account on our platform:</p>
        <ul>
            <li><strong>SMS Sent in the Last 7 Days:</strong> $weekly_sms_sent</li>
            <li><strong>Current SMS Credit Balance:</strong> $credit_balance</li>
            <li><strong>Your Last Login:</strong> $last_login_display</li>
        </ul>
        <p>Thank you for using our service.</p>
    ";

    $email_message = mailDesignTemplate($email_title, $email_content, '');

    $mail_headers = "MIME-Version: 1.0" . "\r\n";
    $mail_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $mail_headers .= 'From: <support@'.$_SERVER["HTTP_HOST"].'>' . "\r\n";

    // Send the email
    $mail_sent = customBCMailSender('', $admin_email, $email_title, $email_message, $mail_headers);

    if ($mail_sent) {
        echo "  - Report sent successfully to $admin_email.\n";
    } else {
        echo "  - Failed to send report to $admin_email.\n";
    }
}

echo "Weekly report generation finished.\n";

?>
