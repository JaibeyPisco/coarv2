<script>
	import Breadcumbs from '../../../../components/utils/Breadcumbs.svelte';

	/**
	 * Estado del formulario de empresa.
	 * @typedef {Object} FormData
	 * @property {File|string} logo Archivo del logo o cadena vacía.
	 * @property {string} document_number Número de documento (RUC).
	 * @property {string} business_name Razón social.
	 * @property {string} trade_name Nombre comercial.
	 * @property {string} address Dirección.
	 * @property {string} phone Teléfono.
	 * @property {string} email Correo electrónico.
	 * @property {string} id_ubigeo Código de ubicación.
	 * @property {string} previewImage URL para vista previa del logo.
	 */

	/** @type {FormData} */
	let formData = $state({
		logo: '',
		document_number: '',
		business_name: '',
		trade_name: '',
		address : '',
		phone : '',
		email : '',
		id_ubigeo : '',
		previewImage: '',

	});

	/**
	 * Maneja el cambio del input file para el logo.
	 * Actualiza la imagen de vista previa y el archivo en formData.
	 * @param {Event} e Evento de cambio.
	 */
	const onchangeLogo = (e) => {
		const target = /** @type {HTMLInputElement} */ (e.target);
		if (!target || !target.files) return;

		const file = target.files[0];
		previewImage(file);
		formData.logo = file;
	}

	/**
	 * Lee el archivo para mostrar su contenido como imagen previa.
	 * @param {File} file Archivo seleccionado.
	 */
	const previewImage = (file) => {
	if (file) {
		const reader = new FileReader();
		reader.onload = (e) => {
		const result = e.target?.result;
		if (typeof result === 'string') {
			formData.previewImage = result;
		} else {
			formData.previewImage = '';
		}
		};
		reader.readAsDataURL(file);
	}
	};

	/**
	 * Maneja el envío del formulario.
	 * Evita el comportamiento por defecto y muestra los datos en alerta.
	 * @param {Event} e Evento submit.
	 */
	const onSubmit = (e) => {
		e.preventDefault();
		alert(JSON.stringify(formData));
	}
</script>

<!-- Content Header (Page header) -->
<Breadcumbs module="Configuración" submodule="Empresa" />
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
	<div class="container-fluid">
		<form onsubmit={onSubmit}>
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-md-4 mt">
							<div class="position-relative">
								<img src={formData.previewImage || "/assets/img/photo1.png"} alt="Logo" class="img-fluid" />
							</div>
							<div class="input-group mt-2">
								<div class="custom-file">
									<input type="file" class="custom-file-input" onchange={onchangeLogo} />
									<label class="custom-file-label" for="exampleInputFile">Elegir logo</label>
								</div>
							</div>
						</div>
						<div class="col-md-8">
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<label>RUC</label>
										<input
											type="number"
											class="form-control"
											placeholder="10738604984"
											bind:value={formData.document_number}
										/>
									</div>
								</div>
								<div class="col-md-8">
									<div class="form-group">
										<label>Razón Social</label>
										<input
											type="text"
											class="form-control"
											bind:value={formData.business_name}
											placeholder="ASOCIACIÓN DE COLEGIOS SA"
										/>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Nombre comercial</label>
										<input
											type="text"
											class="form-control"
											bind:value={formData.trade_name}
											placeholder="COLEGIO SELVA ORIENTE SA"
										/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Dirección</label>
										<input
											type="text"
											class="form-control"
											bind:value={formData.address}
											placeholder="AV. ALFONSO UGARTE, SN"
										/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Ubigeo</label>
										 <select name="id_ubigeo" class="form-control">

										 </select>
									</div>
								</div>
								
								<div class="col-md-6">
									<div class="form-group">
										<label>Teléfono</label>
										<input
											type="text"
											class="form-control"
											placeholder="+51948791601"
											bind:value={formData.phone}
										/>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label>Correo electrónico</label>
										<input
											type="email"
											class="form-control"
											bind:value={formData.email}
											placeholder="administracion@colegioorientesa.edu.pe"
										/>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /.card-body -->
				<div class="card-footer">
					<button type="submit" class="btn btn-primary btn-sm px-3 float-right">Guardar</button>
				</div>
			</div>
		</form>
	</div>
</div>
