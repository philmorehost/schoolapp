<?php
// This file is for the SMS dashboard for school admins.
// It will display the SMS wallet balance, SMS history, and payment history.
$school_id = $get_logged_user_details['school_id_number'];

// Fetch the school's local SMS balance.
// The column is named 'wallet_balance' based on the logic in sms-payments.php,
// but it semantically stores the SMS credit balance.
$get_balance_query = mysqli_query($connection_server, "SELECT wallet_balance FROM sm_school_details WHERE school_id_number = '$school_id' LIMIT 1");

if (mysqli_num_rows($get_balance_query) > 0) {
    $balance_row = mysqli_fetch_assoc($get_balance_query);
    $wallet_balance = $balance_row['wallet_balance'] . ' SMS Credits';
} else {
    // If the school isn't in the details table or column doesn't exist, show 0.
    $wallet_balance = '0 SMS Credits';
}
?>
<div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
    <center>
        <div class="mobile-width-95 system-width-95 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2">
            <div class="container-box bg-3 mobile-width-100 system-width-100 mobile-padding-top-2 system-padding-top-2 mobile-padding-bottom-2 system-padding-bottom-2">
                <div class="mobile-width-90 system-width-90">
                    <h3 class="text-left">SMS Wallet Balance</h3>
                    <p class="text-left"><?php echo $wallet_balance; ?></p>
                </div>
            </div>

            <div class="container-box bg-3 mobile-width-100 system-width-100 mobile-margin-top-2 system-margin-top-2 mobile-padding-top-2 system-padding-top-2 mobile-padding-bottom-2 system-padding-bottom-2">
                <div class="mobile-width-90 system-width-90">
                    <h3 class="text-left">SMS History</h3>
                    <table class="table-2">
                        <thead>
                            <tr>
                                <th>Sender ID</th>
                                <th>Recipients</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch SMS history for the school
                            $school_id = $get_logged_user_details['school_id_number'];
                            $get_sms_history = mysqli_query($connection_server, "SELECT * FROM sm_sms_history WHERE school_id_number = '$school_id' ORDER BY date DESC LIMIT 10");
                            if (mysqli_num_rows($get_sms_history) > 0) {
                                while ($sms = mysqli_fetch_array($get_sms_history)) {
                            ?>
                                    <tr>
                                        <td><?php echo $sms['sender_id']; ?></td>
                                        <td><?php echo $sms['recipients']; ?></td>
                                        <td><?php echo $sms['message']; ?></td>
                                        <td><?php echo $sms['status']; ?></td>
                                        <td><?php echo $sms['date']; ?></td>
                                    </tr>
                            <?php
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="5">No SMS history found.</td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="container-box bg-3 mobile-width-100 system-width-100 mobile-margin-top-2 system-margin-top-2 mobile-padding-top-2 system-padding-top-2 mobile-padding-bottom-2 system-padding-bottom-2">
                <div class="mobile-width-90 system-width-90">
                    <h3 class="text-left">Payment History</h3>
                    <table class="table-2">
                        <thead>
                            <tr>
                                <th>Payment Method</th>
                                <th>Amount</th>
                                <th>Reference</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch payment history for the school
                            $get_payment_history = mysqli_query($connection_server, "SELECT * FROM sm_sms_payment_history WHERE school_id_number = '$school_id' ORDER BY date DESC LIMIT 10");
                            if (mysqli_num_rows($get_payment_history) > 0) {
                                while ($payment = mysqli_fetch_array($get_payment_history)) {
                            ?>
                                    <tr>
                                        <td><?php echo $payment['payment_method']; ?></td>
                                        <td><?php echo $payment['amount']; ?></td>
                                        <td><?php echo $payment['reference']; ?></td>
                                        <td><?php echo $payment['status']; ?></td>
                                        <td><?php echo $payment['date']; ?></td>
                                    </tr>
                            <?php
                                }
                            } else {
                            ?>
                                <tr>
                                    <td colspan="5">No payment history found.</td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <a href="/bc-admin.php?page=smgt_sms_purchase&id=<?php echo $get_logged_user_details['school_id_number']; ?>">
                <button class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-100 system-width-100 mobile-margin-top-2 system-margin-top-2">
                    Purchase SMS Credits
                </button>
            </a>
        </div>
    </center>
</div>
