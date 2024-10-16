<?php

// Function to create the donation form
function kudatuli_donation_form() {
    ob_start(); ?>
    <form id="donation-form" method="post" action="<?php echo esc_url(home_url('/donation-confirmation')); ?>">
        <label for="paypal_email">PayPal Email Receiver:</label>
        <input type="text" name="paypal_email" id="paypal_email" value="email@example.com" readonly style="background-color: transparent; border: 1px solid #ccc; color: #333;" />

        <label for="donor_name">Your Name:</label>
        <input type="text" name="donor_name" id="donor_name" value="<?php echo isset($_POST['donor_name']) ? esc_attr($_POST['donor_name']) : ''; ?>" required>

        <label for="user_email">Your Email:</label>
        <input type="email" name="user_email" id="user_email" required />

        <!-- Add the currency selector here -->
        <label for="currency">Currency:</label>
        <select name="currency" id="currency" required>
            <option value="USD">USD</option>
            <option value="EUR">EURO</option>
            <option value="GBP">GBP</option>
        </select>

        <label for="amount">Amount:</label>
        <select name="amount" id="amount" required>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
            <option value="40">40</option>
            <option value="50">50</option>
            <option value="custom">Custom Amount</option>
        </select>

        <div id="custom-amount-container" style="display: none;">
            <label for="custom_amount">Custom Amount:</label>
            <input type="number" name="custom_amount" id="custom_amount" />
        </div>

        <!-- Note about accepted currencies -->
        <p style="font-size: 12px; color: #555;">We only accept USD, EURO, and GBP.</p> <!-- Adjust style as needed -->

        <!-- Spacer before reCAPTCHA -->
        <div style="height: 20px;"></div> <!-- Adjust the height as needed -->

        <!-- Add reCAPTCHA here -->
        <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY"></div> <!-- Replace with your site key -->

        <input type="hidden" name="kudatuli_nonce" value="<?php echo wp_create_nonce('kudatuli_donation'); ?>">

        <input type="submit" name="submit_donation" value="Donate" style="margin-top: 20px; padding: 10px 15px; background-color: #0070ba; color: white; border: none; border-radius: 4px; cursor: pointer;" />
    </form>
    
    <script>
        // Show custom amount field if 'Custom Amount' is selected
        document.getElementById('amount').addEventListener('change', function() {
            var customAmountContainer = document.getElementById('custom-amount-container');
            if (this.value === 'custom') {
                customAmountContainer.style.display = 'block';
            } else {
                customAmountContainer.style.display = 'none';
            }
        });

        // Check if the form should be reset
        window.onload = function() {
            // Reset the donation form
            var donationForm = document.getElementById('donation-form');
            if (donationForm) {
                donationForm.reset();
            }
        };

        // Clear the form when navigating away
        window.addEventListener('beforeunload', function() {
            var donationForm = document.getElementById('donation-form');
            if (donationForm) {
                donationForm.reset();
            }
        });
    </script>

    <?php
    return ob_get_clean();
}

// Function to display donation confirmation with instructions
function kudatuli_donation_confirmation() {
    // Check if data is available via GET parameters
    if (isset($_GET['amount']) && isset($_GET['currency']) && isset($_GET['paypal_email']) && isset($_GET['user_email']) && isset($_GET['transaction_id'])) {
        $paypal_email = sanitize_email($_GET['paypal_email']);
        $user_email = sanitize_email($_GET['user_email']);
        $amount = floatval($_GET['amount']);
        $currency = sanitize_text_field($_GET['currency']); // Capture the currency
        $transaction_id = sanitize_text_field($_GET['transaction_id']);
        $donor_name = isset($_GET['donor_name']) ? sanitize_text_field($_GET['donor_name']) : 'Anonymous';

        // Display confirmation message with donation details and instructions
        ob_start(); ?>
        <h2>Thank You for Your Donation!</h2>
        <p>Your donation has been recorded, but you need to manually complete the transaction through PayPal. Please follow the instructions below:</p>
        
        <h3>Donation Details</h3>
        <ul>
            <li>Transaction ID: <strong><?php echo esc_html($transaction_id); ?></strong></li>
            <li>PayPal Receiver: <strong><?php echo esc_html($paypal_email); ?></strong></li>
            <li>Donor Name: 
            <?php 
            // Check if donor name is "Anonymous" and append privacy message
                if (!empty($donor_name)) {
                        echo esc_html($donor_name) . ($donor_name === 'Anonymous' ? ' (for privacy purposes)' : '');
                    } 
                ?>
            </li>
            <li>Your Email: <strong><?php echo esc_html($user_email); ?></strong> </li>
            <li>Amount: <strong><?php echo esc_html($currency . ' ' . number_format($amount, 2)); ?></strong></li>
        </ul>
        <p>Thank you for your donation! If you don't see a confirmation email in your inbox, please check your spam or junk folder.</p>

        <h3>Payment Instruction</h3>
        <ol>
            <li>Log in to your PayPal account using the email address associated with your PayPal account.</li>
            <li>Tap on <strong>"Send & Request"</strong>.</li>
            <li>In the <strong>"Send"</strong> section, enter the PayPal receiver's email: <strong><span style="color: #0070ba;"><?php echo esc_html($paypal_email); ?></strong></span>.</li>
            <li>Enter the amount: <strong><?php echo esc_html($currency . ' ' . number_format($amount, 2)); ?></strong> as displayed above.</li>
            <li>In the <strong>"Add a note"</strong> section, enter your Transaction ID: <strong><?php echo esc_html($transaction_id); ?></strong>. This will help us verify your donation faster.</li>
            <li>Complete the payment process.</li>
        </ol>
        <p>Once you have completed the PayPal transaction, we will verify your donation and notify you via email at <?php echo esc_html($user_email); ?>.</p>

        <?php
        return ob_get_clean();
    } else {
        return '<p>Invalid donation data. Please check your donation details or contact support.</p>';
    }
}
add_shortcode('kudatuli_donation_confirmation', 'kudatuli_donation_confirmation');