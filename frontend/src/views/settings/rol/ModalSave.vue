<script setup>
import { onMounted, reactive, ref } from 'vue';

    const modalRef = ref(null)

        const state = reactive(
        {modalInstance: null}
    )

    function handleClick(e) {
        alert('here');
    }

    function openModal(user =  null) {
        state.modalInstance?.show();
    }

    function closeModal() {
        state.modalInstance?.hide()
    }

    defineExpose({
        openModal, closeModal
    })

onMounted(()=>{
    state.modalInstance =  new bootstrap.Modal(modalRef.value);
}) 
</script>
<template>
  <div class="modal fade" id="modalUsuario" tabindex="-1" ref="modalRef">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form @submit="handleSubmit">
          <div class="modal-header">
            <h5 class="modal-title">Nuevo usuario</h5>
            <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div class="row">
              <!-- Columna Izquierda -->
              <div class="col-md-4">
                <div class="form-group mb-3">
                  <label>Tipo Persona</label>
                  <select class="form-control form-control-sm" v-model="form.user_type">
                    <option value="STANDARD">USUARIO STANDARD</option>
                    <option value="DOCENTE">DOCENTE</option>
                    <option value="ESTUDIANTE">ESTUDIANTE</option>
                  </select>
                </div>
                <div class="text-center">
                  <ImagePreviewComponent
                    :image="form.photo ?? ''"
                    @change="handleImageChange"
                  />
                </div>
              </div>

              <!-- Columna Derecha -->
              <div class="col-md-8">
                <div class="mb-2">
                  <label>Nombres</label>
                  <input type="text" class="form-control" v-model="form.name" />
                </div>
                <div class="mb-2">
                  <label>Apellidos</label>
                  <input type="text" class="form-control" v-model="form.surname" />
                </div>
                <div class="mb-2">
                  <label>Correo electrónico</label>
                  <input type="email" class="form-control" v-model="form.email" />
                </div>
                <div class="mb-2">
                  <label>Contraseña</label>
                  <input
                    type="password"
                    class="form-control"
                    v-model="form.password"
                    :disabled="form.id !== null"
                  />
                </div>
                <div class="mb-2">
                  <label>Rol y Permiso</label>
                  <select class="form-control" v-model="form.id_role">
                    <option value="1">SUPER ADMINISTRADOR</option>
                    <option value="2">DOCENTE</option>
                    <option value="3">ESTUDIANTE</option>
                  </select>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer d-flex justify-content-between">
            <button type="button" class="btn btn-light btn-sm" @click="closeModal">Cerrar</button>
            <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>
