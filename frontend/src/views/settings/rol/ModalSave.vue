<script setup>
import { ref, reactive, onMounted } from 'vue'
import PermisoRow from './PermisoRow.vue'

const modalRef = ref(null)
const state = reactive({ modalInstance: null })

const rolData = ref({
  nombre: '',
  
  fl_no_dashboard: false,
  
})

const permisosSeleccionados = reactive({})

const secciones = {
  dashboard: [
    { menu: 'dashboard-general', title: 'Sistema General', items: ['view'] }
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
    { menu: 'configuracion-usuario', title: 'Usuarios', items: ['view', 'new', 'edit', 'delete'] }
  ],
  operacion: [
    { menu: 'operacion-nueva_incidencia', title: 'Nueva Incidencia', items: ['view', 'new'] },
    { menu: 'operacion-incidencias', title: 'Incidencias', items: ['view', 'edit', 'delete'] },
    { menu: 'operacion-derivacion', title: 'Derivaciones', items: ['view', 'edit'] },
    { menu: 'operacion-reporte_incidencia', title: 'Reporte incidencias', items: ['view', 'new', 'edit', 'delete'] }
  ],
  reportes: [
    { menu: 'reporte-movimiento_informacion', title: 'Movimiento de Información', items: ['view'] },
    { menu: 'reporte-incidencias', title: 'Incidencias', items: ['view'] }
  ]
}

const allSecciones = Object.values(secciones).flat()

function toggleAll(tipo, checked) {

  allSecciones.forEach(({ menu, items }) => {
  
    if (!permisosSeleccionados[menu]) permisosSeleccionados[menu] = {}
  
    if (items.includes(tipo)) {
  
      permisosSeleccionados[menu][tipo] = checked
    }
  })
}

function handleSubmit() {
  
  const data = new FormData();
  const permisos = []

  Object.entries(permisosSeleccionados).forEach(([menu, permiso]) => {
    if (permiso.view || permiso.new || permiso.edit || permiso.delete) {
      permisos.push({ menu, ...permiso })
    }
  })

  if (permisos.length === 0) {
    alert('Debe seleccionar al menos un permiso.')
    return
  }

  console.log(permisos);

  data.append('rol', rolData.value.nombre)
  data.append('fl_no_dashboard', rolData.value.fl_no_dashboard)
  data.append('permisos', JSON.stringify(permisos))

  alert('testing si funciona')
  console.log(data);
  
  
 
}

function openModal() {
  state.modalInstance?.show()
}
function closeModal() {
  state.modalInstance?.hide()
}
defineExpose({ openModal, closeModal })

onMounted(() => {
  state.modalInstance = new bootstrap.Modal(modalRef.value)
})
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
                <input type="text" class="form-control form-control-sm"  v-model="rolData.nombre"/>
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
                      <td class="text-center"><input type="checkbox" @change="e => toggleAll('view', e.target.checked)" /></td>
                      <td class="text-center"><input type="checkbox" @change="e => toggleAll('new', e.target.checked)" /></td>
                      <td class="text-center"><input type="checkbox" @change="e => toggleAll('edit', e.target.checked)" /></td>
                      <td class="text-center"><input type="checkbox" @change="e => toggleAll('delete', e.target.checked)" /></td>
                    </tr>

                    <tr><td class="font-weight-bold color-rol" colspan="5"><strong>DASHBOARD</strong></td></tr>
                    <PermisoRow
                      v-for="p in secciones.dashboard"
                      :key="p.menu"
                      v-bind="p"
                      :modelValue="permisosSeleccionados[p.menu] || {}"
                      @update:modelValue="val => permisosSeleccionados[p.menu] = val"
                    />

                    <tr><td class="font-weight-bold color-rol" colspan="5"><strong>CONFIGURACIÓN</strong></td></tr>
                    <PermisoRow
                      v-for="p in secciones.configuracion"
                      :key="p.menu"
                      v-bind="p"
                      :modelValue="permisosSeleccionados[p.menu] || {}"
                      @update:modelValue="val => permisosSeleccionados[p.menu] = val"
                    />

                    <tr><td class="font-weight-bold color-rol" colspan="5"><strong>OPERACIÓN</strong></td></tr>
                    <PermisoRow
                      v-for="p in secciones.operacion"
                      :key="p.menu"
                      v-bind="p"
                      :modelValue="permisosSeleccionados[p.menu] || {}"
                      @update:modelValue="val => permisosSeleccionados[p.menu] = val"
                    />

                    <tr><td class="font-weight-bold color-rol" colspan="5"><strong>REPORTES</strong></td></tr>

                    <PermisoRow
                      v-for="p in secciones.reportes"
                      :key="p.menu"
                      v-bind="p"
                      :modelValue="permisosSeleccionados[p.menu] || {}"
                      @update:modelValue="val => permisosSeleccionados[p.menu] = val"
                    />
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
