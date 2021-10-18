<?php

if ($peticionAjax) {
    require_once "../models/facturaModelo.php";
} else {
    require_once "./models/facturaModelo.php";
}

class facturaControlador extends facturaModelo
{

    /*--------- Controlador generar facturas en serie ---------*/
    public function generarFacturasEnSerieCOntrolador()
    {
        $fechaAsignada = mainModel::limpiar_cadena($_POST['fechaAsignada']);
        $mes = mainModel::limpiar_cadena($_POST['mes']);

        /*== comprobar campos vacios ==*/
        if ($fechaAsignada == "" || $mes == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "Datos Incompletos",
                "Texto" => "No se puede generar facturas con datos vaacíos",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        // comprobar privilegios
        session_start(['name' => 'LMR']);
        if ($_SESSION['id_rol_lmr'] > 2) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "PETICIÓN DENEGADA",
                "Texto" => "No tienes los permisos necesarios para realizar esta operación",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $datos_factura_serie = [
            "FECHA" => $fechaAsignada,
            "MES" => $mes,
            "ID_USUARIO" => $_SESSION['id_lmr'],
            "ID_ESTADO_PAGO" => 2,
            "CANTIDAD" => 1,
            "ID_PRODUCTO_SERVICIO" => 10
        ];

        $generar_facturas = facturaModelo::generarFacturaEnSerieModelo($datos_factura_serie);

        if ($generar_facturas->rowCount() >= 1) {
            $alerta = [
                "Alerta" => "recargar",
                "Titulo" => "Facturas Generadas Exitosamente",
                "Texto" => "Todas las Facturas han sido asignadas",
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

    // controlador actualizar factura y detalle factura
    public function generarFacturaIndividualControlador()
    {
        // recibiendo campos
        $fecha = mainModel::limpiar_cadena($_POST['fecha_reg']);
        $cliente = mainModel::limpiar_cadena($_POST['id_cliente_reg']);
        $usuario = mainModel::limpiar_cadena($_POST['id_usuario_reg']);
        $pago = mainModel::limpiar_cadena($_POST['estado_pago_reg']);
        $producto = mainModel::limpiar_cadena($_POST['producto_servicio_reg']);
        $precio = mainModel::limpiar_cadena($_POST['precio_reg']);
        $mes = mainModel::limpiar_cadena($_POST['mes_pagado_reg']);

        // comprobar privilegios
        session_start(['name' => 'LMR']);
        if ($_SESSION['id_rol_lmr'] > 2) {
            $alerta = [
                "Alerta" => "exitoredireccion",
                "Titulo" => "PETICIÓN DENEGADA",
                "Texto" => "No tienes los permisos necesarios para realizar esta operación",
                "Tipo" => "error",
                "URL" => SERVERURL . "facturacion/"
            ];
            echo json_encode($alerta);
            exit();
        }


        /*== comprobar campos vacios ==*/
        if ($fecha == "" || $cliente == "" || $usuario == "" || $pago == "" || $producto == "" || $precio == "" || $mes == "") {
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
        $datos_factura_reg = [
            "FECHA" => $fecha,
            "ID_CLIENTE" => $cliente,
            "ID_USUARIO" => $usuario,
            "ID_ESTADO_PAGO" => $pago,
        ];

        $exito = 0;
        $insert_factura = facturaModelo::agregarfacturaindividualModelo($datos_factura_reg, "factura");
        if ($insert_factura->rowCount() == 1) {
            $exito = 1;

            // Preparando datos para enviarlos al modelo
            $datos_detalle_factura_reg = [
                "FECHA" => $fecha,
                "ID_CLIENTE" => $cliente,
                "CANTIDAD" => 1,
                "ID_PRODUCTO_SERVICIO" => $producto,
                "PRECIO" => $precio,
                "MES_PAGADO" => $mes
            ];

            $insert_detalle_factura = facturaModelo::agregarfacturaindividualModelo($datos_detalle_factura_reg, "detalle");
            if ($insert_detalle_factura->rowCount() == 1) {
                $exito = 2;
            }
        }


        switch ($exito) {
            case 0: {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Operación Abortada",
                        "Texto" => "No se pudo Agregar los datos de la factura",
                        "Tipo" => "error"
                    ];
                    echo json_encode($alerta);
                    exit();
                    break;
                }
            case 1: {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Operación Abortada",
                        "Texto" => "No se pudo Agregar los detalles de la factura",
                        "Tipo" => "error"
                    ];
                    echo json_encode($alerta);
                    exit();
                    break;
                }
            case 2: {
                    $alerta = [
                        "Alerta" => "exitoredireccion",
                        "Titulo" => "COMPLETADO",
                        "Texto" => "Factura y detalles Agregados exitosamente",
                        "Tipo" => "success",
                        "URL" => SERVERURL . "facturacion/"
                    ];
                    echo json_encode($alerta);
                    exit();
                    break;
                }
        }
    } //fin cntrolador

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
                "Alerta" => "exitoredireccion",
                "Titulo" => "PETICIÓN DENEGADA",
                "Texto" => "No tienes los permisos necesarios para realizar esta operación",
                "Tipo" => "error",
                "URL" => SERVERURL . "trabajos/"
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
    public function PaginadorFacturasPendientesControlador($pagina, $registros, $rol, $id, $url, $busqueda)
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
            $consulta = "SELECT SQL_CALC_FOUND_ROWS factura.idfactura, factura.id_cliente, cliente.nombre_cliente, factura.fecha, factura.id_estado_pago, producto_servicio.nombre_producto_servicio, detalle_factura.precio, detalle_factura.mes_pagado FROM factura JOIN cliente ON (factura.id_cliente=cliente.id_cliente) JOIN detalle_factura ON (factura.idfactura=detalle_factura.id_factura) JOIN producto_servicio ON (detalle_factura.id_producto_servicio=producto_servicio.id_producto_servicio) WHERE (factura.id_estado_pago=2 AND cliente.nombre_cliente LIKE '%$busqueda%') ORDER BY factura.fecha DESC LIMIT $inicio, $registros";
        } else {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS factura.idfactura, factura.id_cliente, cliente.nombre_cliente, factura.fecha, factura.id_estado_pago, producto_servicio.nombre_producto_servicio, detalle_factura.precio, detalle_factura.mes_pagado FROM factura JOIN cliente ON (factura.id_cliente=cliente.id_cliente) JOIN detalle_factura ON (factura.idfactura=detalle_factura.id_factura) JOIN producto_servicio ON (detalle_factura.id_producto_servicio=producto_servicio.id_producto_servicio) WHERE factura.id_estado_pago=2 ORDER BY factura.fecha DESC LIMIT $inicio, $registros";
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
					<th class="d-th text-light col-sm-auto">#</th>
					<th class="d-th text-light col-sm-auto">CLIENTE</th>
					<th class="d-th text-light col-sm-auto">FECHA</th>
					<th class="d-th text-light col-sm-auto">MES</th>
					<th class="d-th text-light col-sm-auto">TOTAL</th>
                    <th class="d-th text-light col-sm-auto">ESTADO</th>
                    <th class="d-th text-light col-sm-auto">EDITAR</th>
                    <th class="d-th text-light col-sm-auto">PAGAR</th>
                    <th class="d-th text-light col-sm-auto">IMPRIMIR</th>
                    <th class="d-th text-light col-sm-auto">ELIMINAR</th>
				</tr>
			</thead>
			<tbody id="myTable">
		';

        if ($total >= 1 && $pagina <= $Npaginas) {
            $contador = $inicio + 1;
            $registro_inicial = $inicio + 1;
            foreach ($datos as $rows) {
                if ($rows['id_estado_pago'] == 1) {
                    $rows['id_estado_pago'] = "Cancelado";
                } else {
                    $rows['id_estado_pago'] = "Pendiente";
                }
                $tabla .= '
					<tr class="text-center">
                        <td>' . $rows['idfactura'] . '</td>
                        <td class="d-td text-secondary">' . $rows['nombre_cliente'] . '</td>
                        <td class="d-td text-secondary">' . $rows['fecha'] . '</td>
                        <td class="d-td text-secondary">' . $rows['mes_pagado'] . '</td>
                        <td class="d-td text-secondary">Q.' . $rows['precio'] . '</td>
                        <td class="d-td text-secondary">' . $rows['id_estado_pago'] . '</td>
                        <td>
                            <a href="' . SERVERURL . 'editar-factura/' . mainModel::encryption($rows['idfactura']) . '/" type="button" class="btn btn-outline-light btn-icon-text">
                                <i class="mdi mdi-pen"></i>
                            </a>
                        </td>
                        <td>
                        <a data-toggle="modal" data-id="' . $rows['nombre_producto_servicio'] . '" class="open-mostrarDescripcion btn btn-outline-success btn-icon-text" href="#mostrarDescripcion"><i class="mdi mdi-cash-multiple"></i></a>
                        </td>
                        <td>
                            <a href="' . SERVERURL . 'facturas/invoice.php?id=' . mainModel::encryption($rows['id_cliente']) . '&idf=' . mainModel::encryption($rows['idfactura']) . '" type="button" class="btn btn-outline-light btn-icon-text" target="_blank">
                                <i class="mdi mdi-printer"></i>
                            </a>
                        </td>
						<td>
						    <form class="FormularioAjax" action="' . SERVERURL . 'ajax/trabajoAjax.php" method="POST" data-form="delete" autocomplete="off">
								<input type="hidden" name="orden_trabajo_id_delete" value="' . mainModel::encryption($rows['idfactura']) . '">
								<button type="submit" class="btn btn-outline-danger btn-icon-text" data-toggle="modal" >
									<i class="mdi mdi-delete-sweep"></i>
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
                $tabla .= '<tr><td colspan="9">No hay Facturas pendientes de pago por el momento</td></tr>';
            }
        }

        $tabla .= '</tbody></table></div>';

        if ($total >= 1 && $pagina <= $Npaginas) {
            $tabla .= '
			<div class="row col-md-12 justify-content-center">
				<p class="text-center">
				Mostrando factura ' . $registro_inicial . ' al ' . $registro_final . ' de un total de ' . $total . '
				</p>
			</div>';

            $tabla .= mainModel::paginador_tablas($pagina, $Npaginas, $url, 5);
        }
        return $tabla;
    } // fin controlador


    // COntrolador Paginar trabajo
    public function PaginadorFacturasCanceladasControlador($pagina, $registros, $rol, $id, $url, $busqueda)
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
            $consulta = "SELECT SQL_CALC_FOUND_ROWS factura.idfactura, factura.id_cliente, cliente.nombre_cliente, factura.fecha, factura.id_estado_pago, producto_servicio.nombre_producto_servicio, detalle_factura.precio, detalle_factura.mes_pagado FROM factura JOIN cliente ON (factura.id_cliente=cliente.id_cliente) JOIN detalle_factura ON (factura.idfactura=detalle_factura.id_factura) JOIN producto_servicio ON (detalle_factura.id_producto_servicio=producto_servicio.id_producto_servicio) WHERE (factura.id_estado_pago=1 OR cliente.nombre_cliente LIKE '%$busqueda%') ORDER BY factura.fecha DESC LIMIT $inicio, $registros";
        } else {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS factura.idfactura, factura.id_cliente, cliente.nombre_cliente, factura.fecha, factura.id_estado_pago, producto_servicio.nombre_producto_servicio, detalle_factura.precio, detalle_factura.mes_pagado FROM factura JOIN cliente ON (factura.id_cliente=cliente.id_cliente) JOIN detalle_factura ON (factura.idfactura=detalle_factura.id_factura) JOIN producto_servicio ON (detalle_factura.id_producto_servicio=producto_servicio.id_producto_servicio) WHERE factura.id_estado_pago=1 ORDER BY factura.fecha DESC LIMIT $inicio, $registros";
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
					<th class="text-light col-sm-auto">No.</th>
					<th class="text-light col-sm-auto">CLIENTE</th>
					<th class="text-light col-sm-auto">FECHA FACTURA</th>
					<th class="text-light col-sm-auto">MES A PAGAR</th>
					<th class="text-light col-sm-auto">TOTAL</th>
                    <th class="text-light col-sm-auto">ESTADO</th>
                    <th class="text-light col-sm-auto">VER</th>
                    <th class="text-light col-sm-auto">EDITAR</th>
                    <th class="text-light col-sm-auto">FINALIZAR</th>
                    <th class="text-light col-sm-auto">ELIMINAR</th>
				</tr>
			</thead>
			<tbody id="myTable">
		';

        if ($total >= 1 && $pagina <= $Npaginas) {
            $contador = $inicio + 1;
            $registro_inicial = $inicio + 1;
            foreach ($datos as $rows) {
                if ($rows['id_estado_pago'] == 1) {
                    $rows['id_estado_pago'] = "Cancelado";
                } else {
                    $rows['id_estado_pago'] = "Pendiente";
                }
                $tabla .= '
					<tr class="text-center">
                        <td>' . $contador . '</td>
                        <td class="text-secondary">' . $rows['nombre_cliente'] . '</td>
                        <td class="text-secondary">' . $rows['fecha'] . '</td>
                        <td class="text-secondary">' . $rows['mes_pagado'] . '</td>
                        <td class="text-secondary">' . $rows['precio'] . '</td>
                        <td class="text-secondary">' . $rows['id_estado_pago'] . '</td>
                        <td>
                        <a data-toggle="modal" data-id="' . $rows['nombre_producto_servicio'] . '" class="open-mostrarDescripcion btn btn-inverse-success btn-icon-text" href="#mostrarDescripcion"><i class="mdi mdi-eye btn-icon-prepend"></i>Ver</a>
                        </td>
                        <td>
                            <a href="' . SERVERURL . 'editar-trabajo/' . mainModel::encryption($rows['idfactura']) . '/" type="button" class="btn btn-inverse-warning btn-icon-text">
                                <i class="mdi mdi-lead-pencil btn-icon-prepend"></i>
                            </a>
                        </td>
                        <td>
						    <form class="FormularioAjax" action="' . SERVERURL . 'ajax/trabajoAjax.php" method="POST" data-form="finish" autocomplete="off">
								<input type="hidden" name="orden_trabajo_finish" value="' . mainModel::encryption($rows['idfactura']) . '">
								<button type="submit" class="btn btn-inverse-primary btn-icon-text" data-toggle="modal" >
									<i class="mdi mdi-checkbox-multiple-marked-outline btn-icon-prepend"></i>
								</button>
							</form>
						</td>
						<td>
						    <form class="FormularioAjax" action="' . SERVERURL . 'ajax/trabajoAjax.php" method="POST" data-form="delete" autocomplete="off">
								<input type="hidden" name="orden_trabajo_id_delete" value="' . mainModel::encryption($rows['idfactura']) . '">
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
                $tabla .= '<tr><td colspan="9">No hay Facturas pendientes de pago por el momento</td></tr>';
            }
        }

        $tabla .= '</tbody></table></div>';

        if ($total >= 1 && $pagina <= $Npaginas) {
            $tabla .= '
			<div class="row col-md-12 justify-content-center">
				<p class="text-center">
				Mostrando factura ' . $registro_inicial . ' al ' . $registro_final . ' de un total de ' . $total . '
				</p>
			</div>';

            $tabla .= mainModel::paginador_tablas($pagina, $Npaginas, $url, 5);
        }
        return $tabla;
    } // fin controlador


    // Controlador datos de la factura
    public function datosFacturaControlador($tipo, $id)
    {
        $tipo = mainModel::limpiar_cadena($tipo);
        $id = mainModel::decryption($id);
        $id = mainModel::limpiar_cadena($id);
        return facturaModelo::datosFacturaModelo($tipo, $id);
    } //fin controlador

    // Controlador datos del usuario que imprime la factura
    public function datosUsuarioFacturaControlador($id)
    {
        $id = mainModel::decryption($id);
        $id = mainModel::limpiar_cadena($id);

        return facturaModelo::datosUsuarioFacturaModelo($id);
    } //fin controlador

    // Controlador datos del detalle de la Factura
    public function datosDetalleFacturaControlador($id)
    {
        $id = mainModel::decryption($id);
        $id = mainModel::limpiar_cadena($id);
        $ids = mainModel::decryption("U0EwcURpK0Z3ajU0K0JmV2VhRnJFUT09");


        return facturaModelo::datosDetalleFacturaModelo($id);
    } //fin controlador


    // controlador actualizar factura y detalle factura
    public function actualizarFacturaControlador()
    {
        // recibiendo id de factura y detallefactura
        $idfactura = mainModel::decryption($_POST['factura_id_update']);
        $iddetallefactura = ($_POST['id_detalle_update']);
        $idfactura = mainModel::limpiar_cadena($idfactura);
        $iddetallefactura = mainModel::limpiar_cadena($iddetallefactura);

        // comprobar privilegios
        session_start(['name' => 'LMR']);
        if ($_SESSION['id_rol_lmr'] > 2) {
            $alerta = [
                "Alerta" => "exitoredireccion",
                "Titulo" => "PETICIÓN DENEGADA",
                "Texto" => "No tienes los permisos necesarios para realizar esta operación",
                "Tipo" => "error",
                "URL" => SERVERURL . "facturacion/"
            ];
            echo json_encode($alerta);
            exit();
        }

        //comprobar el usuario en la base de datos
        $check_factura = mainModel::ejecutar_consulta_simple("SELECT idfactura FROM factura WHERE idfactura='$idfactura'");

        if ($check_factura->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "DATOS INVALIDOS",
                "Texto" => "NO se encontraron registros de la factura en la base de datos",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $check_detalle_factura = mainModel::ejecutar_consulta_simple("SELECT id_detalle_factura FROM detalle_factura WHERE id_detalle_factura = '$iddetallefactura'");

        if ($check_detalle_factura->rowCount() <= 0) {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "DATOS INVALIDOS",
                "Texto" => "NO hay registros del detalle de la factura en la base de datos",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $fecha = mainModel::limpiar_cadena($_POST['fecha_up']);
        $cliente = mainModel::limpiar_cadena($_POST['id_cliente_up']);
        $usuario = mainModel::limpiar_cadena($_POST['id_usuario_up']);
        $pago = mainModel::limpiar_cadena($_POST['estado_pago_up']);
        $producto = mainModel::limpiar_cadena($_POST['producto_servicio_up']);
        $precio = mainModel::limpiar_cadena($_POST['precio_up']);
        $mes = mainModel::limpiar_cadena($_POST['mes_pagado_up']);


        /*== comprobar campos vacios ==*/
        if ($fecha == "" || $cliente == "" || $usuario == "" || $pago == "" || $producto == "" || $precio == "" || $mes == "") {
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
        $datos_factura_update = [
            "IDFACTURA" => $idfactura,
            "FECHA" => $fecha,
            "ID_CLIENTE" => $cliente,
            "ID_USUARIO" => $usuario,
            "ID_ESTADO_PAGO" => $pago,
        ];

        $exito = 0;
        if (facturaModelo::actualizarFacturaModelo($datos_factura_update)) {
            $exito = 1;

            // Preparando datos para enviarlos al modelo
            $datos_detalle_factura_update = [
                "ID_DETALLE_FACTURA" => $iddetallefactura,
                "IDFACTURA" => $idfactura,
                "ID_PRODUCTO_SERVICIO" => $producto,
                "PRECIO" => $precio,
                "MES_PAGADO" => $mes
            ];

            if (facturaModelo::actualizarDetalleFacturaModelo($datos_detalle_factura_update)) {
                $exito = 2;
            }
        }


        switch ($exito) {
            case 0: {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Operación Abortada",
                        "Texto" => "No se pudo Actualizar los datos de la factura",
                        "Tipo" => "error"
                    ];
                    echo json_encode($alerta);
                    exit();
                    break;
                }
            case 1: {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "Operación Abortada",
                        "Texto" => "No se pudo Actualizar los detalles de la factura",
                        "Tipo" => "error"
                    ];
                    echo json_encode($alerta);
                    exit();
                    break;
                }
            case 2: {
                    $alerta = [
                        "Alerta" => "exitoredireccion",
                        "Titulo" => "COMPLETADO",
                        "Texto" => "Factura y detalles actualizados exitosamente",
                        "Tipo" => "success",
                        "URL" => SERVERURL . "facturacion/"
                    ];
                    echo json_encode($alerta);
                    exit();
                    break;
                }
        }
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

    // controlador para llenar selects
    public function llenarSelect($op, $id, $tabla)
    {
        $op = mainModel::limpiar_cadena($op);
        $id = mainModel::decryption($id);
        $id = mainModel::limpiar_cadena($id);
        $tabla = mainModel::limpiar_cadena($tabla);

        return facturaModelo::datosSelect($op, $id, $tabla);
    } // fin controlador
}
