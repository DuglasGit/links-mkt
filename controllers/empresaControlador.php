<?php

if ($peticionAjax) {
	require_once "../models/empresaModelo.php";
} else {
	require_once "./models/empresaModelo.php";
}

class empresaControlador extends empresaModelo
{

	//Agregar Empresa controlador
	public function agregarEmpresaControlador()
	{
		//inputs empresa
		$nombre_empresa = mainModel::limpiar_cadena($_POST['nombreEmpresa']);
		$representante_legal = mainModel::limpiar_cadena($_POST['representanteLegal']);
		$nit_empresa = mainModel::limpiar_cadena($_POST['nitEmpresa']);
		$telefono_empresa = mainModel::limpiar_cadena($_POST['telefonoEmpresa']);
		$correo_empresa = mainModel::limpiar_cadena($_POST['correoEmpresa']);
		$id_municipio = mainModel::limpiar_cadena($_POST['municipioEmpresa']);
		$domicilio = mainModel::limpiar_cadena($_POST['domicilioEmpresa']);
		$ubicacion_gps = mainModel::limpiar_cadena($_POST['gpsEmpresa']);

		//inputs routerMIkrotik
		$modelo = mainModel::limpiar_cadena($_POST['modeloRouter']);
		$serie = mainModel::limpiar_cadena($_POST['serieRouter']);
		$ip_asignada = mainModel::limpiar_cadena($_POST['ipRouter']);
		$usuario_router = mainModel::limpiar_cadena($_POST['usuarioRouter']);
		$password_router = mainModel::limpiar_cadena($_POST['passwordRouter']);

		if ($nombre_empresa == "" || $representante_legal == "" || $nit_empresa == "" || $telefono_empresa == "" || $correo_empresa == "" || $id_municipio == "" || $domicilio == "" || $ubicacion_gps == "" || $modelo == "" || $serie == "" || $ip_asignada == "" || $usuario_router == "" || $password_router == "") {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Campos Vacíos",
				"Texto" => "Por Favor complete los datos antes de proceder",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}

		// comprobar privilegios
		session_start(['name' => 'LMR']);
		if ($_SESSION['id_rol_lmr'] != 1) {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "PETICIÓN DENEGADA",
				"Texto" => "No tienes los permisos necesarios para realizar esta operación",
				"Tipo" => "error",
			];
			echo json_encode($alerta);
			exit();
		}

		$datos_empresa = [
			"NOMBRE_EMPRESA" => $nombre_empresa,
			"REP_LEGAL" => $representante_legal,
			"NIT" => $nit_empresa,
			"TELEFONO" => $telefono_empresa,
			"CORREO" => $correo_empresa,
			"ID_MUNI" => $id_municipio,
			"DOMICILIO" => $domicilio,
			"GPS" => $ubicacion_gps
		];

		$empresa = empresaModelo::agregarEmpresaModelo($datos_empresa, "empresa");
		$exito = 0;

		if ($empresa->rowCount() == 1) {
			$exito = 1;

			$datos_router = [
				"MODELO" => $modelo,
				"SERIE" => $serie,
				"IP" => $ip_asignada,
				"USUARIOR" => $usuario_router,
				"PASSWORDR" => $password_router
			];

			$router = empresaModelo::agregarEmpresaModelo($datos_router, "router");

			if ($router->rowCount() == 1) {
				$exito = 2;
			}
		}

		switch ($exito) {
			case 0: {
					$alerta = [
						"Alerta" => "simple",
						"Titulo" => "MySQL: OPERACIÓN RECHAZADA",
						"Texto" => "No se pudo insertar los datos de la empresa",
						"Tipo" => "error"
					];
					echo json_encode($alerta);
					exit();
					break;
				}
			case 1: {
					$alerta = [
						"Alerta" => "simple",
						"Titulo" => "MySQL: OPERACIÓN RECHAZADA",
						"Texto" => "No se pudo insertar los datos del router Mikrotik",
						"Tipo" => "error"
					];
					echo json_encode($alerta);
					break;
				}
			case 2: {
					$alerta = [
						"Alerta" => "recargar",
						"Titulo" => "OPERACIÓN EXITOSA",
						"Texto" => "Se registró los datos de la empresa y Router Mikrotik",
						"Tipo" => "success"
					];
					echo json_encode($alerta);
					exit();
					break;
				}
			default: {
					$alerta = [
						"Alerta" => "simple",
						"Titulo" => "ALGO SALIÓ MAL",
						"Texto" => "Verifique los datos e intentelo nuevamente",
						"Tipo" => "error"
					];
					echo json_encode($alerta);
					exit();

					break;
				}
		}
	}

	//Actualizar Empresa controlador
	public function actualizarEmpresaControlador()
	{
		//inputs empresa
		$id_empresa = mainModel::limpiar_cadena($_POST['id_empresa_update']);
		$nombre_empresa = mainModel::limpiar_cadena($_POST['nombreEmpresa_up']);
		$representante_legal = mainModel::limpiar_cadena($_POST['representanteLegal_up']);
		$nit_empresa = mainModel::limpiar_cadena($_POST['nitEmpresa_up']);
		$telefono_empresa = mainModel::limpiar_cadena($_POST['telefonoEmpresa_up']);
		$correo_empresa = mainModel::limpiar_cadena($_POST['correoEmpresa_up']);
		$id_municipio = mainModel::limpiar_cadena($_POST['municipioEmpresa_up']);
		$domicilio = mainModel::limpiar_cadena($_POST['domicilioEmpresa_up']);
		$ubicacion_gps = mainModel::limpiar_cadena($_POST['gpsEmpresa_up']);

		//inputs routerMIkrotik
		$id_router = mainModel::limpiar_cadena($_POST['id_router_update']);
		$modelo = mainModel::limpiar_cadena($_POST['modeloRouter_up']);
		$serie = mainModel::limpiar_cadena($_POST['serieRouter_up']);
		$ip_asignada = mainModel::limpiar_cadena($_POST['ipRouter_up']);
		$usuario_router = mainModel::limpiar_cadena($_POST['usuarioRouter_up']);
		$password_router = mainModel::limpiar_cadena($_POST['passwordRouter_up']);

		if ($nombre_empresa == "" || $representante_legal == "" || $nit_empresa == "" || $telefono_empresa == "" || $correo_empresa == "" || $id_municipio == "" || $domicilio == "" || $ubicacion_gps == "" || $modelo == "" || $serie == "" || $ip_asignada == "" || $usuario_router == "" || $password_router == "" || $id_empresa == "" || $id_router == "") {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "Campos Vacíos",
				"Texto" => "Por Favor complete los datos antes de proceder",
				"Tipo" => "error"
			];
			echo json_encode($alerta);
			exit();
		}

		// comprobar privilegios
		session_start(['name' => 'LMR']);
		if ($_SESSION['id_rol_lmr'] != 1) {
			$alerta = [
				"Alerta" => "simple",
				"Titulo" => "PETICIÓN DENEGADA",
				"Texto" => "No tienes los permisos necesarios para realizar esta operación",
				"Tipo" => "error",
			];
			echo json_encode($alerta);
			exit();
		}

		$datos_empresa = [
			"ID" => $id_empresa,
			"NOMBRE_EMPRESA" => $nombre_empresa,
			"REP_LEGAL" => $representante_legal,
			"NIT" => $nit_empresa,
			"TELEFONO" => $telefono_empresa,
			"CORREO" => $correo_empresa,
			"ID_MUNI" => $id_municipio,
			"DOMICILIO" => $domicilio,
			"GPS" => $ubicacion_gps
		];

		$exito = 0;

		if (empresaModelo::actualizarEmpresaModelo($datos_empresa, "empresa")) {
			$exito = 1;

			$datos_router = [
				"IDR" => $id_router,
				"MODELO" => $modelo,
				"SERIE" => $serie,
				"IP" => $ip_asignada,
				"USUARIOR" => $usuario_router,
				"PASSWORDR" => $password_router
			];

			if (empresaModelo::actualizarEmpresaModelo($datos_router, "router")) {
				$exito = 2;
			}
		}

		switch ($exito) {
			case 0: {
					$alerta = [
						"Alerta" => "simple",
						"Titulo" => "MySQL: OPERACIÓN RECHAZADA",
						"Texto" => "No se pudo actualizar los datos de la empresa",
						"Tipo" => "error"
					];
					echo json_encode($alerta);
					exit();
					break;
				}
			case 1: {
					$alerta = [
						"Alerta" => "simple",
						"Titulo" => "MySQL: OPERACIÓN RECHAZADA",
						"Texto" => "No se pudo actualizar los datos del router Mikrotik",
						"Tipo" => "error"
					];
					echo json_encode($alerta);
					break;
				}
			case 2: {
					$alerta = [
						"Alerta" => "recargar",
						"Titulo" => "OPERACIÓN EXITOSA",
						"Texto" => "Se actualizó los datos de la empresa y Router Mikrotik",
						"Tipo" => "success"
					];
					echo json_encode($alerta);
					exit();
					break;
				}
			default: {
					$alerta = [
						"Alerta" => "simple",
						"Titulo" => "ALGO SALIÓ MAL",
						"Texto" => "Verifique los datos e intentelo nuevamente",
						"Tipo" => "error"
					];
					echo json_encode($alerta);
					exit();

					break;
				}
		}
	}

	//Datos empresa Controlador
	public function datosEmpresaControlador()
	{
		return empresaModelo::datosEmpresaModelo();
	} //fin Controlador


	//Datos Router Controlador
	public function datosRouterControlador()
	{
		return empresaModelo::datosRouterModelo();
	} //fin Controlador


	// controlador para llenar selects
	public function llenarSelect($op, $id, $tabla)
	{
		$op = mainModel::limpiar_cadena($op);
		$id = mainModel::limpiar_cadena($id);
		$tabla = mainModel::limpiar_cadena($tabla);

		return empresaModelo::datosSelect($op, $id, $tabla);
	} // fin controlador

}
