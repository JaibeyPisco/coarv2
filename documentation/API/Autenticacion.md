# COAR V2 - Dev Manual

## 📌 Introduction

Welcome to the user guide for **COAR V2**. This manual will help you understand how to use the system effectively and get the most out of its features.

---

## 🔐 1. Getting Started

### 1.1 Register
To register a new user go the the register side and complete all data required

**Endpoint** `POST /api/register`  
**Required**
- `name:string` 
- `email:string|unique`
- `password:string`
- `c_password:string`

**Response**
```json
{
    "success": true,
    "data": {
        "token": "9|1ys2AdY2SirXkbicHWZq6xG0rE6wUhfkAs7WEa6a2061576c",
        "name": "pisco"
    },
    "message": "User register successfully."
}
```

### 1.2. Login
To access the system, go to the login page and enter your email and password.
**Endpoint:** `POST /api/login`  
**Required:** `email`, `password`  

**Response:**
```json
{
  "success": true,
  "data": {
    "token": "8|5JmYbew2soqYkVU1x4lABR3ktF6bmVJyI7ICnROh6eb09b6d",
    "name": "pisco"
  },
  "message": "User login successfully."
}
```
---
 
### 1.3. Logout
Click on the logout button or call the logout endpoint to end your session.

**Endpoint:** `POST /api/logout`  
**Authorization:** Bearer token
**Response:**

---

## 👤 2. User Management

### 2.1. View Users
Go to the **Users** section to see the list of registered users.

**Endpoint:** `GET /api/settings/users`  
**Permissions:** Admin only

### 2.2. Create New User
Click the **New User** button and fill in the required fields.

**Endpoint:** `POST /api/settings/users`  
**Fields:** name, email, role, etc.

---

## 🧩 3. Roles & Permissions

- Each user has a role assigned.
- Roles define what menus and actions are available.
- Permissions are managed under the **Settings > Roles** module.

---

## 🗂 4. Modules Overview

| Module         | Description                     |
|----------------|----------------------------------|
| Users          | Manage user accounts             |
| Roles          | Assign access levels             |
| Areas          | Define internal organization     |
| Monitoring     | View and manage alerts           |
| Settings       | Customize system preferences     |

---

## 🆘 Support

If you experience any issues, please contact the system administrator or technical support team.

---

**COAR V2 — All rights reserved**
