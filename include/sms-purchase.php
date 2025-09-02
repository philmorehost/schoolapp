<?php
// This file is for the SMS credit purchase page for school admins.
?>
<div class="container-box bg-2 mobile-width-100 system-width-100 mobile-margin-top-1 system-margin-top-1">
    <center>
        <div class="mobile-width-95 system-width-95 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2">
            <div class="container-box bg-3 mobile-width-100 system-width-48 mobile-margin-right-1 system-margin-right-1 mobile-padding-top-2 system-padding-top-2 mobile-padding-bottom-2 system-padding-bottom-2">
                <div class="mobile-width-90 system-width-90">
                    <h3 class="text-left">Pay with Flutterwave</h3>
                    <form method="post">
                        <div class="form-group mobile-width-100 system-width-100 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2">
                            <input name="amount" type="number" placeholder="Amount" class="form-input" required/>
                            <span class="form-span mobile-font-size-12 system-font-size-14">Amount*</span>
                        </div>
                        <button type="submit" name="pay-with-flutterwave" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-100 system-width-100">
                            Pay Now
                        </button>
                    </form>
                </div>
            </div>

            <div class="container-box bg-3 mobile-width-100 system-width-48 mobile-margin-left-1 system-margin-left-1 mobile-padding-top-2 system-padding-top-2 mobile-padding-bottom-2 system-padding-bottom-2">
                <div class="mobile-width-90 system-width-90">
                    <h3 class="text-left">Pay with Bank Transfer</h3>
                    <p class="text-left">
                        <strong>Bank Name:</strong> <?php echo $sms_settings['bank_name']; ?><br>
                        <strong>Account Number:</strong> <?php echo $sms_settings['account_number']; ?><br>
                        <strong>Account Name:</strong> <?php echo $sms_settings['account_name']; ?>
                    </p>
                    <hr>
                    <form method="post">
                        <div class="form-group mobile-width-100 system-width-100 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2">
                            <input name="amount" type="number" placeholder="Amount" class="form-input" required/>
                            <span class="form-span mobile-font-size-12 system-font-size-14">Amount*</span>
                        </div>
                        <div class="form-group mobile-width-100 system-width-100 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2">
                            <input name="reference" type="text" placeholder="Payment Reference" class="form-input" required/>
                            <span class="form-span mobile-font-size-12 system-font-size-14">Payment Reference*</span>
                        </div>
                        <button type="submit" name="submit-bank-transfer" class="button-box color-2 bg-4 onhover-bg-color-7 mobile-font-size-14 system-font-size-16 mobile-width-100 system-width-100">
                            Submit Notification
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </center>
</div>
