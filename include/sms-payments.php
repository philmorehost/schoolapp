<?php
// This file is for the SMS payment management interface for the super admin.
// It will display a list of manual payment notifications from the sm_sms_payment_history table.
?>
<?php
if (isset($_SESSION['feedback_message'])) {
    echo '<div class="feedback-message">' . htmlspecialchars($_SESSION['feedback_message']) . '</div>';
    unset($_SESSION['feedback_message']);
}
?>
<div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
    <center>
        <div class="mobile-width-95 system-width-95 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2">
            <table class="table-2">
                <thead>
                    <tr>
                        <th>School ID</th>
                        <th>Amount</th>
                        <th>Reference</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch pending manual payments
                    $get_pending_payments = mysqli_query($connection_server, "SELECT * FROM sm_sms_payment_history WHERE payment_method = 'bank_transfer' AND status = 'pending'");
                    if (mysqli_num_rows($get_pending_payments) > 0) {
                        while ($payment = mysqli_fetch_array($get_pending_payments)) {
                    ?>
                            <tr>
                                <td><?php echo $payment['school_id_number']; ?></td>
                                <td><?php echo $payment['amount']; ?></td>
                                <td><?php echo $payment['reference']; ?></td>
                                <td><?php echo $payment['date']; ?></td>
                                <td>
                                    <form method="post">
                                        <input type="hidden" name="payment-id" value="<?php echo $payment['id']; ?>">
                                        <button type="submit" name="approve-payment" class="button-box-2 bg-5 color-2">Approve</button>
                                        <button type="submit" name="reject-payment" class="button-box-2 bg-10 color-2">Reject</button>
                                    </form>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                    ?>
                        <tr>
                            <td colspan="5">No pending payments.</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </center>
</div>
