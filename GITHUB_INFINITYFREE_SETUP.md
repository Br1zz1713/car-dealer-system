# GitHub → InfinityFree Deployment Guide

Complete step-by-step guide to deploy your Car Dealer System to free hosting.

---

## 📋 Overview

**What we're doing:**
1. Push your code to GitHub (version control)
2. Deploy to InfinityFree (free PHP/MySQL hosting)
3. Access your live site with a free subdomain

**Total Time:** ~30 minutes  
**Cost:** $0 (completely free)

---

## Part 1: Push to GitHub

### Step 1: Check Git Installation

Open PowerShell and check if Git is installed:

```powershell
git --version
```

**If not installed:**
- Download from: https://git-scm.com/download/win
- Install with default settings
- Restart PowerShell

### Step 2: Configure Git (First Time Only)

```powershell
git config --global user.name "Your Name"
git config --global user.email "your.email@example.com"
```

### Step 3: Initialize Repository

```powershell
cd d:\car-dealer-system
git init
```

### Step 4: Add All Files

```powershell
git add .
```

### Step 5: Create First Commit

```powershell
git commit -m "Initial commit - Car Dealer Inventory System"
```

### Step 6: Create GitHub Repository

1. Go to https://github.com/new
2. Fill in:
   - **Repository name**: `car-dealer-system`
   - **Description**: "PHP/MySQL Car Dealer Inventory Management System"
   - **Visibility**: Public (for portfolio) or Private
   - **DO NOT** check "Add a README file" (you already have one)
3. Click **"Create repository"**

### Step 7: Connect to GitHub

GitHub will show you commands. Use these:

```powershell
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/car-dealer-system.git
git push -u origin main
```

**Replace `YOUR_USERNAME`** with your actual GitHub username.

**If prompted for credentials:**
- Use GitHub Personal Access Token (not password)
- Create token at: https://github.com/settings/tokens
- Permissions needed: `repo` (full control)

### Step 8: Verify on GitHub

1. Go to https://github.com/YOUR_USERNAME/car-dealer-system
2. You should see all your files
3. ✅ GitHub setup complete!

---

## Part 2: Deploy to InfinityFree

### Step 1: Sign Up for InfinityFree

1. Go to https://www.infinityfree.net/
2. Click **"Sign Up"**
3. Fill in:
   - Email address
   - Password
   - Complete CAPTCHA
4. Verify your email
5. Login to your account

### Step 2: Create Hosting Account

1. Click **"Create Account"** in your InfinityFree panel
2. Choose a subdomain:
   - Example: `mycardealer.rf.gd`
   - Or: `cardealer.epizy.com`
   - Or use your own domain (if you have one)
3. Enter a label (e.g., "Car Dealer System")
4. Click **"Create Account"**
5. Wait for account activation (~5-10 minutes)

### Step 3: Access Control Panel

1. Once activated, click **"Control Panel"** (cPanel icon)
2. You'll see the cPanel dashboard
3. Note your:
   - **FTP Hostname** (e.g., `ftpupload.net`)
   - **FTP Username** (e.g., `if0_12345678`)
   - **FTP Password** (you set this)

### Step 4: Create MySQL Database

1. In cPanel, find **"MySQL Databases"**
2. Click **"Create Database"**
3. Database name: `cardealer` (it will be prefixed, e.g., `if0_12345678_cardealer`)
4. Click **"Create Database"**
5. **Write down the full database name** (with prefix)

### Step 5: Create Database User

1. Scroll to **"MySQL Users"**
2. Username: `cardealer_user`
3. Password: Create a strong password
4. Click **"Create User"**
5. **Write down:**
   - Full username (e.g., `if0_12345678_cardealer_user`)
   - Password

### Step 6: Add User to Database

1. Scroll to **"Add User To Database"**
2. Select your user and database
3. Click **"Add"**
4. Grant **ALL PRIVILEGES**
5. Click **"Make Changes"**

### Step 7: Import Database Schema

1. In cPanel, find **"phpMyAdmin"**
2. Click to open phpMyAdmin
3. Select your database (e.g., `if0_12345678_cardealer`)
4. Click **"Import"** tab
5. Click **"Choose File"**
6. Select `d:\car-dealer-system\database\init.sql`
7. Click **"Go"** at the bottom
8. ✅ You should see "Import has been successfully finished"

### Step 8: Upload Files via File Manager

**Option A: File Manager (Easier)**

1. In cPanel, click **"File Manager"**
2. Navigate to `htdocs/` folder
3. **Delete** the default `index.html` or `default.php`
4. Click **"Upload"** button
5. Select all files from `d:\car-dealer-system\`
6. Wait for upload to complete

**Important:** Upload the **contents** of the folder, not the folder itself. Your structure should be:
```
htdocs/
├── config/
├── database/
├── public/
├── src/
├── views/
├── README.md
└── .gitignore
```

**Option B: FTP (Alternative)**

1. Download **FileZilla** from https://filezilla-project.org/
2. Connect with:
   - Host: `ftpupload.net`
   - Username: Your FTP username
   - Password: Your FTP password
   - Port: 21
3. Navigate to `htdocs/` on the right panel
4. Drag all files from `d:\car-dealer-system\` to `htdocs/`

### Step 9: Configure Database Connection

1. In File Manager, navigate to `htdocs/config/`
2. Right-click `database.php` → **Edit**
3. Update with your InfinityFree credentials:

```php
<?php

return [
    'host' => 'sql123.infinityfree.com',  // Check your MySQL hostname in cPanel
    'dbname' => 'if0_12345678_cardealer', // Your full database name
    'username' => 'if0_12345678_cardealer_user', // Your full username
    'password' => 'your_password_here',   // Your database password
    'charset' => 'utf8mb4'
];
```

4. Click **"Save Changes"**

**To find your MySQL hostname:**
- In cPanel → MySQL Databases
- Look for "MySQL Hostname" (e.g., `sql123.infinityfree.com`)

### Step 10: Set Permissions

1. In File Manager, navigate to `htdocs/public/uploads/`
2. Right-click the `uploads` folder → **Permissions**
3. Set to `755` or `775`
4. Click **"Change Permissions"**

### Step 11: Test Your Site!

1. Visit your subdomain: `http://yoursubdomain.rf.gd`
2. You should see the inventory page (empty at first)
3. Test admin login: `http://yoursubdomain.rf.gd/admin/login`
   - Username: `admin`
   - Password: `admin123`

---

## 🎉 Success Checklist

After deployment, verify:

- [ ] Public page loads: `http://yoursubdomain.rf.gd`
- [ ] Admin login works: `http://yoursubdomain.rf.gd/admin/login`
- [ ] Can add a vehicle with images
- [ ] Vehicle appears on public page
- [ ] Can edit vehicle
- [ ] Can delete vehicle
- [ ] Search filters work
- [ ] Images display correctly

---

## 🔧 Troubleshooting

### "Database connection failed"

**Solution:**
1. Double-check database credentials in `config/database.php`
2. Verify MySQL hostname (check cPanel → MySQL Databases)
3. Ensure database user has ALL PRIVILEGES

### "500 Internal Server Error"

**Solution:**
1. Check file permissions (755 for directories, 644 for files)
2. Verify `.htaccess` files uploaded correctly
3. Check cPanel → Error Logs for details

### "Images not uploading"

**Solution:**
1. Check `public/uploads/` permissions (should be 755 or 775)
2. Verify `.htaccess` exists in uploads folder
3. Check PHP upload limits in cPanel

### "Page not found" or routing issues

**Solution:**
1. Ensure you're accessing through `public/` directory
2. Check if `.htaccess` is in the `public/` folder
3. InfinityFree may require you to adjust the document root

**Fix for InfinityFree routing:**

If routes don't work, you may need to access via:
- `http://yoursubdomain.rf.gd/public/`

Or create a `.htaccess` in `htdocs/`:
```apache
RewriteEngine On
RewriteCond %{REQUEST_URI} !^/public/
RewriteRule ^(.*)$ /public/$1 [L]
```

### Site is slow

**Note:** InfinityFree free hosting can be slow during peak times. This is normal for free hosting.

---

## 🔒 Security Recommendations

### Change Admin Password Immediately

1. Login to phpMyAdmin
2. Select your database
3. Click `users` table
4. Click "Edit" on the admin user
5. Generate new password:
   ```php
   // Run this locally to get hash:
   echo password_hash('your_new_password', PASSWORD_BCRYPT);
   ```
6. Replace the password hash
7. Save changes

### Restrict File Access

Add to `htdocs/.htaccess`:
```apache
# Deny access to sensitive files
<FilesMatch "^(\.git|\.gitignore|database\.php)">
    Order allow,deny
    Deny from all
</FilesMatch>
```

---

## 📊 InfinityFree Limitations

**Free Plan Includes:**
- ✅ Unlimited bandwidth
- ✅ Unlimited disk space
- ✅ MySQL databases
- ✅ PHP 8.x support
- ✅ Free subdomain
- ❌ No email hosting
- ❌ Limited CPU/RAM (can be slow)
- ❌ Daily hit limits (~50,000 hits)
- ❌ No SSL on free subdomain (HTTP only)

**For Production:**
Consider upgrading to paid hosting (~$3-10/month) for:
- Custom domain with SSL
- Better performance
- Email hosting
- No hit limits

---

## 🎯 Next Steps

After successful deployment:

1. **Add Sample Vehicles**
   - Login to admin
   - Add 3-5 sample vehicles with images
   - Test all functionality

2. **Share Your Portfolio**
   - Add to your resume/CV
   - Share on LinkedIn
   - Include in your portfolio website

3. **Monitor Your Site**
   - Check cPanel error logs regularly
   - Monitor disk space usage
   - Backup database monthly

4. **Consider Upgrades**
   - Custom domain ($10-15/year)
   - Paid hosting for better performance
   - SSL certificate for HTTPS

---

## 📞 Support

**InfinityFree Support:**
- Forum: https://forum.infinityfree.net/
- Knowledge Base: https://infinityfree.net/support/

**GitHub Issues:**
- Create issues in your repository for bugs/features

---

## ✅ Summary

**What You've Accomplished:**
1. ✅ Pushed code to GitHub (version control + portfolio)
2. ✅ Deployed to free hosting (live, accessible website)
3. ✅ Configured database and uploads
4. ✅ Created a working portfolio project

**Your Live URLs:**
- **Public Site**: `http://yoursubdomain.rf.gd`
- **Admin Panel**: `http://yoursubdomain.rf.gd/admin/login`
- **GitHub Repo**: `https://github.com/YOUR_USERNAME/car-dealer-system`

Congratulations! Your Car Dealer System is now live and accessible to the world! 🎉
