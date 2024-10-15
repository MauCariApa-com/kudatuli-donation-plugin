<?php

// Add Meta Boxes for Donations
function kudatuli_add_donation_meta_boxes() {
    add_meta_box('donation_details', 'Donation Details', 'kudatuli_donation_meta_box_callback', 'donation', 'normal', 'high');
}
add_action('add_meta_boxes', 'kudatuli_add_donation_meta_boxes');

function kudatuli_donation_meta_box_callback($post) {
    // Retrieve existing values from the database
    $amount = get_post_meta($post->ID, '_donation_amount', true);
    $user_email = get_post_meta($post->ID, '_donation_user_email', true);
    $donor_name = get_post_meta($post->ID, '_donation_donor_name', true); // Get donor name

    // Display the form fields
    echo '<label for="donation_donor_name">Donor Name:</label>'; // New label for donor name
    echo '<input type="text" name="donation_donor_name" value="' . esc_attr($donor_name) . '" required />'; // New input for donor name
    
    echo '<label for="donation_user_email">User Email:</label>';
    echo '<input type="email" name="donation_user_email" value="' . esc_attr($user_email) . '" required />';

    echo '<label for="donation_amount">Amount:</label>';
    echo '<input type="number" name="donation_amount" value="' . esc_attr($amount) . '" required />';
}