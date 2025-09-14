<script setup>
import { ref, computed, onMounted } from "vue";
import Breadcumbs from "@/components/Breadcumbs.vue";
import { URL_BACKEND_IMAGES, URL_PLACEHOLDER_IMAGE } from '@/lib/utils/config';
import ImagePreviewComponent from "@/components/ImagePreviewComponent.vue";
import { UseCompany } from "@/composables/settings/company/UseCompany";
import { showMessageNotification } from '@/lib/utils/Notification';

const { save, getCompany, loading } = UseCompany();

// Estado del formulario - usando nombres en inglés como el backend
const formData = ref({
  id: null,
  document_number: '',
  business_name: '',
  trade_name: '',
  address: '',
  phone: '',
  email: '',
  logo: '',
  logo_factura: ''
});

// Estado de las imágenes del formulario
const formDataFotos = ref({
  imagen: null,
  imagen_factura: null,
});

// Estado de las imágenes anteriores (para no re-subir si no han cambiado)
const previousImages = ref({
  logo: '',
  logo_factura: '',
});

// Estado de validación
const errors = ref({});

// Cargar datos de la empresa al montar el componente
onMounted(async () => {
  try {
    await loadCompanyData();
  } catch (error) {
    console.error('Error al cargar datos de la empresa:', error);
    showMessageNotification('Error al cargar datos de la empresa', 'error');
  }
});

// Función para cargar los datos de la empresa
const loadCompanyData = async () => {
  try {
    const data = await getCompany();
    
    // Mapear los datos del backend al formulario (nombres en inglés)
    formData.value = {
      id: data.id || null,
      document_number: data.numero_documento || '',
      business_name: data.razon_social || '',
      trade_name: data.nombre_comercial || '',
      address: data.direccion || '',
      phone: data.telefono || '',
      email: data.email || '',
      logo: data.logo || '',
      logo_factura: data.logo_factura || ''
    };

    // Guardar las imágenes anteriores para comparación
    previousImages.value = {
      logo: data.logo || '',
      logo_factura: data.logo_factura || ''
    };
  } catch (error) {
    console.error('Error al cargar datos:', error);
    showMessageNotification('Error al cargar datos de la empresa', 'error');
  }
};

// Validación del formulario
const validateForm = () => {
  errors.value = {};
  
  if (!formData.value.document_number) {
    errors.value.document_number = 'Número RUC es requerido';
  }
  if (!formData.value.business_name) {
    errors.value.business_name = 'Razón Social es requerida';
  }
  if (!formData.value.trade_name) {
    errors.value.trade_name = 'Nombre Comercial es requerido';
  }
  if (!formData.value.address) {
    errors.value.address = 'Dirección es requerida';
  }
  if (!formData.value.phone) {
    errors.value.phone = 'Teléfono es requerido';
  }
  if (!formData.value.email) {
    errors.value.email = 'Correo electrónico es requerido';
  }

  return Object.keys(errors.value).length === 0;
};

// Función para manejar el envío del formulario
const handleSubmit = async () => {
  if (!validateForm()) {
    showMessageNotification('Por favor, complete todos los campos requeridos', 'warning');
    return;
  }

  try {
    const data = new FormData();

    // Agregar los campos del formulario al FormData (nombres en español como espera el backend)
    data.append('numero_documento', formData.value.document_number);
    data.append('razon_social', formData.value.business_name);
    data.append('nombre_comercial', formData.value.trade_name);
    data.append('direccion', formData.value.address);
    data.append('telefono', formData.value.phone);
    data.append('email', formData.value.email);

    // Agregar las imágenes solo si han cambiado
    if (formDataFotos.value.imagen && formDataFotos.value.imagen !== previousImages.value.logo) {
      data.append('imagen', formDataFotos.value.imagen);
    }
    if (formDataFotos.value.imagen_factura && formDataFotos.value.imagen_factura !== previousImages.value.logo_factura) {
      data.append('imagen_factura', formDataFotos.value.imagen_factura);
    }

    const result = await save(data);
    
    // Debug: ver qué retorna el backend
    console.log('Respuesta del backend:', result);
    console.log('Estructura de result:', {
      hasData: !!result.data,
      dataKeys: result.data ? Object.keys(result.data) : 'No data',
      message: result.message,
      success: result.success
    });
    
    // Mostrar mensaje de éxito
    showMessageNotification(result.message || 'Empresa guardada exitosamente', 'success');
    
    // Limpiar las imágenes del formulario
    formDataFotos.value = {
      imagen: null,
      imagen_factura: null,
    };

    // Actualizar el formulario con la respuesta del backend
    if (result.data) {
      console.log('Actualizando formulario con:', result.data);
      formData.value = {
        id: result.data.id || null,
        document_number: result.data.numero_documento || '',
        business_name: result.data.razon_social || '',
        trade_name: result.data.nombre_comercial || '',
        address: result.data.direccion || '',
        phone: result.data.telefono || '',
        email: result.data.email || '',
        logo: result.data.logo || '',
        logo_factura: result.data.logo_factura || ''
      };

      // Actualizar las imágenes anteriores
      previousImages.value = {
        logo: result.data.logo || '',
        logo_factura: result.data.logo_factura || ''
      };
      
      console.log('Formulario actualizado:', formData.value);
    } else {
      console.log('No hay data en la respuesta, recargando datos...');
      // Si no hay data, recargar desde el backend
      await loadCompanyData();
    }
    
  } catch (error) {
    console.error('Error al guardar:', error);
    showMessageNotification('Error al guardar la empresa', 'error');
  }
};

// Función para manejar el cambio de imagen de la empresa
const handleImageCompanyChange = (file) => {
  formDataFotos.value.imagen = file;
};

// Función para manejar el cambio de imagen de documentos
const handleImageDocumentChange = (file) => {
  formDataFotos.value.imagen_factura = file;
};

// Computed para obtener la URL de la imagen de la empresa
const companyLogoUrl = computed(() => {
  if (formDataFotos.value.imagen) {
    return URL.createObjectURL(formDataFotos.value.imagen);
  }
  if (formData.value.logo) {
    // Si la URL ya incluye /storage, usarla directamente
    if (formData.value.logo.startsWith('/storage/')) {
      return formData.value.logo;
    }
    // Si no, construir la URL completa
    return `${URL_BACKEND_IMAGES}${formData.value.logo}`;
  }
  return URL_PLACEHOLDER_IMAGE;
});

// Computed para obtener la URL de la imagen de documentos
const documentLogoUrl = computed(() => {
  if (formDataFotos.value.imagen_factura) {
    return URL.createObjectURL(formDataFotos.value.imagen_factura);
  }
  if (formData.value.logo_factura) {
    // Si la URL ya incluye /storage, usarla directamente
    if (formData.value.logo_factura.startsWith('/storage/')) {
      return formData.value.logo_factura;
    }
    // Si no, construir la URL completa
    return `${URL_BACKEND_IMAGES}${formData.value.logo_factura}`;
  }
  return URL_PLACEHOLDER_IMAGE;
});
</script>

<template>
  <div v-if="loading" class="text-center p-5">
    <div class="spinner-border" role="status">
      <span class="visually-hidden">Cargando...</span>
    </div>
    <p class="mt-2">Cargando datos de la empresa...</p>
  </div>

  <div v-else>
    <Breadcumbs :module="['Configuración', 'Empresa']" />

    <!--begin::App Content-->
    <div class="app-content">
      <!--begin::Container-->
      <div class="container-fluid">
        <!--begin::Row-->
        <!-- Default box -->
        <div class="card">
          <form name="save" @submit.prevent="handleSubmit">
            <div class="card-body">
              <div class="row">
                <div class="col-md-3" align="center">
                  <div class="row">
                    <div class="col-md-12 mb-3" align="center">
                      <ImagePreviewComponent 
                        :image="companyLogoUrl" 
                        @change="handleImageCompanyChange" 
                        title="Examinar Logo"
                        name="companyLogo" 
                      />
                    </div>

                    <div class="col-md-12 mb-3" align="center">
                      <ImagePreviewComponent 
                        :image="documentLogoUrl" 
                        @change="handleImageDocumentChange"
                        title="Logo para documentos" 
                        name="documentLogo" 
                      />
                    </div>
                  </div>
                </div>
                <div class="col-md-9">
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group mb-3">
                        <label for="document_number" class="form-label">Número RUC <span class="text-red">(*)</span></label>
                        <div class="input-group">
                          <span class="input-group-text bg-transparent"><i class='bi bi-ticket-detailed-fill'></i></span>
                          <input 
                            id="document_number" 
                            v-model="formData.document_number" 
                            type="number"
                            name="document_number" 
                            class="form-control border-start-0 form-control-sm"
                            :class="{ 'is-invalid': errors.document_number }"
                            autocomplete="off"
                          >
                        </div>
                        <div v-if="errors.document_number" class="invalid-feedback d-block">
                          {{ errors.document_number }}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group">
                        <label for="business_name" class="form-label">Razón Social <span class="text-red">(*)</span></label>
                        <div class="input-group">
                          <span class="input-group-text bg-transparent"><i class='bi bi-building'></i></span>
                          <input 
                            id="business_name" 
                            type="text" 
                            name="business_name" 
                            v-model="formData.business_name"
                            class="form-control border-start-0 form-control-sm"
                            :class="{ 'is-invalid': errors.business_name }"
                            autocomplete="off"
                          >
                        </div>
                        <div v-if="errors.business_name" class="invalid-feedback d-block">
                          {{ errors.business_name }}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group mb-3">
                        <label for="trade_name" class="form-label">Nombre Comercial <span class="text-red">(*)</span></label>
                        <div class="input-group">
                          <span class="input-group-text bg-transparent"><i class='bi bi-buildings-fill'></i></span>
                          <input 
                            id="trade_name" 
                            type="text" 
                            name="trade_name" 
                            v-model="formData.trade_name"
                            class="form-control form-control-sm"
                            :class="{ 'is-invalid': errors.trade_name }"
                            autocomplete="off"
                          >
                        </div>
                        <div v-if="errors.trade_name" class="invalid-feedback d-block">
                          {{ errors.trade_name }}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group mb-3">
                        <label for="address" class="form-label">Dirección <span class="text-red">(*)</span></label>
                        <div class="input-group">
                          <span class="input-group-text bg-transparent"><i class='bi bi-geo-alt'></i></span>
                          <input 
                            id="address" 
                            type="text" 
                            name="address" 
                            class="form-control form-control-sm"
                            v-model="formData.address"
                            :class="{ 'is-invalid': errors.address }"
                            autocomplete="off"
                          >
                        </div>
                        <div v-if="errors.address" class="invalid-feedback d-block">
                          {{ errors.address }}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="phone" class="form-label">Teléfono <span class="text-red">(*)</span></label>
                        <div class="input-group">
                          <span class="input-group-text bg-transparent"><i class='bi bi-telephone-fill'></i></span>
                          <input 
                            id="phone" 
                            type="text" 
                            name="phone" 
                            data-minus="true" 
                            v-model="formData.phone"
                            class="form-control form-control-sm minus"
                            :class="{ 'is-invalid': errors.phone }"
                            autocomplete="off"
                          >
                        </div>
                        <div v-if="errors.phone" class="invalid-feedback d-block">
                          {{ errors.phone }}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="email" class="form-label">Correo electrónico <span class="text-red">(*)</span></label>
                        <div class="input-group">
                          <span class="input-group-text bg-transparent"><i class='bi bi-envelope-fill'></i></span>
                          <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            v-model="formData.email" 
                            data-minus="true"
                            class="form-control form-control-sm minus"
                            :class="{ 'is-invalid': errors.email }"
                            autocomplete="off"
                          >
                        </div>
                        <div v-if="errors.email" class="invalid-feedback d-block">
                          {{ errors.email }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer d-flex align-items-end justify-content-end">
              <button 
                type="submit" 
                class="btn btn-primary btn-primary-dark m-2 btn-sm"
                :disabled="loading"
              >
                <span v-if="loading" class="spinner-border spinner-border-sm me-2" role="status"></span>
                {{ loading ? 'Guardando...' : 'Guardar' }}
              </button>
            </div>
          </form>
        </div>
        <!-- /.card -->
        <!--begin::Row-->
      </div>
      <!--end::Container-->
    </div>
  </div>
</template>

<style scoped>
.is-invalid {
  border-color: #dc3545;
}

.invalid-feedback {
  display: block;
  color: #dc3545;
  font-size: 0.875em;
  margin-top: 0.25rem;
}
</style>