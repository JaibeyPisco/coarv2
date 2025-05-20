## 🔐 1. Getting Started
This section explains how to interact with static data endpoints, their requirements, and expected responses.
---

### 1.1 Get ubigeo

Fetch Peruvian **Ubigeo** records stored in the database using a search filter.


**📍 Endpoint:**  
`POST /api/data_static/ubigeo`

**🔐 Authorization:**  
Bearer Token (required)

**📥 Request Body:**
- `search` (string): Any value related to department, province, or district.

**Example json to send**
````json
    {
    "search":"AMAZONAS"
    }
````

**📤 Response Example:**
```json
{
  "success": true,
  "data": [
    {
      "id_ubigeo": 10514,
      "text": "10514 - Amazonas - Luya - Pisuquia"
    },
    {
      "id_ubigeo": 10515,
      "text": "10515 - Amazonas - Luya - Providencia"
    },
    {
      "id_ubigeo": 10516,
      "text": "10516 - Amazonas - Luya - San Cristobal"
    },
    {
      "id_ubigeo": 10517,
      "text": "10517 - Amazonas - Luya - San Francisco del Yeso"
    },
    {
      "id_ubigeo": 10518,
      "text": "10518 - Amazonas - Luya - San Jeronimo"
    },
    {
      "id_ubigeo": 10519,
      "text": "10519 - Amazonas - Luya - San Juan de Lopecancha"
    } 
  ],
  "message": ""
}
```
---
