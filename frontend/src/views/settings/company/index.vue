<script setup>
import { ref, computed } from "vue";
import Breadcumbs from "@/components/Breadcumbs.vue";
import { URL_BACKEND_IMAGES } from '@/lib/utils/config';

import ImagePreviewComponent from "@/components/ImagePreviewComponent.vue";


const formData = ref({
  id: null,
  document_number: '',
  business_name: '',
  trade_name: '',
  address: '',
  phone: '',
  email: '',
  company_logo: '',
  document_logo: ''
});

const formDataFotos = ref({
  company_logo: '',
  document_logo: '',
})


const handleSubmit = () => {
  const formData = new FormData();

  // Agregar los campos del formulario al FormData
  data.append('document_number', formData.value.document_number);
  data.append('business_name', formData.value.business_name);
  data.append('trade_name', formData.value.trade_name);
  data.append('address', formData.value.address);
  data.append('phone', formData.value.phone);
  data.append('email', formData.value.email);

    // Agregar los archivos (si existen) al FormData
  if (formDataFotos.value.company_logo) {
    data.append('company_logo', formDataFotos.value.company_logo);
  }

  if (formDataFotos.value.document_logo) {
    data.append('document_logo', formDataFotos.value.document_logo);
  }


}

const handleImageCompanyChange = (file) => {
  formDataFotos.value.company_logo = file;
  console.log({ company: formDataFotos });
}

const handleImageDocumentChange = (file) => {

  formDataFotos.value.document_logo = file;

}



</script>

<template>
  <!-- <div v-if="loading" class="text-center p-5">
    <div class="spinner-border" incidenceType="status">
      <span class="visually-hidden">Cargando...</span>
    </div>
    <p class="mt-2">Cargando incidenceTypes...</p>
  </div>

  <div v-else> -->
  <!-- <ModalSave ref="modalRef" @guardado="handleSaved" /> -->

  <Breadcumbs :module="['Configuración', 'Empresa']" />

  <!--end::App Content Header-->
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
                    <ImagePreviewComponent :image="''" @change="handleImageCompanyChange" :title="'Examinar Logo'"
                      :name="'companyLogo'" />
                  </div>

                  <div class="col-md-12 mb-3" align="center">
                    <ImagePreviewComponent :image="formData.document_logo" @change="handleImageDocumentChange"
                      :title="'Logo para documentos'" :name="'documentLogo'" />
                  </div>
                </div>
              </div>
              <div class="col-md-9">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group mb-3">
                      <label for="numero_documento" class="form-label">Número RUC <span
                          class="text-red">(*)</span></label>
                      <div class="input-group"> <span class="input-group-text bg-transparent"><i
                            class='bi bi-ticket-detailed-fill'></i></span>
                        <input id="numero_documento" v-model="formData.document_number" type="number"
                          name="numero_documento" class="form-control border-start-0 form-control-sm"
                          autocomplete="off">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="form-group">
                      <label for="razon_social" class="form-label">Razón Social <span
                          class="text-red">(*)</span></label>
                      <div class="input-group"> <span class="input-group-text bg-transparent"><i
                            class='bi bi-building'></i></span>
                        <input id="razon_social" type="text" name="razon_social" v-model="formData.business_name"
                          class="form-control border-start-0 form-control-sm" autocomplete="off">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group mb-3">
                      <label for="nombre_comercial" class="form-label">Nombre Comercial <span
                          class="text-red">(*)</span></label>
                      <div class="input-group"> <span class="input-group-text bg-transparent"><i
                            class='bi bi-buildings-fill'></i></span>
                        <input id="nombre_comercial" type="text" name="nombre_comercial" v-model="formData.trade_name"
                          class="form-control form-control-sm" autocomplete="off">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group mb-3">
                      <label for="direccion" class="form-label">Dirección <span class="text-red">(*)</span></label>
                      <div class="input-group"> <span class="input-group-text bg-transparent"><i
                            class='bi bi-geo-alt'></i></span>
                        <input id="direccion" type="text" name="direccion" class="form-control form-control-sm"
                          v-model="address" autocomplete="off">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="telefono" class="form-label">Teléfono <span class="text-red">(*)</span></label>
                      <div class="input-group"> <span class="input-group-text bg-transparent"><i
                            class='bi bi-telephone-fill'></i></span>
                        <input id="telefono" type="text" name="telefono" data-minus="true" v-model="formData.phone"
                          class="form-control form-control-sm minus" autocomplete="off">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email" class="form-label">Correo electrónico <span class="text-red">(*)</span></label>
                      <div class="input-group"> <span class="input-group-text bg-transparent"><i
                            class='bi bi-envelope-fill'></i></span>
                        <input id="email" type="email" name="email" v-model="formData.email" data-minus="true"
                          class="form-control form-control-sm minus" autocomplete="off">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer d-flex align-items-end justify-content-end">
            <button type="submit" class="btn btn-primary btn-primary-dark m-2 btn-sm">Guardar</button>
          </div>
        </form>
      </div>
      <!-- /.card -->
      <!--begin::Row-->
    </div>
    <!--end::Container-->
  </div>
  <!-- </div> -->
</template>