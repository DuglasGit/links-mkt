<?php
require_once "mainModel.php";

class trabajoModelo extends mainModel
{

    /* -- Modelo agregar orden trabaja --*/
    protected static function agregarTrabajoModelo($datos)
    {
        $sql = mainModel::conectar()->prepare("INSERT INTO orden_trabajo(id_usuario,fecha_creacion,id_tipo_trabajo,descripcion_trabajo,estado_orden) VALUES(:ID_USUARIO,:FECHA_CREACION,:ID_TIPO_TRABAJO,:DESCRIPCION_TRABAJO,:ESTADO_ORDEN)");

        $sql->bindParam(":ID_USUARIO", $datos['ID_USUARIO']);
        $sql->bindParam(":FECHA_CREACION", $datos['FECHA_CREACION']);
        $sql->bindParam(":ID_TIPO_TRABAJO", $datos['ID_TIPO_TRABAJO']);
        $sql->bindParam(":DESCRIPCION_TRABAJO", $datos['DESCRIPCION_TRABAJO']);
        $sql->bindParam(":ESTADO_ORDEN", $datos['ESTADO_ORDEN']);

        $sql->execute();
        return $sql;
    }

    /* -- Modelo agregar nuevo tipo de trabaja --*/
    protected static function agregarTipoTrabajoModelo($datos)
    {
        $sql = mainModel::conectar()->prepare("INSERT INTO tipo_trabajo (nombre_tipo_trabajo) VALUES(:NOMBRE_TIPO_TRABAJO)");
        $sql->bindParam(":NOMBRE_TIPO_TRABAJO", $datos);

        $sql->execute();
        return $sql;
    }

    /* -- Modelo Eliminar orden trabaja --*/
    protected static function eliminar_trabajo_modelo($id)
    {

        $sql = mainModel::conectar()->prepare("DELETE FROM orden_trabajo WHERE id_orden_trabajo=:ID_ORDEN_TRABAJO");

        $sql->bindParam(":ID_ORDEN_TRABAJO", $id);
        $sql->execute();

        return $sql;
    }


    /* -- Modelo Eliminar orden trabajo --*/
    protected static function eliminar_trabajo_terminado_modelo($id, $opcion, $operacion)
    {
        switch ($opcion) {
            case 1: {
                    $sql = mainModel::conectar()->prepare("DELETE FROM trabajo_terminado WHERE id_orden_trabajo=:ID_ORDEN_TRABAJO");
                    $sql->bindParam(":ID_ORDEN_TRABAJO", $id);
                    $sql->execute();
                    return $sql;

                    break;
                }
            case 2: {
                    $sql = mainModel::conectar()->prepare("UPDATE orden_trabajo SET estado_orden=:ESTADO_ORDEN WHERE id_orden_trabajo=:ID_ORDEN_TRABAJO");
                    $sql->bindParam(":ESTADO_ORDEN", $operacion);
                    $sql->bindParam(":ID_ORDEN_TRABAJO", $id);
                    $sql->execute();
                    return $sql;
                    break;
                }
        }
    }


    /* -- Modelo Finalizar orden trabajo --*/
    protected static function finalizar_trabajo_modelo($id, $opcion, $operacion)
    {
        switch ($opcion) {
            case 1: {
                    $sql = mainModel::conectar()->prepare("INSERT INTO trabajo_terminado (id_orden_trabajo) VALUES(:ID_ORDEN_TRABAJO)");
                    $sql->bindParam(":ID_ORDEN_TRABAJO", $id);
                    $sql->execute();
                    return $sql;

                    break;
                }
            case 2: {
                    $sql = mainModel::conectar()->prepare("UPDATE orden_trabajo SET estado_orden=:ESTADO_ORDEN WHERE id_orden_trabajo=:ID_ORDEN_TRABAJO");
                    $sql->bindParam(":ESTADO_ORDEN", $operacion);
                    $sql->bindParam(":ID_ORDEN_TRABAJO", $id);
                    $sql->execute();
                    return $sql;
                    break;
                }
        }
    }

    // Modelo datos del orden trabaja
    protected static function datosTrabajoioModelo($tipo, $id)
    {
        if ($tipo == "Unico") {
            $sql = mainModel::conectar()->prepare("SELECT fecha_creacion, descripcion_trabajo FROM orden_trabajo WHERE id_orden_trabajo=:ID");
            $sql->bindParam(":ID", $id);
        }

        $sql->execute();
        return $sql;
    }

    //modelo para llenar select de usuario responsable del trabajo
    protected static function datosResponsable($tipo, $id)
    {

        switch ($tipo) {
            case 0: {
                    $sql = mainModel::conectar()->prepare("SELECT usuario.id_usuario, usuario.nombre_usuario FROM usuario JOIN orden_trabajo ON (usuario.id_usuario=orden_trabajo.id_usuario) WHERE orden_trabajo.id_orden_trabajo=:ID");
                    $sql->bindParam(":ID", $id);
                    $sql->execute();
                    return $sql;
                    break;
                }
            case 1: {
                    $sql = mainModel::conectar()->prepare("SELECT id_usuario, nombre_usuario FROM usuario");
                    $sql->execute();
                    return $sql;
                    break;
                }
            case 2: {
                    $sql = mainModel::conectar()->prepare("SELECT tipo_trabajo.id_tipo_trabajo, tipo_trabajo.nombre_tipo_trabajo FROM tipo_trabajo JOIN orden_trabajo ON (tipo_trabajo.id_tipo_trabajo=orden_trabajo.id_tipo_trabajo) WHERE orden_trabajo.id_orden_trabajo=:ID");
                    $sql->bindParam(":ID", $id);
                    $sql->execute();
                    return $sql;
                    break;
                }
            case 3: {
                    $sql = mainModel::conectar()->prepare("SELECT id_tipo_trabajo, nombre_tipo_trabajo FROM tipo_trabajo");
                    $sql->execute();
                    return $sql;
                    break;
                }
        }
    }

    // Modelo para actualizar la orden de trabaja
    protected static function actualizarTrabajoModelo($datos)
    {
        $sql = mainModel::conectar()->prepare("UPDATE orden_trabajo SET id_usuario=:ID_USUARIO, fecha_creacion=:FECHA_CREACION, id_tipo_trabajo=:ID_TIPO_TRABAJO, descripcion_trabajo=:DESCRIPCION_TRABAJO WHERE id_orden_trabajo=:ID_ORDEN_TRABAJO");
        $sql->bindParam(":ID_USUARIO", $datos['ID_USUARIO']);
        $sql->bindParam(":FECHA_CREACION", $datos['FECHA_CREACION']);
        $sql->bindParam(":ID_TIPO_TRABAJO", $datos['ID_TIPO_TRABAJO']);
        $sql->bindParam(":DESCRIPCION_TRABAJO", $datos['DESCRIPCION_TRABAJO']);
        $sql->bindParam(":ID_ORDEN_TRABAJO", $datos['ID_ORDEN_TRABAJO']);
        $sql->execute();

        return $sql;
    }
}
