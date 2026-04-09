# 📇 Laravel Contact Manager

A modern and feature-rich **Contact Management System** built with Laravel.  
This project goes beyond basic CRUD and provides advanced functionalities like search, filtering, favorites, tagging, and CSV export.

---

## 🚀 Features

### 🔹 Core Functionality
- Create, Read, Update, Delete (CRUD)
- Clean and responsive contact listing (Card UI)

### 🔹 Advanced Features
- Real-time Search (name, email, phone, company)
- Sorting (Ascending / Descending)
- Mark contacts as Favorites
- Tag system (Family, Work, Friend)
- Dashboard statistics (Total, Favorites, This Page)
- Export contacts to CSV

### 🔹 UI/UX
- Modern sidebar navigation
- Dark Mode support
- Smooth and user-friendly interface

---

## 🛠️ Tech Stack

- Backend: Laravel (PHP)
- Frontend: Blade / Bootstrap / CSS
- Database: MySQL
- Tools: Composer, Artisan CLI

---

## 🎥 Demo Video

👉 https://drive.google.com/file/d/1KleNE6684SZwiS9s9TtbmYkzfdzdnGLA/view

---

## 📸 Screenshots

👉 https://drive.google.com/file/d/1qgXD5TZYq0i9X-FnzjR3HYUM-VNRVeX3/view

---

## ⚙️ Installation & Setup

```bash
git clone https://github.com/MubeenZahid-294/contact-book-crud-laravel.git
cd contact-book
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve