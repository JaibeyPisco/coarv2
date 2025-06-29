<script>
 	/**
	 * Estado del formulario de empresa.
	 * @property {string} module Módulo ejemplo Configuración.
	 * @property {string} submodule Submodulo ejemplo: empresa.
	 * @property {() => any} [buttons] - Función que retorna botones renderizables como HTML o componentes.
	 */

    let {
        module , 
        submodule,
        buttons } = $props();

</script>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-8">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:;">{module}</a></li>
                    <li class="breadcrumb-item active">{submodule}</li>
                </ol>
            </div>
            <div class="col-sm-4 text-right">
                <div class=" gap-1 btn-group">
                    {@render buttons?.()}
                </div>
            </div>
        </div>
    </div>
</div>
