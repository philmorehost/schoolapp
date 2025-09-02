<?php
// This file is for the Send SMS page for school admins.
?>
<div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
    <center>
        <div class="mobile-width-95 system-width-95 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2">
            <div class="container-box bg-3 mobile-width-100 system-width-100 mobile-padding-top-2 system-padding-top-2 mobile-padding-bottom-2 system-padding-bottom-2">
                <div class="mobile-width-90 system-width-90">
                    <h3>Send SMS</h3>
                    <form method="post">
                        <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                            <select name="sender-id" id="sender-id" class="form-select" required>
                                <option value="" disabled selected>Select Sender ID</option>
                                <?php
                                $school_id = $get_logged_user_details['school_id_number'];
                                $get_sender_ids = mysqli_query($connection_server, "SELECT * FROM sm_sms_sender_ids WHERE school_id_number = '$school_id' AND status = 'approved'");
                                while ($sender_id = mysqli_fetch_array($get_sender_ids)) {
                                    echo "<option value='" . $sender_id['sender_id'] . "'>" . $sender_id['sender_id'] . "</option>";
                                }
                                ?>
                            </select>
                            <span class="form-span mobile-font-size-12 system-font-size-14">Sender ID*</span>
                        </div>
                        <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                            <select name="recipients[]" id="recipients" class="form-select" multiple required>
                                <optgroup label="Parents">
                                    <?php
                                    $get_parents = mysqli_query($connection_server, "SELECT * FROM sm_parents WHERE school_id_number = '$school_id'");
                                    while ($parent = mysqli_fetch_array($get_parents)) {
                                        echo "<option value='" . $parent['father_phone_number'] . "'>" . $parent['father_first_name'] . " " . $parent['father_last_name'] . " (Father)</option>";
                                        echo "<option value='" . $parent['mother_phone_number'] . "'>" . $parent['mother_first_name'] . " " . $parent['mother_last_name'] . " (Mother)</option>";
                                    }
                                    ?>
                                </optgroup>
                                <optgroup label="External">
                                    <?php
                                    $get_external_contacts = mysqli_query($connection_server, "SELECT * FROM sm_sms_phonebook WHERE school_id_number = '$school_id' AND is_parent = 0");
                                    while ($contact = mysqli_fetch_array($get_external_contacts)) {
                                        echo "<option value='" . $contact['phone_number'] . "'>" . $contact['name'] . "</option>";
                                    }
                                    ?>
                                </optgroup>
                            </select>
                            <span class="form-span mobile-font-size-12 system-font-size-14">Recipients*</span>
                        </div>
                        <div class="form-group mobile-width-90 system-width-93 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                            <textarea name="message" id="message" class="form-input" rows="5" required></textarea>
                            <span class="form-span mobile-font-size-12 system-font-size-14">Message*</span>
                        </div>
                        <button type="submit" name="send-sms" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-93 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">Send SMS</button>
                    </form>
                </div>
            </div>
        </div>
    </center>
</div>
