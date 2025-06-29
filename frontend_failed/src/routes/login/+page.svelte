<script>
   import LoaderStatic from "$lib/utils/LoaderStatic.js";
   import  {onMount} from "svelte";
   import   {showNotificacion} from "$lib/utils/notification.js";
   import {goto} from "$app/navigation";


   let email = $state();
   let password = $state();


   onMount(() => {

       LoaderStatic.requireFiles([
           "/assets/plugins/fontawesome-free/css/all.min.css",
           "/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css",
           "/assets/css/adminlte.min.css",
           "/assets/plugins/bootstrap/js/bootstrap.bundle.min.js",
           "/assets/js/adminlte.min.js"
       ], function () {


       })
   })


   /**
    * @param {SubmitEvent} event
    */
   const onSubmit = async (event) =>{
       event.preventDefault();

       const API = import.meta.env.VITE_BACKEND_API;

       const  response = await fetch(`${API}/login`, {
           method:"POST",
           headers:{
               'Content-Type' :'application/json'
           },
           body:  JSON.stringify({
               email,
               password
           })
       })

       const data = await  response.json();

       if(!data.success){
         showNotificacion('Exito', data.data.error,'warning')
           return;
       }


       localStorage.setItem("token", data.data.token)

      showNotificacion('Exito', data.message,'success')

       //console.log(data)
       window.location.href = '/app';
      // await  goto("/app")


   }



</script>


<svelte:head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Log in (v2)</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

</svelte:head>
    <div class="hold-transition login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="../../index2.html" class="h1"><b>Admin</b>LTE</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Iniciar sesión</p>

                    <form  onsubmit={onSubmit} method="post">
                        <div class="input-group mb-3">
                            <input bind:value={email}  type="email" class="form-control" placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input bind:value={password} class="form-control" placeholder="Password" type="password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- /.col -->
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                </div>
                <!-- /.card-body -->
            </div>
        <!-- /.card -->
            </div>
        </div>
    <!-- /.login-box -->
