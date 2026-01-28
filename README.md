# eCommerce Website (PHP + MySQL) — Legacy Project

This repository contains an **old / legacy eCommerce web application** that I built as a learning project using **PHP and MySQL**.

The project demonstrates early backend development concepts such as **session-based shopping carts, relational database design, CRUD operations, and server-side rendering with PHP**.

⚠️ **Important:**  
This is **legacy code**. It is intentionally kept for portfolio and learning-history purposes and does **not** reflect my current coding style or best practices.

---

## Tech Stack

### Frontend
- HTML
- CSS
- Bootstrap
- JavaScript
- jQuery

### Backend
- PHP (PDO)
- PHP Sessions (shopping cart stored in `$_SESSION`)
- Server-side rendered pages

### Database
- MySQL / MariaDB
- phpMyAdmin (SQL dump included)

---

## Main Features

- User authentication system
- Product and category management
- Item details pages
- Session-based shopping cart (add/remove items)
- Orders system
- Comments system
- Notifications table
- Admin panel (basic management)

---

## Database Structure

The database name is **`shop`** and includes the following main tables:

- `users`
- `items`
- `categories`
- `comments`
- `orders`
- `notifications`

A full SQL dump (`shop.sql`) is included in the repository with:
- Table creation
- Foreign keys
- Sample data

---

## How to Run the Project Locally

### 1️⃣ Requirements

This project was developed and tested with **PHP 7.4**.

✅ **Recommended XAMPP version:**
- **XAMPP 7.4.x**  
  (Any XAMPP version that includes PHP 7.4 will work)

📌 Recommended download page:  
https://www.apachefriends.org/download.html

> ⚠️ Newer PHP versions (8.x) may cause compatibility issues due to deprecated syntax.

---

### 2️⃣ Clone the Repository

```bash
git clone https://github.com/mohammad-kawach/eCommerce-Website.git
```

---

## 3️⃣ Move Project to Web Server Directory

Place the project folder inside your web server directory:

- **Windows:**  
  `C:\xampp\htdocs\`

- **macOS:**  
  `/Applications/XAMPP/htdocs/`

- **Linux:**  
  `/opt/lampp/htdocs/`

Example structure: htdocs/eCommerce-Website

---


---

## 4️⃣ Create the Database

1. Start **Apache** and **MySQL** from the XAMPP Control Panel
2. Open **phpMyAdmin** in your browser:  
   http://localhost/phpmyadmin
3. Create a new database named: shop

---

## 5️⃣ Configure Database Credentials

Locate the database connection file (usually inside `init.php` or the `includes/` directory).

Update the credentials if needed:

```php
$host   = "localhost";
$dbname = "shop";
$user   = "root";
$pass   = "";
```

---

## 6️⃣ Run the Application

Open your browser and navigate to:

http://localhost/eCommerce-Website/

---
