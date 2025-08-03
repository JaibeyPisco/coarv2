<script setup>
import { ref, reactive, onMounted } from 'vue'
import PermisoRow from './PermisoRow.vue'
import { Usesave } from '@/composables/settings/rol/UseSave'

const modalRef = ref(null)
const state = reactive({ modalInstance: null })
const { save, loading, response } = Usesave()
const emits = defineEmits(['saved'])

const rolData = ref({
  nombre: '',
  id_role: null,
  fl_no_dashboard: false,
})

const permisosSeleccionados = reactive({})

const secciones = {
  dashboard: [
    { menu: 'dashboard-general', title: 'Sistema General', items: ['view'] },
  ],
  configuracion: [
    { menu: 'configuracion-empresa', title: 'Empresa', items: ['view', 'new', 'edit'] },
    { menu: 'configuracion-area', title: 'Áreas', items: ['view', 'new', 'edit', 'delete'] },
    { menu: 'configuracion-lugar', title: 'Lugares', items: ['view', 'new', 'edit', 'delete'] },
    { menu: 'configuracion-tipos_incidencia', title: 'Tipos de incidencias', items: ['view', 'new', 'edit', 'delete'] },
    { menu: 'configuracion-estado_monitoreo', title: 'Estados de Monitoreo', items: ['view', 'new', 'edit', 'delete'] },
    { menu: 'configuracion-tipo_personal', title: 'Tipos de Personal', items: ['view', 'new', 'edit', 'delete'] },
    { menu: 'configuracion-rol', title: 'Roles y Permisos', items: ['view', 'new', 'edit', 'delete'] },
    { menu: 'configuracion-personal', title: 'Personales', items: ['view', 'new', 'edit', 'delete'] },
    { menu: 'configuracion-proveedor', title: 'Proveedores', items: ['view', 'new', 'edit', 'delete'] },
    { menu: 'configuracion-estudiante', title: 'Estudiante', items: ['view', 'new', 'edit', 'delete'] },
    { menu: 'configuracion-usuario', title: 'Usuarios', items: ['view', 'new', 'edit', 'delete'] },
  ],
  operacion: [
    { menu: 'operacion-nueva_incidencia', title: 'Nueva Incidencia', items: ['view', 'new'] },
    { menu: 'operacion-incidencias', title: 'Incidencias', items: ['view', 'edit', 'delete'] },
    { menu: 'operacion-derivacion', title: 'Derivaciones', items: ['view', 'edit'] },
    { menu: 'operacion-reporte_incidencia', title: 'Reporte incidencias', items: ['view', 'new', 'edit', 'delete'] },
  ],
  reportes: [
    { menu: 'reporte-movimiento_informacion', title: 'Movimiento de Información', items: ['view'] },
    { menu: 'reporte-incidencias', title: 'Incidencias', items: ['view'] },
  ],
}

const allSecciones = Object.values(secciones).flat()

function toggleAll(tipo, checked) {

  allSecciones.forEach(({ menu, items }) => {
    if (!permisosSeleccionados[menu]) permisosSeleccionados[menu] = {}
    if (items.includes(tipo)) permisosSeleccionados[menu][tipo] = checked
  })
}

// function construirPermisos() {

//   return Object.entries(permisosSeleccionados)
//     .filter(([_, permisos]) => permisos.view || permisos.new || permisos.edit || permisos.delete)
//     .map(([menu, permisos]) => ({ menu, ...permisos }))
// }

// function cargarPermisosDesdeRol(roleDetails) {

//   Object.keys(permisosSeleccionados).forEach(key => delete permisosSeleccionados[key])

//   roleDetails?.forEach(p => {
//     if (!permisosSeleccionados[p.menu]) permisosSeleccionados[p.menu] = {}
//     for (const tipo of ['view', 'new', 'edit', 'delete']) {
//       if (p[tipo] !== undefined) permisosSeleccionados[p.menu][tipo] = !!p[tipo]
//     }
//   })
// }

async function handleSubmit() {
  const permisos = construirPermisos()

  if (permisos.length === 0) {
    alert('Debe seleccionar al menos un permiso.')
    return
  }

  // const data = new FormData()

  // if (rolData.value.id_role) data.append('id_role', rolData.value.id_role)

  // data.append('rol', rolData.value.nombre)
  // data.append('fl_no_dashboard', rolData.value.fl_no_dashboard)
  // data.append('permisos', JSON.stringify(permisos))

    await  save(new FormData())

  if (response.value.tipo === 'success') {
    closeModal()
    emits('saved')
  }
}

function openModal() {
  resetForm()
  state.modalInstance?.show()
}

function editarRole(role) {

  rolData.value = {
    nombre: role.name,
    id_role: role.id,
    fl_no_dashboard: parseInt(role.fl_no_view_dashboard) === 1,
  }

  //cargarPermisosDesdeRol(role.role_details)
  state.modalInstance?.show()
}


function closeModal() {
  // if (state.modalInstance) {
    state.modalInstance.hide()
  // }

//   // 🔧 Forzar cierre manual por seguridad (fallback)
//   const modalEl = modalRef.value
//   if (modalEl) {
//     modalEl.classList.remove('show')
//     modalEl.style.display = 'none'
//     document.body.classList.remove('modal-open')
//     document.body.style = ''
//     const backdrop = document.querySelector('.modal-backdrop')
//     if (backdrop) backdrop.remove()
//   }
// }

// function resetForm() {
//   rolData.value = {
//     nombre: '',
//     id_role: null,
//     fl_no_dashboard: false,
//   }
//   Object.keys(permisosSeleccionados).forEach(key => delete permisosSeleccionados[key])
// }

onMounted(() => {
  state.modalInstance = new bootstrap.Modal(modalRef.value)
  
})

defineExpose({ openModal, closeModal, editarRole })
</script>


<template>
  <div class="modal fade" id="modalUsuario" tabindex="-1" ref="modalRef">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form @submit.prevent="handleSubmit">
          <div class="modal-header">
            <h5 class="modal-title">Nuevo usuario</h5>
            <button type="button" class="btn-close" @click="closeModal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <div class="row">
              <div class="col-md-8">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control form-control-sm" v-model="rolData.nombre" />
              </div>
              <div class="col-md-4 d-flex align-items-end">
                <label class="form-label w-100">
                  <input type="checkbox" name="fl_no_dashboard" v-model="rolData.fl_no_dashboard" /> Ocultar Dashboard
                </label>
              </div>

              <div class="col-md-12 mt-3">
                <table class="table tabla_permiso">
                  <thead>
                    <tr>
                      <th>SECCIONES</th>
                      <th class="text-center" style="width:80px;">VER</th>
                      <th class="text-center" style="width:80px;">CREAR</th>
                      <th class="text-center" style="width:80px;">EDITAR</th>
                      <th class="text-center" style="width:80px;">ELIMINAR</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="font-weight-bold"></td>
                      <td class="text-center"><input type="checkbox"
                          @change="e => toggleAll('view', e.target.checked)" /></td>
                      <td class="text-center"><input type="checkbox"
                          @change="e => toggleAll('new', e.target.checked)" /></td>
                      <td class="text-center"><input type="checkbox"
                          @change="e => toggleAll('edit', e.target.checked)" /></td>
                      <td class="text-center"><input type="checkbox"
                          @change="e => toggleAll('delete', e.target.checked)" /></td>
                    </tr>

                    <!-- <tr>
                      <td class="font-weight-bold color-rol" colspan="5"><strong>DASHBOARD</strong></td>
                    </tr> -->

                    <tr>
                      <td class="font-weight-bold color-rol" colspan="5"><strong>CONFIGURACIÓN</strong></td>
                    </tr>

                       <tr data-menu="configuracion-usuario">
                          <td>Usuarios</td>
                          <td class="text-center"><input type="checkbox" name="view"></td>
                          <td class="text-center"><input type="checkbox" name="new"></td>
                          <td class="text-center"><input type="checkbox" name="edit"></td>
                          <td class="text-center"><input type="checkbox" name="delete"></td>
                      </tr>

                       <tr data-menu="configuracion-rol">
                        <td>Roles y Permisos</td>
                        <td class="text-center"><input type="checkbox" name="view"></td>
                        <td class="text-center"><input type="checkbox" name="new"></td>
                        <td class="text-center"><input type="checkbox" name="edit"></td>
                        <td class="text-center"><input type="checkbox" name="delete"></td>
                    </tr>
                                      

                    <!-- <PermisoRow v-for="p in secciones.dashboard" :key="p.menu" v-bind="p"
                      :modelValue="permisosSeleccionados[p.menu] || {}"
                      @update:modelValue="val => permisosSeleccionados[p.menu] = val" />

                    
                    <PermisoRow v-for="p in secciones.configuracion" :key="p.menu" v-bind="p"
                      :modelValue="permisosSeleccionados[p.menu] || {}"
                      @update:modelValue="val => permisosSeleccionados[p.menu] = val" />

                    <tr>
                      <td class="font-weight-bold color-rol" colspan="5"><strong>OPERACIÓN</strong></td>
                    </tr>
                    <PermisoRow v-for="p in secciones.operacion" :key="p.menu" v-bind="p"
                      :modelValue="permisosSeleccionados[p.menu] || {}"
                      @update:modelValue="val => permisosSeleccionados[p.menu] = val" />

                    <tr>
                      <td class="font-weight-bold color-rol" colspan="5"><strong>REPORTES</strong></td>
                    </tr>

                    <PermisoRow v-for="p in secciones.reportes" :key="p.menu" v-bind="p"
                      :modelValue="permisosSeleccionados[p.menu] || {}"
                      @update:modelValue="val => permisosSeleccionados[p.menu] = val" />
                   -->
                      </tbody>
                </table>
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
