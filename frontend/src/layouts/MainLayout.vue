<script setup>
  import {onMounted} from "vue";
  import LoaderStatic from "@/lib/utils/LoaderStatic.js";
  import Header from "@/layouts/Header.vue";
  import Sidebar from "@/layouts/Sidebar.vue";
  import Footer from "@/layouts/Footer.vue";
  import {useAuthStore} from "@/lib/authentication/auth.js";

 


  const authStore = useAuthStore();

  onMounted( () => {

    authStore.getInitialData();

     LoaderStatic.requireFiles([
       'https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css',
       'https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css',
       'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
       '/css/adminlte.css',
       'https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css',
       'https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css',


       'https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js',
       'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js',
       'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js',
       '/js/adminlte.js',
       'https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js',
       'https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js',
       'https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js',
       'https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js'


     ], function () {

       const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
       const Default = {
         scrollbarTheme: 'os-theme-light',
         scrollbarAutoHide: 'leave',
         scrollbarClickScroll: true,
       };
       document.addEventListener('DOMContentLoaded', function () {
         const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
         if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
           OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
             scrollbars: {
               theme: Default.scrollbarTheme,
               autoHide: Default.scrollbarAutoHide,
               clickScroll: Default.scrollbarClickScroll,
             },
           });
         }
       });



     });



  })

  console.log()


</script>

<template>

  <!--end::Head-->
  <!--begin::Body-->
  <div class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
      <!--begin::Header-->
      <Header :initialData="authStore.initialData"/>
      <!--end::Header-->
      <!--begin::Sidebar-->
      <Sidebar/>
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">

        <router-view></router-view>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <Footer/>
      <!--end::Footer-->
    </div>



  </div>


</template>

<style scoped>

</style>
