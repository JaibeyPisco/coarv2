<script setup>
  import axiosInstance from "@/lib/utils/axiosInstance.js";
  import {onMounted, ref} from "vue";
  import Breadcumbs from "@/components/Breadcumbs.vue";
  import ModalSave from "@/views/settings/user/ModalSave.vue";

  let users = ref(null);

  onMounted( async ()=>{

    const {data} = await axiosInstance.get('settings/users')

    if(data.success){
      users.value = data.data;
    }


  })

 const buttons = [
     {label: 'Nuevo', class:"btn-primary", action:'new'}
 ]
  const modalRef = ref(null);
  const handleClick = () => {
      modalRef.value?.openModal();
  }

</script>

<template>

  <ModalSave ref="modalRef"/>
  <Breadcumbs :buttons="buttons" :module="['Configuración', 'Usuario']"  @button-click="handleClick"></Breadcumbs>

  <!--end::App Content Header-->
  <!--begin::App Content-->
  <div class="app-content">

    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <!-- Default box -->
      <div class="card" style="height: 80vh">
        <div class="card-body">

          <table class="table table-sm">
            <thead>
            <tr>
              <th>NOMBRES</th>
              <th>APELLIDOS</th>
              <th >EMAIL</th>
              <th >TIPO PERSONA</th>
              <th >ROL Y PERMISO</th>
              <th >ACCIONES</th>
            </tr>
            </thead>
            <tbody>

              <tr v-for="user in users" :key="users.id" class="align-middle">
                <td>{{user.name}}</td>
               <td> {{user.surname}}</td>

                <td>{{user.email}}</td>
                <td>PERSONAL</td>
                <td>DOCENTE</td>
                <td>
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"  ref="dropdownBtn">
                      Dropdown button
                    </button>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </div>
                </td>
              </tr>


            </tbody>
          </table>

        </div>
        <!-- /.card-body -->

        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
      <!--begin::Row-->

    </div>
    <!--end::Container-->
  </div>

</template>

<style scoped>

</style>
