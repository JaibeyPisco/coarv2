<script setup>
  import {ref} from "vue";
  import {useAuthStore} from "@/lib/authentication/auth.js";


  const {authenticate} = useAuthStore();

  let formData = ref({
    email: '',
    password: ''
  });


</script>

<template>
  <div class="login-page bg-body-secondary">
    <div class="login-box">
      <div class="card card-outline card-primary">
        <div class="card-header text-center "style="border-bottom: none !important;">
          <img src="/assets/img/system/logocoar.png" alt="" class="img-fluid mb-3" style="height: 10rem">
        </div>
        <div class="card-body login-card-body">
          <form @submit.prevent="authenticate(formData)" method="post">
            <div class="input-group mb-1">
              <div class="form-floating">
                <input id="loginEmail" type="email"  v-model="formData.email"  class="form-control" placeholder="Correo electrónico" />
                <label for="loginEmail">Email</label>
              </div>
              <div class="input-group-text">
                <span class="bi bi-envelope"></span>
              </div>
            </div>

            <div class="input-group mb-1">
              <div class="form-floating">
                <input id="loginPassword" type="password"  v-model="formData.password"  class="form-control" placeholder="Password"/>
                <label for="loginPassword">Password</label>
              </div>
              <div class="input-group-text">
                <span class="bi bi-lock-fill"></span>
              </div>
            </div>

          <div class="social-auth-links text-center mb-3 d-grid gap-2">
            <button type="submit" class="btn btn-primary"> Iniciar sesión</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* Personaliza si necesitas */
</style>
