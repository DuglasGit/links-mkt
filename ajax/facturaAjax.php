<?php
$peticionAjax = true;
require_once "../config/APP.php";

if (isset($_POST['fechaAsignada']) || isset($_POST['mes']) || isset($_POST['factura_id_update']) || isset($_POST['factura_cancelada_id_update']) || isset($_POST['factura_cancelada_id_updateH']) || isset($_POST['id_cliente_reg']) || isset($_POST['idfactura_pay']) || isset($_POST['idfactura_delete'])) {

    /*--------- Instancia al controlador ---------*/
    require_once "../controllers/facturaControlador.php";
    $ins_factura = new facturaControlador();

    /*--------- Generar facturas en Serie ---------*/
    if (isset($_POST['fechaAsignada']) && isset($_POST['mes'])) {
        echo $ins_factura->generarFacturasEnSerieCOntrolador();
    }

    /*--------- Agregar nueva factura individual ---------*/
    if (isset($_POST['id_cliente_reg']) && isset($_POST['mes_pagado_reg'])) {
        echo $ins_factura->generarFacturaIndividualControlador();
    }

    /*--------- Pagar factura individual ---------*/
    if (isset($_POST['idfactura_pay']) && isset($_POST['idfactura_detalle_pay'])) {
        echo $ins_factura->PagarFacturaIndividualControlador();
    }

    /*--------- Eliminar una factura pendiente de pago ---------*/
    if (isset($_POST['idfactura_delete']) && isset($_POST['idfactura_detalle_delete'])) {
        echo $ins_factura->eliminarFacturaControlador();
    }


    // actualizar factura y detalle factura Pendiente
    if (isset($_POST['factura_id_update']) && isset($_POST['id_detalle_update'])) {
        echo $ins_factura->actualizarFacturaControlador();
    }

    // actualizar factura y detalle factura Cancelada de hoy
    if (isset($_POST['factura_cancelada_id_update']) && isset($_POST['id_detalle_cancelado_update'])) {
        echo $ins_factura->actualizarFacturaCanceladaControlador();
    }

    // actualizar factura y detalle factura Cancelada en el historial
    if (isset($_POST['factura_cancelada_id_updateH']) && isset($_POST['id_detalle_cancelado_updateH'])) {
        echo $ins_factura->actualizarFacturaCanceladaHistorialControlador();
    }

} else {
    session_start(['name' => 'LMR']);
    session_unset();
    session_destroy();
    header("Location: " . SERVERURL . "login/");
    exit();
}
