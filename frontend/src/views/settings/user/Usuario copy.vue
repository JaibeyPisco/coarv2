<script setup>
import { ref, onMounted, nextTick } from 'vue'
import axiosInstance from '@/lib/utils/axiosInstance.js'
import ModalSave from '@/views/settings/user/ModalSave.vue'
import { showMessageNotification } from '@/lib/utils/Notification'
import { TabulatorFull as Tabulator } from 'tabulator-tables'
import 'tabulator-tables/dist/css/tabulator.min.css'
import * as XLSX from 'xlsx';
import Breadcumbs from "@/components/Breadcumbs.vue";

const users = ref([])
const modalRef = ref(null)
const usuarioSeleccionado = ref(null)
const modoModal = ref('nuevo')
const filtroTexto = ref('')
let tablaInstance = null

const cargarUsuarios = async () => {
  try {
    const { data } = await axiosInstance.get('settings/users')
    if (data.success) {
      users.value = data.data
    }
  } catch (error) {
    console.error('Error al cargar usuarios:', error)
    showMessageNotification('Error al cargar usuarios', 'danger')
  }
}

const filtrarTabla = () => {
  tablaInstance.setFilter([
    { field: 'name', type: 'like', value: filtroTexto.value },
    { field: 'surname', type: 'like', value: filtroTexto.value },
    { field: 'email', type: 'like', value: filtroTexto.value },
  ])
}

const renderizarTabla = async() => {
   await nextTick(() => {
  if (tablaInstance) {
    tablaInstance.setData(users.value)
    return
  }

  tablaInstance = new Tabulator("#tablaRef", {
    data: users.value,
    layout: 'fitColumns',
    pagination: true,  // Habilita la paginación
    paginationSize: 5, // Muestra 5 registros por página
    columns: [
      { title: 'ID', field: 'id', visible: false },
      { title: 'NOMBRES', field: 'name' },
      { title: 'APELLIDOS', field: 'surname' },
      { title: 'EMAIL', field: 'email' },
      { title: 'TIPO PERSONA', field: 'user_type' },
      { title: 'ROL', field: 'id_role' },
      {
        title: 'ESTADO',
        field: 'status',
        formatter: (cell) => {
          const status = cell.getValue()
          const clase = status === 'ACTIVO' ? 'success' : 'danger'
          return `<span class="badge bg-${clase}">${status}</span>`
        }
      },
      {
        title: 'ACCIONES',
        formatter: () => /*html*/`
          <div class="btn-group">
            <button type="button" class="btn btn-outline-primary btn-sm" name="editar" title="Editar rol">
              <i class="bi bi-pencil"></i> Editar
            </button>
            <button type="button" class="btn btn-outline-danger btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
              <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item text-danger" href="#" name="eliminar"><i class="bi bi-trash me-2"></i>Eliminar</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2"></i>Ver permisos</a></li>
            </ul>
          </div>
        `,
        cellClick: (e, cell) => {
          const row = cell.getRow().getData()
          const btnEditar = e.target.closest('button[name="editar"]');
          const btnEliminar = e.target.closest('a[name="eliminar"]');

          if (btnEditar) {
            editarUsuario(row)
          }
          if (btnEliminar) {
            eliminarUsuario(row)
          }
        }
      }
    ],
  })
   })

}

onMounted(async () => {
  await cargarUsuarios()
  renderizarTabla()
})

const handleClick = () => {
  usuarioSeleccionado.value = null
  modoModal.value = 'nuevo'
  modalRef.value?.openModal(null, 'nuevo')
}

const editarUsuario = (usuario) => {
  usuarioSeleccionado.value = { ...usuario }
  modoModal.value = 'editar'
  modalRef.value?.openModal(usuarioSeleccionado.value, 'editar')
}

const eliminarUsuario = async (usuario) => {
  if (confirm(`¿Estás seguro de que quieres eliminar a ${usuario.name} ${usuario.surname}?`)) {
    try {
      await axiosInstance.delete(`/settings/user/${usuario.id}`)
      showMessageNotification('Usuario eliminado correctamente', 'success')
      await cargarUsuarios()
      tablaInstance.setData(users.value)
    } catch (error) {
      console.error('Error al eliminar usuario:', error)
      showMessageNotification('Error al eliminar usuario', 'danger')
    }
  }
}

const onUsuarioGuardado = async () => {
  await cargarUsuarios()
  tablaInstance.setData(users.value)
}

const exportarExcel = () => {
  tablaInstance.download("xlsx", "usuarios.xlsx", { sheetName: "Usuarios" })
}
</script>

<template>
    <Breadcumbs
      :buttons="[{ label: 'Nuevo', class: 'btn-primary', action: 'new' }]"
      :module="['Configuración', 'Rol y permisos']"
      @button-click="handleClick"
    />
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            <div class="card" style="max-height: 80vh; overflow-y: auto;">
              <div class="card-body">
                <div class="row mb-3">
                  <div class="col-md-6">
                    <div class="d-flex align-items-center">
                      <button class="btn btn-success btn-sm ms-2" @click="exportarExcel">
                        <i class="bi bi-file-earmark-excel"></i> Exportar Excel
                      </button>
                      <button class="btn btn-outline-secondary btn-sm ms-2" type="button">
                        <i class="bi bi-printer"></i> Imprimir
                      </button>
                      <button class="btn btn-outline-secondary btn-sm ms-2" type="button">
                        <i class="bi bi-columns"></i> Mostrar Columnas
                      </button>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div id="DataTables_Table_0_filter" class="dataTables_filter d-flex justify-content-end">
                      <label class="d-flex align-items-center">
                        <i class="bi bi-search me-2"></i>
                        <input
                          v-model="filtroTexto"
                          @input="filtrarTabla"
                          class="form-control form-control-sm"
                          placeholder="Buscar por nombre, apellido o email..."
                        />
                      </label>
                    </div>
                  </div>
                </div>

                <!-- Tabla de Tabulator -->
                <div ref="tablaRef" class="tabulator-table"></div>
              </div>

              <div class="card-footer sticky-footer">
                <div class="d-flex justify-content-between">
                  <div class="dataTables_info" role="status" aria-live="polite">
                    Mostrando 1 a 3 de 3 registros
                  </div>
                  <div>
                    <!-- Puedes agregar más opciones aquí si deseas -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de Guardado -->
    <ModalSave ref="modalRef" :usuario="usuarioSeleccionado" :modo="modoModal" @saved="onUsuarioGuardado" />
</template>

<style scoped>
/* Mejora de la organización visual de los botones y el filtro */
.card-body {
  padding: 20px;
}

.d-flex {
  display: flex;
  align-items: center;
}

.ms-2 {
  margin-left: 0.5rem;
}

.btn {
  font-size: 0.9rem;
}

.tabulator-table {
  width: 100%;
  margin-top: 20px;
}

/* Estilo del footer fijo */
.sticky-footer {
  position: sticky;
  bottom: 0;
  background-color: #f8f9fa;
  box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
  padding: 10px 20px;
}

/* Estilo del campo de búsqueda */
.dataTables_filter label {
  font-size: 0.9rem;
  margin-bottom: 0;
  display: flex;
  align-items: center;
}

.dataTables_filter input {
  width: 200px;
}

.card-footer {
  padding-top: 0;
}

/* Estilo de los botones en la interfaz */
.btn-outline-secondary {
  border-color: #dee2e6;
  color: #6c757d;
}

.btn-outline-secondary:hover {
  color: #495057;
  background-color: #f8f9fa;
}

.badge {
  font-size: 0.75rem;
}

@media (max-width: 768px) {
  /* Asegurando que todo se ajuste bien en pantallas pequeñas */
  .dataTables_filter input {
    width: 100%;
  }
  .d-flex {
    flex-direction: column;
  }
  .card-body {
    padding: 15px;
  }
}
</style>
