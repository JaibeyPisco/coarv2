<script setup>
import { onMounted, reactive, ref } from 'vue'

import ImagePreviewComponent from "@/components/ImagePreviewComponent.vue";
import axiosInstance from "@/lib/utils/axiosInstance.js";


const state = reactive({
  modal_open: null,
})
const  imageUserSelected = ref(null);

let formData = ref({
  name: '',
  surname: '',
  email: '',
  password: '',
  id_role: '1',
  user_type: 'STANDARD'
})

onMounted(() => {
  state.modal_open = new bootstrap.Modal('#modalUsuario', {})
})

function openModal() {
  state.modal_open.show()
}

function closeModal() {
  state.modal_open.hide()
}


const handleSubmit = async (e)=> {
    e.preventDefault();

    const payload = new FormData();

    payload.append('name', formData.value.name);
    payload.append('surname', formData.value.surname);
    payload.append('email', formData.value.email);
    payload.append('password', formData.value.password);
    payload.append('id_role', formData.value.id_role);
    payload.append('user_type', formData.value.user_type);

    if (imageUserSelected.value) {
      payload.append('photo', imageUserSelected.value);
    }

    try {

      const response = await  axiosInstance.post('/settings/user/register', payload, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      });

      console.log(response);

    }catch (e) {
      console.log(e)
    }

}

const handleChangeImage = (file) => {
  imageUserSelected.value = file;

}

defineExpose({
  openModal,
  closeModal,
})
</script>

<template>
  <div class="modal" tabindex="-1" id="modalUsuario">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form @submit.prevent="handleSubmit">
          <div class="modal-header">
            <h5 class="modal-title">Nuevo usuario</h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-4">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Tipo Persona</label>
                      <select  class="form-control form-control-sm" autocomplete="off"  v-model="formData.user_type">
                        <option value="STANDARD">USUARIO STANDARD</option>
                        <option value="DOCENTE">DOCENTE</option>
                        <option value="ESTUDIANTE">ESTUDIANTE</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-12" align="center">
                     <ImagePreviewComponent @change="handleChangeImage"/>
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="row">
                  <div class="col-md-12">
                    <label for="">Nombres</label>
                    <input type="text" class="form-control" v-model="formData.name" />
                  </div>
                  <div class="col-md-12">
                    <label for="">Apellidos</label>
                    <input type="text" class="form-control" v-model="formData.surname" />
                  </div>
                  <div class="col-md-12">
                    <label for="">Correo electronico</label>
                    <input type="email" class="form-control" v-model="formData.email" />
                  </div>
                  <div class="col-md-12">
                    <label for="">Contraseña</label>
                    <input type="text" class="form-control" v-model="formData.password" />
                  </div>
                  <div class="col-md-12">
                    <label for="">Rol y Permiso</label>
                    <select class="form-control" v-model="formData.id_role">
                        <option value="1">SUPER ADMINISTRADOR</option>
                        <option value="2">DOCENTE</option>
                        <option value="3">ESTUDIANTE</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer d-flex justify-content-between">
            <button type="button" class="btn btn-close-white btn-sm" data-bs-dismiss="modal">
              Cerrar
            </button>
            <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped></style>
