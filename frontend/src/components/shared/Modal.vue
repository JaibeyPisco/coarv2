<script setup>
import { onMounted, ref } from 'vue';

    const props = defineProps({
        formData:{
            type: Object,
            required: true,
        },
        title: {
            type: String,
            default: 'Formulario'
        },
        modalSize: {
            type: String,
            default: 'modal-lg'
        }
    })

    const emits = defineEmits('guardado', 'cerrar');

    const modalRef = ref(null);
    const modalInstance = ref(null);

    onMounted(()=> {
        modalInstance.value = new bootstrap.Modal(modalRef.value);
    } );


    defineExpose({
        openModal,
        closeModal
    });

    const openModal = ()=> {
        modalInstance.value?.show();
    }

    const closeModal = ()=> {
        modalInstance.value?.hide();
    }

    const handleSubmit = (event) => {
        event.preventDefault();

        emits('guardado', props.formData);
        closeModal();
    }
</script>

<template>
  <div class="modal fade" tabindex="-1" ref="modalRef">
    <div class="modal-dialog {{ props.modalSize }}">
      <div class="modal-content">
        <form @submit.prevent="handleSubmit">
          <div class="modal-header">
            <h5 class="modal-title">{{ title }}</h5>
            <button type="button" class="btn-close" @click="cerrarModal" aria-label="Close"></button>
          </div>

          <div class="modal-body">
            <!-- Usar slots para personalizar el contenido del formulario -->
            <slot name="form-content"></slot>
          </div>

          <div class="modal-footer d-flex justify-content-between">
            <button type="button" class="btn btn-light btn-sm" @click="cerrarModal">Cancelar</button>
            <button type="submit" class="btn btn-primary btn-sm">
              <i class="bi bi-save me-1"></i>
              {{ props.formData.id ? 'Actualizar' : 'Guardar' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>