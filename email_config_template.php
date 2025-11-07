<?php
/**
 * Email Configuration Template
 * 
 * INSTRUCTIONS:
 * 1. Rename this file to: email_config.php
 * 2. Fill in your actual email credentials below
 * 3. Never commit email_config.php to version control
 * 4. Add email_config.php to your .gitignore file
 */

// SMTP Server Configuration (Hostinger)
define('SMTP_HOST', 'smtp.hostinger.com');  // Hostinger SMTP server
define('SMTP_PORT', 587);                    // Port for TLS (or use 465 for SSL)
define('SMTP_USERNAME', 'your-email@yourdomain.com');  // Your email address
define('SMTP_PASSWORD', 'YOUR_APP_PASSWORD_HERE');      // Your app password (not regular password)

// Sender Information
define('SMTP_FROM_EMAIL', 'noreply@yourdomain.com');  // Sender email (can be same as SMTP_USERNAME)
define('SMTP_FROM_NAME', 'DeliaNexus');               // Sender name

// Admin Email (Where contact form messages will be sent)
define('ADMIN_EMAIL', 'admin@yourdomain.com');  // Your admin email to receive contact form submissions

/**
 * IMPORTANT NOTES FOR HOSTINGER:
 * 
 * 1. Use your full email address as SMTP_USERNAME (e.g., info@yourdomain.com)
 * 2. Use an App Password, not your regular email password:
 *    - Log in to Hostinger webmail
 *    - Go to Settings > Security > App Passwords
 *    - Generate a new app password
 *    - Use that password here
 * 
 * 3. Make sure your domain's email is properly set up in Hostinger
 * 4. SMTP_HOST should be: smtp.hostinger.com
 * 5. Use port 587 with TLS or port 465 with SSL
 * 
 * 6. For testing purposes, you can use the same email for all:
 *    - SMTP_USERNAME, SMTP_FROM_EMAIL, and ADMIN_EMAIL can all be the same
 * 
 * EXAMPLE CONFIGURATION:
 * define('SMTP_HOST', 'smtp.hostinger.com');
 * define('SMTP_PORT', 587);
 * define('SMTP_USERNAME', 'contact@delianexus.com');
 * define('SMTP_PASSWORD', 'abcd1234efgh5678');  // App password from Hostinger
 * define('SMTP_FROM_EMAIL', 'noreply@delianexus.com');
 * define('SMTP_FROM_NAME', 'DeliaNexus');
 * define('ADMIN_EMAIL', 'admin@delianexus.com');
 */
?>
