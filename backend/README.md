# DeliaNexus Backend API

Backend server for DeliaNexus contact form with Nodemailer email functionality.

## Features

- ✉️ Contact form email handling with Nodemailer
- 🔒 Security with Helmet and CORS
- ⏱️ Rate limiting to prevent spam (5 requests per 15 minutes)
- 📧 Automatic confirmation email to users
- 📨 Admin notification emails
- 🎨 Beautiful HTML email templates

## Setup Instructions

### 1. Install Dependencies

```bash
cd backend
npm install
```

### 2. Configure Environment Variables

Create a `.env` file in the backend directory:

```bash
cp .env.example .env
```

Edit `.env` with your actual credentials:

```env
# For Gmail
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USER=your-email@gmail.com
SMTP_PASS=your-app-password

# For other providers (e.g., Hostinger)
# SMTP_HOST=smtp.hostinger.com
# SMTP_PORT=587
# SMTP_USER=your-email@yourdomain.com
# SMTP_PASS=your-app-password

FROM_EMAIL=noreply@delianexus.com
FROM_NAME=DeliaNexus
ADMIN_EMAIL=cordelliaafriyie@gmail.com
ADMIN_EMAIL_CC=rpdonkor@gmail.com

PORT=3000
NODE_ENV=production

ALLOWED_ORIGINS=https://www.delianexus.com,https://delianexus.com
```

### 3. Gmail App Password Setup (if using Gmail)

1. Go to your Google Account settings
2. Enable 2-Factor Authentication
3. Go to Security > App passwords
4. Generate a new app password for "Mail"
5. Copy the 16-character password to `SMTP_PASS` in `.env`

### 4. Test Locally

```bash
npm run dev
```

Server will run on `http://localhost:3000`

Test the health endpoint:
```bash
curl http://localhost:3000/api/health
```

## API Endpoints

### GET /api/health
Health check endpoint

**Response:**
```json
{
  "success": true,
  "message": "DeliaNexus API is running",
  "timestamp": "2025-01-10T12:00:00.000Z"
}
```

### POST /api/contact
Submit contact form

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "phone": "+233 XXX XXX XXX",
  "subject": "General Inquiry",
  "message": "Hello, I would like to know more about your services."
}
```

**Response (Success):**
```json
{
  "success": true,
  "message": "Your message has been sent successfully! Check your email for confirmation."
}
```

**Response (Error):**
```json
{
  "success": false,
  "message": "Error message here"
}
```

## Deployment to Render

See the main project README for deployment instructions.

## Security Features

- **Helmet**: Security headers
- **CORS**: Controlled cross-origin access
- **Rate Limiting**: 5 requests per 15 minutes per IP
- **Input Validation**: Email and required fields validation
- **Environment Variables**: Sensitive data protection

## Email Templates

The API sends two types of emails:

1. **Admin Notification**: Styled email to admin with all form details
2. **User Confirmation**: Professional confirmation email to the user

Both emails use responsive HTML templates with modern design.

## Troubleshooting

### Emails not sending

- Check SMTP credentials in `.env`
- Verify app password is correct (for Gmail)
- Check transporter verification logs in console
- Ensure firewall allows outbound SMTP traffic

### CORS errors

- Add your domain to `ALLOWED_ORIGINS` in `.env`
- Include protocol (https://) in the origin
- Restart the server after changing `.env`

### Rate limit issues

- Wait 15 minutes between multiple test submissions
- Adjust `windowMs` and `max` in server.js if needed for development

## Development

```bash
npm run dev
```

Uses nodemon for automatic restarts on file changes.

## Production

```bash
npm start
```

Starts the server with Node.js directly.
