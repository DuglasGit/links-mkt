<?php
$peticionAjax = true;
require_once "../config/APP.php";

if (isset($_POST['fechaAsignada']) || isset($_POST['mes']) || isset($_POST['factura_id_update']) || isset($_POST['id_cliente_reg'])) {

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

    // /*--------- Eliminar una orden de trabajo ---------*/
    // if (isset($_POST['orden_trabajo_id_delete'])) {
    //     echo $ins_trabajo->eliminarTrabajoControlador();
    // }

    //  /*--------- Eliminar una orden de trabajo finalizada---------*/
    //  if (isset($_POST['trabajo_finalizado_delete'])) {
    //     echo $ins_trabajo->eliminarTrabajoTerminadoControlador();
    // }

    // /*--------- Finalizar orden de Trabajo ---------*/
    // if (isset($_POST['orden_trabajo_finish'])) {
    //     echo $ins_trabajo->finalizarTrabajoControlador();
    // }

    // actualizar factura y detalle factura
    if(isset($_POST['factura_id_update'])&&isset($_POST['id_detalle_update'])){
        echo $ins_factura->actualizarFacturaControlador();
    }
    

} else {
    session_start(['name' => 'LMR']);
    session_unset();
    session_destroy();
    header("Location: " . SERVERURL . "login/");
    exit();
}
