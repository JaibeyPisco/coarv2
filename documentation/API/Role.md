# COAR V2 - Dev Manual

## 📌 Introduction

Welcome to the user guide for **COAR V2**. This manual will help you understand how to use the system effectively and get the most out of its features.

---

## 🔐 1. Getting Started

> **TODO:**
> - Edit an existing role
> - Assign a role to a user
> - Modify permissions per user

---

### 1.1 Create a New Role

To register a new role, send a `POST` request to the following endpoint with all required data:

**🛠 Endpoint:**  
`POST /api/settings/store`

**📥 Required Fields:**
- `name: string` — Unique role identifier
- `fl_no_view_dashboard: string | nullable` — Optional flag to hide the dashboard
- `permissions: array` — List of permission objects with actions per module:
    - `menu: string` — Module name (e.g., empleados, equipos)
    - `view: boolean`
    - `new: boolean`
    - `edit: boolean`
    - `delete: boolean`

** Example json to send**
 ```json
     {
      "name": "SUPER ADMIN2",
      "fl_no_view_dashboard": "1",
      "permissions": [
        {"menu": "empleados", "view": true, "new": true, "edit": false, "delete": true},
        {"menu": "equipos", "view": true, "new": false, "edit": false, "delete": false},
        {"menu": "usuarios", "view": true, "new": true, "edit": true, "delete": true}
      ]
    }
 ```
**📤 Example Response:**

```json
{
  "success": true,
  "data": [
    "empleados.view",
    "empleados.delete",
    "equipos.view",
    "usuarios.view",
    "usuarios.edit",
    "usuarios.delete"
  ],
  "message": "Rol creado correctamente"
}

```
