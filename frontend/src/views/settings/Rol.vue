<script setup>
import { ref, onMounted } from 'vue';
import axiosInstance from '@/lib/utils/axiosInstance.js';
import ModalSave from '@/views/settings/rol/ModalSave.vue';
import { showMessageNotification } from '@/lib/utils/Notification';

const roles = ref([]);
const modalRef = ref(null);
const rolSeleccionado = ref(null);
const modoModal = ref('nuevo');

const cargarRoles = async () => {
  try {
    const { data } = await axiosInstance.get('settings/roles');
    roles.value = data;
  } catch (error) {
    console.error('Error al cargar roles:', error);
    showMessageNotification('Error al cargar roles', 'danger');
  }
};

onMounted(() => {
  cargarRoles();
});

const handleClick = () => {
  rolSeleccionado.value = null;
  modoModal.value = 'nuevo';
  modalRef.value?.openModal(null, 'nuevo');
};

const editarRol = (rol) => {
  rolSeleccionado.value = { ...rol };
  modoModal.value = 'editar';
  modalRef.value?.openModal(rolSeleccionado.value, 'editar');
};

const eliminarRol = async (rol) => {
  if (confirm(`¿Estás seguro de que quieres eliminar el rol "${rol.name}"?`)) {
    try {
      await axiosInstance.delete(`/settings/role/${rol.id}`);
      showMessageNotification('Rol eliminado correctamente', 'success');
      await cargarRoles();
    } catch (error) {
      console.error('Error al eliminar rol:', error);
      showMessageNotification('Error al eliminar rol', 'danger');
    }
  }
};

const onRolGuardado = () => {
  cargarRoles();
};
</script>

<template>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Roles y Permisos</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Configuración</a></li>
              <li class="breadcrumb-item active">Roles</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Gestión de Roles</h3>
                <div class="card-tools">
                  <button @click="handleClick" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i>Nuevo Rol
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-striped table-hover">
                    <thead class="table-dark">
                      <tr>
                        <th>ID</th>
                        <th>NOMBRE</th>
                        <th>OCULTAR DASHBOARD</th>
                        <th>PERMISOS</th>
                        <th width="150">ACCIONES</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="rol in roles" :key="rol.id">
                        <td>{{ rol.id }}</td>
                        <td>{{ rol.name }}</td>
                        <td>
                          <span :class="rol.fl_no_view_dashboard ? 'badge bg-danger' : 'badge bg-success'">
                            {{ rol.fl_no_view_dashboard ? 'Sí' : 'No' }}
                          </span>
                        </td>
                        <td>
                          <span class="badge bg-info">{{ rol.role_details?.length || 0 }} permisos</span>
                        </td>
                        <td>
                          <div class="btn-group">
                            <button class="btn btn-sm btn-outline-primary" @click="editarRol(rol)">
                              <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" @click="eliminarRol(rol)">
                              <i class="bi bi-trash"></i>
                            </button>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal para crear/editar roles -->
    <ModalSave
      ref="modalRef"
      :rol="rolSeleccionado"
      :modo="modoModal"
      @guardado="onRolGuardado"
    />
  </div>
</template>

<style scoped>
.content-wrapper {
  padding: 20px;
}

.table th {
  font-weight: 600;
  text-transform: uppercase;
  font-size: 0.8rem;
}

.btn-group .btn {
  margin-right: 2px;
}

.badge {
  font-size: 0.75rem;
}
</style> 