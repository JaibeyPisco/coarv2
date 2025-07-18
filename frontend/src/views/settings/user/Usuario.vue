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

  const editarUsuario = (usuario) => {
    modalRef.value?.openModal(usuario);
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
                   <!-- Example split danger button -->
                  <div class="btn-group">
                    <button type="button" class="btn btn-light btn-sm" @click="editarUsuario(user)">Editar</button>
                    <button type="button" class="btn btn-light btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                      <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Suspender</a></li>
                      
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="#">Separated link</a></li>
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
