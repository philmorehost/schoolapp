<?php
// This file is for the SMS settings page for the super admin.
// It will have a form to configure the PhilmoreSMS API key, Flutterwave credentials, and bank details.
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

            <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <input name="price_per_sms" type="text" placeholder="Price per SMS" class="form-input" value="<?php echo $sms_settings['price_per_sms']; ?>" required/>
                <span class="form-span mobile-font-size-12 system-font-size-14">Price per SMS*</span>
            </div>

            <div class="form-group mobile-width-90 system-width-45 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-2 system-margin-left-2 mobile-margin-right-2 system-margin-right-2">
                <input name="payment_charges" type="text" placeholder="Payment Charges (%)" class="form-input" value="<?php echo $sms_settings['payment_charges']; ?>" required/>
                <span class="form-span mobile-font-size-12 system-font-size-14">Payment Charges (%)*</span>
            </div>

            <button type="submit" name="save-sms-settings" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-93 system-width-46 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2 mobile-margin-left-5 system-margin-left-3 mobile-margin-right-1 system-margin-right-1">
                Save Settings
            </button>
        </form>

        <div class="container-box bg-3 mobile-width-95 system-width-95 mobile-margin-top-2 system-margin-top-2 mobile-padding-top-2 system-padding-top-2 mobile-padding-bottom-2 system-padding-bottom-2">
            <div class="mobile-width-90 system-width-90">
                <h3 class="text-left">Cron Job Information</h3>
                <p class="text-left">To enable automated weekly reports, set up a cron job on your server to execute the following script once a week:</p>
                <pre style="background-color: #eee; padding: 10px; border-radius: 5px; text-align: left;"><code>/usr/bin/php <?php echo htmlspecialchars($_SERVER['DOCUMENT_ROOT']); ?>/cron_weekly_report.php</code></pre>
                <p class="text-left" style="font-size: 12px; color: #555;">Note: The exact path to PHP may vary on your server. Contact your hosting provider for assistance if needed.</p>
            </div>
        </div>
    </center>
</div>
