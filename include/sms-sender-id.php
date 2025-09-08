<?php
// This file is for the Sender ID management page for school admins.
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
            <div class="container-box bg-3 mobile-width-100 system-width-100 mobile-padding-top-2 system-padding-top-2 mobile-padding-bottom-2 system-padding-bottom-2">
                <div class="mobile-width-90 system-width-90">
                    <h3>Register New Sender ID</h3>
                    <form method="post">
                        <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                            <input type="text" name="sender-id" id="sender-id" class="form-input" maxlength="11" required>
                            <span class="form-span mobile-font-size-12 system-font-size-14">Sender ID*</span>
                        </div>
                        <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                            <textarea name="sample-message" id="sample-message" class="form-input" rows="3" required></textarea>
                            <span class="form-span mobile-font-size-12 system-font-size-14">Sample Message*</span>
                        </div>
                        <button type="submit" name="register-sender-id" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-93 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">Register Sender ID</button>
                    </form>
                </div>
            </div>

            <div class="container-box bg-3 mobile-width-100 system-width-100 mobile-margin-top-2 system-margin-top-2 mobile-padding-top-2 system-padding-top-2 mobile-padding-bottom-2 system-padding-bottom-2">
                <div class="mobile-width-90 system-width-90">
                    <h3>Sender ID Status</h3>
                    <table class="table-2">
                        <thead>
                            <tr>
                                <th>Sender ID</th>
                                <th>Status</th>
                                <th>Date Submitted</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $school_id = $get_logged_user_details['school_id_number'];
                            $get_sender_ids = mysqli_query($connection_server, "SELECT * FROM sm_sms_sender_ids WHERE school_id_number = '$school_id'");
                            while ($sender_id = mysqli_fetch_array($get_sender_ids)) {
                            ?>
                                <tr>
                                    <td><?php echo $sender_id['sender_id']; ?></td>
                                    <td><?php echo $sender_id['status']; ?></td>
                                    <td><?php echo $sender_id['date_submitted']; ?></td>
                                    <td>
                                        <form method="post">
                                            <input type="hidden" name="sender-id-to-check" value="<?php echo $sender_id['sender_id']; ?>">
                                            <button type="submit" name="check-sender-id-status" class="button-box-2 bg-5 color-2">Check Status</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </center>
</div>
