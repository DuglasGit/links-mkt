<?php
$peticionAjax = true;
require_once "../config/APP.php";

if (isset($_POST['nombre_reg']) || isset($_POST['id_usuario_delete']) || isset($_POST['usuario_id_update'])) {

    /*--------- Instancia al controlador ---------*/
    require_once "../controllers/usuarioControlador.php";
    $ins_usuario = new usuarioControlador();


    /*--------- Agregar un usuario ---------*/
    if (isset($_POST['nombre_reg']) && isset($_POST['password_reg'])) {
        echo $ins_usuario->agregar_usuario_controlador();
    }

    /*--------- Eliminar un usuario ---------*/
    if (isset($_POST['id_usuario_delete'])) {
        echo $ins_usuario->eliminarUsuarioControlador();
    }

    // actualizar usuario
    if(isset($_POST['usuario_id_update'])){
        echo $ins_usuario->actualizarUsuarioControlador();
    }


} else {
    session_start(['name' => 'LMR']);
    session_unset();
    session_destroy();
    header("Location: " . SERVERURL . "login/");
    exit();
}
