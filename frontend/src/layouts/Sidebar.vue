<script setup>
import MenuItem from '@/components/utils/MenuItem.vue';


</script>

<template>
  <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
      <!--begin::Brand Link-->
      <a href="./index.html" class="brand-link">
        <!--begin::Brand Image-->
        <img
          src="/assets/img/AdminLTELogo.png"
          alt="AdminLTE Logo"
          class="brand-image opacity-75 shadow"
        />
        <!--end::Brand Image-->
        <!--begin::Brand Text-->
        <span class="brand-text fw-light">AdminLTE 4</span>
        <!--end::Brand Text-->
      </a>
      <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
      <nav class="mt-2">
        <!--begin::Sidebar Menu-->
        <ul
          class="nav sidebar-menu flex-column"
          data-lte-toggle="treeview"
          role="menu"
          data-accordion="false"
        >
          <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon bi bi-speedometer"></i>
              <p>
                Configuración
                <i class="nav-arrow bi bi-chevron-right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
                  <MenuItem  to="/configuracion/usuario" icon="bi bi-cicle" label="Usuario" />
                  <MenuItem to="/configuracion/rol_permiso" icon="bi bi-cicle" label="Roles y permisos" />
            </ul>
          </li>
          <li class="nav-item">
            <a href="./generate/theme.html" class="nav-link">
              <i class="nav-icon bi bi-palette"></i>
              <p>Theme Generate</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon bi bi-box-seam-fill"></i>
              <p>
                Widgets
                <i class="nav-arrow bi bi-chevron-right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./widgets/small-box.html" class="nav-link">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Small Box</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./widgets/info-box.html" class="nav-link">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>info Box</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./widgets/cards.html" class="nav-link">
                  <i class="nav-icon bi bi-circle"></i>
                  <p>Cards</p>
                </a>
              </li>
            </ul>
          </li>




        </ul>
        <!--end::Sidebar Menu-->
      </nav>
    </div>
    <!--end::Sidebar Wrapper-->
  </aside>
</template>

<style scoped>

</style>
