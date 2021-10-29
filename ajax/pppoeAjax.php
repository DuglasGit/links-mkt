<?php
$peticionAjax = true;
require_once "../config/APP.php";

if (isset($_POST['nombreCliente']) || isset($_POST['cliente_ip_update'])|| isset($_POST['pppoe_id_disabled']) || isset($_POST['pppoe_id_enabled'])) {

    /*--------- Instancia al controlador ---------*/
    require_once "../controllers/pppoeControlador.php";
    $ins_cliente = new pppoeControlador();


    /*--------- Agregar un cliente ---------*/
    if (isset($_POST['nombreCliente']) && isset($_POST['nombreServicio'])) {
        echo $ins_cliente->agregarClienteControlador();
    }

    // actualizar cliente
    if(isset($_POST['cliente_ip_update'])){
        echo $ins_cliente->actualizarClienteControlador();
    }

    // suspender cliente
    if(isset($_POST['pppoe_id_disabled']) && isset($_POST['pppoe_name_disabled']) && isset($_POST['pppoe_ip_disabled'])){
        echo $ins_cliente->suspenderClienteControlador();
    }

    /*--------- Reactivar servicios de un cliente ---------*/
    if (isset($_POST['cliente_id_enabled'])) {
        echo $ins_cliente->reactivarClienteControlador();
    }

} else {
    session_start(['name' => 'LMR']);
    session_unset();
    session_destroy();
    header("Location: " . SERVERURL . "login/");
    exit();
}
