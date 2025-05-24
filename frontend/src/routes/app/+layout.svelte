<script>
    import {onMount} from "svelte";

    import LoaderStatic from "$lib/utils/LoaderStatic.js";
    import Footer from "../../components/partials/Footer.svelte";
    import Sidebar from "../../components/partials/Sidebar.svelte";
    import Navbar from "../../components/partials/Navbar.svelte";

    let {children} = $props();

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


</script>

<svelte:head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Starter</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
</svelte:head>

<div class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
            <Navbar/>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <Sidebar/>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Starter Page</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Starter Page</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    {@render children()}
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar contentss</p>
            </div>
        </aside>

        <!-- /.control-sidebar -->
        <Footer/>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

</div>
