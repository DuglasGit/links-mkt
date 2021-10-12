<?php
$peticionAjax = true;
require_once "../config/APP.php";

if ((isset($_POST['nombreEmpresa']) && isset($_POST['ipRouter'])) || (isset($_POST['id_router_update']) && isset($_POST['id_empresa_update']))) {

    /*--------- Instancia al controlador ---------*/
    require_once "../controllers/empresaControlador.php";
    $ins_empresa = new empresaControlador();

    /* Agregar Empresa y Router Mikrotik*/
    if(isset($_POST['nombreEmpresa']) && isset($_POST['ipRouter'])){
        echo $ins_empresa->agregarEmpresaControlador();
    }

    /* Actualizar Empresa y Router Mikrotik*/
    if(isset($_POST['id_empresa_update']) && isset($_POST['id_router_update'])){
        echo $ins_empresa->actualizarEmpresaControlador();
    }

} else {
    session_start(['name' => 'LMR']);
    session_unset();
    session_destroy();
    header("Location: " . SERVERURL . "login/");
    exit();
}
