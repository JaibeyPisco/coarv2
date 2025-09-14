<script setup>
import  { ref, watch } from "vue";
import { URL_PLACEHOLDER_IMAGE } from '@/lib/utils/config';


const emit = defineEmits(['change']);
 
const props = defineProps({
  image: {
    type: String,
   
  },
  title: {
    type: String,
    default: 'Seleccionar imagen'
  },
  name: {
    type: String, 
    required: true
  }
});

const previewUrl = ref('');
 

watch(() => props.image, (newValue) => {
  previewUrl.value = newValue || URL_PLACEHOLDER_IMAGE; // Si no hay imagen, usa la de placeholder
}, { immediate: true })

// watch(() => props.image, (valueImage) => {

//   if (valueImage) {
//     previewUrl.value = valueImage // Actualiza la vista previa con la nueva URL
//   } else {
//       previewUrl.value = URL_PLACEHOLDER_IMAGE
//   }
// })

const onfileChange = (event) => {

  const file = event.target.files[0];

  if (!file) return;

  const reader = new FileReader();

  reader.onload = (e) => {
    previewUrl.value = e.target.result  // // Para mostrar una vista previa
   
    emit('change', file );


  }

  reader.readAsDataURL(file);
}


console.log(previewUrl);


</script>

<template>
  <div class="mt-3">
   
    <img  v-if="previewUrl || props.image" :src="previewUrl" alt="Vista previa" class="img-preview" style="max-width:100%;" />
  </div>
  <div>
    <label class="btn btn-light w-100">
      <i class="fa fa-upload"></i> {{ props.title }}
      <input type="file" accept="image/*" @change="onfileChange" hidden name="props.name.value"   />
    </label>
  </div>
</template>

<style scoped>

</style>
