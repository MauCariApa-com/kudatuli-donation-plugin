<?php

// Register Custom Post Type for Donations
function kudatuli_register_donation_post_type() {
    $labels = array(
        'name'               => 'Donations',
        'singular_name'      => 'Donation',
        'menu_name'          => 'Donations',
        'name_admin_bar'     => 'Donation',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Donation',
        'new_item'           => 'New Donation',
        'edit_item'          => 'Edit Donation',
        'view_item'          => 'View Donation',
        'all_items'          => 'All Donations',
        'search_items'       => 'Search Donations',
        'not_found'          => 'No donations found.',
        'not_found_in_trash' => 'No donations found in Trash.', // Label for Trash
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'donation'),
        'capability_type'    => 'post', // Use default post capabilities
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_icon'          => 'dashicons-money-alt', // Add Dashicon for money
        'menu_position'      => 5,
        'supports'           => array('title', 'editor', 'custom-fields', 'revisions'), // Supports trash and revisions
    );

    register_post_type('donation', $args);
}
add_action('init', 'kudatuli_register_donation_post_type');