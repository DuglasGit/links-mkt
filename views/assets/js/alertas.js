const formularios_ajax = document.querySelectorAll(".FormularioAjax");

function enviar_formulario_ajax(e) {
	e.preventDefault();

	let data = new FormData(this);
	let method = this.getAttribute("method");
	let action = this.getAttribute("action");
	let tipo = this.getAttribute("data-form");

	let encabezados = new Headers();

	let config = {
		method: method,
		headers: encabezados,
		mode: 'cors',
		cache: 'no-cache',
		body: data
	}

	let texto_alerta;

	if (tipo === "save") {
		texto_alerta = "Los datos quedaran guardados en el sistema";
	} else if (tipo === "delete") {
		texto_alerta = "Los datos serán eliminados completamente del sistema";
	} else if (tipo === "disabled") {
		texto_alerta = "El servicio de Red del Cliente quedará suspendido";
	} else if (tipo === "enabled") {
		texto_alerta = "El servicio de Red del Cliente Será Reactivado";
	} else if (tipo === "finish") {
		texto_alerta = "La orden de Trabajo será Finalizada";
	} else if (tipo === "update") {
		texto_alerta = "Los datos del sistema serán actualizados";
	} else if (tipo === "search") {
		texto_alerta = "Se Realizará una búsqueda en la báse de datos";
	} else if (tipo === "search-delete"){
		texto_alerta = "Se eliminará la búsqueda actual";
	} else if (tipo === "saveserie") {
		texto_alerta = "Este proceso tardará un momento en completarse";
	}else if(tipo === "pay"){
		texto_alerta = "Se Registrará el pago de la Factura Seleccionada";
	} else {
		texto_alerta = "Confirmar Busqueda";
	}

	Swal.fire({
		title: '¿Estás Seguro?',
		text: texto_alerta,
		icon: 'question',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Aceptar',
		cancelButtonText: 'Cancelar'
	}).then((result) => {
		if (result.value) {
			fetch(action, config)
				.then(respuesta => respuesta.json())
				.then(respuesta => {
					return alertas_ajax(respuesta);
				});
		}
	});

}

formularios_ajax.forEach(formularios => {
	formularios.addEventListener("submit", enviar_formulario_ajax);
});

function alertas_ajax(alerta) {
	if (alerta.Alerta === "simple") {
		Swal.fire({
			title: alerta.Titulo,
			text: alerta.Texto,
			icon: alerta.Tipo,
			confirmButtonText: 'Aceptar'
		});
	} else if (alerta.Alerta === "recargar") {
		Swal.fire({
			title: alerta.Titulo,
			text: alerta.Texto,
			icon: alerta.Tipo,
			confirmButtonText: 'Aceptar'
		}).then((result) => {
			if (result.value) {
				location.reload();
			}
		});
	} else if (alerta.Alerta === "limpiar") {
		Swal.fire({
			title: alerta.Titulo,
			text: alerta.Texto,
			icon: alerta.Tipo,
			confirmButtonText: 'Aceptar'
		}).then((result) => {
			if (result.value) {
				document.querySelector(".FormularioAjax").reset();
			}
		});
	} else if (alerta.Alerta === "redireccionar") {
		window.location.href = alerta.URL;
	} else if (alerta.Alerta === "exitoredireccion") {
		Swal.fire({
			title: alerta.Titulo,
			text: alerta.Texto,
			icon: alerta.Tipo,
			confirmButtonText: 'Aceptar'
		}).then((result) => {
			if (result.value) {
				window.location.href = alerta.URL;
			}
		});
	}
}