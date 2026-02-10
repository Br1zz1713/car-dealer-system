# Deployment Guide - Car Dealer System

This guide covers multiple deployment options for your PHP/MySQL application.

---

## 🚫 Why Not Vercel?

**Vercel is NOT compatible** with this project because:
- Vercel is designed for **serverless/static sites** (Next.js, React, Vue)
- This is a **traditional PHP application** with MySQL database
- Vercel doesn't support PHP runtime or persistent MySQL databases

---

## ✅ Recommended Deployment Options

### Option 1: Shared Hosting (Easiest) ⭐

**Best for**: Production use, custom domain, email hosting  
**Cost**: $3-10/month  
**Providers**: Hostinger, Bluehost, SiteGround, Namecheap

#### Steps:

1. **Purchase Hosting Plan**
   - Choose plan with PHP 7.4+ and MySQL support
   - Most shared hosting includes cPanel

2. **Upload Files via FTP**
   ```
   Use FileZilla or cPanel File Manager:
   - Upload all files to public_html/
   - Or create subdirectory: public_html/cardealer/
   ```

3. **Create MySQL Database**
   - Login to cPanel
   - Go to "MySQL Databases"
   - Create database: `username_cardealer`
   - Create user with password
   - Grant all privileges

4. **Import Database**
   - Go to phpMyAdmin
   - Select your database
   - Click "Import"
   - Upload `database/init.sql`
   - Click "Go"

5. **Update Configuration**
   - Edit `config/database.php`:
   ```php
   return [
       'host' => 'localhost',
       'dbname' => 'username_cardealer',
       'username' => 'username_dbuser',
       'password' => 'your_secure_password',
       'charset' => 'utf8mb4'
   ];
   ```

6. **Set Permissions**
   - Ensure `public/uploads/` is writable (chmod 755)

7. **Access Your Site**
   - Visit: `https://yourdomain.com`
   - Admin: `https://yourdomain.com/admin/login`

---

### Option 2: GitHub + Free PHP Hosting

**Best for**: Testing, portfolio projects  
**Cost**: Free  
**Providers**: InfinityFree, 000webhost, Awardspace

#### Part A: Push to GitHub

1. **Initialize Git Repository**
   ```bash
   cd d:\car-dealer-system
   git init
   ```

2. **Create `.gitignore`**
   ```bash
   echo "config/database.php" > .gitignore
   echo "public/uploads/*" >> .gitignore
   echo "!public/uploads/.htaccess" >> .gitignore
   ```

3. **Create `config/database.example.php`**
   ```php
   <?php
   // Copy this file to database.php and update with your credentials
   return [
       'host' => 'localhost',
       'dbname' => 'your_database_name',
       'username' => 'your_username',
       'password' => 'your_password',
       'charset' => 'utf8mb4'
   ];
   ```

4. **Commit and Push**
   ```bash
   git add .
   git commit -m "Initial commit - Car Dealer System"
   git branch -M main
   git remote add origin https://github.com/yourusername/car-dealer-system.git
   git push -u origin main
   ```

#### Part B: Deploy to Free Hosting

1. **Sign up** at InfinityFree or 000webhost
2. **Create hosting account**
3. **Upload files** via FTP or File Manager
4. **Create MySQL database** in control panel
5. **Import** `database/init.sql`
6. **Create** `config/database.php` with hosting credentials
7. **Access** your free subdomain

---

### Option 3: DigitalOcean / VPS

**Best for**: Full control, scalability  
**Cost**: $5-10/month  

#### Quick Setup (Ubuntu 22.04)

1. **Create Droplet**
   - Choose Ubuntu 22.04
   - $5/month plan is sufficient

2. **SSH into Server**
   ```bash
   ssh root@your_server_ip
   ```

3. **Install LAMP Stack**
   ```bash
   # Update system
   apt update && apt upgrade -y

   # Install Apache, MySQL, PHP
   apt install apache2 mysql-server php php-mysql php-pdo libapache2-mod-php -y

   # Enable Apache modules
   a2enmod rewrite
   systemctl restart apache2
   ```

4. **Configure MySQL**
   ```bash
   mysql_secure_installation
   
   # Create database
   mysql -u root -p
   ```
   ```sql
   CREATE DATABASE cardealer CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   CREATE USER 'cardealer_user'@'localhost' IDENTIFIED BY 'secure_password';
   GRANT ALL PRIVILEGES ON cardealer.* TO 'cardealer_user'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```

5. **Upload Application**
   ```bash
   # Clone from GitHub (if you pushed it)
   cd /var/www/html
   git clone https://github.com/yourusername/car-dealer-system.git
   cd car-dealer-system
   
   # Or upload via SFTP to /var/www/html/car-dealer-system
   ```

6. **Set Permissions**
   ```bash
   chown -R www-data:www-data /var/www/html/car-dealer-system
   chmod -R 755 /var/www/html/car-dealer-system
   chmod -R 775 /var/www/html/car-dealer-system/public/uploads
   ```

7. **Configure Apache**
   ```bash
   nano /etc/apache2/sites-available/cardealer.conf
   ```
   ```apache
   <VirtualHost *:80>
       ServerName yourdomain.com
       DocumentRoot /var/www/html/car-dealer-system/public
       
       <Directory /var/www/html/car-dealer-system/public>
           Options Indexes FollowSymLinks
           AllowOverride All
           Require all granted
       </Directory>
       
       ErrorLog ${APACHE_LOG_DIR}/cardealer_error.log
       CustomLog ${APACHE_LOG_DIR}/cardealer_access.log combined
   </VirtualHost>
   ```

8. **Enable Site**
   ```bash
   a2ensite cardealer.conf
   systemctl reload apache2
   ```

9. **Import Database**
   ```bash
   mysql -u cardealer_user -p cardealer < /var/www/html/car-dealer-system/database/init.sql
   ```

10. **Update Config**
    ```bash
    nano /var/www/html/car-dealer-system/config/database.php
    ```

11. **Setup SSL (Optional but Recommended)**
    ```bash
    apt install certbot python3-certbot-apache -y
    certbot --apache -d yourdomain.com
    ```

---

### Option 4: Heroku (with ClearDB MySQL)

**Best for**: Quick deployment, auto-scaling  
**Cost**: Free tier available (limited)

#### Steps:

1. **Install Heroku CLI**
   ```bash
   # Download from https://devcenter.heroku.com/articles/heroku-cli
   ```

2. **Prepare Application**
   
   Create `Procfile`:
   ```
   web: vendor/bin/heroku-php-apache2 public/
   ```

   Create `composer.json`:
   ```json
   {
       "require": {
           "php": "^7.4.0"
       }
   }
   ```

3. **Deploy**
   ```bash
   heroku login
   heroku create your-car-dealer-app
   
   # Add ClearDB MySQL addon
   heroku addons:create cleardb:ignite
   
   # Get database credentials
   heroku config:get CLEARDB_DATABASE_URL
   
   # Push to Heroku
   git push heroku main
   ```

4. **Import Database**
   - Use the MySQL credentials from `CLEARDB_DATABASE_URL`
   - Import via MySQL Workbench or command line

5. **Update Config**
   - Parse `CLEARDB_DATABASE_URL` in `config/database.php`

---

## 📋 Pre-Deployment Checklist

Before deploying to production:

- [ ] Change default admin password
- [ ] Update `config/database.php` with production credentials
- [ ] Set strong database password
- [ ] Verify `public/uploads/.htaccess` exists
- [ ] Test all functionality locally first
- [ ] Backup database before deployment
- [ ] Enable HTTPS/SSL certificate
- [ ] Set `display_errors = Off` in PHP settings
- [ ] Configure proper error logging
- [ ] Set up regular database backups

---

## 🔒 Security Hardening

### For Production Deployments:

1. **Change Admin Password Immediately**
   ```sql
   UPDATE users SET password = '$2y$10$NewHashHere' WHERE username = 'admin';
   ```

2. **Restrict Database Access**
   - Use strong passwords
   - Limit MySQL user privileges
   - Don't use root user

3. **Enable HTTPS**
   - Use Let's Encrypt (free SSL)
   - Force HTTPS redirects

4. **File Permissions**
   ```bash
   # Files: 644
   find . -type f -exec chmod 644 {} \;
   
   # Directories: 755
   find . -type d -exec chmod 755 {} \;
   
   # Uploads: 775
   chmod -R 775 public/uploads
   ```

5. **Hide Sensitive Files**
   
   Add to `public/.htaccess`:
   ```apache
   # Deny access to config files
   <FilesMatch "^(database\.php)$">
       Order allow,deny
       Deny from all
   </FilesMatch>
   ```

6. **Disable Directory Listing**
   ```apache
   Options -Indexes
   ```

---

## 🌐 Custom Domain Setup

### After Deployment:

1. **Purchase Domain** (Namecheap, GoDaddy, Google Domains)

2. **Update DNS Records**
   
   Add A Record:
   ```
   Type: A
   Host: @
   Value: your_server_ip
   TTL: Automatic
   ```
   
   Add CNAME (optional):
   ```
   Type: CNAME
   Host: www
   Value: yourdomain.com
   TTL: Automatic
   ```

3. **Wait for Propagation** (up to 48 hours)

4. **Update Apache Config** (if using VPS)
   - Set `ServerName` to your domain

---

## 🔄 Continuous Deployment

### GitHub Actions (for VPS)

Create `.github/workflows/deploy.yml`:

```yaml
name: Deploy to Production

on:
  push:
    branches: [ main ]

jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - name: Deploy to Server
        uses: appleboy/ssh-action@master
        with:
          host: ${{ secrets.SERVER_IP }}
          username: ${{ secrets.SERVER_USER }}
          key: ${{ secrets.SSH_PRIVATE_KEY }}
          script: |
            cd /var/www/html/car-dealer-system
            git pull origin main
            chown -R www-data:www-data .
```

---

## 📊 Monitoring & Maintenance

### Regular Tasks:

1. **Database Backups**
   ```bash
   # Daily backup script
   mysqldump -u username -p cardealer > backup_$(date +%Y%m%d).sql
   ```

2. **Monitor Disk Space**
   - Check `public/uploads/` size
   - Implement image optimization

3. **Update PHP/MySQL**
   - Keep software updated for security

4. **Monitor Logs**
   - Check Apache error logs
   - Monitor PHP error logs

---

## 🆘 Troubleshooting

### Common Issues:

**500 Internal Server Error**
- Check Apache error logs
- Verify file permissions
- Check `.htaccess` syntax

**Database Connection Failed**
- Verify credentials in `config/database.php`
- Check MySQL service is running
- Confirm database exists

**Images Not Uploading**
- Check `uploads/` directory permissions
- Verify `upload_max_filesize` in `php.ini`
- Check disk space

**Blank Page**
- Enable error display temporarily
- Check PHP error logs
- Verify all files uploaded correctly

---

## 📞 Support Resources

- **Shared Hosting**: Contact hosting provider support
- **VPS**: DigitalOcean Community Tutorials
- **PHP Issues**: Stack Overflow, PHP.net documentation
- **MySQL**: MySQL documentation, DBA Stack Exchange

---

## Summary

**Recommended Path**:
1. ✅ **Development**: Local PHP server
2. ✅ **Version Control**: GitHub
3. ✅ **Production**: Shared hosting (easiest) or VPS (more control)

**Not Recommended**:
- ❌ Vercel (doesn't support PHP/MySQL)
- ❌ Netlify (static sites only)
- ❌ GitHub Pages (static sites only)

Choose the option that best fits your budget, technical expertise, and scalability needs!
