<script setup>
import { onMounted, reactive, ref } from 'vue';
import ImagePreviewComponent from '@/components/ImagePreviewComponent.vue';
import axiosInstance from '@/lib/utils/axiosInstance.js';
import { showMessageNotification } from '@/lib/utils/Notification';
import { URL_BACKEND_IMAGES, URL_PLACEHOLDER_IMAGE } from '@/lib/utils/config';

const modalRef = ref(null);
const uploadedImage = ref(null);

const DEFAULT_USER = {
  id: null,
  name: '',
  surname: '',
  email: '',
  password: '',
  id_role: '1',
  user_type: 'STANDARD',
  photo: '',
};

const form = ref({ ...DEFAULT_USER });

const state = reactive({
  modalInstance: null,
});

// Inicializar modal al montar componente
onMounted(() => {
  state.modalInstance = new bootstrap.Modal(modalRef.value);
});

// Exponer funciones al padre
defineExpose({
  openModal,
  closeModal,
});

function openModal(user = null) {
  resetForm();

  if (user) {
    loadUserData(user);
  }

  state.modalInstance?.show();
}

function closeModal() {
  state.modalInstance?.hide();
}

function loadUserData(user) {
  form.value = {
    id: user.id ?? null,
    name: user.name ?? '',
    surname: user.surname ?? '',
    email: user.email ?? '',
    password: '',
    id_role: user.id_role ?? '1',
    user_type: user.user_type ?? 'STANDARD',
    photo: user.photo ?? '',
  };

  uploadedImage.value = null;
}

function resetForm() {
  form.value = { ...DEFAULT_USER };
  uploadedImage.value = null;
}

function handleImageChange(file) {
  uploadedImage.value = file instanceof File ? file : null;
}

function buildFormData() {
  const data = new FormData();

  Object.entries(form.value).forEach(([key, value]) => {
    if (key !== 'photo') data.append(key, value);
  });

  if (uploadedImage.value instanceof File) {
    data.append('photo', uploadedImage.value);
  }

  return data;
}

async function handleSubmit(event) {
  event.preventDefault();

  try {
    const payload = buildFormData();

    const response = await axiosInstance.post(
      '/settings/user/register',
      payload,
      { headers: { 'Content-Type': 'multipart/form-data' } }
    );

    showMessageNotification(response.data.message, 'success');
    closeModal();
    resetForm();
  } catch (error) {
    const messages = error.response?.data?.data || ['Ocurrió un error inesperado'];
    showMessageNotification(messages, 'danger');
  }
}
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
                    :image="(form.value?.id != null ? URL_BACKEND_IMAGES + form.value.photo : URL_PLACEHOLDER_IMAGE)"
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
