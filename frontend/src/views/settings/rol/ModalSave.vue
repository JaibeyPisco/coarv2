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
  id_role: null,
  nombre: '',
  fl_no_dashboard: false,
});

// Configuración de módulos y permisos
const modulos = reactive({
  configuracion: {
    titulo: 'CONFIGURACIÓN',
    items: {
      'configuracion-usuario': { titulo: 'Usuarios', view: false, new: false, edit: false, delete: false },
      'configuracion-rol': { titulo: 'Roles y Permisos', view: false, new: false, edit: false, delete: false },
      'configuracion-empresa': { titulo: 'Empresa', view: false, new: false, edit: false, delete: false },
      'configuracion-area': { titulo: 'Áreas', view: false, new: false, edit: false, delete: false }
    }
  },
  operacion: {
    titulo: 'OPERACIÓN',
    items: {
      'operacion-nueva_incidencia': { titulo: 'Nueva Incidencia', view: false, new: false, edit: false, delete: false },
      'operacion-incidencias': { titulo: 'Incidencias', view: false, new: false, edit: false, delete: false },
      'operacion-derivacion': { titulo: 'Derivación', view: false, new: false, edit: false, delete: false }
    }
  },
  dashboard: {
    titulo: 'DASHBOARD',
    items: {
      'dashboard-general': { titulo: 'Dashboard General', view: false, new: false, edit: false, delete: false }
    }
  },
  
  reporte: {
    titulo: 'REPORTES',
    items: {
      'reporte-incidencias': { titulo: 'Reporte de Incidencias', view: false, new: false, edit: false, delete: false }
    }
  }
});
 
onMounted(() => {
  modalInstance.value = new bootstrap.Modal(modalRef.value);
});

// Exponer funciones al padre
defineExpose({
  abrirModal,
  editarRole,
  cerrarModal,
});

function abrirModal() {
  resetForm();
  modalInstance.value?.show();
}

async function editarRole(role) {
  resetForm();
  loadRolData(role);
  
  // Esperar a que Vue actualice la vista
  await nextTick();
  
  modalInstance.value?.show();
}

function cerrarModal() {
  modalInstance.value?.hide();
}

function loadRolData(rol) {
  console.log('=== LOAD ROL DATA ===');
  console.log('Tipo de rol recibido:', typeof rol);
  console.log('Rol completo:', rol);
  console.log('Es un objeto?', typeof rol === 'object');
  console.log('Tiene role_details?', rol && rol.role_details);
  console.log('role_details es array?', Array.isArray(rol?.role_details));
  
  formData.value = {
    id_role: rol.id,
    nombre: rol.name,
    fl_no_dashboard: rol.fl_no_view_dashboard === '1' || rol.fl_no_view_dashboard === true,
  };

  // Primero resetear todos los permisos
  resetPermisos();

  // Cargar permisos existentes
  if (rol.role_details && Array.isArray(rol.role_details)) {
    console.log('Permisos encontrados:', rol.role_details);
    
    rol.role_details.forEach(permiso => {
      console.log('Procesando permiso:', permiso);
      
      // Buscar el módulo y item correspondiente
      Object.keys(modulos).forEach(moduloKey => {
        const modulo = modulos[moduloKey];
        if (modulo.items[permiso.menu]) {
          console.log('Encontrado item:', permiso.menu);
          
          // Convertir strings "0"/"1" a booleanos
          const view = permiso.view === '1' || permiso.view === true || permiso.view === 1;
          const new_perm = permiso.new === '1' || permiso.new === true || permiso.new === 1;
          const edit = permiso.edit === '1' || permiso.edit === true || permiso.edit === 1;
          const delete_perm = permiso.delete === '1' || permiso.delete === true || permiso.delete === 1;
          
          // Actualizar los valores
          modulo.items[permiso.menu].view = view;
          modulo.items[permiso.menu].new = new_perm;
          modulo.items[permiso.menu].edit = edit;
          modulo.items[permiso.menu].delete = delete_perm;
          
          console.log('Permisos actualizados para', permiso.menu, ':', {
            view: view,
            new: new_perm,
            edit: edit,
            delete: delete_perm
          });
        } else {
          console.warn('Item no encontrado en la configuración:', permiso.menu);
        }
      });
    });
  }
}

function resetPermisos() {
  // Resetear todos los permisos
  Object.keys(modulos).forEach(moduloKey => {
    const modulo = modulos[moduloKey];
    Object.keys(modulo.items).forEach(itemKey => {
      modulo.items[itemKey].view = false;
      modulo.items[itemKey].new = false;
      modulo.items[itemKey].edit = false;
      modulo.items[itemKey].delete = false;
    });
  });
}

function resetForm() {
  formData.value = {
    id_role: null,
    nombre: '',
    fl_no_dashboard: false,
  };

  resetPermisos();
}

function selectAll(permiso) {
  const isChecked = event.target.checked;
  
  Object.keys(modulos).forEach(moduloKey => {
    const modulo = modulos[moduloKey];
    Object.keys(modulo.items).forEach(itemKey => {
      modulo.items[itemKey][permiso] = isChecked;
    });
  });
}

function buildPermisosPayload() {
  const permisos = [];
  
  Object.keys(modulos).forEach(moduloKey => {
    const modulo = modulos[moduloKey];
    Object.keys(modulo.items).forEach(itemKey => {
      const item = modulo.items[itemKey];
      if (item.view || item.new || item.edit || item.delete) {
        permisos.push({
          menu: itemKey,
          view: item.view ? '1' : '0',
          new: item.new ? '1' : '0',
          edit: item.edit ? '1' : '0',
          delete: item.delete ? '1' : '0',
        });
      }
    });
  });
  
  console.log('Payload de permisos construido:', permisos);
  return permisos;
}

function debugPermisos() {
  console.log('=== DEBUG PERMISOS ===');
  console.log('FormData:', formData.value);
  console.log('Módulos:', modulos);
  
  Object.keys(modulos).forEach(moduloKey => {
    const modulo = modulos[moduloKey];
    console.log(`Módulo ${moduloKey}:`, modulo.titulo);
    Object.keys(modulo.items).forEach(itemKey => {
      const item = modulo.items[itemKey];
      console.log(`  ${itemKey}:`, item);
    });
  });
}

async function handleSubmit(event) {
  event.preventDefault();
  
  const permisos = buildPermisosPayload();
  
  if (permisos.length === 0) {
    showMessageNotification('Debe seleccionar al menos un permiso', 'warning');
    return;
  }
  
  try {
    const payload = new FormData();
    payload.append('rol', formData.value.nombre);
    payload.append('fl_no_dashboard', formData.value.fl_no_dashboard ? '1' : '0');
    payload.append('permisos', JSON.stringify(permisos));
    
    if (formData.value.id_role) {
      payload.append('id_role', formData.value.id_role);
      console.log('Modo edición - ID del rol:', formData.value.id_role);
    } else {
      console.log('Modo creación - Nuevo rol');
    }
    
    // Debug: mostrar qué se está enviando
    console.log('=== PAYLOAD ENVIADO ===');
    console.log('Nombre del rol:', formData.value.nombre);
    console.log('ID del rol:', formData.value.id_role);
    console.log('Ocultar dashboard:', formData.value.fl_no_dashboard);
    console.log('Permisos:', permisos);
    
    const response = await axiosInstance.post('/settings/role/save', payload);
    
    if (response.data.tipo === 'success') {
      showMessageNotification(response.data.mensaje, 'success');
      cerrarModal();
      
      // Pasar los datos del rol guardado para actualización local
      const rolGuardado = {
        id: formData.value.id_role || response.data.role_id, // Si es nuevo, usar el ID del servidor
        name: formData.value.nombre,
        fl_no_view_dashboard: formData.value.fl_no_dashboard ? '1' : '0',
        role_details: permisos,
        updated_at: new Date().toISOString()
      };
      
      emit('guardado', rolGuardado);
    } else {
      showMessageNotification(response.data.mensaje, 'danger');
    }
  } catch (error) {
    console.error('Error al guardar rol:', error);
    showMessageNotification('Error al guardar rol', 'danger');
  }
}
</script>

<template>
  <div class="modal fade" id="modalRol" tabindex="-1" ref="modalRef">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form @submit.prevent="handleSubmit">
          <div class="modal-header">
            <h5 class="modal-title">{{ formData.id_role ? 'Editar Rol' : 'Nuevo Rol' }}</h5>
            <button type="button" class="btn-close" @click="cerrarModal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div class="row">
              <div class="col-md-8">
                <div class="form-group mb-3">
                  <label class="form-label">Nombre del Rol</label>
                  <input 
                    type="text" 
                    class="form-control form-control-sm" 
                    v-model="formData.nombre" 
                    required
                    placeholder="Ej: Administrador, Usuario, etc."
                  />
                </div>
              </div>
              <div class="col-md-4 d-flex align-items-end">
                <div class="form-check">
                  <input 
                    type="checkbox" 
                    class="form-check-input" 
                    id="fl_no_dashboard"
                    v-model="formData.fl_no_dashboard"
                  />
                  <label class="form-check-label" for="fl_no_dashboard">
                    Ocultar Dashboard
                </label>
                </div>
              </div>

              <div class="col-md-12">
                <h6 class="mb-3">Permisos del Rol</h6>
                <div class="table-responsive">
                  <table class="table table-sm table-bordered tabla-permisos">
                    <thead class="table-dark">
                      <tr>
                        <th style="width: 200px;">SECCIONES</th>
                        <th class="text-center" style="width: 80px;">
                          <input 
                            type="checkbox" 
                            @change="selectAll('view')"
                            title="Seleccionar todos"
                          />
                          VER
                        </th>
                        <th class="text-center" style="width: 80px;">
                          <input 
                            type="checkbox" 
                            @change="selectAll('new')"
                            title="Seleccionar todos"
                          />
                          CREAR
                        </th>
                        <th class="text-center" style="width: 80px;">
                          <input 
                            type="checkbox" 
                            @change="selectAll('edit')"
                            title="Seleccionar todos"
                          />
                          EDITAR
                        </th>
                        <th class="text-center" style="width: 80px;">
                          <input 
                            type="checkbox" 
                            @change="selectAll('delete')"
                            title="Seleccionar todos"
                          />
                          ELIMINAR
                        </th>
                    </tr>
                  </thead>
                  <tbody>
                      <template v-for="(modulo, moduloKey) in modulos" :key="moduloKey">
                        <tr class="table-secondary">
                          <td colspan="5" class="fw-bold">
                            <i class="bi bi-folder me-2"></i>{{ modulo.titulo }}
                          </td>
                        </tr>
                        <tr 
                          v-for="(item, itemKey) in modulo.items" 
                          :key="itemKey"
                          :data-menu="itemKey"
                        >
                          <td class="ps-4">
                            <i class="bi bi-file-text me-2"></i>{{ item.titulo }}
                          </td>
                          <td class="text-center">
                            <input 
                              type="checkbox" 
                              v-model="item.view"
                              class="form-check-input"
                            />
                          </td>
                          <td class="text-center">
                            <input 
                              type="checkbox" 
                              v-model="item.new"
                              class="form-check-input"
                            />
                          </td>
                          <td class="text-center">
                            <input 
                              type="checkbox" 
                              v-model="item.edit"
                              class="form-check-input"
                            />
                          </td>
                          <td class="text-center">
                            <input 
                              type="checkbox" 
                              v-model="item.delete"
                              class="form-check-input"
                            />
                          </td>
                    </tr>
                      </template>
                  </tbody>
                </table>
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
            <button type="submit" class="btn btn-success btn-sm">
              <i class="bi bi-save me-1"></i>
              {{ formData.id_role ? 'Actualizar' : 'Guardar' }}
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
