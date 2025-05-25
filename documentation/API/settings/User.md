## 🔐 1. Getting Started

---

### 1.1 Get All Users

Fetch all users registered in the system.

**📍 Endpoint:** `POST /api/settings/users/`  
**🔐 Authorization:** `Bearer Token`

**📤 Response Example:**
```json
{
"success": true,
"data": [
    {
    "id": 1,
    "name": "pisco",
    "email": "pisco@gmail.com",
    "email_verified_at": null,
    "created_at": "2025-05-17T03:52:51.000000Z",
    "updated_at": "2025-05-17T03:52:51.000000Z"
    },
    {
    "id": 2,
    "name": "pisco2",
    "email": "pisco2@gmail.com",
    "email_verified_at": null,
    "created_at": "2025-05-17T21:51:04.000000Z",
    "updated_at": "2025-05-17T21:51:04.000000Z"
    },
    {
    "id": 8,
    "name": "pisco2",
    "email": "p1isco22w22222ww3@wgmail.com",
    "email_verified_at": null,
    "created_at": "2025-05-17T22:00:33.000000Z",
    "updated_at": "2025-05-17T22:00:33.000000Z"
    }
],
"message": ""
}
```
---

### 1.2 Register a New User

Register a new user by submitting the required data.

**📍 Endpoint:** `POST /api/settings/user/register`  
**🔐 Authorization:** `Bearer Token`

**📥 Required Fields:**
- name: string
- email: string (must be unique)
- password: string
- c_password: string (must match password)

**📤 Response Example:**
```json
{
    "success": true,
    "data": {
    "token": "9|1ys2AdY2SirXkbicHWZq6xG0rE6wUhfkAs7WEa6a2061576c",
    "name": "pisco"
},
"message": "User registered successfully."
}
```
---

### 1.3 Edit an Existing User

Update the information of an existing user.

**📍 Endpoint:** `POST /api/settings/user/edit`  
**🔐 Authorization:** `Bearer Token`

**📥 Required Fields:**
- id: int — User ID
- name: string
- email: string (must be unique, except for the current user)
- role: string (must match an existing role name)

**📤 Response Example:**
```json{
"success": true,
"data": {
    "id": 1,
    "name": "jaibey",
    "email": "posocc@gmail.com",
    "email_verified_at": null,
    "created_at": "2025-05-17T03:52:51.000000Z",
    "updated_at": "2025-05-17T23:22:34.000000Z"
},
"message": "User updated successfully."
}
```
---

### 1.4 Get a Single User by ID

Retrieve a specific user by their ID.

**📍 Endpoint:** `GET /api/settings/user/uniqueUser/{id_user}`  
**🔐 Authorization:** `Bearer Token`

**📥 URL Parameter:**
- id_user: int — User ID

**📤 Response Example:**
```json
{
"id": 2,
"name": "pisco2",
"email": "pisco2@gmail.com",
"email_verified_at": null,
"created_at": "2025-05-17T21:51:04.000000Z",
"updated_at": "2025-05-17T21:51:04.000000Z"
}
```
---
### 1.4 Change status

If user is active the system will change the status

**📍 Endpoint:** `GET /api/settings/user/uniqueUser/{id_user}`  
**🔐 Authorization:** `Bearer Token`

**📥 URL Parameter:**
- id_user: int — User ID

**📤 Response Example:**

```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "jaibey",
    "email": "posocc@gmail.com",
    "email_verified_at": null,
    "created_at": "2025-05-17T03:52:51.000000Z",
    "updated_at": "2025-05-18T00:08:03.000000Z",
    "status": "ACTIVO"
  },
  "message": "Guardado correctamente."
}
```
---
