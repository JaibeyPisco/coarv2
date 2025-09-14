# Company API - Configuración de Empresa

## Descripción

API para la gestión de configuración de empresa, incluyendo información básica y manejo de logos. Utiliza endpoints separados para guardar y editar, siguiendo el mismo patrón de manejo de imágenes que el `UserController`.

## Endpoints

### 1. Obtener Datos de Empresa

**GET** `/api/settings/company`

Obtiene la información actual de la empresa configurada.

#### Respuesta Exitosa (200)

```json
{
  "success": true,
  "data": {
    "id": 1,
    "numero_documento": "20123456789",
    "razon_social": "Empresa Ejemplo S.A.C.",
    "nombre_comercial": "Empresa Ejemplo",
    "direccion": "Av. Principal 123, Lima",
    "telefono": "+51 1 123-4567",
    "email": "contacto@empresa.com",
    "logo": "/storage/images/1734528000_logo.png",
    "logo_factura": "/storage/images/1734528000_logo_factura.png"
  },
  "message": "Datos de empresa obtenidos correctamente."
}
```

#### Respuesta Sin Datos (200)

```json
{
  "success": true,
  "data": {
    "id": null,
    "numero_documento": "",
    "razon_social": "",
    "nombre_comercial": "",
    "direccion": "",
    "telefono": "",
    "email": "",
    "logo": "",
    "logo_factura": ""
  },
  "message": "No hay datos de empresa configurados."
}
```

#### Respuesta de Error (400/500)

```json
{
  "success": false,
  "message": "Error al obtener datos de empresa.",
  "data": "Detalles del error"
}
```

---

### 2. Guardar Empresa

**POST** `/api/settings/company/save`

Guarda o actualiza la información de la empresa. Si no existe una empresa, la crea; si existe, la actualiza.

#### Parámetros del Body (FormData)

| Campo | Tipo | Requerido | Descripción |
|-------|------|-----------|-------------|
| `numero_documento` | string | ✅ | Número RUC de la empresa |
| `razon_social` | string | ✅ | Razón social |
| `nombre_comercial` | string | ✅ | Nombre comercial |
| `direccion` | string | ✅ | Dirección de la empresa |
| `telefono` | string | ✅ | Teléfono de contacto |
| `email` | string | ✅ | Correo electrónico |
| `imagen` | file | ❌ | Logo de la empresa (imagen) |
| `imagen_factura` | file | ❌ | Logo para documentos (imagen) |

#### Ejemplo de Request

```javascript
const formData = new FormData();
formData.append('numero_documento', '20123456789');
formData.append('razon_social', 'Empresa Ejemplo S.A.C.');
formData.append('nombre_comercial', 'Empresa Ejemplo');
formData.append('direccion', 'Av. Principal 123, Lima');
formData.append('telefono', '+51 1 123-4567');
formData.append('email', 'contacto@empresa.com');

// Solo si se selecciona una nueva imagen
if (companyLogoFile) {
  formData.append('imagen', companyLogoFile);
}
if (documentLogoFile) {
  formData.append('imagen_factura', documentLogoFile);
}
```

#### Respuesta Exitosa (200)

```json
{
  "success": true,
  "data": {
    "id": 1,
    "numero_documento": "20123456789",
    "razon_social": "Empresa Ejemplo S.A.C.",
    "nombre_comercial": "Empresa Ejemplo",
    "direccion": "Av. Principal 123, Lima",
    "telefono": "+51 1 123-4567",
    "email": "contacto@empresa.com",
    "logo": "/storage/images/1734528000_logo.png",
    "logo_factura": "/storage/images/1734528000_logo_factura.png"
  },
  "message": "Empresa creada correctamente."
}
```

---

### 3. Editar Empresa

**POST** `/api/settings/company/edit`

Actualiza la información de una empresa existente.

#### Parámetros del Body (FormData)

| Campo | Tipo | Requerido | Descripción |
|-------|------|-----------|-------------|
| `id` | integer | ✅ | ID de la empresa a editar |
| `numero_documento` | string | ✅ | Número RUC de la empresa |
| `razon_social` | string | ✅ | Razón social |
| `nombre_comercial` | string | ✅ | Nombre comercial |
| `direccion` | string | ✅ | Dirección de la empresa |
| `telefono` | string | ✅ | Teléfono de contacto |
| `email` | string | ✅ | Correo electrónico |
| `imagen` | file | ❌ | Logo de la empresa (imagen) |
| `imagen_factura` | file | ❌ | Logo para documentos (imagen) |

#### Respuesta Exitosa (200)

```json
{
  "success": true,
  "data": {
    "id": 1,
    "numero_documento": "20123456789",
    "razon_social": "Empresa Ejemplo S.A.C.",
    "nombre_comercial": "Empresa Ejemplo",
    "direccion": "Av. Principal 123, Lima",
    "telefono": "+51 1 123-4567",
    "email": "contacto@empresa.com",
    "logo": "/storage/images/1734528000_logo.png",
    "logo_factura": "/storage/images/1734528000_logo_factura.png"
  },
  "message": "Empresa actualizada correctamente."
}
```

---

## Manejo de Imágenes

### Patrón Establecido

El `CompanyController` utiliza **exactamente el mismo patrón** de manejo de imágenes que el `UserController`:

```php
// Patrón del UserController (replicado en CompanyController)
if ($request->hasFile('imagen')) {
    $logo = $request->file('imagen')->store('images', 'public');
    $urlLogo = Storage::url($logo);
    $input['logo'] = $urlLogo;
}
```

### Carpetas de Almacenamiento

- **Todas las imágenes**: `storage/app/public/images/`
- **Acceso público**: `/storage/images/` (URL generada por `Storage::url()`)

### Formato de Archivos

- **Tipos permitidos**: Cualquier tipo de imagen válido
- **Nomenclatura**: Generada automáticamente por Laravel
- **Ejemplo de URL**: `/storage/images/1734528000_logo.png`

### Proceso de Subida

1. **Almacenamiento**: `$request->file('imagen')->store('images', 'public')`
2. **Generación de URL**: `Storage::url($logo)`
3. **Almacenamiento en BD**: URL completa para acceso directo

### Ventajas del Patrón

- **Consistencia**: Mismo enfoque en toda la aplicación
- **Simplicidad**: Código más limpio y mantenible
- **URLs públicas**: Acceso directo a las imágenes desde el frontend
- **Laravel nativo**: Uso de las mejores prácticas del framework

---

## Validaciones

### Campos Obligatorios

- `numero_documento`: Máximo 255 caracteres
- `razon_social`: Máximo 255 caracteres
- `nombre_comercial`: Máximo 255 caracteres
- `direccion`: Máximo 500 caracteres
- `telefono`: Máximo 20 caracteres
- `email`: Formato de email válido, máximo 255 caracteres

### Imágenes

- Solo se procesan si se proporcionan en el request
- Se almacenan en `storage/app/public/images/`
- Se generan URLs públicas con `Storage::url()`
- No se requieren validaciones adicionales (manejadas por Laravel)

---

## Modelo de Datos

### Tabla: `empresa`

| Campo | Tipo | Nullable | Descripción |
|-------|------|----------|-------------|
| `id` | bigint | ❌ | ID único de la empresa |
| `document_number` | varchar(255) | ❌ | Número RUC |
| `business_name` | varchar(255) | ❌ | Razón social |
| `trade_name` | varchar(255) | ❌ | Nombre comercial |
| `address` | varchar(500) | ❌ | Dirección |
| `phone` | varchar(20) | ❌ | Teléfono |
| `email` | varchar(255) | ❌ | Correo electrónico |
| `id_ubigeo` | bigint | ✅ | ID de ubigeo (opcional) |
| `logo` | varchar(255) | ✅ | URL completa del logo de empresa |
| `logo_factura` | varchar(255) | ✅ | URL completa del logo para documentos |
| `created_at` | timestamp | ✅ | Fecha de creación |
| `updated_at` | timestamp | ✅ | Fecha de última actualización |

---

## Códigos de Estado HTTP

- **200**: Operación exitosa
- **422**: Error de validación
- **500**: Error interno del servidor

---

## Autenticación

Todos los endpoints requieren autenticación mediante Sanctum.

**Header requerido:**
```
Authorization: Bearer {token}
```

---

## Lógica de Negocio

### Creación vs Actualización

La API detecta automáticamente si debe crear o actualizar:

1. **Primera vez**: Si no existe empresa en el sistema, se crea una nueva
2. **Actualización**: Si ya existe una empresa, se actualiza la existente
3. **Respuesta completa**: Después de guardar, se retorna toda la información para llenar los campos

### Manejo de Imágenes

- **Opcional**: Los campos de imagen son opcionales
- **Actualización selectiva**: Solo se actualizan las imágenes que se envían
- **Preservación**: Las imágenes existentes se mantienen si no se envían nuevas
- **Patrón consistente**: Mismo enfoque que `UserController`
- **URLs públicas**: Acceso directo desde el frontend

---

## Ejemplos de Uso

### Frontend (Vue.js)

```javascript
import { UseCompany } from "@/composables/settings/company/UseCompany";

const { save, getCompany, loading } = UseCompany();

// Obtener datos
const loadData = async () => {
  try {
    const data = await getCompany();
    console.log('Datos de empresa:', data);
    // Las URLs de las imágenes ya están listas para usar
    // data.logo = "/storage/images/1734528000_logo.png"
  } catch (error) {
    console.error('Error:', error);
  }
};

// Guardar/actualizar datos
const saveData = async (formData) => {
  try {
    const result = await save(formData);
    console.log('Empresa guardada:', result);
    // Después de guardar, recargar los datos para llenar los campos
    await loadData();
  } catch (error) {
    console.error('Error:', error);
  }
};
```

### cURL

```bash
# Obtener datos
curl -X GET "http://localhost:8000/api/settings/company" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json"

# Guardar empresa
curl -X POST "http://localhost:8000/api/settings/company/save" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json" \
  -F "numero_documento=20123456789" \
  -F "razon_social=Empresa Ejemplo S.A.C." \
  -F "nombre_comercial=Empresa Ejemplo" \
  -F "direccion=Av. Principal 123, Lima" \
  -F "telefono=+51 1 123-4567" \
  -F "email=contacto@empresa.com" \
  -F "imagen=@logo.png"

# Editar empresa
curl -X POST "http://localhost:8000/api/settings/company/edit" \
  -H "Authorization: Bearer {token}" \
  -H "Accept: application/json" \
  -F "id=1" \
  -F "numero_documento=20123456789" \
  -F "razon_social=Empresa Ejemplo S.A.C." \
  -F "nombre_comercial=Empresa Ejemplo" \
  -F "direccion=Av. Principal 123, Lima" \
  -F "telefono=+51 1 123-4567" \
  -F "email=contacto@empresa.com" \
  -F "imagen=@logo.png"
```

---

## Notas de Implementación

- Solo se puede tener una empresa configurada por sistema
- Las imágenes se almacenan en `storage/app/public/images/` del storage de Laravel
- Se recomienda configurar un enlace simbólico para acceso público a las imágenes
- Los campos de imagen son opcionales y se pueden actualizar independientemente
- La API maneja automáticamente la creación vs actualización según si existe una empresa
- **Después de guardar, se retorna toda la información para llenar los campos del frontend**
- **Patrón consistente**: Mismo manejo de imágenes que `UserController`
- **URLs públicas**: Generadas automáticamente con `Storage::url()`
- **Acceso directo**: Las imágenes son accesibles directamente desde el frontend
