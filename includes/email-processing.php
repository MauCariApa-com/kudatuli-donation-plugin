<?php

// Action to send confirmation email on post publish
add_action('transition_post_status', 'kudatuli_send_confirmation_email_on_publish', 10, 3);

// Function to send confirmation email on publish
function kudatuli_send_confirmation_email_on_publish($new_status, $old_status, $post) {
    // Only trigger if the post type is 'donation'
    if ($post->post_type === 'donation' && $old_status === 'draft' && $new_status === 'publish') {
        // Get donor details from post meta
        $donor_name = get_post_meta($post->ID, '_donation_donor_name', true);
        $donor_name = empty($donor_name) ? 'Anonymous' : $donor_name;

        $user_email = sanitize_email(get_post_meta($post->ID, '_donation_user_email', true));
        if (!is_email($user_email)) {
            error_log('Invalid email for post ID: ' . $post->ID);
            return; // Exit if email is invalid
        }

        $donation_amount = floatval(get_post_meta($post->ID, '_donation_amount', true));
        $donation_currency = sanitize_text_field(get_post_meta($post->ID, '_donation_currency', true));
        $transaction_id = sanitize_text_field(get_post_meta($post->ID, '_donation_transaction_id', true));
        $donation_date = get_post_meta($post->ID, '_donation_date', true); // Uncommented to use donation date

        // Prepare the confirmation email
        $subject = 'Your Donation Has Been Confirmed!';
        $message = "<p>Dear " . esc_html($donor_name) . ",</p>"
            . "<p>Thank you for your generous donation! We are thrilled to have your support.</p>"
            . "<p>Here are the details of your donation:</p>"
            . "<ul>"
            . "<li>Transaction ID: " . esc_html($transaction_id) . "</li>"
            . "<li>Donor Name: " . esc_html($donor_name) . "</li>"
            . "<li>Your PayPal Email: " . esc_html($user_email) . "</li>"
            . "<li>Amount: " . esc_html($donation_currency) . " " . number_format($donation_amount, 2) . "</li>"
            . "<li>Date: Included in your Invoice</li>" // Change this line if you add the donation date
            . "</ul>"
            . "<p>If you have any questions or need further information, please do not hesitate to contact us.</p>"
            . "<p>Warmest regards,<br>The Kudatuli Team</p>"
            . "<p>P.S. Every donation helps us achieve our mission, and we couldn’t do it without you!</p>";

        // Generate the PDF invoice
        $pdf_file = generate_invoice_pdf($post->ID, $donor_name, $donation_amount, $donation_currency, $transaction_id, $donation_date);

        if ($pdf_file !== false) {
            // Save the PDF path to post meta for future reference
            update_post_meta($post->ID, '_donation_invoice_pdf', $pdf_file);

            // Email headers
            $headers = array('Content-Type: text/html; charset=UTF-8');
            
            // Add PDF attachment
            $attachments = array($pdf_file);

            // Send the email with PDF attachment
            if (wp_mail($user_email, $subject, $message, $headers, $attachments)) {
                error_log('Email successfully sent to: ' . $user_email);
            } else {
                error_log('Failed to send email to: ' . $user_email);
            }
        } else {
            error_log('PDF generation failed for post ID: ' . $post->ID);
        }
    }
}

// Example donation processing function
function process_donation() {
    if (isset($_POST['submit_donation'])) {
        // Validate form data (sanitize inputs, etc.)
        $donor_name = sanitize_text_field($_POST['donor_name']);
        $user_email = sanitize_email($_POST['donor_email']);
        $donation_amount = floatval($_POST['donation_amount']);
        
        // Create a new donation post
        $donation_id = wp_insert_post(array(
            'post_title' => $donor_name,
            'post_content' => '',
            'post_status' => 'draft', // Or 'publish' if appropriate
            'post_type' => 'donation',
        ));

        // Generate the Invoice ID without outputting it
        $invoice_id = generate_invoice_id(); // Call the function to get the ID

        // Save the Invoice ID to post meta
        update_post_meta($donation_id, '_donation_invoice_id', $invoice_id);

        // Save other donation details to post meta as needed
        update_post_meta($donation_id, '_donation_user_email', $user_email);
        update_post_meta($donation_id, '_donation_amount', $donation_amount);
    }
}