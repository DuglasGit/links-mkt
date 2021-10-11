<?php

if ($peticionAjax) {
    require_once "../models/trabajoModelo.php";
} else {
    require_once "./models/trabajoModelo.php";
}

class trabajoControlador extends trabajoModelo
{

    /*--------- Controlador agregar trabajo ---------*/
    public function agregar_trabajo_controlador()
    {
        $idUsuario = mainModel::limpiar_cadena($_POST['responsable']);
        $fechaCreacion = mainModel::limpiar_cadena($_POST['fechaAsignada']);
        $tipoTrabajo = mainModel::limpiar_cadena($_POST['trabajo']);
        $descripcion = mainModel::limpiar_cadena($_POST['descripcionTrabajo']);
        $estadoOrden = "Pendiente";


        /*== comprobar campos vacios ==*/
        if ($idUsuario == "" || $fechaCreacion == "" || $tipoTrabajo == "" || $descripcion == "" || $estadoOrden == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Datos Incompletos",
                "Texto" => "No puedes agregar datos vacíos a la Orden de Trabajo",
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
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $datos_trabajo_reg = [
            "ID_USUARIO" => $idUsuario,
            "FECHA_CREACION" => $fechaCreacion,
            "ID_TIPO_TRABAJO" => $tipoTrabajo,
            "DESCRIPCION_TRABAJO" => $descripcion,
            "ESTADO_ORDEN" => $estadoOrden
        ];

        $agregar_trabajo = trabajoModelo::agregarTrabajoModelo($datos_trabajo_reg);

        if ($agregar_trabajo->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Trabajo Registrado y Asignado",
                "Texto" => "La Orden de Trabajo se guardó Correctamente",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "MYSQL: OPERACIÓN RECHAZADA",
                "Texto" => "NO se pudo realizar la transacción solicitada",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
    } /* Fin controlador */

    /*--------- Controlador agregar trabajo ---------*/
    public function agregar_tipo_trabajo_controlador()
    {
        $tipoTrabajo = mainModel::limpiar_cadena($_POST['nombre_tipo_trabajo']);


        /*== comprobar campos vacios ==*/
        if ($tipoTrabajo == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Campos Vacíos",
                "Texto" => "Por Favor complete los datos antes de proceder",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        /*== Comprobando Nombre del tipo de trabajo ==*/
        $check_trabajo = mainModel::ejecutar_consulta_simple("SELECT nombre_tipo_trabajo FROM tipo_trabajo WHERE nombre_tipo_trabajo='$tipoTrabajo'");
        if ($check_trabajo->rowCount() > 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Datos Repetidos",
                "Texto" => "EL tipo de trabajo que desea guardar ya existe en el sistema",
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
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }


        $agregar_trabajo = trabajoModelo::agregarTipoTrabajoModelo($tipoTrabajo);

        if ($agregar_trabajo->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Registro Exitoso",
                "Texto" => "Se guardó el nuevo tipo de Trabajo",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "MYSQL: OPERACIÓN RECHAZADA",
                "Texto" => "NO se pudo realizar la transacción solicitada",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
    } /* Fin controlador */

    // COntrolador Paginar trabajo
    public function PaginadorTrabajoPendienteControlador($pagina, $registros, $rol, $id, $url, $busqueda)
    {
        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $rol = mainModel::limpiar_cadena($rol);
        $id = mainModel::limpiar_cadena($id);
        $url = mainModel::limpiar_cadena($url);
        $busqueda = mainModel::limpiar_cadena($busqueda);

        $url = SERVERURL . $url . "/";

        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        if (isset($busqueda) && $busqueda != "") {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS orden_trabajo.id_orden_trabajo, usuario.nombre_usuario, rol_usuario.nombre_rol, orden_trabajo.fecha_creacion, tipo_trabajo.nombre_tipo_trabajo, orden_trabajo.descripcion_trabajo FROM orden_trabajo JOIN usuario ON (orden_trabajo.id_usuario=usuario.id_usuario) JOIN rol_usuario ON(usuario.id_rol=rol_usuario.id_rol) JOIN tipo_trabajo ON (orden_trabajo.id_tipo_trabajo=tipo_trabajo.id_tipo_trabajo) WHERE estado_orden!='Completado' OR nombre_usuario LIKE '%$busqueda%'  ORDER BY orden_trabajo.fecha_creacion ASC LIMIT $inicio, $registros";
        } else {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS orden_trabajo.id_orden_trabajo, usuario.nombre_usuario, rol_usuario.nombre_rol, orden_trabajo.fecha_creacion, tipo_trabajo.nombre_tipo_trabajo, orden_trabajo.descripcion_trabajo FROM orden_trabajo JOIN usuario ON (orden_trabajo.id_usuario=usuario.id_usuario) JOIN rol_usuario ON(usuario.id_rol=rol_usuario.id_rol) JOIN tipo_trabajo ON (orden_trabajo.id_tipo_trabajo=tipo_trabajo.id_tipo_trabajo) WHERE estado_orden!='Completado' ORDER BY orden_trabajo.fecha_creacion ASC LIMIT $inicio, $registros";
        }

        $conexion = mainModel::conectar();
        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();
        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();
        $Npaginas = ceil($total / $registros);

        $tabla .= '
		<div class="table-responsive">
		<table class="table table-hover">
			<thead>
				<tr class="text-center">
					<th class="text-success col-sm-auto">No.</th>
					<th class="text-success col-sm-auto">RESPONSABLE</th>
					<th class="text-success col-sm-auto">ROLL</th>
					<th class="text-success col-sm-auto">FECHA CREACIÓN</th>
					<th class="text-success col-sm-auto">DESCRIPCIÓN</th>
                    <th class="text-success col-sm-auto">EDITAR</th>
                    <th class="text-success col-sm-auto">FINALIZAR</th>
                    <th class="text-success col-sm-auto">ELIMINAR</th>
				</tr>
			</thead>
			<tbody id="myTable">
		';

        if ($total >= 1 && $pagina <= $Npaginas) {
            $contador = $inicio + 1;
            $registro_inicial = $inicio + 1;
            foreach ($datos as $rows) {
                $tabla .= '
					<tr class="text-center">
                        <td>' . $contador . '</td>
                        <td class="text-secondary">' . $rows['nombre_usuario'] . '</td>
                        <td class="text-secondary">' . $rows['nombre_rol'] . '</td>
                        <td class="text-secondary">' . $rows['fecha_creacion'] . '</td>
                        <td>
                        <a data-toggle="modal" data-id="' . $rows['descripcion_trabajo'] . '" class="open-mostrarDescripcion btn btn-inverse-success btn-icon-text" href="#mostrarDescripcion"><i class="mdi mdi-eye btn-icon-prepend"></i>Ver</a>
                        </td>
                        <td>
                            <a href="' . SERVERURL . 'editar-trabajo/' . mainModel::encryption($rows['id_orden_trabajo']) . '/" type="button" class="btn btn-inverse-warning btn-icon-text">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i>
                            </a>
                        </td>
                        <td>
						    <form class="FormularioAjax" action="' . SERVERURL . 'ajax/trabajoAjax.php" method="POST" data-form="finish" autocomplete="off">
								<input type="hidden" name="orden_trabajo_finish" value="' . mainModel::encryption($rows['id_orden_trabajo']) . '">
								<button type="submit" class="btn btn-inverse-primary btn-icon-text" data-toggle="modal" >
									<i class="mdi mdi-checkbox-multiple-marked-outline btn-icon-prepend"></i>
								</button>
							</form>
						</td>
						<td>
						    <form class="FormularioAjax" action="' . SERVERURL . 'ajax/trabajoAjax.php" method="POST" data-form="delete" autocomplete="off">
								<input type="hidden" name="orden_trabajo_id_delete" value="' . mainModel::encryption($rows['id_orden_trabajo']) . '">
								<button type="submit" class="btn btn-inverse-danger btn-icon-text" data-toggle="modal" >
									<i class="mdi mdi-delete-sweep btn-icon-prepend"></i>
								</button>
							</form>
						</td>
                    </tr>';
                $contador++;
            }
            $registro_final = $contador - 1;
        } else {
            if ($total >= 1) {
                $tabla .= '<tr><td colspan="9">
				<a href="' . $url . '" class="btn btn-inverse-warning btn-icon-text">Haga clic aqupi para recargar el listado</a>
				</td></tr>';
            } else {
                $tabla .= '<tr><td colspan="9">No hay Ordenes de trabajo Pendientes de Ejecutar</td></tr>';
            }
        }

        $tabla .= '</tbody></table></div>';

        if ($total >= 1 && $pagina <= $Npaginas) {
            $tabla .= '
			<div class="row col-md-12 justify-content-center">
				<p class="text-center">
				Mostrando trabajo ' . $registro_inicial . ' al ' . $registro_final . ' de un total de ' . $total . '
				</p>
			</div>';

            $tabla .= mainModel::paginador_tablas($pagina, $Npaginas, $url, 5);
        }
        return $tabla;
    } // fin controlador


    // COntrolador Paginar trabajo
    public function PaginadorTrabajoTerminadoControlador($pagina, $registros, $rol, $id, $url, $busqueda)
    {
        $pagina = mainModel::limpiar_cadena($pagina);
        $registros = mainModel::limpiar_cadena($registros);
        $rol = mainModel::limpiar_cadena($rol);
        $id = mainModel::limpiar_cadena($id);
        $url = mainModel::limpiar_cadena($url);
        $busqueda = mainModel::limpiar_cadena($busqueda);

        $url = SERVERURL . $url . "/";

        $tabla = "";

        $pagina = (isset($pagina) && $pagina > 0) ? (int)$pagina : 1;
        $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

        if (isset($busqueda) && $busqueda != "") {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS orden_trabajo.id_orden_trabajo, usuario.nombre_usuario, rol_usuario.nombre_rol, orden_trabajo.fecha_creacion, tipo_trabajo.nombre_tipo_trabajo, orden_trabajo.descripcion_trabajo FROM orden_trabajo JOIN usuario ON (orden_trabajo.id_usuario=usuario.id_usuario) JOIN rol_usuario ON(usuario.id_rol=rol_usuario.id_rol) JOIN tipo_trabajo ON (orden_trabajo.id_tipo_trabajo=tipo_trabajo.id_tipo_trabajo) WHERE estado_orden='Completado' OR nombre_usuario LIKE '%$busqueda%'  ORDER BY orden_trabajo.fecha_creacion ASC LIMIT $inicio, $registros";
        } else {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS orden_trabajo.id_orden_trabajo, usuario.nombre_usuario, rol_usuario.nombre_rol, orden_trabajo.fecha_creacion, tipo_trabajo.nombre_tipo_trabajo, orden_trabajo.descripcion_trabajo FROM orden_trabajo JOIN usuario ON (orden_trabajo.id_usuario=usuario.id_usuario) JOIN rol_usuario ON(usuario.id_rol=rol_usuario.id_rol) JOIN tipo_trabajo ON (orden_trabajo.id_tipo_trabajo=tipo_trabajo.id_tipo_trabajo) WHERE estado_orden='Completado' ORDER BY orden_trabajo.fecha_creacion ASC LIMIT $inicio, $registros";
        }

        $conexion = mainModel::conectar();
        $datos = $conexion->query($consulta);
        $datos = $datos->fetchAll();
        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();
        $Npaginas = ceil($total / $registros);

        $tabla .= '
            <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr class="text-center">
                        <th class="text-info col-sm-2">No.</th>
                        <th class="text-info col-sm-6">RESPONSABLE</th>
                        <th class="text-info col-sm-2">ROLL</th>
                        <th class="text-info col-sm-1">FECHA ASIGNACION</th>
                        <th class="text-info col-sm-1">DESCRIPCIÓN</th>
                        <th class="text-info col-sm-1">ELIMINAR</th>
                    </tr>
                </thead>
                <tbody id="myTable">
            ';

        if ($total >= 1 && $pagina <= $Npaginas) {
            $contador = $inicio + 1;
            $registro_inicial = $inicio + 1;
            foreach ($datos as $rows) {
                $tabla .= '
                        <tr class="text-center">
                            <td>' . $contador . '</td>
                            <td class="text-secondary">' . $rows['nombre_usuario'] . '</td>
                            <td class="text-secondary">' . $rows['nombre_rol'] . '</td>
                            <td class="text-secondary">' . $rows['fecha_creacion'] . '</td>
                            <td>
                            <a data-toggle="modal" data-id="' . $rows['descripcion_trabajo'] . '" class="open-mostrarDescripcionTerminado btn btn-inverse-info btn-icon-text" href="#mostrarDescripcionTerminado"><i class="mdi mdi-eye btn-icon-prepend"></i>Ver</a>
                            </td>
                            <td>
                            <form class="FormularioAjax" action="' . SERVERURL . 'ajax/trabajoAjax.php" method="POST" data-form="delete" autocomplete="off">
                                    <input type="hidden" name="trabajo_finalizado_delete" value="' . mainModel::encryption($rows['id_orden_trabajo']) . '">
                                    <button type="submit" class="btn btn-inverse-danger btn-icon-text" data-toggle="modal">
                                        <i class="mdi mdi-delete-sweep btn-icon-prepend"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>';
                $contador++;
            }
            $registro_final = $contador - 1;
        } else {
            if ($total >= 1) {
                $tabla .= '<tr><td colspan="9">
                    <a href="' . $url . '" class="btn btn-inverse-warning btn-icon-text">Haga clic aqupi para recargar el listado</a>
                    </td></tr>';
            } else {
                $tabla .= '<tr><td colspan="9">No hay Ordenes de trabajo Pendientes de Ejecutar</td></tr>';
            }
        }

        $tabla .= '</tbody></table></div>';

        if ($total >= 1 && $pagina <= $Npaginas) {
            $tabla .= '
                <div class="row col-md-12 justify-content-center">
                    <p class="text-center">
                    Mostrando trabajo ' . $registro_inicial . ' al ' . $registro_final . ' de un total de ' . $total . '
                    </p>
                </div>';

            $tabla .= mainModel::paginador_tablas($pagina, $Npaginas, $url, 5);
        }
        return $tabla;
    } // fin controlador


    // Controlador datos del trabajo
    public function datosTrabajoControlador($tipo, $id)
    {
        $tipo = mainModel::limpiar_cadena($tipo);
        $id = mainModel::decryption($id);
        $id = mainModel::limpiar_cadena($id);

        return trabajoModelo::datosTrabajoioModelo($tipo, $id);
    } //fin controlador

    // controlador para llenar select de formulario actualizar trabajo
    public function llenarSelect($op, $id)
    {
        $op = mainModel::limpiar_cadena($op);
        $id = mainModel::decryption($id);
        $id = mainModel::limpiar_cadena($id);

        return trabajoModelo::datosResponsable($op, $id);
    } // fin controlador


    // controlador actualizar trabajo
    public function actualizarTrabajoControlador()
    {
        // recibiendo id de orden trabajo
        $id_orden = mainModel::decryption($_POST['orden_trabajo_id_update']);
        $id_orden = mainModel::limpiar_cadena($id_orden);

        // comprobar privilegios
        session_start(['name' => 'LMR']);
        if ($_SESSION['id_rol_lmr'] != 1) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "PETICIÓN DENEGADA",
                "Texto" => "No tienes los permisos necesarios para realizar esta operación",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        //comprobar el usuario en la base de datos
        $check_trabajo = mainModel::ejecutar_consulta_simple("SELECT * FROM orden_trabajo WHERE id_orden_trabajo='$id_orden'");

        if ($check_trabajo->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "DATOS INACCESIBLES",
                "Texto" => "NO se encontraron registros del trabajo en la base de datos",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $id_usuario = mainModel::limpiar_cadena($_POST['responsable_Up']);
        $fechaAsignada = mainModel::limpiar_cadena($_POST['fechaAsignada_Up']);
        $tipoTrabajo = mainModel::limpiar_cadena($_POST['trabajo_Up']);
        $descripcion = mainModel::limpiar_cadena($_POST['descripcionTrabajo_Up']);

        /*== comprobar campos vacios ==*/
        if ($id_usuario == "" || $fechaAsignada == "" || $tipoTrabajo == "" || $descripcion == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "INFORMACIÓN INCOMPLETA",
                "Texto" => "No has llenado todos los campos Requeridos",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        // Preparando datos para enviarlos al modelo
        $datos_trabajo_update = [
            "ID_ORDEN_TRABAJO" => $id_orden,
            "ID_USUARIO" => $id_usuario,
            "FECHA_CREACION" => $fechaAsignada,
            "ID_TIPO_TRABAJO" => $tipoTrabajo,
            "DESCRIPCION_TRABAJO" => $descripcion
        ];

        if (trabajoModelo::actualizarTrabajoModelo($datos_trabajo_update)) {
            $alerta = [
                "Alerta" => "exitoredireccion",
                "Titulo" => "Completado",
                "Texto" => "Orden de trabajo actualizada exitosamente",
                "Tipo" => "success",
                "URL" => SERVERURL . "trabajos/"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Operación Abortada",
                "Texto" => "La Base de Datos rechazó la petición de actualización",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
        exit();
    } //fin cntrolador


    // Controlador para Eliminar trabajo
    public function eliminarTrabajoControlador()
    {
        // recibiendo id de orden trabajo
        $id_orden = mainModel::decryption($_POST['orden_trabajo_id_delete']);
        $id_orden = mainModel::limpiar_cadena($id_orden);


        //comprobar la orden de trabajo en la base de datos
        $check_trabajo = mainModel::ejecutar_consulta_simple("SELECT id_orden_trabajo FROM orden_trabajo WHERE id_orden_trabajo='$id_orden'");

        if ($check_trabajo->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ORDEN NO ENCONTRADA",
                "Texto" => "No existe la orden de trabajo que desea eliminar",
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
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $eliminar_orden = trabajoModelo::eliminar_trabajo_modelo($id_orden);

        if ($eliminar_orden->rowCount() == 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Eliminación Exitosa",
                "Texto" => "La Orden de Trabajo ha sido eliminada",
                "Tipo" => "success"
            ];
        } else {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "MYSQL: OPERACIÓN RECHAZADA",
                "Texto" => "No puede eliminar una orden que ya ha sido completada",
                "Tipo" => "error"
            ];
        }
        echo json_encode($alerta);
    } // fin controlador


    // Controlador para Eliminar trabajo finalizado
    public function eliminarTrabajoTerminadoControlador()
    {
        // recibiendo id de orden trabajo
        $id_orden = mainModel::decryption($_POST['trabajo_finalizado_delete']);
        $id_orden = mainModel::limpiar_cadena($id_orden);


        //comprobar la orden de trabajo en la base de datos
        $check_trabajo = mainModel::ejecutar_consulta_simple("SELECT id_orden_trabajo FROM trabajo_terminado WHERE id_orden_trabajo='$id_orden'");

        if ($check_trabajo->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "TRABAJO NO ENCONTRADO",
                "Texto" => "No existe la orden de trabajo que desea eliminar",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $eliminar_orden = trabajoModelo::eliminar_trabajo_terminado_modelo($id_orden, 1, 0);
        $exito = 0;

        if ($eliminar_orden->rowCount() == 1) {
            $exito = 1;

            if (trabajoModelo::eliminar_trabajo_terminado_modelo($id_orden, 2, "Pendiente")) {
                $exito = 2;
            }
        }

        switch ($exito) {
            case 0: {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "MYSQL: OPERACIÓN RECHAZADA",
                        "Texto" => "No se pudo Remover el trabajo finalizado",
                        "Tipo" => "error"
                    ];
                    echo json_encode($alerta);
                    exit();
                    break;
                }
            case 1: {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "MYSQL: OPERACIÓN RECHAZADA",
                        "Texto" => "No se pudo Renombrar el estado del trabajo",
                        "Tipo" => "error"
                    ];
                    echo json_encode($alerta);
                    exit();
                    break;
                }
            case 2: {
                    $alerta = [
                        "Alerta" => "recargar",
                        "Titulo" => "Eliminación Exitosa",
                        "Texto" => "El Trabajo ha sido Restaurado a los Pendientes Nuevamente",
                        "Tipo" => "success"
                    ];
                    echo json_encode($alerta);
                    exit();
                    break;
                }
            default: {
                    break;
                }
        }
    } //fin controlador


    // Controlador para Finalizar trabajo Pendiente
    public function finalizarTrabajoControlador()
    {
        // recibiendo id de orden trabajo
        $id_orden = mainModel::decryption($_POST['orden_trabajo_finish']);
        $id_orden = mainModel::limpiar_cadena($id_orden);


        //comprobar la orden de trabajo en la base de datos
        $check_trabajo = mainModel::ejecutar_consulta_simple("SELECT id_orden_trabajo FROM orden_trabajo WHERE id_orden_trabajo='$id_orden'");

        if ($check_trabajo->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "ORDEN NO ENCONTRADA",
                "Texto" => "No existe la orden de trabajo que desea Finalizar",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $actualizar_orden = trabajoModelo::finalizar_trabajo_modelo($id_orden, 1, 0);
        $exito = 0;

        if ($actualizar_orden->rowCount() == 1) {
            $exito = 1;

            if (trabajoModelo::finalizar_trabajo_modelo($id_orden, 2, "Completado")) {
                $exito = 2;
            }
        }

        switch ($exito) {
            case 0: {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "MYSQL: OPERACIÓN RECHAZADA",
                        "Texto" => "No se pudo Finalizar el trabajo solicitado",
                        "Tipo" => "error"
                    ];
                    echo json_encode($alerta);
                    exit();
                    break;
                }
            case 1: {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "MYSQL: OPERACIÓN RECHAZADA",
                        "Texto" => "No se pudo cambiar el estado del trabajo a Finalizado",
                        "Tipo" => "error"
                    ];
                    echo json_encode($alerta);
                    exit();
                    break;
                }
            case 2: {
                    $alerta = [
                        "Alerta" => "recargar",
                        "Titulo" => "Trabajo Completado",
                        "Texto" => "El Trabajo ha sido Finalizado Existosamente",
                        "Tipo" => "success"
                    ];
                    echo json_encode($alerta);
                    exit();
                    break;
                }
            default: {
                    break;
                }
        }
    } //fin controlador
}
