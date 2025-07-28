<script setup>
    defineProps({
        items:{
            type: Array,
            required:true,
        }
    })

</script>
<template>
     <!-- Default box -->
      <div class="card" style="max-height: 80vh; overflow-y: auto;">
        <div class="card-body">

          <div class="table-responsive" style="max-height: 100%; overflow-y: auto;">
                 <table class="table table-sm">
            <thead>
            <tr>
              <th>ACCION</th>
              <th>NOMBRES</th>
              <th>Estado</th>
              
            </tr>
            </thead>
            <tbody>
              <tr v-for="role in response" :key="role.id" class="align-middle">
 
                <td>
                   <!-- Example split danger button -->
                  <div class="btn-group">
                    <button type="button" class="btn btn-light btn-sm" @click="editarUsuario(role)">Editar</button>
                    <button type="button" class="btn btn-light btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                      <span class="visually-hidden">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Suspender</a></li>
                      
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="#">Separated link</a></li>
                    </ul>
                  </div>
                </td>

                <td>{{ role.name}}</td>

                <td>
                   <span v-if="role.fl_no_view_dashboard == 0" class="badge text-bg-success"> Con dashboard </span>
                   <span v-else class="badge text-bg-warning"> sin Dashborad</span>
                  </td>
              </tr>


            </tbody>
          </table>

          </div>

       
        </div>
        <!-- /.card-body -->

        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
      <!--begin::Row-->
</template>
<style>
</style>