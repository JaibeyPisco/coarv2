# Settings API - Configuración del Sistema

## Descripción

Esta sección contiene la documentación de todas las APIs relacionadas con la configuración del sistema COARV2.

## Módulos Disponibles

### 1. **Company** - Configuración de Empresa
- **Archivo**: `Company.md`
- **Endpoints**: 
  - `GET /api/settings/company` - Obtener datos de empresa
  - `POST /api/settings/company/save` - Guardar/actualizar empresa
- **Funcionalidad**: Gestión de información básica de la empresa y logos
- **Frontend**: Componente Vue en `frontend/src/views/settings/company/`

### 2. **User** - Gestión de Usuarios
- **Archivo**: `User.md`
- **Endpoints**: Gestión completa de usuarios del sistema
- **Funcionalidad**: CRUD de usuarios, autenticación, permisos

### 3. **Role** - Gestión de Roles
- **Archivo**: `Role.md`
- **Endpoints**: Gestión de roles y permisos
- **Funcionalidad**: Asignación de roles y permisos a usuarios

### 4. **Places** - Gestión de Lugares
- **Archivo**: `Place.md`
- **Endpoints**: Gestión de ubicaciones y lugares
- **Funcionalidad**: CRUD de lugares del sistema

### 5. **Incidence Types** - Tipos de Incidencias
- **Archivo**: `IncidenceTypes.md`
- **Endpoints**: Gestión de tipos de incidencias
- **Funcionalidad**: Configuración de categorías de incidencias

## Estructura de Carpetas

```
documentation/API/settings/
├── README.md           # Esta documentación general
├── Company.md          # API de configuración de empresa
├── User.md             # API de gestión de usuarios
├── Role.md             # API de gestión de roles
├── Place.md            # API de gestión de lugares
└── IncidenceTypes.md   # API de tipos de incidencias
```

## Autenticación

Todos los endpoints de settings requieren autenticación mediante Laravel Sanctum.

**Header requerido:**
```
Authorization: Bearer {token}
```

## Patrones de Respuesta

### Respuesta Exitosa
```json
{
  "success": true,
  "data": { ... },
  "message": "Operación realizada correctamente"
}
```

### Respuesta de Error
```json
{
  "success": false,
  "message": "Descripción del error",
  "data": { ... }
}
```

## Códigos de Estado HTTP

- **200**: Operación exitosa
- **201**: Recurso creado exitosamente
- **400**: Error de solicitud
- **401**: No autorizado
- **403**: Prohibido
- **404**: No encontrado
- **422**: Error de validación
- **500**: Error interno del servidor

## Validaciones

Todos los endpoints implementan validaciones robustas:
- Validación de campos requeridos
- Validación de tipos de datos
- Validación de formatos (email, números, etc.)
- Validación de archivos (cuando aplica)
- Validación de permisos de usuario

## Manejo de Archivos

Los módulos que manejan archivos (como Company) implementan:
- Validación de tipos de archivo
- Generación de nombres únicos
- Almacenamiento en carpetas específicas
- Enlaces simbólicos para acceso público

## Frontend Integration

Cada módulo de settings tiene su correspondiente implementación en el frontend:

```
frontend/src/views/settings/
├── company/           # Configuración de empresa
├── user/              # Gestión de usuarios
├── rol/               # Gestión de roles
├── places/            # Gestión de lugares
└── IncidenceTypes/    # Tipos de incidencias
```

## Composable Pattern

El frontend utiliza composables para la lógica de negocio:

```javascript
// Ejemplo para Company
import { UseCompany } from "@/composables/settings/company/UseCompany";
const { save, getCompany, loading } = UseCompany();
```

## Testing

Cada módulo debe incluir:
- Tests unitarios para modelos
- Tests de integración para controladores
- Tests de validación
- Tests de autenticación y autorización

## Mantenimiento

### Actualizaciones de API
1. Documentar cambios en el archivo correspondiente
2. Actualizar versiones si es necesario
3. Mantener compatibilidad hacia atrás
4. Actualizar tests

### Frontend
1. Mantener sincronización con la API
2. Actualizar composables según cambios del backend
3. Mantener consistencia en la UI/UX

## Contribución

Para agregar nuevos módulos de settings:

1. Crear el controlador en `backend/app/Http/Controllers/API/settings/`
2. Crear el modelo correspondiente
3. Agregar rutas en `backend/routes/api.php`
4. Crear migraciones si es necesario
5. Documentar en `documentation/API/settings/`
6. Implementar en el frontend
7. Crear tests

## Recursos Adicionales

- **Diagrama del sistema**: `DIAGRAMA COARV2.drawio`
- **Autenticación**: `Autenticacion.md`
- **Roles y permisos**: `Role.md`
- **Datos estáticos**: `resources/Data_static.md`
