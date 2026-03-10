

# ☕ Cafeteria Management System

A comprehensive cafeteria management system built with **PHP (OOP)** and **MySQL**. This project is designed with a modular architecture to allow 5 developers to work simultaneously without conflicts.

## 🛠 Tech Stack

* **Backend:** PHP 8.1+ (Object-Oriented Programming)
* **Database:** MySQL / MariaDB
* **Frontend:** HTML5, CSS3, Bootstrap 5, JavaScript
* **Version Control:** Git & GitHub

---

## 📂 Project Structure

```text
cafeteria-project/
├── admin/             # Admin-only pages (User mgmt, Product mgmt, Orders)
├── public/            # User-facing pages (Login, Home/Shop, Cart)
├── classes/           # PHP Classes (Database, User, Product, Order)
├── config/            # Configuration files and DB connection logic
├── includes/          # Shared UI components (Header, Footer, Sidebar)
├── assets/            # Static assets (CSS, JS, Images, Uploads)
└── database.sql       # Unified Database Schema

```

---

## 🚀 Getting Started

To set up the project locally, every team member should follow these steps:

1. **Clone the Repository:**
```bash
git clone [repository_url]
cd cafeteria-project

```


2. **Database Setup:**
* Open `phpMyAdmin`.
* Create a new database named `cafeteria_db`.
* **Import** the `database.sql` file located in the root directory.


3. **Configure Connection:**
* Open `classes/Database.php`.
* Update the `$username` and `$password` to match your local environment (e.g., XAMPP usually has an empty password, while Linux might differ).



---

## 🌿 Git Workflow (Branching Strategy)

To avoid merge conflicts, **NEVER** push directly to `main`. Follow this workflow:

1. **Create a feature branch:**
* `feature-auth` (Dev 1)
* `feature-users` (Dev 2)
* `feature-products` (Dev 3)
* `feature-cart` (Dev 4)
* `feature-orders` (Dev 5)


2. **Work and Push:**
```bash
git checkout -b feature-your-name
git add .
git commit -m "Added [feature name] functionality"
git push origin feature-your-name

```



---

## 📜 Coding Standards

* **Naming Conventions:** Use **PascalCase** for Class files (e.g., `Product.php`) and **camelCase** for variables/functions.
* **Shared Layouts:** Always include `includes/header.php` and `includes/footer.php` in your pages to maintain UI consistency.
* **File Uploads:** Store all product and user images in `assets/uploads/`.
* **Logic Separation:** Keep SQL queries inside the Classes; do not write raw SQL in the HTML files.

---
