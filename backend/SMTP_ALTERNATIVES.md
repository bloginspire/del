# SMTP Alternatives for Render Deployment

## Problem: Gmail SMTP Timeout on Render

Gmail's SMTP often blocks connections from Render's free tier IP addresses, causing timeout errors:
```
SMTP connection error: Error: Connection timeout
```

## Solutions (Choose One)

---

### ✅ Solution 1: Use Gmail SMTP Port 465 (SSL) - Try This First

Update your Render environment variables:

```
SMTP_HOST=smtp.gmail.com
SMTP_PORT=465
SMTP_SECURE=true
SMTP_USER=rpdonkor7@gmail.com
SMTP_PASS=ydbncsybcpelzwrc
```

Then update `server.js` to use `secure: true` when port is 465.

---

### ✅ Solution 2: SendGrid (Recommended for Production)

**Free Tier**: 100 emails/day forever

1. **Sign up**: https://signup.sendgrid.com/
2. **Verify email address**
3. **Create API Key**:
   - Go to Settings → API Keys
   - Create API Key
   - Copy the key (starts with `SG.`)

4. **Get SMTP Credentials**:
   - Username: `apikey` (literally the word "apikey")
   - Password: Your API key from step 3

5. **Update Render Environment Variables**:
```
SMTP_HOST=smtp.sendgrid.net
SMTP_PORT=587
SMTP_USER=apikey
SMTP_PASS=SG.your_actual_api_key_here
FROM_EMAIL=rpdonkor7@gmail.com
FROM_NAME=DeliaNexus
ADMIN_EMAIL=cordelliaafriyie@gmail.com
ADMIN_EMAIL_CC=rpdonkor7@gmail.com
```

**Pros**: Reliable, designed for cloud apps, great deliverability
**Cons**: Requires account verification

---

### ✅ Solution 3: Brevo (formerly Sendinblue)

**Free Tier**: 300 emails/day

1. **Sign up**: https://www.brevo.com/
2. **Get SMTP credentials**:
   - Go to Settings → SMTP & API
   - SMTP & API → SMTP
   - Copy your credentials

3. **Update Render Environment Variables**:
```
SMTP_HOST=smtp-relay.brevo.com
SMTP_PORT=587
SMTP_USER=your-brevo-email@gmail.com
SMTP_PASS=your-brevo-smtp-key
FROM_EMAIL=rpdonkor7@gmail.com
FROM_NAME=DeliaNexus
```

**Pros**: Generous free tier, easy setup
**Cons**: Requires account verification

---

### ✅ Solution 4: Mailgun

**Free Tier**: 5,000 emails/month for 3 months

1. **Sign up**: https://signup.mailgun.com/
2. **Verify domain** (or use sandbox domain for testing)
3. **Get SMTP credentials**:
   - Go to Sending → Domain Settings
   - Copy SMTP credentials

4. **Update Render Environment Variables**:
```
SMTP_HOST=smtp.mailgun.org
SMTP_PORT=587
SMTP_USER=postmaster@sandboxXXXXXXXX.mailgun.org
SMTP_PASS=your-mailgun-password
FROM_EMAIL=rpdonkor7@gmail.com
FROM_NAME=DeliaNexus
```

---

### ✅ Solution 5: Resend (Modern Alternative)

**Free Tier**: 3,000 emails/month

1. **Sign up**: https://resend.com/
2. **Add domain** (or use their test domain)
3. **Create API Key**
4. **Use their SDK** (requires code change) or SMTP:

```
SMTP_HOST=smtp.resend.com
SMTP_PORT=587
SMTP_USER=resend
SMTP_PASS=re_your_api_key_here
```

---

## Quick Fix: Update Backend Code for Port 465

If trying Gmail with port 465, update `backend/server.js`:

```javascript
const transporter = nodemailer.createTransport({
  host: process.env.SMTP_HOST,
  port: parseInt(process.env.SMTP_PORT),
  secure: process.env.SMTP_PORT === '465', // Auto-detect based on port
  auth: {
    user: process.env.SMTP_USER,
    pass: process.env.SMTP_PASS,
  },
  connectionTimeout: 10000,
  greetingTimeout: 10000,
  socketTimeout: 10000
});
```

---

## Testing Your SMTP Configuration

After updating Render environment variables:

1. **Check Render Logs**:
   - Go to Render Dashboard
   - Click on your service
   - View "Logs" tab
   - Look for: "SMTP server is ready to send emails"

2. **Test Contact Form**:
   - Visit your website
   - Submit contact form
   - Check if emails arrive

3. **Manual Test** (via curl):
```bash
curl -X POST https://del-ed9i.onrender.com/api/contact \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "email": "test@example.com",
    "subject": "Test",
    "message": "Testing SMTP"
  }'
```

---

## Recommended Solution for DeliaNexus

**For immediate fix**: Try Gmail with port 465 (Solution 1)

**For production**: Use SendGrid (Solution 2)
- Most reliable
- Best deliverability
- Easy to set up
- Scales well

---

## Current Configuration

Your current settings (in Render):
```
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USER=rpdonkor7@gmail.com
SMTP_PASS=ydbncsybcpelzwrc
```

**Try changing to port 465:**
```
SMTP_HOST=smtp.gmail.com
SMTP_PORT=465
SMTP_USER=rpdonkor7@gmail.com
SMTP_PASS=ydbncsybcpelzwrc
```

If that doesn't work within 5 minutes, switch to SendGrid.

---

## After Changing SMTP Settings

1. Update environment variables in Render
2. Click "Manual Deploy" to restart service
3. Wait 2-3 minutes
4. Test contact form
5. Check Render logs for success message

---

**Need help?** Check Render logs for specific error messages.
