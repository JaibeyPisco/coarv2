<script setup>
import  {ref} from "vue";


const emit = defineEmits(['change']);


const placeHolderImage =import.meta.env.VITE_URL_PLACEHOLDER_IMAGE;
const previewUrl = ref(placeHolderImage);

console.log(placeHolderImage);


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

</script>

<template>
  <div class="mt-3">
    <img v-if="previewUrl" :src="previewUrl" alt="Vista previa" class="img-preview" style="max-width:100%;" />
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
