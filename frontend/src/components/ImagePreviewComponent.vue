<script setup>
import  { ref, watch } from "vue";
import { URL_BACKEND_IMAGES, URL_PLACEHOLDER_IMAGE } from '@/lib/utils/config';


const emit = defineEmits(['change']);


const props = defineProps({
  image: {
    type: String,
    default: URL_PLACEHOLDER_IMAGE
  }
});

const previewUrl = ref(URL_PLACEHOLDER_IMAGE);
 

const onfileChange = (event) => {

  const file = event.target.files[0];

  if (!file) return;

  const reader = new FileReader();

  reader.onload = (e) => {
    previewUrl.value = e.target.result
    emit('change', file);
  }

  reader.readAsDataURL(file);
}

watch(() => props.image, (valueImage) => {
  if (valueImage) {
    previewUrl.value = ''
  } else {
      previewUrl.value = URL_PLACEHOLDER_IMAGE
  }
})

</script>

<template>
  <div class="mt-3">
    {{ previewUrl }}
    <img  v-if="previewUrl || props.image" :src="previewUrl || URL_BACKEND_IMAGES+'/'+props.image" alt="Vista previa" class="img-preview" style="max-width:100%;" />
  </div>
  <div>
    <label class="btn btn-light w-100">
      <i class="fa fa-upload"></i> Seleccionar imagen
      <input type="file" accept="image/*" @change="onfileChange" hidden />
    </label>
  </div>
</template>

<style scoped>

</style>
