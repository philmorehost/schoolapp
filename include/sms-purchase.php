<?php
// This file is for the SMS credit purchase page for school admins.
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
            <div class="container-box bg-3 mobile-width-100 system-width-100 mobile-padding-top-2 system-padding-top-2 mobile-padding-bottom-2 system-padding-bottom-2 mobile-margin-bottom-2 system-margin-bottom-2">
                <div class="mobile-width-90 system-width-90">
                    <h3 class="text-left">Pricing Information</h3>
                    <p class="text-left">
                        <strong>Price per SMS:</strong> <?php echo htmlspecialchars($sms_settings['price_per_sms']); ?> NGN<br>
                        <strong>Payment Gateway Charges:</strong> <?php echo htmlspecialchars($sms_settings['payment_charges']); ?>%
                    </p>
                </div>
            </div>

            <div class="container-box bg-3 mobile-width-100 system-width-48 mobile-margin-right-1 system-margin-right-1 mobile-padding-top-2 system-padding-top-2 mobile-padding-bottom-2 system-padding-bottom-2">
                <div class="mobile-width-90 system-width-90">
                    <h3 class="text-left">Pay with Flutterwave</h3>
                    <form method="post">
                        <div class="form-group mobile-width-100 system-width-100 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2">
                            <input name="amount" type="number" placeholder="Amount (NGN)" class="form-input" id="flutterwave-amount" required/>
                            <span class="form-span mobile-font-size-12 system-font-size-14">Amount (NGN)*</span>
                        </div>
                        <div class="mobile-width-100 system-width-100 mobile-margin-bottom-2 system-margin-bottom-2">
                            <p class="text-left">You will get: <strong id="flutterwave-sms-count">0</strong> SMS credits.</p>
                            <p class="text-left">Total Charge: <strong id="flutterwave-total-charge">0.00</strong> NGN</p>
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
                        <strong>Bank Name:</strong> <?php echo htmlspecialchars($sms_settings['bank_name']); ?><br>
                        <strong>Account Number:</strong> <?php echo htmlspecialchars($sms_settings['account_number']); ?><br>
                        <strong>Account Name:</strong> <?php echo htmlspecialchars($sms_settings['account_name']); ?>
                    </p>
                    <hr>
                    <form method="post">
                        <div class="form-group mobile-width-100 system-width-100 mobile-margin-top-2 system-margin-top-2 mobile-margin-bottom-2 system-margin-bottom-2">
                            <input name="amount" type="number" placeholder="Amount (NGN)" class="form-input" id="bank-amount" required/>
                            <span class="form-span mobile-font-size-12 system-font-size-14">Amount (NGN)*</span>
                        </div>
                        <div class="mobile-width-100 system-width-100 mobile-margin-bottom-2 system-margin-bottom-2">
                            <p class="text-left">You will get: <strong id="bank-sms-count">0</strong> SMS credits.</p>
                            <p class="text-left">Total to Transfer: <strong id="bank-total-charge">0.00</strong> NGN</p>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pricePerSms = parseFloat(<?php echo json_encode($sms_settings['price_per_sms']); ?>) || 0;
    const chargePercentage = parseFloat(<?php echo json_encode($sms_settings['payment_charges']); ?>) || 0;

    const fwAmountInput = document.getElementById('flutterwave-amount');
    const fwSmsCount = document.getElementById('flutterwave-sms-count');
    const fwTotalCharge = document.getElementById('flutterwave-total-charge');

    const bankAmountInput = document.getElementById('bank-amount');
    const bankSmsCount = document.getElementById('bank-sms-count');

    function calculateFwSms(amount) {
        if (isNaN(amount) || amount <= 0 || pricePerSms <= 0) {
            return { smsCount: 0, totalCharge: 0 };
        }
        const smsCount = Math.floor(amount / pricePerSms);
        const chargeAmount = (amount * chargePercentage) / 100;
        const totalCharge = amount + chargeAmount;
        return { smsCount, totalCharge };
    }

    function calculateFwSms(amount) {
        if (isNaN(amount) || amount <= 0 || pricePerSms <= 0) {
            return { smsCount: 0, totalCharge: 0 };
        }
        const smsCount = Math.floor(amount / pricePerSms);
        const chargeAmount = (amount * chargePercentage) / 100;
        const totalCharge = amount + chargeAmount;
        return { smsCount, totalCharge };
    }

    function calculateFwSms(amount) {
        if (isNaN(amount) || amount <= 0 || pricePerSms <= 0) {
            return { smsCount: 0, totalCharge: 0 };
        }
        const smsCount = Math.floor(amount / pricePerSms);
        const chargeAmount = (amount * chargePercentage) / 100;
        const totalCharge = amount + chargeAmount;
        return { smsCount, totalCharge };
    }

    function calculateBankSms(amount) {
        // This logic is now identical to Flutterwave's display logic
        if (isNaN(amount) || amount <= 0 || pricePerSms <= 0) {
            return { smsCount: 0, totalCharge: 0 };
        }
        const smsCount = Math.floor(amount / pricePerSms);
        const chargeAmount = (amount * chargePercentage) / 100;
        const totalCharge = amount + chargeAmount;
        return { smsCount, totalCharge };
    }

    fwAmountInput.addEventListener('input', function() {
        const amount = parseFloat(fwAmountInput.value);
        const { smsCount, totalCharge } = calculateFwSms(amount);

        fwSmsCount.textContent = smsCount.toLocaleString();
        fwTotalCharge.textContent = totalCharge.toFixed(2).toLocaleString();
    });

    bankAmountInput.addEventListener('input', function() {
        const amount = parseFloat(bankAmountInput.value);
        const { smsCount, totalCharge } = calculateBankSms(amount);

        bankSmsCount.textContent = smsCount.toLocaleString();
        document.getElementById('bank-total-charge').textContent = totalCharge.toFixed(2).toLocaleString();
    });
});
</script>
