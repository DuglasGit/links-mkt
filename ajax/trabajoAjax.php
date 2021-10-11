<?php
$peticionAjax = true;
require_once "../config/APP.php";

if (isset($_POST['responsable']) || isset($_POST['nombre_tipo_trabajo']) || isset($_POST['orden_trabajo_id_delete']) || isset($_POST['trabajo_finalizado_delete']) || isset($_POST['orden_trabajo_finish']) || isset($_POST['orden_trabajo_id_update'])) {

    /*--------- Instancia al controlador ---------*/
    require_once "../controllers/trabajoControlador.php";
    $ins_trabajo = new trabajoControlador();

    
    /*--------- Agregar una orden de trabajo ---------*/
    if (isset($_POST['responsable']) && isset($_POST['trabajo'])) {
        echo $ins_trabajo->agregar_trabajo_controlador();
    }

    /*--------- Agregar nuevo tipo de trabajo ---------*/
    if (isset($_POST['nombre_tipo_trabajo'])) {
        echo $ins_trabajo->agregar_tipo_trabajo_controlador();
    }

    /*--------- Eliminar una orden de trabajo ---------*/
    if (isset($_POST['orden_trabajo_id_delete'])) {
        echo $ins_trabajo->eliminarTrabajoControlador();
    }

     /*--------- Eliminar una orden de trabajo finalizada---------*/
     if (isset($_POST['trabajo_finalizado_delete'])) {
        echo $ins_trabajo->eliminarTrabajoTerminadoControlador();
    }

    /*--------- Finalizar orden de Trabajo ---------*/
    if (isset($_POST['orden_trabajo_finish'])) {
        echo $ins_trabajo->finalizarTrabajoControlador();
    }

    // actualizar orden trabajo
    if(isset($_POST['orden_trabajo_id_update'])){
        echo $ins_trabajo->actualizarTrabajoControlador();
    }
    

} else {
    session_start(['name' => 'LMR']);
    session_unset();
    session_destroy();
    header("Location: " . SERVERURL . "login/");
    exit();
}
