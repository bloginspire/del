# DeliaNexus Quick Start Guide

Get your website live in 30 minutes! ⚡

## Step 1: Setup Backend (5 minutes)

### 1.1 Install Dependencies
```bash
cd backend
npm install
```

### 1.2 Configure Environment
```bash
cp .env.example .env
```

Edit `.env` file with your details:
```env
SMTP_HOST=smtp.gmail.com
SMTP_PORT=587
SMTP_USER=rpdonkor7@gmail.com
SMTP_PASS=ydbncsybcpelzwrc
FROM_EMAIL=noreply@delianexus.com
FROM_NAME=DeliaNexus
ADMIN_EMAIL=cordelliaafriyie@gmail.com
ADMIN_EMAIL_CC=rpdonkor7@gmail.com
ALLOWED_ORIGINS=https://www.delianexus.com,https://delianexus.com,http://delianexus.com,http://www.delianexus.com
```

**Gmail App Password**: 
1. Enable 2FA: https://myaccount.google.com/security
2. Generate App Password: https://myaccount.google.com/apppasswords
3. Copy the 16-character password to `SMTP_PASS`

### 1.3 Test Locally
```bash
npm run dev
```

Visit: http://localhost:3000/api/health

Should see:
```json
{"success": true, "message": "DeliaNexus API is running"}
```

---

## Step 2: Deploy Backend to Render (10 minutes)

### 2.1 Push to GitHub
```bash
cd ..
git add .
git commit -m "Initial commit with backend"
git push origin main
```

### 2.2 Deploy on Render

1. Go to https://render.com and sign up
2. Click **New +** → **Web Service**
3. Connect your GitHub repository
4. Configure:
   - **Name**: `delianexus-backend`
   - **Region**: Oregon (or closest to you)
   - **Root Directory**: `backend`
   - **Build Command**: `npm install`
   - **Start Command**: `npm start`

5. Add Environment Variables (click Advanced):
   ```
   NODE_ENV=production
   SMTP_HOST=smtp.gmail.com
   SMTP_PORT=587
   SMTP_USER=rpdonkor7@gmail.com
   SMTP_PASS=ydbncsybcpelzwrc
   FROM_EMAIL=noreply@delianexus.com
   FROM_NAME=DeliaNexus
   ADMIN_EMAIL=cordelliaafriyie@gmail.com
   ADMIN_EMAIL_CC=rpdonkor7@gmail.com
   ALLOWED_ORIGINS=https://www.delianexus.com,https://delianexus.com,http://delianexus.com,http://www.delianexus.com
   ```

6. Click **Create Web Service**

Wait 2-5 minutes for deployment. You'll get a URL like:
`https://delianexus-backend.onrender.com`

### 2.3 Test Backend
Visit: `https://delianexus-backend.onrender.com/api/health`

---

## Step 3: Update Frontend (2 minutes)

### 3.1 Update API URL

Open `contact.html`, find line 730, and update if needed:

```javascript
const API_URL = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1'
    ? 'http://localhost:3000/api/contact'
    : 'https://YOUR-RENDER-URL.onrender.com/api/contact';
```

Replace `YOUR-RENDER-URL` with your actual Render URL.

### 3.2 Commit Changes
```bash
git add contact.html
git commit -m "Update API URL"
git push origin main
```

---

## Step 4: Deploy Frontend to GitHub Pages (5 minutes)

### 4.1 Enable GitHub Pages

1. Go to your GitHub repository
2. Click **Settings** → **Pages**
3. Under "Source":
   - Branch: `main`
   - Folder: `/ (root)`
4. Click **Save**

Wait 1-2 minutes. Your site will be at:
`https://USERNAME.github.io/REPO-NAME/`

---

## Step 5: Test Everything (5 minutes)

### 5.1 Test Contact Form

1. Visit your GitHub Pages URL
2. Go to Contact page
3. Fill out and submit the form
4. Check:
   - ✅ Success message appears
   - ✅ You receive admin email
   - ✅ User receives confirmation email

### 5.2 Test SEO

1. View page source (Right-click → View Page Source)
2. Look for:
   - ✅ Meta tags
   - ✅ Open Graph tags
   - ✅ Structured data

---

## Step 6: Custom Domain (Optional, 10 minutes)

### 6.1 Configure DNS

In your domain provider (Hostinger, GoDaddy, etc.), add:

**A Records** (for root domain):
```
Type: A, Name: @, Value: 185.199.108.153
Type: A, Name: @, Value: 185.199.109.153
Type: A, Name: @, Value: 185.199.110.153
Type: A, Name: @, Value: 185.199.111.153
```

**CNAME Record** (for www):
```
Type: CNAME, Name: www, Value: USERNAME.github.io
```

### 6.2 Add to GitHub Pages

1. GitHub repository → Settings → Pages
2. Custom domain: `www.delianexus.com`
3. Check "Enforce HTTPS" (after DNS propagates)
4. Click Save

### 6.3 Update URLs

After DNS propagates (24-48 hours):

1. Update `ALLOWED_ORIGINS` in Render environment variables:
   ```
   ALLOWED_ORIGINS=https://www.delianexus.com,https://delianexus.com
   ```

2. Update all canonical URLs in HTML files
3. Update sitemap.xml

---

## Step 7: Submit to Google (5 minutes)

### 7.1 Google Search Console

1. Go to https://search.google.com/search-console
2. Add property: `https://www.delianexus.com`
3. Verify ownership (via HTML file or DNS)
4. Submit sitemap: `https://www.delianexus.com/sitemap.xml`

### 7.2 Request Indexing

In Search Console, use "URL Inspection" tool to request indexing for:
- Homepage
- About page
- Fashion page
- Digital page
- Health page
- Contact page

---

## Troubleshooting

### Backend Issues

**Render service not starting:**
- Check Render logs for errors
- Verify environment variables are correct
- Ensure `backend/package.json` exists

**Emails not sending:**
- Use Gmail App Password, not regular password
- Check spam folder
- Verify SMTP credentials in Render

### Frontend Issues

**GitHub Pages not updating:**
- Wait 5-10 minutes
- Check GitHub Actions tab
- Clear browser cache

**Contact form CORS error:**
- Add your domain to `ALLOWED_ORIGINS` in Render
- Include `https://` in the origin
- Restart Render service

---

## Next Steps

✅ Monitor contact form submissions
✅ Check Google Search Console weekly
✅ Update content regularly
✅ Add more products/services
✅ Consider analytics (Google Analytics)

---

## Need Help?

📖 Read the full [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md)
📖 Check [README.md](README.md) for detailed documentation
📖 Review backend docs: [backend/README.md](backend/README.md)

---

**🎉 Congratulations! Your website is live!**

- Frontend: `https://www.delianexus.com`
- Backend: `https://delianexus-backend.onrender.com`
- Contact form: Working! ✅
- SEO: Optimized! ✅

**Time to celebrate! 🚀**
