# Quick Fix for Render SMTP Issue

## The Problem

Your backend deployed successfully but Gmail SMTP is timing out:
```
SMTP connection error: Error: Connection timeout
```

## Quick Fix (2 minutes)

### Option 1: Try Gmail Port 465 First

1. Go to: https://dashboard.render.com
2. Click on your service: **del-ed9i**
3. Click **Environment** in left sidebar
4. Find `SMTP_PORT` and change from `587` to `465`
5. Click **Save Changes**
6. Service will auto-redeploy (wait 2 minutes)
7. Test contact form

**If this works**, you'll see in logs: ✅ SMTP server is ready to send emails

---

### Option 2: Use SendGrid (If Port 465 Doesn't Work)

**Best for production** - More reliable on Render

1. **Sign up for SendGrid**: https://signup.sendgrid.com/
   - Free tier: 100 emails/day forever
   - Verify your email address

2. **Create API Key**:
   - Go to Settings → API Keys
   - Click "Create API Key"
   - Name it: "DeliaNexus"
   - Copy the key (starts with `SG.`)

3. **Update Render Environment Variables**:
   - Go to your Render dashboard
   - Click **Environment**
   - Update these variables:

   ```
   SMTP_HOST=smtp.sendgrid.net
   SMTP_PORT=587
   SMTP_USER=apikey
   SMTP_PASS=SG.your_actual_sendgrid_api_key_here
   ```
   
   Keep these the same:
   ```
   FROM_EMAIL=cordelliaafriyie@gmail.com
   FROM_NAME=DeliaNexus
   ADMIN_EMAIL=cordelliaafriyie@gmail.com
   ADMIN_EMAIL_CC=rpdonkor7@gmail.com
   ```

4. Click **Save Changes**
5. Wait 2 minutes for redeploy
6. Test contact form

---

## Testing

### Check Render Logs

1. Go to Render Dashboard
2. Click **Logs** tab
3. Look for:
   - ✅ Success: "SMTP server is ready to send emails"
   - ❌ Failure: "SMTP verification failed"

### Test Contact Form

1. Visit: http://delianexus.com/contact.html
2. Fill out form and submit
3. Check emails arrive:
   - cordelliaafriyie@gmail.com should receive notification
   - rpdonkor7@gmail.com should receive copy (CC)
   - User should receive confirmation email

---

## Current Status

✅ **Backend is running**: https://del-ed9i.onrender.com
✅ **API is working**: https://del-ed9i.onrender.com/api/health
❌ **SMTP needs fix**: Gmail port 587 is timing out on Render

---

## Recommendation

**For quick fix**: Try port 465 (Option 1)
**For reliability**: Use SendGrid (Option 2)

SendGrid is more reliable because:
- Designed for cloud services
- Better IP reputation
- Higher deliverability
- Won't get blocked like Gmail often does

---

## After Fix

Once SMTP is working:

1. ✅ Test contact form thoroughly
2. ✅ Update `ALLOWED_ORIGINS` in Render to include your actual GitHub Pages URL
3. ✅ Enable HTTPS on GitHub Pages (once DNS propagates)

---

## Need More Options?

See `backend/SMTP_ALTERNATIVES.md` for other email services:
- Brevo (300 emails/day free)
- Mailgun (5,000 emails/month free)
- Resend (3,000 emails/month free)
