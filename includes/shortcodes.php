<?php

// Shortcode to display the donation form
function kudatuli_donation_shortcode() {
    return kudatuli_donation_form();
}
add_shortcode('kudatuli_donation_form', 'kudatuli_donation_shortcode');