<?php
$peticionAjax = true;
require_once "../config/APP.php";

if (isset($_POST['nombreCliente']) || isset($_POST['id_cliente_delete']) || isset($_POST['id_cliente_update'])) {

    /*--------- Instancia al controlador ---------*/
    require_once "../controllers/clientesControlador.php";
    $ins_cliente = new clientesControlador();


    /*--------- Agregar un usuario ---------*/
    if (isset($_POST['nombreCliente']) && isset($_POST['nombreServicio'])) {
        echo $ins_cliente->agregarClienteControlador();
    }

    /*--------- Eliminar un usuario ---------*/
    if (isset($_POST['id_cliente_delete'])) {
        echo $ins_cliente->eliminarClienteControlador();
    }

    // actualizar usuario
    if(isset($_POST['id_cliente_update'])){
        echo $ins_cliente->actualizarClienteControlador();
    }


} else {
    session_start(['name' => 'LMR']);
    session_unset();
    session_destroy();
    header("Location: " . SERVERURL . "login/");
    exit();
}
