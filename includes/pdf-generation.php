<?php

// Function to generate the PDF invoice
function generate_invoice_pdf($invoice_id, $donor_name, $donation_amount, $donation_currency, $transaction_id, $donation_date) {
    // Include the TCPDF library
    if (!class_exists('TCPDF')) {
        require_once(ABSPATH . 'wp-content/plugins/kudatuli-donation-plugin/vendor/tecnickcom/tcpdf/tcpdf.php');
    }

    // Check if TCPDF is available
    if (!class_exists('TCPDF')) {
        error_log('TCPDF library is not loaded.');
        return false;
    }

    // Validate and format the donation date
    if (empty($donation_date)) {
        $donation_date = date('F d, Y g:i A'); // Default to current date and time if not provided
    } else {
        $donation_date = date('F d, Y g:i A', strtotime($donation_date));
    }

    // Create a new PDF document
    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Kudatuli');
    $pdf->SetTitle('Donation Invoice for ' . $transaction_id);
    $pdf->SetSubject('Donation Invoice for ' . $transaction_id);
    $pdf->AddPage();

    // Add logo
    $logo_path = ABSPATH . 'wp-content/plugins/kudatuli-donation-plugin/assets/images/logo.png';
    if (file_exists($logo_path)) {
        $pdf->Image($logo_path, 10, 12, 25, 25);
    } else {
        error_log('Logo image not found: ' . $logo_path);
    }

    // Set font and add header text next to the logo
    $pdf->SetFont('helvetica', 'B', 20);
    $pdf->SetXY(40, 15);
    $pdf->Cell(0, 10, 'Kudatuli Project', 0, 1, 'L');
    $pdf->SetFont('helvetica', '', 12);
    $pdf->SetXY(40, 25);
    $pdf->Cell(0, 10, 'Invoice ID: ' . esc_html($invoice_id), 0, 1, 'L');
    $pdf->Line(10, 40, 200, 40);
    $pdf->Ln(18);
    $pdf->Cell(0, 1, 'Date of Donation: ' . esc_html($donation_date), 0, 1, 'R');
    $pdf->Ln(20);

    // Set the HTML content for the PDF body (invoice details)
    $html = <<<EOD
        <h1>Donation Invoice</h1>
        <p>Thank you for your donation, <strong>{$donor_name}</strong>!</p>
        <p>Here are your donation details:</p>
        <table border="1" cellpadding="5">
        <tr>
            <th>Transaction ID</th>
            <th>Amount</th>
            <th>Currency</th>
        </tr>
        <tr>
            <td>{$transaction_id}</td>
            <td>{$donation_amount}</td>
            <td>{$donation_currency}</td>
        </tr>
        </table>
        <p>If you have any questions, please feel free to contact us.</p>
        <p>Thank you for your support!</p>
        <br />
        <p>Warmest regards,<br>The Kudatuli Team</p>
    EOD;

    // Output the HTML content to the PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Define the upload directory for the invoice
    $upload_dir = wp_upload_dir();
    $invoice_dir = trailingslashit($upload_dir['basedir']) . 'invoice'; // Path to the invoice directory

    // Ensure the invoice directory exists
    if (!file_exists($invoice_dir)) {
        if (!mkdir($invoice_dir, 0755, true)) {
            error_log('Failed to create invoice directory: ' . $invoice_dir);
            return false; // Early exit on failure
        }
    }

    // Check if transaction ID is empty
    if (empty($transaction_id)) {
        error_log('Transaction ID is empty.');
        return false; // Early exit if transaction ID is empty
    }

    // Log original transaction ID
    error_log('Original Transaction ID: ' . $transaction_id); // Log original transaction ID
    $transaction_id = trim($transaction_id); // Trim any whitespace
    $file_name = $transaction_id . '.pdf'; // Temporarily set the filename to the transaction ID
    error_log('Sanitized file name: ' . $file_name); // Log sanitized filename for debugging

    // Ensure that the filename is unique
    $file_path = trailingslashit($invoice_dir) . $file_name;
    $counter = 1;

    // If file exists, append a counter to the filename to make it unique
    while (file_exists($file_path)) {
        $file_name = sanitize_file_name($transaction_id) . '-' . $counter . '.pdf'; // Append counter
        $file_path = trailingslashit($invoice_dir) . $file_name;
        $counter++;
    }

    // Output the PDF as a file
    $pdf->Output($file_path, 'F'); // Save the PDF file to the server

    // Check if the file exists after saving
    if (file_exists($file_path)) {
        return $file_path; // Return the path to the generated PDF file
    } else {
        error_log('Failed to save the PDF file at: ' . $file_path);
        return false;
    }
}