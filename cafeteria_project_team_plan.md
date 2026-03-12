
# Cafeteria PHP Project — Final Team Division (5 Members)

## Tech Stack

* PHP (OOP)
* MySQL (phpMyAdmin)
* Bootstrap
* GitHub
* Trello

---

# Team Responsibilities

## Developer 1 — Authentication & Sessions

**Pages**

* login.php
* resetPassword.php
* logout.php

**UI**

* Login form
* Reset password form
* Bootstrap layout

**PHP Logic**

* Login validation
* Password verification
* Reset password logic
* Session management
* Access control (Admin / User)

**Database Tables**

* users

---

# Developer 2 — Users & Rooms Management (Admin)

**Pages**

* users.php
* addUser.php
* editUser.php
* rooms.php
* addRoom.php

**UI**

* Users table
* Add/Edit user form
* Rooms table
* Add room form

**PHP Logic**

* Create user
* Update user
* Delete user
* Upload user image
* Assign room
* Manage rooms

**Database Tables**

* users
* rooms

---

# Developer 3 — Products & Categories

**Pages**

* products.php
* addProduct.php
* editProduct.php
* categories.php
* addCategory.php

**UI**

* Products table
* Product form
* Categories table

**PHP Logic**

* Create product
* Update product
* Delete product
* Create category
* Upload product images

**Database Tables**

* products
* categories

---

# Developer 4 — User Ordering (Shop / Cart)

**Pages**

* home.php
* cart.php

**UI**

* Products grid with images
* Add to cart button
* * / − quantity buttons
* Notes field
* Room dropdown

**PHP Logic**

* Add product to cart
* Update quantity
* Remove product from cart
* Calculate total price
* Session cart handling

**Database Tables**

* products
* rooms

---

# Developer 5 — Orders System & Admin Orders

**Pages**

* checkout.php
* myOrders.php
* orderDetails.php
* currentOrders.php
* createOrder.php
* checks.php

**UI**

* Orders table
* Order details page
* Admin orders table
* Date filters
* User dropdown

**PHP Logic**

* Create order
* Insert order items
* Cancel order
* Change order status
* Admin create order
* Reports queries

**Database Tables**

* orders
* order_items
* users

---

# Database Tables

* users
* rooms
* categories
* products
* orders
* order_items

---

# Shared Requirements

## UI

Use **Bootstrap** for all pages.

---

## Validation

### Frontend

* JavaScript validation

### Backend

* PHP validation

---

# GitHub Workflow

Each developer works on a separate branch:

```
feature-auth
feature-users
feature-products
feature-cart
feature-orders
```

Example:

```bash
git checkout -b feature-products
git add .
git commit -m "Add products feature"
git push origin feature-products
```

---

# Shared Layout Files

To keep UI consistent:

* header.php
* sidebar.php
* footer.php

All pages should include them.

