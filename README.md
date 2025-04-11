# 📁 Laravel File Uploader

A simple and powerful Laravel-based file uploader that supports file storage on AWS S3 and uses PostgreSQL hosted on AWS RDS. Deployed on an AWS EC2 instance running Ubuntu.

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

## 🚀 Features

- Upload files via a simple web interface
- Store uploaded files in AWS S3
- Store file metadata in PostgreSQL (AWS RDS)
- Uses Laravel Queues and Sessions (Database-driven)
- SMTP Email notifications (Gmail)
- Deployed on AWS EC2

## 🔧 Tech Stack

- **Framework:** Laravel
- **Database:** PostgreSQL (AWS RDS)
- **Storage:** AWS S3
- **Queue/Cache/Session:** Database
- **Web Server:** Nginx
- **OS:** Ubuntu (EC2)
- **Email Service:** Gmail SMTP

## 📦 Requirements

- PHP >= 8.1
- Composer
- PostgreSQL
- AWS S3 Bucket
- Node.js + npm (for compiling frontend assets)

## ⚙️ Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/tulbadex/laravel-file-uploader-s3-bucket-rds.git
cd laravel-file-uploader-s3-bucket-rds
```

### 2. Install Dependencies

```bash
composer install
npm install && npm run dev
```

### 3. Set Permissions

```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 4. Environment Configuration

Copy `.env.example` to `.env` and update values:

```bash
cp .env.example .env
```

Your `.env` should include:

```env
APP_NAME="File Uploader"
APP_ENV=local
APP_KEY=base64:...

DB_CONNECTION=pgsql
DB_HOST=your-rds-endpoint
DB_PORT=5432
DB_DATABASE=file_uploader
DB_USERNAME=postgres
DB_PASSWORD=yourpassword

FILESYSTEM_DISK=s3
AWS_ACCESS_KEY_ID=your-access-key
AWS_SECRET_ACCESS_KEY=your-secret
AWS_DEFAULT_REGION=your-region
AWS_BUCKET=your-bucket-name

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=you@gmail.com
MAIL_PASSWORD=your-gmail-password
MAIL_ENCRYPTION=tls
```

### 5. Generate App Key

```bash
php artisan key:generate
```

### 6. Run Migrations

```bash
php artisan migrate
```

### 7. Run the App

```bash
php artisan serve
```

Or if deployed via Nginx/EC2, just visit your public IP.

## ☁️ Deployment

This app is deployed on an AWS EC2 instance with:

- PostgreSQL database hosted on AWS RDS.
- Uploaded files stored in AWS S3.
- Nginx configured to serve Laravel.

Ensure Nginx is configured correctly and port 80 is available:
```bash
sudo systemctl stop apache2
sudo systemctl disable apache2
sudo systemctl start nginx
```

## 📬 Email Notifications

To enable email notifications via Gmail:

1. Enable 2FA on your Gmail account
2. Create an **App Password** for use in `.env`
3. Update `MAIL_USERNAME` and `MAIL_PASSWORD`

## ✅ Future Improvements

- File type validation & virus scanning
- User authentication & upload history
- File expiration/download tracking

## 🤝 Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you'd like to change.

## 📜 License

[MIT](https://opensource.org/licenses/MIT)

## 👤 Author

**Ibrahim Adedayo**  
📧 tulbadex@gmail.com
🌐 [LinkedIn Profile](https://www.linkedin.com/in/ibrahim-adedayo/)
```