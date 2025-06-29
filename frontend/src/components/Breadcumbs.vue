<script setup>
 const  props = defineProps({
   buttons:{
     type: Array,
     required: true
   },
   module: {
     type: Array,
     required:true
   }

 })

 const emit = defineEmits(['button-click']);

 const handleClick = (action) => {
   emit('button-click', action)
 }

</script>

<template>
  <!--begin::App Content Header-->
  <div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-start">
            <li class="breadcrumb-item"><a href="#">{{ module[0]}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{module[1]}}</li>
          </ol>
        </div>
        <div class="col-sm-6">
          <div class="btn btn-group float-sm-end">

            <!--  Cargar botones-->
            <button v-for="(button, index) in props.buttons"
                    :key="index"
                    :class="['btn', 'btn-sm', button.class, 'px-3']"
                    @click="handleClick(button.action)"
            >
              {{button.label}}

            </button>

          </div>
        </div>
      </div>
      <!--end::Row-->
    </div>
    <!--end::Container-->
  </div>
</template>

<style scoped>

</style>
