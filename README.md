# Car Dealer Inventory Management System

A production-ready inventory management system built with **Pure PHP** and **MySQL** for fast deployment on any standard shared hosting.

## Features

- 🚗 **Public Inventory Page** - Browse vehicles with search and filter capabilities
- 🔐 **Admin Dashboard** - Secure login with session-based authentication
- ✏️ **CRUD Operations** - Add, edit, and delete vehicle listings
- 📸 **Multi-Image Upload** - Support for multiple vehicle photos
- 🎨 **Modern UI** - Responsive design that works on all devices
- 🔒 **Security** - Prepared statements, password hashing, upload protection

## Prerequisites

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server (or PHP built-in server for development)
- PDO MySQL extension enabled

## Installation

### 1. Clone or Download

```bash
git clone <repository-url>
cd car-dealer-system
```

### 2. Create Database

Create a MySQL database named `cardealer`:

```sql
CREATE DATABASE cardealer CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Import Database Schema

Import the database schema using MySQL command line or phpMyAdmin:

```bash
mysql -u root -p cardealer < database/init.sql
```

Or via phpMyAdmin:
- Select the `cardealer` database
- Click "Import"
- Choose `database/init.sql`
- Click "Go"

### 4. Configure Database Connection

Edit `config/database.php` with your database credentials:

```php
return [
    'host' => '127.0.0.1',
    'dbname' => 'cardealer',
    'username' => 'root',      // Your MySQL username
    'password' => '',          // Your MySQL password
    'charset' => 'utf8mb4'
];
```

### 5. Set Directory Permissions

Ensure the uploads directory is writable:

```bash
# Linux/Mac
chmod 755 public/uploads

# Windows - no action needed
```

### 6. Start Development Server

```bash
cd car-dealer-system
php -S localhost:8000 -t public
```

Visit `http://localhost:8000` in your browser.

## Default Admin Credentials

- **Username**: `admin`
- **Password**: `admin123`

⚠️ **IMPORTANT**: Change the default password immediately after first login!

## Usage

### Public Pages

- **Home** (`/`) - Browse all vehicles with search filters
- **Vehicle Detail** (`/vehicle/{id}`) - View detailed information about a specific vehicle

### Admin Pages

- **Login** (`/admin/login`) - Admin authentication
- **Dashboard** (`/admin/dashboard`) - View and manage all vehicles
- **Add Vehicle** (`/admin/vehicle/add`) - Add new vehicle to inventory
- **Edit Vehicle** (`/admin/vehicle/edit/{id}`) - Edit existing vehicle
- **Delete Vehicle** - Delete confirmation via dashboard

### Adding Vehicles

1. Login to admin dashboard
2. Click "Add New Vehicle"
3. Fill in vehicle details (make, model, year, price, description)
4. Upload images (multiple files supported)
5. Click "Add Vehicle"

### Managing Images

- **Add Mode**: Upload multiple images at once
- **Edit Mode**: New uploads are added to existing images
- Supported formats: JPG, PNG, GIF, WebP
- First image is used as the thumbnail

## Deployment to Shared Hosting

### Via FTP/SFTP

1. Upload all files to your hosting directory (e.g., `public_html`)
2. Create MySQL database via cPanel/Plesk
3. Import `database/init.sql` via phpMyAdmin
4. Update `config/database.php` with hosting credentials
5. Ensure `public/uploads/` is writable (chmod 755)

### URL Rewriting (Optional)

If your hosting supports `.htaccess`, add this to `public/.htaccess` for clean URLs:

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

### Security Checklist

- [ ] Change default admin password
- [ ] Use strong database password
- [ ] Enable HTTPS (Let's Encrypt recommended)
- [ ] Set `display_errors = Off` in production PHP settings
- [ ] Verify `uploads/.htaccess` blocks PHP execution
- [ ] Keep PHP and MySQL updated

## Troubleshooting

### Database Connection Failed

- Verify database credentials in `config/database.php`
- Ensure MySQL service is running
- Check database name exists
- Confirm PDO MySQL extension is enabled

### Images Not Uploading

- Check `public/uploads/` directory exists and is writable
- Verify `upload_max_filesize` and `post_max_size` in `php.ini`
- Ensure sufficient disk space

### 404 Errors on Routes

- Verify you're serving from the `public` directory
- Check `.htaccess` is present (if using Apache)
- For Nginx, configure proper URL rewriting

### Session Issues

- Ensure session directory is writable
- Check `session.save_path` in `php.ini`
- Verify cookies are enabled in browser

## Project Structure

```
car-dealer-system/
├── config/
│   └── database.php          # Database configuration
├── database/
│   └── init.sql              # Database schema
├── public/
│   ├── css/
│   │   ├── style.css         # Main stylesheet
│   │   └── placeholder-car.svg
│   ├── uploads/              # Image storage
│   │   └── .htaccess         # Upload security
│   └── index.php             # Entry point
├── src/
│   ├── Controllers/
│   │   ├── AdminController.php
│   │   └── PublicController.php
│   ├── Models/
│   │   ├── User.php
│   │   └── Vehicle.php
│   ├── Controller.php        # Base controller
│   └── Router.php            # Routing system
├── views/
│   ├── admin/
│   │   ├── dashboard.php
│   │   ├── form.php
│   │   └── login.php
│   ├── public/
│   │   ├── detail.php
│   │   └── home.php
│   └── layout.php            # Master template
└── README.md
```

## Technology Stack

- **Backend**: Pure PHP 7.4+ (no frameworks)
- **Database**: MySQL 5.7+ with PDO
- **Frontend**: HTML5, CSS3, Vanilla JavaScript
- **Architecture**: Custom MVC pattern
- **Authentication**: PHP Sessions with bcrypt password hashing

## Future Enhancements

- Contact form for vehicle inquiries
- Email notifications
- Advanced search (mileage, color, features)
- Image optimization and thumbnails
- Multi-user admin system
- Activity logs
- CSV/PDF export
- REST API

## License

This project is open source and available for personal and commercial use.

## Support

For issues or questions, please create an issue in the repository or contact the development team.
