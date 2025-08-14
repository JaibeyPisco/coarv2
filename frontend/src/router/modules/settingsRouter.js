const baseURL = '/configuracion/';
const baseUrlView = '../../views/settings/';

export default [
  {
    path: baseURL + 'usuario',
    name: 'usuario',
    component: () => import(baseUrlView + 'user/index.vue'),
    meta: { requiresAuth: true }
  },
    {
    path: baseURL + 'empresa',
    name: 'usuario',
    component: () => import(baseUrlView + 'company/index.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: baseURL + 'rol_permiso',
    name: 'rol_permiso',
    component: () => import(baseUrlView + 'rol/index.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: baseURL + 'lugares',
    name: 'lugares',
    component: () => import(baseUrlView + 'places/index.vue'),
    meta: { requiresAuth: true }
  },
  {
    path: baseURL + 'tipos_incidencia',
    name: 'tipos_incidencia',
    component: () => import(baseUrlView + 'IncidenceTypes/index.vue'),
    meta: { requiresAuth: true }
  }
];
