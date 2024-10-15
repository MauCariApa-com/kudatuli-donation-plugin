<?php

// Handle form submission
function kudatuli_handle_donation() {
    if ( isset($_POST['submit_donation']) ) {
        // Verify nonce for security
        if (!isset($_POST['kudatuli_nonce']) || !wp_verify_nonce($_POST['kudatuli_nonce'], 'kudatuli_donation')) {
            wp_die(__('Nonce verification failed!', 'kudatuli'));
        }

        // Sanitize and validate inputs
        $paypal_email = sanitize_email($_POST['paypal_email']);
        $donor_name = sanitize_text_field($_POST['donor_name']);
        $user_email = sanitize_email($_POST['user_email']);
        $amount = floatval($_POST['amount']);
        $currency = sanitize_text_field($_POST['currency']);
        
        // Check if the donation amount is valid
        if ($amount <= 0) {
            wp_die(__('Invalid donation amount!', 'kudatuli'));
        }

        // Generate random transaction ID
        $transaction_id = 'KP-' . strtoupper(wp_generate_password(10, false, false));

        // Process the donation (saving as draft)
        $donation_data = array(
            'post_title'   => 'Donation from ' . $user_email,
            'post_content' => 'Donation of ' . $currency . ' ' . number_format($amount, 2) . ' with transaction ID: ' . $transaction_id,
            'post_name'    => strtoupper($transaction_id), // Set the slug as the uppercase transaction ID
            'post_status'  => 'draft', // Set status to draft
            'post_type'    => 'donation',
        );
        
        // Insert post and check for errors
        $donation_id = wp_insert_post($donation_data);
        if (is_wp_error($donation_id)) {
            wp_die(__('Error creating donation record!', 'kudatuli'));
        }

        // Add metadata for the donation
        update_post_meta($donation_id, '_donation_donor_name', $donor_name);
        update_post_meta($donation_id, '_donation_user_email', $user_email);
        update_post_meta($donation_id, '_donation_amount', $amount);
        update_post_meta($donation_id, '_donation_currency', $currency);
        update_post_meta($donation_id, '_donation_transaction_id', $transaction_id);

        // Prepare email content
        $email_subject = 'Thank You for Your Donation - Complete Your Payment';
        $email_message = sprintf(
            "Hi, %s.\n\nThank you for initiating a donation to the Kudatuli Project! Here are the details of your donation:\n\n- Transaction ID: %s\n- Donor Name: %s\n- Your PayPal Email: %s\n- Amount: $%s\n\nPlease follow these instructions to complete your donation through PayPal:\n\n1. Log in to your PayPal account.\n2. Tap on 'Send & Request'.\n3. In the 'Send' section, enter the PayPal receiver's email: %s.\n4. Enter the donation amount: $%s.\n5. In the 'Add a note' section, enter your Transaction ID: %s.\n6. Complete the payment process.\n\nOnce you complete the payment, we will verify your donation and send you a confirmation email.\n\nThank you for supporting the Kudatuli Project!\n\nBest regards,\nThe Kudatuli Project Team",
            esc_html($donor_name),
            esc_html($transaction_id),
            esc_html($donor_name),
            esc_html($user_email),
            esc_html(number_format($amount, 2)),
            esc_html($paypal_email),
            esc_html(number_format($amount, 2)),
            esc_html($transaction_id)
        );

        // Send the email
        wp_mail($user_email, $email_subject, $email_message);

        // Redirect to confirmation page
        $redirect_url = add_query_arg(array(
            'amount'         => $amount,
            'currency'       => $currency,
            'paypal_email'   => $paypal_email,
            'user_email'     => $user_email,
            'transaction_id' => $transaction_id
        ), get_permalink(get_page_by_path('donation-confirmation'))); // Adjust the page slug if necessary
        
        wp_redirect($redirect_url);
        exit;
    }
}
add_action('wp', 'kudatuli_handle_donation');