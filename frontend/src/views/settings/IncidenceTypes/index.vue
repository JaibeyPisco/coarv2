

<script setup>
import { ref, computed } from "vue";
import Breadcumbs from "@/components/Breadcumbs.vue";
import ModalSave from "./ModalSave.vue";
import { showMessageNotification } from '@/lib/utils/Notification';
import { onMounted, onUnmounted } from "vue";
import { UseIncidenceTypes } from "@/composables/settings/incidenceTypes/UseIncidenceTypes";
 

const { getIncidenceTypes,
  //  deleteincidenceType, 
  refreshIncidenceTypes, 
  // 
  response, loading
  
  } = UseIncidenceTypes();

getIncidenceTypes();

const buttons = [
  { label: 'Nuevo', class: "btn-primary", action: 'new' }
];

const modalRef = ref(null);
const searchTerm = ref('');
const searchInputRef = ref(null);

// Atajo de teclado para enfocar el buscador
const handleKeydown = (event) => {
  if ((event.ctrlKey || event.metaKey) && event.key === 'f') {
    event.preventDefault();
    searchInputRef.value?.focus();
  }
};

// Agregar y remover event listener
onMounted(() => {
  document.addEventListener('keydown', handleKeydown);
});

onUnmounted(() => {
  document.removeEventListener('keydown', handleKeydown);
});

// Computed property para filtrar incidenceTypes
const filteredincidenceTypes = computed(() => {
  if (!searchTerm.value.trim()) return response.value;

  const term = searchTerm.value.toLowerCase().trim();

  return response.value.filter(incidenceType => {

 
    const textoBuscado = `
      ${incidenceType.name}
    
      ${incidenceType.description}
    `.toLowerCase();

    return textoBuscado.includes(term);
  });
});


const handleClick = () => {
  modalRef.value?.abrirModal();
};

const 
editincidenceType = (incidenceType) => {
  modalRef.value?.edit(incidenceType);
};

const eliminarincidenceType = async (incidenceType) => {
  if (confirm(`¿Estás seguro de que quieres eliminar el rol "${incidenceType.name}"?`)) {
    await deleteincidenceType(incidenceType.id);
  }
};

const handleSaved = (rolGuardado) => {
   
   if(rolGuardado){
    refreshIncidenceTypes()
   }
};
</script>

<template>
  <div v-if="loading" class="text-center p-5">
    <div class="spinner-border" incidenceType="status">
      <span class="visually-hidden">Cargando...</span>
    </div>
    <p class="mt-2">Cargando incidenceTypes...</p>
  </div>

  <div v-else>
    <ModalSave ref="modalRef" @guardado="handleSaved" />
    
    <Breadcumbs 
      :buttons="buttons" 
      :module="['Configuración', 'Tipos de incidencias']" 
      @button-click="handleClick"
    />

    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
      <!--begin::Container-->
      <div class="container-fluid">
        <!--begin::Row-->
        <!-- Default box -->
        <div class="card" style="max-height: 80vh; overflow-y: auto;">
          <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
              <h3 class="card-title"> </h3>
              <div class="d-flex align-items-center gap-3">
                <!-- Buscador -->
                <div class="input-group" style="width: 300px;">
                  <span class="input-group-text">
                    <i class="bi bi-search"></i>
                  </span>
                  <input 
                    type="text" 
                    class="form-control" 
                    incidenceTypeholder="Buscar por nombre  (Ctrl+F)"
                    v-model="searchTerm"
                    ref="searchInputRef"
                  />
                  <button 
                    v-if="searchTerm" 
                    class="btn btn-outline-secondary" 
                    type="button"
                    @click="searchTerm = ''"
                    title="Limpiar búsqueda"
                  >
                    <i class="bi bi-x"></i>
                  </button>
                </div>
                <!-- Contador de resultados -->
                
              </div>
            </div>
          </div>
          
          <div class="card-body">
            <div class="table-responsive" style="max-height: 100%; overflow-y: auto;">
              <table class="table table-striped table-hover">
                <thead class="table-dark">
                  <tr>
                    <th width="200">ACCIONES</th>
                    <th>NOMBRE</th>
                    <th>TIPO DE INCIDENCIA</th>
                   
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="incidenceType in filteredincidenceTypes" :key="incidenceType.id" class="align-middle">
                    <td>
                      <!-- Botones de acción -->
                      <div class="btn-group">
                        <button 
                          type="button" 
                          class="btn btn-light btn-sm" 
                          @click="
                          editincidenceType(incidenceType)"
                          title="Editar rol"
                        >
                          <i class="bi bi-pencil"></i> Editar
                        </button>
                        <button 
                          type="button" 
                          class="btn btn-light btn-sm dropdown-toggle dropdown-toggle-split" 
                          data-bs-toggle="dropdown" 
                          aria-expanded="false"
                        >
                          <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu">
                          <li>
                            <a class="dropdown-item text-danger" href="#" @click="eliminarincidenceType(incidenceType)">
                              <i class="bi bi-trash me-2"></i>Eliminar
                            </a>
                          </li>
                          <li><hr class="dropdown-divider"></li>
                          <li>
                            <a class="dropdown-item" href="#">
                              <i class="bi bi-eye me-2"></i>Ver permisos
                            </a>
                          </li>
                        </ul>
                      </div>
                    </td>

                    <td>
                      <strong>{{ incidenceType.name }}</strong>
                       
                    </td>

                    <td>
                      <td>
                      <span 
                        v-if="incidenceType.level == 'POSITIVO'" 
                        class="badge bg-success"
                      >
                        <i class="bi bi-check-circle me-1"></i> POSITIVO
                      </span>
                      <span 
                        v-else 
                        class="badge bg-danger"
                      >
                        <i class="bi bi-x-circle me-1"></i>NEGATIVO
                      </span>
                    </td>

                    </td>

                  </tr>
                  
                  <!-- Mensaje cuando no hay resultados -->
                  <tr v-if="searchTerm && filteredincidenceTypes.length === 0">
                    <td colspan="4" class="text-center py-4">
                      <div class="text-muted">
                        <i class="bi bi-search me-2"></i>
                        No se encontraron incidenceTypes que coincidan con "{{ searchTerm }}"
                      </div>
                      <button 
                        class="btn btn-outline-primary btn-sm mt-2"
                        @click="searchTerm = ''"
                      >
                        Limpiar búsqueda
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <!--begin::Row-->
      </div>
      <!--end::Container-->
    </div>
  </div>
</template>

<style scoped>
.app-content {
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

.dropdown-item {
  font-size: 0.875rem;
}

.dropdown-item i {
  width: 16px;
}

.table-responsive {
  border-radius: 0.375rem;
}

.card-header {
  background-color: #f8f9fa;
  border-bottom: 1px solid #dee2e6;
}

.card-tools {
  float: right;
}

.input-group {
  transition: all 0.3s ease;
}

.input-group:focus-within {
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.form-control:focus {
  border-color: #80bdff;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Animación para el mensaje de no resultados */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(-10px); }
  to { opacity: 1; transform: translateY(0); }
}

tr:last-child {
  animation: fadeIn 0.3s ease-in-out;
}

/* Estilo para resaltar el texto buscado */
.highlight {
  background-color: #fff3cd;
  padding: 2px 4px;
  border-radius: 3px;
}
</style>
