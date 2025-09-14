# Frontend COARV2 - Vue 3 Application

## Descripción

Aplicación frontend desarrollada en Vue 3 con Composition API para el sistema COARV2, implementando un patrón de composables y componentes reutilizables.

## Estructura del Proyecto

```
frontend/
├── src/
│   ├── components/           # Componentes reutilizables
│   │   ├── Breadcumbs.vue
│   │   ├── ImagePreviewComponent.vue
│   │   └── shared/
│   ├── composables/          # Lógica de negocio reutilizable
│   │   └── settings/
│   │       ├── company/
│   │       ├── user/
│   │       ├── rol/
│   │       ├── places/
│   │       └── incidenceTypes/
│   ├── views/                # Páginas de la aplicación
│   │   └── settings/
│   │       ├── company/
│   │       ├── user/
│   │       ├── rol/
│   │       ├── places/
│   │       └── IncidenceTypes/
│   ├── layouts/              # Layouts de la aplicación
│   ├── lib/                  # Utilidades y configuración
│   └── router/               # Configuración de rutas
├── public/                   # Archivos estáticos
└── package.json
```

## Tecnologías Utilizadas

- **Vue 3**: Framework principal con Composition API
- **Vue Router**: Enrutamiento de la aplicación
- **Composables**: Patrón para lógica de negocio reutilizable
- **Axios**: Cliente HTTP para comunicación con backend
- **Bootstrap**: Framework CSS para estilos
- **AdminLTE**: Tema de administración

## Patrón de Arquitectura

### Composables

Los composables encapsulan la lógica de negocio y comunicación con el backend:

```javascript
// Ejemplo: UseCompany
import { UseCompany } from "@/composables/settings/company/UseCompany";

const { save, getCompany, loading } = UseCompany();
```

**Ubicación**: `src/composables/settings/{module}/`

**Estructura típica**:
- Estado reactivo (`loading`, `data`)
- Funciones de API (`get`, `save`, `update`, `delete`)
- Manejo de errores
- Retorno de funciones y estados

### Componentes

#### Componentes Reutilizables

- **Breadcumbs.vue**: Navegación de migas de pan
- **ImagePreviewComponent.vue**: Manejo de imágenes con preview
- **Modal.vue**: Modal reutilizable
- **Datatable.vue**: Tabla de datos

#### Componentes de Vista

- **index.vue**: Vista principal de cada módulo
- **modalSave.vue**: Modal para guardar/editar
- **example/**: Ejemplos de implementación

### Estructura de Módulos

Cada módulo de settings sigue la misma estructura:

```
settings/{module}/
├── index.vue          # Vista principal
├── modalSave.vue      # Modal de guardado
└── example/           # Ejemplos de implementación
    └── {Module}.js    # Implementación de referencia
```

## Configuración

### Variables de Entorno

```env
VITE_API_URL=http://localhost:8000/api
VITE_URL_PLACEHOLDER_IMAGE=/path/to/placeholder.png
VITE_URL_BACKEND_IMAGES=http://localhost:8000/storage/
```

### Axios Instance

Configuración centralizada para peticiones HTTP:

```javascript
// src/lib/utils/axiosInstance.js
import axios from 'axios';

const axiosInstance = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  headers: {
    'Content-Type': 'application/json',
  },
});

// Interceptors para autenticación y manejo de errores
```

## Módulos Implementados

### 1. Company (Empresa)

**Ubicación**: `src/views/settings/company/`

**Funcionalidades**:
- Configuración de información básica de empresa
- Manejo de logos (empresa y documentos)
- Validación de formularios
- Carga automática de datos existentes

**Composable**: `UseCompany`
**API Endpoints**: `/settings/company`, `/settings/company/save`

### 2. User (Usuario)

**Ubicación**: `src/views/settings/user/`

**Funcionalidades**:
- Gestión completa de usuarios
- CRUD de usuarios del sistema
- Asignación de roles

### 3. Role (Rol)

**Ubicación**: `src/views/settings/rol/`

**Funcionalidades**:
- Gestión de roles y permisos
- Asignación de permisos a roles

### 4. Places (Lugares)

**Ubicación**: `src/views/settings/places/`

**Funcionalidades**:
- Gestión de ubicaciones
- CRUD de lugares del sistema

### 5. Incidence Types (Tipos de Incidencia)

**Ubicación**: `src/views/settings/IncidenceTypes/`

**Funcionalidades**:
- Configuración de tipos de incidencias
- Categorización de incidencias

## Flujo de Datos

### 1. Carga de Componente
```
Componente Vue → onMounted → Composable.get() → API → Backend → Base de datos
```

### 2. Interacción del Usuario
```
Usuario interactúa → Estado reactivo actualizado → Validación en tiempo real
```

### 3. Envío de Datos
```
Validación → FormData → Composable.save() → API → Backend → Respuesta
```

### 4. Actualización de UI
```
Respuesta exitosa → Estado actualizado → UI reactiva → Feedback visual
```

## Validaciones

### Frontend
- Validación en tiempo real
- Mensajes de error específicos
- Estados visuales para campos inválidos
- Prevención de envío con errores

### Backend
- Validación de campos requeridos
- Validación de tipos de datos
- Validación de formatos
- Validación de archivos

## Manejo de Estados

### Estados Reactivos
- `loading`: Estado de carga para operaciones
- `data`: Datos del módulo
- `errors`: Errores de validación
- `formData`: Datos del formulario

### Estados de UI
- Botones deshabilitados durante operaciones
- Spinners de carga
- Mensajes de éxito/error
- Campos con estilos de error

## Componentes Reutilizables

### ImagePreviewComponent

**Props**:
- `image`: URL de la imagen
- `title`: Texto del botón
- `name`: Identificador único

**Eventos**:
- `@change`: Archivo seleccionado

**Funcionalidades**:
- Preview de imagen
- Selección de archivo
- Fallback a imagen placeholder

### Breadcumbs

**Props**:
- `module`: Array de módulos para navegación

**Funcionalidades**:
- Navegación jerárquica
- Estilo consistente

## Rutas

### Configuración Principal
```javascript
// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router';
import settingsRouter from './modules/settingsRouter';

const routes = [
  {
    path: '/settings',
    component: () => import('@/layouts/MainLayout.vue'),
    children: settingsRouter
  }
];
```

### Módulos de Settings
```javascript
// src/router/modules/settingsRouter.js
export default [
  {
    path: 'company',
    component: () => import('@/views/settings/company/index.vue')
  },
  // ... otros módulos
];
```

## Estilos y Temas

### Bootstrap
- Sistema de grid responsive
- Componentes de formulario
- Utilidades de espaciado y colores

### AdminLTE
- Tema de administración
- Sidebar y navegación
- Componentes de UI

### CSS Personalizado
- Estilos específicos de componentes
- Variables CSS para consistencia
- Responsive design

## Testing

### Estrategia
- Tests unitarios para composables
- Tests de componentes
- Tests de integración
- Tests de validación

### Herramientas
- Vitest para testing
- Vue Test Utils
- Testing Library

## Despliegue

### Build de Producción
```bash
npm run build
```

### Variables de Entorno
- Configurar URLs de producción
- Configurar endpoints de API
- Configurar recursos estáticos

### Optimizaciones
- Code splitting
- Lazy loading de componentes
- Compresión de assets
- Cache de recursos

## Mantenimiento

### Actualizaciones
- Mantener dependencias actualizadas
- Seguir cambios de Vue 3
- Actualizar composables según cambios de API
- Mantener consistencia en UI/UX

### Debugging
- Vue DevTools
- Console del navegador
- Network tab
- Estado de componentes

## Contribución

### Estándares de Código
- ESLint configurado
- Prettier para formateo
- Convenciones de nomenclatura
- Documentación de componentes

### Estructura de Commits
- Mensajes descriptivos
- Referencias a issues
- Separación de cambios lógicos

## Recursos Adicionales

### Documentación
- [Vue 3 Documentation](https://vuejs.org/)
- [Vue Router](https://router.vuejs.org/)
- [Composition API](https://vuejs.org/guide/extras/composition-api-faq.html)

### Backend
- [API Documentation](../documentation/API/)
- [Company API](../documentation/API/settings/Company.md)

### Herramientas
- Vue DevTools
- Postman/Insomnia
- Chrome DevTools
- VS Code con extensiones Vue

## Conclusión

El frontend de COARV2 implementa una arquitectura moderna y escalable con:

- **Vue 3**: Framework moderno con Composition API
- **Composables**: Lógica de negocio reutilizable
- **Componentes**: UI consistente y reutilizable
- **Estado Reactivo**: Gestión eficiente de datos
- **Validación**: Experiencia de usuario mejorada
- **Arquitectura**: Separación clara de responsabilidades

La implementación proporciona una base sólida para futuras expansiones y mantiene la consistencia en todo el sistema.
