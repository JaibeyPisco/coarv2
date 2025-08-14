<script setup>
import { ref, watch, defineProps, defineEmits, onMounted, nextTick, reactive } from 'vue';
import axiosInstance from '@/lib/utils/axiosInstance.js';
import { showMessageNotification } from '@/lib/utils/Notification';

const props = defineProps({
  rol: Object,
  modo: String // 'nuevo' o 'editar'
});

const emit = defineEmits(['guardado']);

const modalRef = ref(null);
const modalInstance = ref(null);

// Estado del formulario
const formData = ref({
  id: null,
  name: '',
  level: '',
});

 
onMounted(() => {
  modalInstance.value = new bootstrap.Modal(modalRef.value);
});

// Exponer funciones al padre
defineExpose({
  abrirModal,
  edit,
  cerrarModal,
});

function abrirModal() {
  resetForm();
  modalInstance.value?.show();
}

async function edit(role) {
  resetForm();
  loadRolData(role);
  
  // Esperar a que Vue actualice la vista
  await nextTick();
  
  modalInstance.value?.show();
}

function cerrarModal() {
  modalInstance.value?.hide();
}

function loadRolData(place) {
 
  formData.value = {
    id: place.id,
    name: place.name,
    level: place.level,
  };

  // Primero resetear todos los permisos
  resetPermisos();
 
}

function resetPermisos() {
  // Resetear todos los permisos
  
}

function resetForm() {
  formData.value = {
    id: null,
    name: '',
    level: '',
  };

  resetPermisos();
}
 

async function handleSubmit(event) {
  event.preventDefault();
   
  try {
    const payload = new FormData();
    payload.append('name', formData.value.name);
    payload.append('level', formData.value.level);
  
    
    if (formData.value.id) {
      payload.append('id', formData.value.id);
      
    } 
 
    const response = await axiosInstance.post('/settings/incidence_types/save', payload);
    
    if (response.data.tipo === 'success') {
      showMessageNotification(response.data.mensaje, 'success');
      cerrarModal();
      
      // Pasar los datos del rol guardado para actualización local
      const incidence_type = {
        id: formData.value.id || response.data.id, // Si es nuevo, usar el ID del servidor
        name: formData.value.name,
        level: formData.value.level,
       
      };
      
      emit('guardado', incidence_type);
    } else {
      showMessageNotification(response.data.mensaje, 'danger');
    }
  } catch (error) {
    console.error('Error al guardar rol:', error);
    showMessageNotification('Error al guardar Tipo de incidencia', 'danger');
  }
}


</script>

<template>
  <div class="modal fade" id="modalRol" tabindex="-1" ref="modalRef">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <form @submit.prevent="handleSubmit">
          <div class="modal-header">
            <h5 class="modal-title">{{ formData.id ? 'Editar Tipo de incidencia' : 'Nuevo Tipo de incidencia' }}</h5>
            <button type="button" class="btn-close" @click="cerrarModal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group mb-3">
                  <label class="form-label">Nombre del Tipo de incidencia</label>
                  <input 
                    type="text" 
                    class="form-control form-control-sm" 
                    v-model="formData.name" 
                    required
                    placeholder="Ej: Administrador, Usuario, etc."
                  />
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group mb-3">
                   <label class="form-group-label" for="level">
                    Nivel de incidencia
                </label>
                   <select name="" v-model="formData.level" id="" class="form-control form-control-sm" :required="true">
                    <option>NEGATIVO</option>
                    <option>POSITIVO</option>
                   </select>
                 
                </div>
              </div>

              
            </div>
          </div>

          <div class="modal-footer d-flex justify-content-between">
            <button type="button" class="btn btn-light btn-sm" @click="cerrarModal">
              Cancelar
            </button>
            <!-- <button type="button" class="btn btn-warning" @click="debugPermisos">
              Debug
            </button> -->
            <button type="submit" class="btn btn-primary btn-sm">
              <i class="bi bi-save me-1"></i>
              {{ formData.id ? 'Actualizar' : 'Guardar' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped>
.tabla-permisos {
  font-size: 0.9rem;
}

.tabla-permisos th,
.tabla-permisos td {
  padding: 0.5rem;
  vertical-align: middle;
}

.tabla-permisos .table-secondary {
  background-color: #f8f9fa;
}

.form-check-input {
  margin: 0;
}

.modal-xl {
  max-width: 90%;
}

@media (max-width: 768px) {
  .modal-xl {
    max-width: 95%;
  }
  
  .tabla-permisos {
    font-size: 0.8rem;
  }
}
</style>
