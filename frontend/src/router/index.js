  import { createRouter, createWebHistory } from 'vue-router'
  import {useAuthStore} from "@/lib/authentication/auth.js";
  import settingsRouter from './modules/settingsRouter.js';

  const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
      {
        path: '/',
        component: () => import('../layouts/MainLayout.vue'),
        children: [
          {
            path: '',
            name: 'home',
            component: () => import('../views/HomeView.vue'),
            meta: { requiresAuth: true }
          },
          ...settingsRouter,
          // {
          //   path: '/configuracion/usuario',
          //   name: 'usuario',
          //   component: () => import('../views/settings/user/index.vue'),
          //   meta: { requiresAuth: true }
          // },
          // {
          //   path: '/configuracion/rol_permiso',
          //   name: 'rol_permiso',
          //   component: () => import('../views/settings/rol/index.vue'),
          //   meta: { requiresAuth: true }
          // }
          // ,{
          //   path: '/configuracion/lugares',
          //   name: 'lugares',
          //   component: () => import('../views/settings/places/index.vue'),
          //   meta: { requiresAuth: true }
          // }
          // ,{
          //   path: '/configuracion/tipos_incidencia',
          //   name: 'tipos_incidencia',
          //   component: () => import('../views/settings/IncidenceTypes/index.vue'),
          //   meta: { requiresAuth: true }
          // }
        ]
      },
      { 
        path: '/login',
        name: 'login',
        component: () => import('../views/autentication/Login.vue')
      }
    ]
  })

  router.beforeEach(async (to, from, next) => {
    
    const authStore = useAuthStore();


    if (!authStore.initialData) {
      await authStore.getInitialData();
    }

    const isAuthenticated = !!authStore.initialData;
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);

    // Redirige a home si ya está logueado y va a /login
    if (to.name === 'login' && isAuthenticated) {
      return next({ name: 'home' });
    }

    // Si requiere auth y no está logueado
    if (requiresAuth && !isAuthenticated) {
      return next({ name: 'login' });
    }

    next();
  });

  export default router
