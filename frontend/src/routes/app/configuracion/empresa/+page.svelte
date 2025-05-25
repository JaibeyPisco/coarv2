<script>

import Breadcumbs from "../../../../components/utils/Breadcumbs.svelte";
</script>

<!-- Content Header (Page header) -->
<Breadcumbs module="Configuración"  submodule="Empresa">
    {#snippet buttons()}
        <button class="btn btn-primary btn-sm px-3">Nuevo</button>
    {/snippet}
</Breadcumbs>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">

        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                  <div class="col-md-4 mt">
                      <div class="position-relative">
                          <img src="/assets/img/photo1.png" alt="Photo 1" class="img-fluid">
                      </div>
                      <div class="input-group mt-2">
                          <div class="custom-file">
                              <input type="file" class="custom-file-input">
                              <label class="custom-file-label" for="exampleInputFile">Elegir logo</label>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-8">
                      <h1>hello world</h1>

                  </div>
              </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>