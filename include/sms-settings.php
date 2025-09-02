<?php
// This file is for the SMS settings page for the super admin.
// It will have a form to configure the PhilmoreSMS API key, Flutterwave credentials, and bank details.
session_start();
?>
<?php
if (isset($_SESSION['feedback_message'])) {
    echo '<div class="feedback-message">' . htmlspecialchars($_SESSION['feedback_message']) . '</div>';
    unset($_SESSION['feedback_message']);
}
?>
<div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
    <center>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <input name="sms-api-key" type="text" placeholder="PhilmoreSMS API Key" class="form-input" value="<?php echo $sms_settings['sms_api_key']; ?>" required/>
                <span class="form-span mobile-font-size-12 system-font-size-14">PhilmoreSMS API Key*</span>
            </div>

            <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <input name="flutterwave-public-key" type="text" placeholder="Flutterwave Public Key" class="form-input" value="<?php echo $sms_settings['flutterwave_public_key']; ?>" required/>
                <span class="form-span mobile-font-size-12 system-font-size-14">Flutterwave Public Key*</span>
            </div>

            <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <input name="flutterwave-secret-key" type="text" placeholder="Flutterwave Secret Key" class="form-input" value="<?php echo $sms_settings['flutterwave_secret_key']; ?>" required/>
                <span class="form-span mobile-font-size-12 system-font-size-14">Flutterwave Secret Key*</span>
            </div>

            <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <input name="flutterwave-encryption-key" type="text" placeholder="Flutterwave Encryption Key" class="form-input" value="<?php echo $sms_settings['flutterwave_encryption_key']; ?>" required/>
                <span class="form-span mobile-font-size-12 system-font-size-14">Flutterwave Encryption Key*</span>
            </div>

            <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <input name="bank-name" type="text" placeholder="Bank Name" class="form-input" value="<?php echo $sms_settings['bank_name']; ?>" required/>
                <span class="form-span mobile-font-size-12 system-font-size-14">Bank Name*</span>
            </div>

            <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <input name="account-number" type="text" placeholder="Account Number" class="form-input" value="<?php echo $sms_settings['account_number']; ?>" required/>
                <span class="form-span mobile-font-size-12 system-font-size-14">Account Number*</span>
            </div>

            <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <input name="account-name" type="text" placeholder="Account Name" class="form-input" value="<?php echo $sms_settings['account_name']; ?>" required/>
                <span class="form-span mobile-font-size-12 system-font-size-14">Account Name*</span>
            </div>

            <button type="submit" name="save-sms-settings" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
                Save Settings
            </button>
        </form>
    </center>
</div>
