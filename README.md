# 📒 ContactBook

A full-featured Contact Management System built with Laravel 12, Blade, and Tailwind CSS.

Demo video[https://drive.google.com/file/d/1KleNE6684SZwiS9s9TtbmYkzfdzdnGLA/view?usp=drive_link)

## ✨ Features

### Core CRUD
- Create, Read, Update, Delete contacts
- Profile photo upload for each contact
- Per-user data isolation

### Advanced Features
- 🔐 Authentication (Register, Login, Logout)
- 🔍 Live Search (no page reload)
- 📊 Dashboard with stats chart
- ⭐ Favorite / Unfavorite contacts
- 🏷️ Contact Groups & Tags
- 📤 Export contacts to CSV
- 🌙 Dark Mode (saves preference)
- 🔔 Notifications system
- 🔒 Profile & Password settings
- 📱 QR Code for each contact

### Validation
- Strong password rules (uppercase, lowercase, number, symbol)
- Real-time field validation
- Password strength meter
- Show/Hide password toggle

### Events & Listeners
- ContactCreated event
- ContactUpdated event
- ContactDeleted event
- All events logged to laravel.log

## 🛠️ Tech Stack

| Technology | Usage |
|---|---|
| Laravel 12 | Backend Framework |
| Blade | Templating Engine |
| Tailwind CSS | Styling |
| SQLite | Database |
| Laravel Breeze | Authentication |
| Vite | Asset Bundling |

## ⚙️ Installation

```bash
# Clone the repository
git clone https://github.com/MubeenZahid-294/contact-book-validations-events.git

# Navigate to project
cd contact-book

# Install PHP dependencies
composer install

# Install JS dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Create storage link
php artisan storage:link

# Run migrations
php artisan migrate

# Start the servers
php artisan serve
npm run dev
```

## 📋 Requirements

- PHP 8.2+
- Composer
- Node.js & NPM
- Laravel 12

## 👨‍💻 Developer

Mubeen Zahid
