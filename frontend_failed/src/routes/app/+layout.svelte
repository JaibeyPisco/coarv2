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

            "/assets/css/app.css",

            "/assets/plugins/datatables/jquery.dataTables.min.js",
            "/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js",
            "/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js",
            "/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js",
            "/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js",
            "/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js",
            "/assets/plugins/jszip/jszip.min.js",
            "/assets/plugins/pdfmake/pdfmake.min.js",
            "/assets/plugins/pdfmake/vfs_fonts.js",
            "/assets/plugins/datatables-buttons/js/buttons.html5.min.js",
            "/assets/plugins/datatables-buttons/js/buttons.print.min.js",
            "/assets/plugins/datatables-buttons/js/buttons.colVis.min.js",

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
            {@render children()}
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
