# Kudatuli Donation Plugin

**Version**: 1.0
**Author**: Kudatuli Project, MauCariApa.com

## Description

## Description

The **Kudatuli Donation Plugin** is a flexible and extensible WordPress donation plugin designed to accept donations through a variety of manual or automatic payment methods. It can integrate with **PayPal**, **Stripe**, **Bank transfers**, or any other payment gateway, making it highly adaptable to the specific needs of your organization.

The plugin provides users with a simple way to process donations, whether through manual verification or automated payments. It includes features for handling donations securely and efficiently, such as custom post types for donation records, shortcodes for embedding forms, email notifications, and PDF receipt generation. The plugin also incorporates **Google reCAPTCHA** to protect your forms from spam and bot submissions.

This plugin is highly extensible, allowing developers to enhance functionality with additional payment gateway integrations, API connections, or more complex custom features. Examples include adding multi-currency support, integrating with external CRM systems for donation tracking, or building more advanced reporting and analytics dashboards to suit specific project requirements.

With its combination of out-of-the-box functionality and potential for customization, the **Kudatuli Donation Plugin** provides a robust foundation for managing donations on any WordPress site.

## Features

### Donation Processing

The **Kudatuli Donation Plugin** allows you to accept and manage donations through a secure and efficient process.

- **Manual Verification**: When a donation is made, the administrator can manually verify the transaction details, ensuring that only confirmed donations are processed.
- **Secure Donation Processing**: This manual verification step enhances the security of the donation process, preventing unauthorized or incorrect transactions from being recorded.

### Custom Post Types

To organize and store donation information within the WordPress system, the plugin creates a custom post type called `donation`.

- **Donation Records**: Each donation is stored as a separate post within WordPress, making it easy for administrators to view and manage donation records.
- **Metadata Storage**: The plugin stores relevant donation data, such as donor names, email addresses, payment amounts, and transaction IDs, as post metadata.
- **Custom Taxonomies**: Allows categorization of donations by campaign or other custom taxonomies for better data organization.

### Admin Menu

The **Kudatuli Donation Plugin** adds an intuitive admin menu to the WordPress dashboard, offering a centralized location for donation management.

- **Donation Management**: Administrators can view, edit, and delete donation records directly from the admin panel.
- **Trash Count Display**: Shows the count of trashed donations, making it easier for admins to track and recover discarded donations.
- **Settings Configuration**: From this menu, admins can configure plugin settings, notification emails, and reCAPTCHA integration.

### Email Processing

The plugin includes built-in email processing features, ensuring that donors receive timely and professional communication.

- **Donor Confirmation Emails**: Sends an automated confirmation email to donors after their donation is successfully processed.
- **Customizable Email Templates**: Admins can customize the email templates, including the subject line and message content, to fit the tone and branding of their organization.
- **Admin Notifications**: Sends notification emails to administrators when a new donation is received, keeping them informed in real time.

### PDF Generation

The plugin provides PDF receipt generation, ensuring that donors receive formal documentation of their donation.

- **Automatic PDF Creation**: Upon successful donation, a PDF receipt is automatically generated and attached to the confirmation email.
- **Customizable Receipts**: Admins can customize the PDF template to include details such as the donor's name, donation amount, transaction ID, and organization branding.
- **Downloadable Receipts**: Donors can also download their receipt directly from their confirmation email, providing an easy way to keep a copy for tax purposes.

### Shortcodes

The **Kudatuli Donation Plugin** offers shortcodes for embedding donation forms directly into WordPress pages and posts.

- **Form Placement**: Simply add the `[kudatuli_donation_form]` shortcode to any page or post to display the donation form.
- **Customizable Forms**: The shortcode allows for easy customization, enabling admins to configure specific form fields, donation amounts, and reCAPTCHA settings.
- **Multiple Instances**: Shortcodes can be used multiple times on different pages, allowing for unique donation forms for different campaigns or causes.

### Google reCAPTCHA

To protect your donation forms from spam and bots, the plugin integrates **Google reCAPTCHA**.

- **Spam Prevention**: reCAPTCHA ensures that only real users can submit donations, preventing automated bots from filling out the form.
- **Easy Integration**: Simply enter your reCAPTCHA site key and secret key in the plugin’s settings to enable this protection.
- **Invisible reCAPTCHA**: Option to use invisible reCAPTCHA, which doesn’t interfere with the user experience but still offers strong protection.

---

These features ensure that the **Kudatuli Donation Plugin** provides a comprehensive and secure way to manage donations for your WordPress site while offering extensibility for further customizations.

## Extensibility

This plugin is extensible, allowing you to easily add more features to suit your project's needs. Some examples of additional features that could be added include:

- **Multiple Payment Gateways**: You can extend the plugin to support other payment gateways, such as **PayPal**, **Stripe**, **Authorize.net**, or **Square**, giving your users more flexibility in how they accept donations.
- **Recurring Donations**: Enable recurring donations by integrating APIs from **PayPal Subscriptions** or other payment processors like Stripe, allowing users to set up regular, automated contributions.
- **API Integration**: Integrate with third-party APIs like **CRM systems (e.g., Salesforce, HubSpot)** to sync donor data and donation records, or integrate with **email marketing platforms (e.g., Mailchimp)** to automatically add donors to email lists and trigger campaigns.
- **Advanced Reporting**: Create detailed reports for admins, including graphs and charts of donation data, filtered by date, donor demographics, or campaign. This could be achieved through integrations with analytics libraries or services like **Google Analytics**.
- **Multi-Currency Support**: Implement a feature that allows donations in different currencies based on the donor's location, with real-time currency conversion.
- **Social Media Sharing**: Automatically share successful donations on social media platforms (e.g., Twitter, Facebook) using APIs to encourage viral sharing and attract more donations.
- **Custom Donation Tiers**: Add a feature that allows admins to create predefined donation tiers with specific rewards or acknowledgments, encouraging larger donations.
- **CRM Export Functionality**: Allow admins to export donation and donor data to CSV, Excel, or directly to a CRM system for offline record keeping and donor management.

By building upon the existing structure, you can adapt the plugin for more sophisticated donation management systems or broader use cases.

## Installation

1. Download the plugin.
2. Upload the `kudatuli-donation-plugin` folder to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Configure your PayPal account and webhook settings from the plugin's settings page.

## Usage

Once the plugin is activated, you can add donation forms using the provided shortcodes and start accepting donations through PayPal. Donations will be tracked in the admin area, and users will receive confirmation emails with PDF receipts.

## Enqueued Resources

The plugin enqueues the following resources:

- **CSS**: `assets/css/style.css`
- **JavaScript**: `assets/js/script.js`
- **Google reCAPTCHA**: Enqueued via `https://www.google.com/recaptcha/api.js`

## Development

The plugin includes multiple functionality modules located in the `includes/` folder:

- `admin-menu.php`: Defines the admin interface for managing donations and plugin settings.
- `donation-processing.php`: Handles donation-related operations.
- `email-processing.php`: Manages email notifications for donors.
- `functions.php`: Contains helper functions used throughout the plugin.
- `meta-boxes.php`: Adds custom meta boxes for donation information in the WordPress admin.
- `pdf-generation.php`: Manages the creation of PDF receipts for donations.
- `post-type.php`: Registers the custom post type for donations.
- `shortcodes.php`: Defines shortcodes for embedding donation forms.

## Third-Party Components

### Acknowledgments

We would like to thank the developers of these third-party components for their contributions to the open-source community, which greatly enhance the functionality and security of the **Kudatuli Donation Plugin**.

The **Kudatuli Donation Plugin** utilizes several third-party components to enhance its functionality, particularly in generating PDF invoices. Below is a list of these components, along with their descriptions and licenses:

### 1. TCPDF

- **Description**: TCPDF is a PHP class for generating PDF documents. It allows for the creation of complex PDFs with text, images, tables, and more, making it ideal for generating invoices.
- **License**: GNU Lesser General Public License (LGPL)
- **Website**: [TCPDF](https://tcpdf.org/)

#### Usage of TCPDF in the Plugin

The **Kudatuli Donation Plugin** utilizes the TCPDF library to generate PDF invoices for donations. Below is an overview of how TCPDF is implemented in the plugin:

1. **Invoice Generation**: The `generate_invoice_pdf` function generates a PDF invoice for each donation, including details such as the donor's name, donation amount, currency, transaction ID, and donation date.

2. **Error Handling**: The plugin checks for the availability of the TCPDF library and logs errors if the library is not loaded or if issues arise during invoice creation.

3. **Dynamic Content**: The PDF includes dynamic content such as the donation details formatted in an HTML table, which enhances the presentation of the invoice.

4. **File Management**: The plugin ensures that invoices are saved in a unique filename format within the uploads directory, preventing overwrites.

5. **Logo Integration**: If a logo file exists, it is included in the PDF to brand the invoice, adding a professional touch to the generated document.

This integration of TCPDF enables the **Kudatuli Donation Plugin** to provide a valuable feature for donors, giving them a formal record of their contributions.

### 2. jQuery

- **Description**: A fast, small, and feature-rich JavaScript library that simplifies HTML document traversal and manipulation, event handling, and animation.
- **License**: MIT License
- **Website**: [jQuery](https://jquery.com)

### 3. Google reCAPTCHA

- **Description**: A service that protects your website from spam and abuse by verifying that the user is a human and not a bot.
- **License**: Proprietary (free for use)
- **Website**: [Google reCAPTCHA](https://www.google.com/recaptcha)

### 4. PHPMailer

- **Description**: A popular library for sending emails securely using PHP. It offers various features such as SMTP authentication, HTML email support, and attachment handling.
- **License**: LGPL
- **Website**: [PHPMailer](https://github.com/PHPMailer/PHPMailer)

## License

The **Kudatuli Donation Plugin** is licensed under the [GNU General Public License v2.0](https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html). This license allows you to use, modify, and distribute the plugin for both personal and commercial purposes.

### Summary of the License Terms:

- **Commercial Use**: You are free to use the plugin in commercial projects.
- **Modification**: You can modify the plugin to suit your needs.
- **Distribution**: You may distribute the original plugin or your modified version.
- **Attribution Encouraged**: While not legally required, we encourage you to credit the original author when using or distributing the plugin.

For more details, please refer to the full text of the license [here](https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html).
