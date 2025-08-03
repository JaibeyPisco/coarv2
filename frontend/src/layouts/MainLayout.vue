<script setup>
import { nextTick, onMounted } from "vue";
import LoaderStatic from "@/lib/utils/LoaderStatic.js";
import Header from "@/layouts/Header.vue";
import Sidebar from "@/layouts/Sidebar.vue";
import Footer from "@/layouts/Footer.vue";
import { useAuthStore } from "@/lib/authentication/auth.js";
import 'tabulator-tables/dist/css/tabulator.min.css'
import 'tabulator-tables/dist/css/tabulator_materialize.min.css'
import 'https://oss.sheetjs.com/sheetjs/xlsx.full.min.js'




const authStore = useAuthStore();

onMounted(() => {

  authStore.getInitialData();

  LoaderStatic.requireFiles([
    '/css/adminlte.css',
     '/js/adminlte.min.js',
      '/css/app.css',
  ],async function () 
  {

  
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
      <Header :initialData="authStore.initialData" />
      <!--end::Header-->
      <!--begin::Sidebar-->
      <Sidebar />
      <!--end::Sidebar-->
      <!--begin::App Main-->
      <main class="app-main">

        <router-view></router-view>
        <!--end::App Content-->
      </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <Footer />
      <!--end::Footer-->
    </div>



  </div>


</template>

<style scoped></style>
