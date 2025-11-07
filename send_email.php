<?php
/**
 * DeliaNexus Contact Form Email Handler
 * Uses PHPMailer to send emails to admin and confirmation to user
 */

// Prevent direct access
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Make sure PHPMailer is installed via Composer

// Load email configuration
if (!file_exists('email_config.php')) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Email configuration not found. Please contact the administrator.']);
    exit;
}
require 'email_config.php';

// Sanitize and validate form data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Get and validate form data
$name = isset($_POST['name']) ? sanitize_input($_POST['name']) : '';
$email = isset($_POST['email']) ? sanitize_input($_POST['email']) : '';
$phone = isset($_POST['phone']) ? sanitize_input($_POST['phone']) : '';
$subject = isset($_POST['subject']) ? sanitize_input($_POST['subject']) : '';
$message = isset($_POST['message']) ? sanitize_input($_POST['message']) : '';

// Validation
$errors = [];

if (empty($name)) {
    $errors[] = 'Name is required';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Valid email is required';
}

if (empty($subject)) {
    $errors[] = 'Subject is required';
}

if (empty($message)) {
    $errors[] = 'Message is required';
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
    exit;
}

// Create PHPMailer instance
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USERNAME;
    $mail->Password   = SMTP_PASSWORD;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = SMTP_PORT;
    $mail->CharSet    = 'UTF-8';
    
    // ============================================
    // SEND EMAIL TO ADMIN
    // ============================================
    $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
    $mail->addAddress(ADMIN_EMAIL, 'DeliaNexus Admin');
    $mail->addReplyTo($email, $name);
    
    $mail->isHTML(true);
    $mail->Subject = 'New Contact Form Submission: ' . $subject;
    
    // Email body for admin
    $adminBody = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #1f2937; color: white; padding: 20px; text-align: center; }
            .content { background-color: #f9fafb; padding: 30px; border-radius: 8px; margin-top: 20px; }
            .field { margin-bottom: 20px; }
            .label { font-weight: bold; color: #1f2937; margin-bottom: 5px; display: block; }
            .value { background-color: white; padding: 10px; border-radius: 4px; border-left: 3px solid #3b82f6; }
            .footer { text-align: center; margin-top: 30px; color: #6b7280; font-size: 14px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>New Contact Form Submission</h1>
            </div>
            <div class='content'>
                <div class='field'>
                    <span class='label'>From:</span>
                    <div class='value'>{$name}</div>
                </div>
                <div class='field'>
                    <span class='label'>Email:</span>
                    <div class='value'>{$email}</div>
                </div>
                " . (!empty($phone) ? "
                <div class='field'>
                    <span class='label'>Phone:</span>
                    <div class='value'>{$phone}</div>
                </div>
                " : "") . "
                <div class='field'>
                    <span class='label'>Subject:</span>
                    <div class='value'>{$subject}</div>
                </div>
                <div class='field'>
                    <span class='label'>Message:</span>
                    <div class='value'>" . nl2br($message) . "</div>
                </div>
            </div>
            <div class='footer'>
                <p>This email was sent from the DeliaNexus contact form</p>
                <p>Received on: " . date('F j, Y, g:i a') . "</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    $mail->Body = $adminBody;
    $mail->AltBody = "New Contact Form Submission\n\n" .
                     "From: {$name}\n" .
                     "Email: {$email}\n" .
                     (!empty($phone) ? "Phone: {$phone}\n" : "") .
                     "Subject: {$subject}\n\n" .
                     "Message:\n{$message}\n\n" .
                     "Received on: " . date('F j, Y, g:i a');
    
    // Send to admin
    $mail->send();
    
    // ============================================
    // SEND CONFIRMATION EMAIL TO USER
    // ============================================
    $mail->clearAddresses();
    $mail->clearReplyTos();
    
    $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
    $mail->addAddress($email, $name);
    $mail->addReplyTo(ADMIN_EMAIL, 'DeliaNexus');
    
    $mail->Subject = 'We Received Your Message - DeliaNexus';
    
    // Email body for user confirmation
    $userBody = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #1f2937; color: white; padding: 30px; text-align: center; border-radius: 8px 8px 0 0; }
            .content { background-color: #ffffff; padding: 30px; border: 1px solid #e5e7eb; border-top: none; }
            .message-box { background-color: #f0fdf4; border-left: 4px solid #10b981; padding: 15px; margin: 20px 0; border-radius: 4px; }
            .button { display: inline-block; background-color: #1f2937; color: white; padding: 12px 30px; text-decoration: none; border-radius: 6px; margin: 20px 0; }
            .footer { background-color: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb; border-radius: 0 0 8px 8px; }
            .contact-info { margin: 20px 0; }
            .contact-item { margin: 10px 0; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h1>Thank You for Contacting Us!</h1>
            </div>
            <div class='content'>
                <p>Dear {$name},</p>
                
                <div class='message-box'>
                    <strong>✓ Your message has been successfully received!</strong>
                </div>
                
                <p>We appreciate you taking the time to reach out to DeliaNexus. Our team has received your message regarding <strong>{$subject}</strong> and we will review it carefully.</p>
                
                <p><strong>What happens next?</strong></p>
                <ul>
                    <li>Our team will review your message within 24 business hours</li>
                    <li>We'll respond to your inquiry at the email address you provided</li>
                    <li>For urgent matters, feel free to call or WhatsApp us directly</li>
                </ul>
                
                <div class='contact-info'>
                    <p><strong>Need immediate assistance?</strong></p>
                    <div class='contact-item'>📞 <strong>Phone:</strong> +233 547 573 910</div>
                    <div class='contact-item'>💬 <strong>WhatsApp:</strong> +233 547 573 910</div>
                    <div class='contact-item'>⏰ <strong>Business Hours:</strong> Mon-Fri: 8AM-6PM, Sat: 9AM-4PM</div>
                </div>
                
                <p>We look forward to serving you!</p>
                
                <p>Best regards,<br><strong>The DeliaNexus Team</strong></p>
            </div>
            <div class='footer'>
                <p style='margin: 5px 0;'><strong>DeliaNexus</strong></p>
                <p style='margin: 5px 0; color: #6b7280;'>Fashion • Digital • Health</p>
                <p style='margin: 5px 0; color: #6b7280; font-size: 12px;'>This is an automated confirmation email. Please do not reply to this email.</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    $mail->Body = $userBody;
    $mail->AltBody = "Dear {$name},\n\n" .
                     "Thank you for contacting DeliaNexus!\n\n" .
                     "We have received your message regarding: {$subject}\n\n" .
                     "Our team will review your inquiry and respond within 24 business hours.\n\n" .
                     "For immediate assistance:\n" .
                     "Phone: +233 547 573 910\n" .
                     "WhatsApp: +233 547 573 910\n" .
                     "Business Hours: Mon-Fri: 8AM-6PM, Sat: 9AM-4PM\n\n" .
                     "Best regards,\n" .
                     "The DeliaNexus Team\n\n" .
                     "---\n" .
                     "This is an automated confirmation email.";
    
    // Send confirmation to user
    $mail->send();
    
    // Success response
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Your message has been sent successfully! A confirmation email has been sent to your inbox.'
    ]);
    
} catch (Exception $e) {
    // Error response
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to send message. Please try again or contact us directly.',
        'error' => $mail->ErrorInfo // Remove in production
    ]);
}
?>
