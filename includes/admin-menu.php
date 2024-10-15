<?php

// Add trash count next to Donations in admin menu
function kudatuli_custom_menu_count() {
    $num_posts = wp_count_posts('donation');
    $count = 0;
    if ($num_posts) {
        $count = $num_posts->trash; // Get trash count
    }

    if ($count > 0) {
        global $menu;
        foreach ($menu as $key => $value) {
            if ($value[2] == 'edit.php?post_type=donation') {
                $menu[$key][0] .= ' <span class="awaiting-mod update-plugins count-' . esc_attr($count) . '"><span class="pending-count">' . number_format_i18n($count) . '</span></span>';
                break;
            }
        }
    }
}
add_action('admin_menu', 'kudatuli_custom_menu_count');

// Remove notification count for donations in trash
function kudatuli_remove_donation_notification_count($count, $post_type) {
    if ($post_type === 'donation') {
        // Get the count of trashed donations
        $trashed_donations = wp_count_posts('donation')->trash;
        // Set count to zero if there are trashed donations
        return max(0, $count - $trashed_donations);
    }
    return $count;
}
add_filter('get_post_type_labels', 'kudatuli_remove_donation_notification_count', 10, 2);


// Save Donation Meta Box Data
function kudatuli_save_donation_meta($post_id) {
    // Save the donation details
    if (isset($_POST['donor_name'])) { // Add donor name
        update_post_meta($post_id, '_donation_donor_name', sanitize_text_field($_POST['donor_name']));
    }
    if (isset($_POST['donation_user_email'])) {
        update_post_meta($post_id, '_donation_user_email', sanitize_email($_POST['donation_user_email']));
    }
    if (isset($_POST['donation_amount'])) {
        update_post_meta($post_id, '_donation_amount', sanitize_text_field($_POST['donation_amount']));
    }
    if (isset($_POST['donation_unique_code'])) {
        update_post_meta($post_id, '_donation_unique_code', sanitize_text_field($_POST['donation_unique_code']));
    }
}
add_action('save_post', 'kudatuli_save_donation_meta');