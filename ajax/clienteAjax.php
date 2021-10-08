<?php
$peticionAjax = true;
require_once "../config/APP.php";

if (isset($_POST['nombreCliente']) || isset($_POST['id_cliente_delete']) || isset($_POST['cliente_ip_update'])) {

    /*--------- Instancia al controlador ---------*/
    require_once "../controllers/clienteControlador.php";
    $ins_cliente = new clienteControlador();


    /*--------- Agregar un cliente ---------*/
    if (isset($_POST['nombreCliente']) && isset($_POST['nombreServicio'])) {
        echo $ins_cliente->agregarClienteControlador();
    }

    /*--------- Eliminar un cliente ---------*/
    if (isset($_POST['id_cliente_delete'])) {
        echo $ins_cliente->eliminarClienteControlador();
    }

    // actualizar cliente
    if(isset($_POST['cliente_ip_update'])){
        echo $ins_cliente->actualizarClienteControlador();
    }


} else {
    session_start(['name' => 'LMR']);
    session_unset();
    session_destroy();
    header("Location: " . SERVERURL . "login/");
    exit();
}
