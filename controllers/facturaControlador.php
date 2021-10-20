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



    // COntrolador Paginar Facturas pendientes de pago
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
            $consulta = "SELECT SQL_CALC_FOUND_ROWS factura.idfactura, factura.id_cliente, cliente.nombre_cliente, factura.fecha, factura.id_estado_pago, producto_servicio.nombre_producto_servicio, detalle_factura.id_detalle_factura, detalle_factura.precio, detalle_factura.mes_pagado FROM factura JOIN cliente ON (factura.id_cliente=cliente.id_cliente) JOIN detalle_factura ON (factura.idfactura=detalle_factura.id_factura) JOIN producto_servicio ON (detalle_factura.id_producto_servicio=producto_servicio.id_producto_servicio) WHERE (factura.id_estado_pago=2 AND cliente.nombre_cliente LIKE '%$busqueda%') ORDER BY factura.fecha DESC LIMIT $inicio, $registros";
        } else {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS factura.idfactura, factura.id_cliente, cliente.nombre_cliente, factura.fecha, factura.id_estado_pago, producto_servicio.nombre_producto_servicio, detalle_factura.id_detalle_factura, detalle_factura.precio, detalle_factura.mes_pagado FROM factura JOIN cliente ON (factura.id_cliente=cliente.id_cliente) JOIN detalle_factura ON (factura.idfactura=detalle_factura.id_factura) JOIN producto_servicio ON (detalle_factura.id_producto_servicio=producto_servicio.id_producto_servicio) WHERE factura.id_estado_pago=2 ORDER BY factura.fecha DESC LIMIT $inicio, $registros";
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
					<th class="d-th text-light col-sm-auto">ID</th>
					<th class="d-th text-light col-sm-auto">CLIENTE</th>
					<th class="d-th text-light col-sm-auto">FECHA</th>
					<th class="d-th text-light col-sm-auto">MES</th>
					<th class="d-th text-light col-sm-auto">TOTAL</th>
                    <th class="d-th text-light col-sm-auto">ESTADO</th>
                    <th class="d-th text-light col-sm-auto">EDITAR</th>
                    <th class="d-th text-light col-sm-auto">PAGAR</th>
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
						    <form class="FormularioAjax" action="' . SERVERURL . 'ajax/facturaAjax.php" method="POST" data-form="pay" autocomplete="off">
								<input type="hidden" name="idfactura_pay" value="' . mainModel::encryption($rows['idfactura']) . '">
                                <input type="hidden" name="idfactura_detalle_pay" value="' . mainModel::encryption($rows['id_detalle_factura']) . '">
								<button type="submit" class="btn btn-outline-success btn-icon-text" data-toggle="modal" >
									<i class="mdi mdi-cash-multiple"></i>
								</button>
							</form>
						</td>
						<td>
						    <form class="FormularioAjax" action="' . SERVERURL . 'ajax/facturaAjax.php" method="POST" data-form="delete" autocomplete="off">
                                <input type="hidden" name="idfactura_delete" value="' . mainModel::encryption($rows['idfactura']) . '">
                                <input type="hidden" name="idfactura_detalle_delete" value="' . mainModel::encryption($rows['id_detalle_factura']) . '">
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


    // Controlador Paginar Facturas Pagadas
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
        $hoy = date('Y-m-d');
        if (isset($busqueda) && $busqueda != "") {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS factura.idfactura, factura.id_cliente, cliente.nombre_cliente, factura.fecha, factura.id_estado_pago, factura.fecha_pago, producto_servicio.nombre_producto_servicio, detalle_factura.id_detalle_factura, detalle_factura.precio, detalle_factura.mes_pagado FROM factura JOIN cliente ON (factura.id_cliente=cliente.id_cliente) JOIN detalle_factura ON (factura.idfactura=detalle_factura.id_factura) JOIN producto_servicio ON (detalle_factura.id_producto_servicio=producto_servicio.id_producto_servicio) WHERE (factura.id_estado_pago=1 AND factura.fecha_pago='$hoy' AND cliente.nombre_cliente LIKE '%$busqueda%') ORDER BY factura.fecha ASC LIMIT $inicio, $registros";
        } else {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS factura.idfactura, factura.id_cliente, cliente.nombre_cliente, factura.fecha, factura.id_estado_pago, factura.fecha_pago, producto_servicio.nombre_producto_servicio, detalle_factura.id_detalle_factura, detalle_factura.precio, detalle_factura.mes_pagado FROM factura JOIN cliente ON (factura.id_cliente=cliente.id_cliente) JOIN detalle_factura ON (factura.idfactura=detalle_factura.id_factura) JOIN producto_servicio ON (detalle_factura.id_producto_servicio=producto_servicio.id_producto_servicio) WHERE factura.id_estado_pago=1 AND factura.fecha_pago='$hoy' ORDER BY factura.fecha ASC LIMIT $inicio, $registros";
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
					<th class="d-th text-light col-sm-auto">ID</th>
					<th class="d-th text-light col-sm-auto">CLIENTE</th>
					<th class="d-th text-light col-sm-auto">FECHA PAGO</th>
					<th class="d-th text-light col-sm-auto">MES</th>
					<th class="d-th text-light col-sm-auto">TOTAL</th>
                    <th class="d-th text-light col-sm-auto">ESTADO</th>
                    <th class="d-th text-light col-sm-auto">EDITAR</th>
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
                        <td class="d-td text-secondary">' . $rows['fecha_pago'] . '</td>
                        <td class="d-td text-secondary">' . $rows['mes_pagado'] . '</td>
                        <td class="d-td text-secondary">Q.' . $rows['precio'] . '</td>
                        <td class="d-td text-secondary">' . $rows['id_estado_pago'] . '</td>
                        <td>
                            <a href="' . SERVERURL . 'editar-factura-cancelada/' . mainModel::encryption($rows['idfactura']) . '/" type="button" class="btn btn-outline-warning btn-icon-text">
                                <i class="mdi mdi-pen"></i>
                            </a>
                        </td>
                        <td>
                            <a href="' . SERVERURL . 'facturas/invoice.php?id=' . mainModel::encryption($rows['id_cliente']) . '&idf=' . mainModel::encryption($rows['idfactura']) . '&op=t' . '" type="button" class="btn btn-outline-primary btn-icon-text" target="_blank">
                                <i class="mdi mdi-printer"></i>
                            </a>
                        </td>
						<td>
						    <form class="FormularioAjax" action="' . SERVERURL . 'ajax/facturaAjax.php" method="POST" data-form="delete" autocomplete="off">
                                <input type="hidden" name="idfactura_delete" value="' . mainModel::encryption($rows['idfactura']) . '">
                                <input type="hidden" name="idfactura_detalle_delete" value="' . mainModel::encryption($rows['id_detalle_factura']) . '">
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
                $tabla .= '<tr><td colspan="9">No hay Facturas pagadas el día de hoy</td></tr>';
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


    // Controlador Paginar Facturas Pagadas
    public function PaginadorHistorialFacturasCanceladasControlador($pagina, $registros, $rol, $id, $url, $busqueda)
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
            $consulta = "SELECT SQL_CALC_FOUND_ROWS factura.idfactura, factura.id_cliente, cliente.nombre_cliente, factura.fecha, factura.id_estado_pago, factura.fecha_pago, producto_servicio.nombre_producto_servicio, detalle_factura.id_detalle_factura, detalle_factura.precio, detalle_factura.mes_pagado FROM factura JOIN cliente ON (factura.id_cliente=cliente.id_cliente) JOIN detalle_factura ON (factura.idfactura=detalle_factura.id_factura) JOIN producto_servicio ON (detalle_factura.id_producto_servicio=producto_servicio.id_producto_servicio) WHERE (factura.id_estado_pago=1 AND cliente.nombre_cliente LIKE '%$busqueda%') ORDER BY factura.fecha_pago DESC LIMIT $inicio, $registros";
        } else {
            $consulta = "SELECT SQL_CALC_FOUND_ROWS factura.idfactura, factura.id_cliente, cliente.nombre_cliente, factura.fecha, factura.id_estado_pago, factura.fecha_pago, producto_servicio.nombre_producto_servicio, detalle_factura.id_detalle_factura, detalle_factura.precio, detalle_factura.mes_pagado FROM factura JOIN cliente ON (factura.id_cliente=cliente.id_cliente) JOIN detalle_factura ON (factura.idfactura=detalle_factura.id_factura) JOIN producto_servicio ON (detalle_factura.id_producto_servicio=producto_servicio.id_producto_servicio) WHERE factura.id_estado_pago=1 ORDER BY factura.fecha_pago DESC LIMIT $inicio, $registros";
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
                        <th class="d-th text-light col-sm-auto">ID</th>
                        <th class="d-th text-light col-sm-auto">CLIENTE</th>
                        <th class="d-th text-light col-sm-auto">FECHA PAGO</th>
                        <th class="d-th text-light col-sm-auto">MES</th>
                        <th class="d-th text-light col-sm-auto">TOTAL</th>
                        <th class="d-th text-light col-sm-auto">ESTADO</th>
                        <th class="d-th text-light col-sm-auto">EDITAR</th>
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
                            <td class="d-td text-secondary">' . $rows['fecha_pago'] . '</td>
                            <td class="d-td text-secondary">' . $rows['mes_pagado'] . '</td>
                            <td class="d-td text-secondary">Q.' . $rows['precio'] . '</td>
                            <td class="d-td text-secondary">' . $rows['id_estado_pago'] . '</td>
                            <td>
                                <a href="' . SERVERURL . 'editar-factura-cancelada-historial/' . mainModel::encryption($rows['idfactura']) . '/" type="button" class="btn btn-outline-warning btn-icon-text">
                                    <i class="mdi mdi-pen"></i>
                                </a>
                            </td>
                            <td>
                                <a href="' . SERVERURL . 'facturas/invoice.php?id=' . mainModel::encryption($rows['id_cliente']) . '&idf=' . mainModel::encryption($rows['idfactura']) . '&op=h' . '" type="button" class="btn btn-outline-primary btn-icon-text" target="_blank">
                                    <i class="mdi mdi-printer"></i>
                                </a>
                            </td>
                            <td>
						    <form class="FormularioAjax" action="' . SERVERURL . 'ajax/facturaAjax.php" method="POST" data-form="delete" autocomplete="off">
                                <input type="hidden" name="idfactura_delete" value="' . mainModel::encryption($rows['idfactura']) . '">
                                <input type="hidden" name="idfactura_detalle_delete" value="' . mainModel::encryption($rows['id_detalle_factura']) . '">
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
                $tabla .= '<tr><td colspan="9">No hay Historial de Facturas Pagadas por el momento</td></tr>';
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


    // Controlador datos del detalle de la Factura
    public function datosDetalleFacturaControlador($id, $fechaHoy)
    {
        $id = mainModel::decryption($id);
        $id = mainModel::limpiar_cadena($id);

        return facturaModelo::datosDetalleFacturaModelo($id, $fechaHoy);
    } //fin controlador

    // Controlador datos de las facturas pendientes en el reporte del PDF
    public function datosFacturasPendientesControlador($idcliente)
    {
        $idcliente = mainModel::decryption($idcliente);
        $idcliente = mainModel::limpiar_cadena($idcliente);

        return facturaModelo::datosFacturasPendientesModelo($idcliente);
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


    // controlador actualizar factura y detalle factura ya cancelada
    public function actualizarFacturaCanceladaControlador()
    {
        // recibiendo id de factura y detallefactura
        $idfactura = mainModel::decryption($_POST['factura_cancelada_id_update']);
        $iddetallefactura = ($_POST['id_detalle_cancelado_update']);
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

        $fecha = mainModel::limpiar_cadena($_POST['fecha_upC']);
        $cliente = mainModel::limpiar_cadena($_POST['id_cliente_upC']);
        $usuario = mainModel::limpiar_cadena($_POST['id_usuario_upC']);
        $pago = mainModel::limpiar_cadena($_POST['estado_pago_upC']);
        $producto = mainModel::limpiar_cadena($_POST['producto_servicio_upC']);
        $precio = mainModel::limpiar_cadena($_POST['precio_upC']);
        $mes = mainModel::limpiar_cadena($_POST['mes_pagado_upC']);


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
                        "URL" => SERVERURL . "facturas-canceladas/"
                    ];
                    echo json_encode($alerta);
                    exit();
                    break;
                }
        }
    } //fin cntrolador


    // controlador actualizar factura y detalle factura ya cancelada
    public function actualizarFacturaCanceladaHistorialControlador()
    {
        // recibiendo id de factura y detallefactura
        $idfactura = mainModel::decryption($_POST['factura_cancelada_id_updateH']);
        $iddetallefactura = ($_POST['id_detalle_cancelado_updateH']);
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

        $fecha = mainModel::limpiar_cadena($_POST['fecha_upCH']);
        $cliente = mainModel::limpiar_cadena($_POST['id_cliente_upCH']);
        $usuario = mainModel::limpiar_cadena($_POST['id_usuario_upCH']);
        $pago = mainModel::limpiar_cadena($_POST['estado_pago_upCH']);
        $producto = mainModel::limpiar_cadena($_POST['producto_servicio_upCH']);
        $precio = mainModel::limpiar_cadena($_POST['precio_upCH']);
        $mes = mainModel::limpiar_cadena($_POST['mes_pagado_upCH']);


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
                        "URL" => SERVERURL . "facturas-pagadas-historial/"
                    ];
                    echo json_encode($alerta);
                    exit();
                    break;
                }
        }
    } //fin cntrolador


    // controlador para pagar factura individual
    public function PagarFacturaIndividualControlador()
    {
        // recibiendo id de factura y detallefactura
        $idfactura = mainModel::decryption($_POST['idfactura_pay']);
        $iddetallefactura = mainModel::decryption($_POST['idfactura_detalle_pay']);
        $idfactura = mainModel::limpiar_cadena($idfactura);
        $iddetallefactura = mainModel::limpiar_cadena($iddetallefactura);
        $fecha_pago = date('Y/m/d');

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

        /*== comprobar campos vacios ==*/
        if ($idfactura == "" || $iddetallefactura == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "INFORMACIÓN INCOMPLETA",
                "Texto" => "Los Ids de la factura vienen vacíos",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        // Preparando datos para enviarlos al modelo
        $datos_factura_pay = [
            "IDFACTURA" => $idfactura,
            "ID_USUARIO" => $_SESSION['id_rol_lmr'],
            "ID_ESTADO_PAGO" => 1,
            "FECHA_PAGO" => $fecha_pago
        ];

        $exito = 0;
        if (facturaModelo::PagarFacturaModelo($datos_factura_pay)) {
            $exito = 1;
        }


        switch ($exito) {
            case 0: {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "MySQL: Operación Abortada",
                        "Texto" => "No se pudo Realizar la transacción de Pago",
                        "Tipo" => "error"
                    ];
                    echo json_encode($alerta);
                    exit();
                    break;
                }
            case 1: {
                    $alerta = [
                        "Alerta" => "exitoredireccion",
                        "Titulo" => "Pago Registrado",
                        "Texto" => "La transacción se realizó correctamente",
                        "Tipo" => "success",
                        "URL" => SERVERURL . "facturacion/"
                    ];
                    echo json_encode($alerta);
                    exit();
                    break;
                }
        }
    } //fin cntrolador



    // Controlador para Eliminar una factura pendiente o cancelada
    public function eliminarFacturaControlador()
    {
        // recibiendo ids de factura y detalle de factura
        $idfactura = mainModel::decryption($_POST['idfactura_delete']);
        $iddetallefactura = mainModel::decryption($_POST['idfactura_detalle_delete']);
        $idfactura = mainModel::limpiar_cadena($idfactura);
        $iddetallefactura = mainModel::limpiar_cadena($iddetallefactura);


        // comprobar privilegios
        session_start(['name' => 'LMR']);
        if ($_SESSION['id_rol_lmr'] != 1) {
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

        /*== comprobar campos vacios ==*/
        if ($idfactura == "" || $iddetallefactura == "") {
            $alerta = [
                "Alerta" => "simple",
                "Titulo" => "INFORMACIÓN INCOMPLETA",
                "Texto" => "Los Ids de la factura vienen vacíos",
                "Tipo" => "error"
            ];
            echo json_encode($alerta);
            exit();
        }

        $exito = 0;
        $eliminar_detalle = facturaModelo::EliminarDetalleFacturaModelo($iddetallefactura, "detalle");

        if ($eliminar_detalle->rowCount() == 1) {
            $exito = 1;

            $eliminar_factura = facturaModelo::EliminarDetalleFacturaModelo($idfactura, "factura");

            if ($eliminar_factura->rowCount() == 1) {
                $exito = 2;
            }
        }

        switch ($exito) {
            case 0: {
                    $alerta = [
                        "Alerta" => "simple",
                        "Titulo" => "MYSQL: OPERACIÓN RECHAZADA",
                        "Texto" => "No se pudo eliminar el detalle de la factura",
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
                        "Texto" => "No se pudo eliminar la factura despues de eliminar el detalle",
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
                        "Texto" => "La factura y el detalle han sido Borrados del sistema",
                        "Tipo" => "success"
                    ];
                    echo json_encode($alerta);
                    exit();
                    break;
                }
        }
    } // fin controlador



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
