# DeliaNexus Website - Setup Instructions

**⚠️ DEPRECATED: This file describes the old PHP setup.**

**✅ NEW SETUP: We now use Node.js with Nodemailer!**

Please refer to:
- **[QUICK_START.md](QUICK_START.md)** - Get started in 30 minutes
- **[DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md)** - Complete deployment guide
- **[README.md](README.md)** - Full documentation
- **[backend/README.md](backend/README.md)** - Backend API docs

---

## Old PHP Setup (Archived)

## Contact Form Email Setup (PHPMailer) - NO LONGER USED

### Prerequisites
- Hostinger hosting account
- Domain with email configured
- Composer installed (for PHPMailer)

### Step 1: Install PHPMailer via Composer

1. Open terminal/command prompt in your project directory
2. Run the following command:
```bash
composer require phpmailer/phpmailer
```

This will create a `vendor` folder with PHPMailer installed.

### Step 2: Configure Email Settings

1. Copy `email_config_template.php` to `email_config.php`:
```bash
cp email_config_template.php email_config.php
```

2. Open `email_config.php` and fill in your actual credentials:

```php
define('SMTP_HOST', 'smtp.hostinger.com');
define('SMTP_PORT', 587);
define('SMTP_USERNAME', 'your-email@yourdomain.com');  // Your full email
define('SMTP_PASSWORD', 'your-app-password');          // App password from Hostinger
define('SMTP_FROM_EMAIL', 'noreply@yourdomain.com');
define('SMTP_FROM_NAME', 'DeliaNexus');
define('ADMIN_EMAIL', 'admin@yourdomain.com');         // Where messages go
```

### Step 3: Generate App Password in Hostinger

1. Log in to Hostinger webmail (webmail.yourdomain.com)
2. Go to **Settings** > **Security** > **App Passwords**
3. Click **Generate New App Password**
4. Give it a name (e.g., "DeliaNexus Website")
5. Copy the generated password
6. Paste it as `SMTP_PASSWORD` in `email_config.php`

**IMPORTANT:** Never use your regular email password - always use an app password!

### Step 4: Upload to Hostinger

1. Upload all files to your Hostinger public_html directory
2. Make sure the `vendor` folder is uploaded (contains PHPMailer)
3. Ensure `email_config.php` is uploaded but NOT `email_config_template.php`
4. Set proper file permissions if needed (usually 644 for PHP files)

### Step 5: Test the Contact Form

1. Visit your website at yourdomain.com/contact.html
2. Fill out and submit the contact form
3. Check:
   - Admin email receives the contact form submission
   - User receives confirmation email
   - Success message appears on the website

## Troubleshooting

### "Email configuration not found" error
- Make sure `email_config.php` exists (not just the template)
- Check that it's in the same directory as `send_email.php`

### "Failed to send message" error
- Verify SMTP credentials are correct
- Make sure you're using an app password, not regular password
- Check that your domain's email is set up in Hostinger
- Verify SMTP settings (host: smtp.hostinger.com, port: 587)

### Emails not being received
- Check spam folder
- Verify `ADMIN_EMAIL` is correct
- Test sending email directly from Hostinger webmail

### PHPMailer not found
- Run `composer install` in project directory
- Ensure `vendor` folder exists and contains PHPMailer
- Check that `require 'vendor/autoload.php';` path is correct

## Security Notes

1. **Never** commit `email_config.php` to version control
2. Always use app passwords, not regular passwords
3. Keep PHPMailer updated: `composer update phpmailer/phpmailer`
4. Monitor your email logs for suspicious activity
5. Consider adding CAPTCHA to prevent spam (future enhancement)

## File Structure

```
delia/
├── index.html
├── about.html
├── contact.html
├── fashion.html (to be created)
├── digital.html (to be created)
├── health.html (to be created)
├── send_email.php
├── email_config_template.php
├── email_config.php (you create this)
├── .gitignore
├── composer.json
├── vendor/
│   └── phpmailer/
└── img/
    ├── logo.webp
    └── ceo.jpg
```

## Support

If you encounter issues:
1. Check Hostinger's email documentation
2. Verify all credentials are correct
3. Test email sending from Hostinger webmail first
4. Check PHP error logs on your server

## Next Steps

After setting up the contact form:
1. Add your Supabase credentials for the Fashion, Digital, and Health pages
2. Test all functionality
3. Set up SSL certificate (Hostinger provides free SSL)
4. Configure domain DNS if not already done
