<?php
require_once "mainModel.php";

class facturaModelo extends mainModel
{

    /* -- Modelo generar facturas en serie --*/
    protected static function generarFacturaEnSerieModelo($datos)
    {

        $sql = mainModel::conectar()->prepare("SELECT cliente.id_cliente, plan_servicio.precio FROM cliente JOIN contrato_servicio ON(cliente.id_cliente=contrato_servicio.id_cliente) JOIN plan_servicio ON(contrato_servicio.plan_contrato=plan_servicio.nombre_plan) WHERE id_tipo_cliente !=3");
        $sql->execute();
        $cliente = $sql->fetchAll();

        foreach ($cliente as $row) {
            $sql = mainModel::conectar()->prepare("INSERT INTO factura(fecha,id_cliente,id_usuario,id_estado_pago) VALUES(:FECHA,:ID_CLIENTE,:ID_USUARIO,:ID_ESTADO_PAGO)");

            $sql->bindParam(":FECHA", $datos['FECHA']);
            $sql->bindParam(":ID_CLIENTE", $row['id_cliente']);
            $sql->bindParam(":ID_USUARIO", $datos['ID_USUARIO']);
            $sql->bindParam(":ID_ESTADO_PAGO", $datos['ID_ESTADO_PAGO']);

            $sql->execute();
        }

        $sql = mainModel::conectar()->prepare("SELECT factura.idfactura, cliente.id_cliente, plan_servicio.precio FROM cliente JOIN factura ON(cliente.id_cliente=factura.id_cliente) JOIN contrato_servicio ON(cliente.id_cliente=contrato_servicio.id_cliente) JOIN plan_servicio ON(contrato_servicio.plan_contrato=plan_servicio.nombre_plan) WHERE id_tipo_cliente !=3 AND factura.fecha=:FECHA");
        $sql->bindParam(":FECHA", $datos['FECHA']);
        $sql->execute();
        $factura = $sql->fetchAll();

        foreach ($factura as $val) {
            $sql = mainModel::conectar()->prepare("INSERT INTO detalle_factura(id_factura,cantidad,id_producto_servicio,precio,mes_pagado) VALUES(:ID_FACTURA, :CANTIDAD,:ID_PRODUCTO_SERVICIO,:PRECIO,:MES_PAGADO)");

            $sql->bindParam(":ID_FACTURA", $val['idfactura']);
            $sql->bindParam(":CANTIDAD", $datos['CANTIDAD']);
            $sql->bindParam(":ID_PRODUCTO_SERVICIO", $datos['ID_PRODUCTO_SERVICIO']);
            $sql->bindParam(":PRECIO", $val['precio']);
            $sql->bindParam(":MES_PAGADO", $datos['MES']);

            $sql->execute();
        }
        return $sql;
    }

    /* -- Modelo agregar nueva factura individual --*/
    protected static function agregarfacturaindividualModelo($datos, $tabla)
    {
        switch ($tabla) {
            case 'factura': {
                    $sql = mainModel::conectar()->prepare("INSERT INTO factura (fecha, id_cliente, id_usuario, id_estado_pago) VALUES(:FECHA,:ID_CLIENTE,:ID_USUARIO,:ID_ESTADO_PAGO)");
                    $sql->bindParam(":FECHA", $datos['FECHA']);
                    $sql->bindParam(":ID_CLIENTE", $datos['ID_CLIENTE']);
                    $sql->bindParam(":ID_USUARIO", $datos['ID_USUARIO']);
                    $sql->bindParam(":ID_ESTADO_PAGO", $datos['ID_ESTADO_PAGO']);

                    $sql->execute();
                    return $sql;
                    break;
                }
            case 'detalle': {
                    $sql = mainModel::conectar()->prepare("SELECT idfactura FROM factura WHERE fecha=:FECHA AND id_cliente=:ID_CLIENTE");
                    $sql->bindParam(":FECHA", $datos['FECHA']);
                    $sql->bindParam(":ID_CLIENTE", $datos['ID_CLIENTE']);

                    $sql->execute();
                    $idfactura = $sql->fetchAll();

                    foreach ($idfactura as $row) {

                        $sql = mainModel::conectar()->prepare("INSERT INTO detalle_factura (id_factura, cantidad, id_producto_servicio, precio, mes_pagado) VALUES(:IDFACTURA, :CANTIDAD, :ID_PRODUCTO_SERVICIO, :PRECIO, :MES_PAGADO)");
                        $sql->bindParam(":IDFACTURA", $row['idfactura']);
                        $sql->bindParam(":CANTIDAD", $datos['CANTIDAD']);
                        $sql->bindParam(":ID_PRODUCTO_SERVICIO", $datos['ID_PRODUCTO_SERVICIO']);
                        $sql->bindParam(":PRECIO", $datos['PRECIO']);
                        $sql->bindParam(":MES_PAGADO", $datos['MES_PAGADO']);

                        $sql->execute();
                    }
                    return $sql;
                    break;
                }
        }
    }


    /* -- Modelo Eliminar factura y detalle cuando está pendiente de pago --*/
    protected static function EliminarDetalleFacturaModelo($id, $tabla)
    {
        switch ($tabla) {
            case "detalle": {
                    $sql = mainModel::conectar()->prepare("DELETE FROM detalle_factura WHERE id_detalle_factura=:ID");
                    $sql->bindParam(":ID", $id);
                    $sql->execute();
                    return $sql;

                    break;
                }
            case "factura": {
                    $sql = mainModel::conectar()->prepare("DELETE FROM factura WHERE idfactura=:ID");
                    $sql->bindParam(":ID", $id);
                    $sql->execute();
                    return $sql;
                    break;
                }
        }
    }

    // Modelo para datos de la edición de la factura Pendiente de pago
    protected static function datosFacturaModelo($tipo, $id)
    {
        switch ($tipo) {
            case "Unico": {
                    $sql = mainModel::conectar()->prepare("SELECT detalle_factura.id_detalle_factura, factura.idfactura, factura.id_cliente, cliente.nombre_cliente, cliente.telefono_cliente, municipio.nombre_municipio, cliente.domicilio, factura.fecha, factura.id_estado_pago, producto_servicio.id_producto_servicio, producto_servicio.nombre_producto_servicio, detalle_factura.cantidad, detalle_factura.precio, detalle_factura.mes_pagado FROM factura JOIN cliente ON (factura.id_cliente=cliente.id_cliente) JOIN municipio ON (cliente.id_municipio=municipio.id_municipio) JOIN detalle_factura ON (factura.idfactura=detalle_factura.id_factura) JOIN producto_servicio ON (detalle_factura.id_producto_servicio=producto_servicio.id_producto_servicio) WHERE factura.id_estado_pago=2 AND factura.idfactura=:ID");
                    $sql->bindParam(":ID", $id);
                    $sql->execute();
                    return $sql;
                    break;
                }
            case "unico_cancelado": {
                    $sql = mainModel::conectar()->prepare("SELECT detalle_factura.id_detalle_factura, factura.idfactura, factura.id_cliente, cliente.nombre_cliente, cliente.telefono_cliente, municipio.nombre_municipio, cliente.domicilio, factura.fecha, factura.id_estado_pago, producto_servicio.id_producto_servicio, producto_servicio.nombre_producto_servicio, detalle_factura.cantidad, detalle_factura.precio, detalle_factura.mes_pagado FROM factura JOIN cliente ON (factura.id_cliente=cliente.id_cliente) JOIN municipio ON (cliente.id_municipio=municipio.id_municipio) JOIN detalle_factura ON (factura.idfactura=detalle_factura.id_factura) JOIN producto_servicio ON (detalle_factura.id_producto_servicio=producto_servicio.id_producto_servicio) WHERE factura.id_estado_pago=1 AND factura.idfactura=:ID");
                    $sql->bindParam(":ID", $id);
                    $sql->execute();
                    return $sql;
                    break;
                }
                case "unico_cancelado_pdf": {
                    $sql = mainModel::conectar()->prepare("SELECT detalle_factura.id_detalle_factura, factura.idfactura, factura.id_cliente, cliente.nombre_cliente, cliente.telefono_cliente, municipio.nombre_municipio, cliente.domicilio, factura.fecha, factura.id_estado_pago, producto_servicio.id_producto_servicio, producto_servicio.nombre_producto_servicio, detalle_factura.cantidad, detalle_factura.precio, detalle_factura.mes_pagado FROM factura JOIN cliente ON (factura.id_cliente=cliente.id_cliente) JOIN municipio ON (cliente.id_municipio=municipio.id_municipio) JOIN detalle_factura ON (factura.idfactura=detalle_factura.id_factura) JOIN producto_servicio ON (detalle_factura.id_producto_servicio=producto_servicio.id_producto_servicio) WHERE factura.id_estado_pago=1 AND factura.idfactura=:ID");
                    $sql->bindParam(":ID", $id);
                    $sql->execute();
                    return $sql;
                    break;
                }
        }

    }

    // Modelo datos del deltalle de la factura
    protected static function datosDetalleFacturaModelo($idcliente, $fechaHoy)
    {
        $sql = mainModel::conectar()->prepare("SELECT detalle_factura.id_detalle_factura, detalle_factura.cantidad, detalle_factura.id_producto_servicio, producto_servicio.nombre_producto_servicio, detalle_factura.precio, detalle_factura.mes_pagado FROM detalle_factura JOIN producto_servicio ON (detalle_factura.id_producto_servicio=producto_servicio.id_producto_servicio) JOIN factura ON(detalle_factura.id_factura=factura.idfactura) WHERE factura.id_estado_pago=1 AND factura.id_cliente=:ID AND factura.fecha_pago=:FECHA_PAGO");
        $sql->bindParam(":ID", $idcliente);
        $sql->bindParam(":FECHA_PAGO", $fechaHoy);

        $sql->execute();
        return $sql;
    }


    // Modelo para actualizar la factura
    protected static function actualizarFacturaModelo($datos)
    {
        $sql = mainModel::conectar()->prepare("UPDATE factura SET fecha=:FECHA, id_cliente=:ID_CLIENTE, id_usuario=:ID_USUARIO, id_estado_pago=:ID_ESTADO_PAGO WHERE idfactura=:IDFACTURA");
        $sql->bindParam(":FECHA", $datos['FECHA']);
        $sql->bindParam(":ID_CLIENTE", $datos['ID_CLIENTE']);
        $sql->bindParam(":ID_USUARIO", $datos['ID_USUARIO']);
        $sql->bindParam(":ID_ESTADO_PAGO", $datos['ID_ESTADO_PAGO']);
        $sql->bindParam(":IDFACTURA", $datos['IDFACTURA']);
        $sql->execute();

        return $sql;
    }

    // Modelo para actualizar el detalle de la factura
    protected static function actualizarDetalleFacturaModelo($datos)
    {
        $sql = mainModel::conectar()->prepare("UPDATE detalle_factura SET id_factura=:IDFACTURA, id_producto_servicio=:ID_PRODUCTO_SERVICIO, precio=:PRECIO, mes_pagado=:MES_PAGADO WHERE id_detalle_factura=:ID_DETALLE_FACTURA");
        $sql->bindParam(":IDFACTURA", $datos['IDFACTURA']);
        $sql->bindParam(":ID_PRODUCTO_SERVICIO", $datos['ID_PRODUCTO_SERVICIO']);
        $sql->bindParam(":PRECIO", $datos['PRECIO']);
        $sql->bindParam(":MES_PAGADO", $datos['MES_PAGADO']);
        $sql->bindParam(":ID_DETALLE_FACTURA", $datos['ID_DETALLE_FACTURA']);
        $sql->execute();

        return $sql;
    }


    // Modelo para actualizar estado del pago de la factura
    protected static function PagarFacturaModelo($datos)
    {
        $sql = mainModel::conectar()->prepare("UPDATE factura SET id_usuario=:ID_USUARIO, id_estado_pago=:ID_ESTADO_PAGO, fecha_pago=:FECHA_PAGO WHERE idfactura=:IDFACTURA");
        $sql->bindParam(":ID_USUARIO", $datos['ID_USUARIO']);
        $sql->bindParam(":ID_ESTADO_PAGO", $datos['ID_ESTADO_PAGO']);
        $sql->bindParam(":FECHA_PAGO", $datos['FECHA_PAGO']);
        $sql->bindParam(":IDFACTURA", $datos['IDFACTURA']);
        $sql->execute();

        return $sql;
    }


    //modelo para llenar selects de formulario actualizar-factura
    protected static function datosSelect($tipo, $id, $tabla)
    {
        switch ($tabla) {
            case "cliente": {
                    if ($tipo == "actual") {
                        $sql = mainModel::conectar()->prepare("SELECT id_cliente, nombre_cliente FROM cliente WHERE id_tipo_cliente!=3 AND id_cliente=:ID");
                        $sql->bindParam(":ID", $id);
                        $sql->execute();
                        return $sql;
                    } elseif ($tipo == "todo") {
                        $sql = mainModel::conectar()->prepare("SELECT id_cliente, nombre_cliente FROM cliente WHERE id_tipo_cliente!=3");
                        $sql->execute();
                        return $sql;
                    }
                    break;
                }
            case "estado": {
                    if ($tipo == "actual") {
                        $sql = mainModel::conectar()->prepare("SELECT estado_pago.id_estado_pago, estado_pago.nombre_estado FROM estado_pago
                        JOIN factura ON(estado_pago.id_estado_pago=factura.id_estado_pago)
                        WHERE factura.idfactura=:ID");
                        $sql->bindParam(":ID", $id);
                        $sql->execute();
                        return $sql;
                    } elseif ($tipo == "todo") {
                        $sql = mainModel::conectar()->prepare("SELECT * FROM estado_pago;");
                        $sql->execute();
                        return $sql;
                    }
                    break;
                }
            case "producto": {
                    if ($tipo == "actual") {
                        $sql = mainModel::conectar()->prepare("SELECT producto_servicio.id_producto_servicio, producto_servicio.nombre_producto_servicio
                        FROM producto_servicio JOIN detalle_factura ON(producto_servicio.id_producto_servicio=detalle_factura.id_producto_servicio)
                        WHERE detalle_factura.id_factura=:ID");
                        $sql->bindParam(":ID", $id);
                        $sql->execute();
                        return $sql;
                    } elseif ($tipo == "todo") {
                        $sql = mainModel::conectar()->prepare("SELECT * FROM producto_servicio;");
                        $sql->execute();
                        return $sql;
                    }
                    break;
                }
            case "precio": {
                    if ($tipo == "actual") {
                        $sql = mainModel::conectar()->prepare("SELECT plan_servicio.nombre_plan, plan_servicio.precio FROM plan_servicio
                        JOIN contrato_servicio ON(plan_servicio.nombre_plan=contrato_servicio.plan_contrato)
                        JOIN factura ON(contrato_servicio.id_cliente=factura.id_cliente)
                        JOIN detalle_factura ON(factura.idfactura=detalle_factura.id_factura)
                        WHERE detalle_factura.id_factura=:ID");
                        $sql->bindParam(":ID", $id);
                        $sql->execute();
                        return $sql;
                    } elseif ($tipo == "todo") {
                        $sql = mainModel::conectar()->prepare("SELECT nombre_plan, precio FROM plan_servicio WHERE precio>0;");
                        $sql->execute();
                        return $sql;
                    }
                    break;
                }
            default: {
                    break;
                }
        }
    }
}
