<?php
require_once "mainModel.php";

class usuarioModelo extends mainModel
{

    /* -- Modelo agregar usuario --*/
    protected static function agregar_usuario_modelo($datos)
    {
        $sql = mainModel::conectar()->prepare("INSERT INTO usuario(nombre_usuario,password_usuario,id_rol) VALUES(:Nombre,:Pass,:Rol)");

        $sql->bindParam(":Nombre", $datos['Nombre']);
        $sql->bindParam(":Pass", $datos['Pass']);
        $sql->bindParam(":Rol", $datos['Rol']);
        $sql->execute();

        return $sql;
    }

    /* -- Modelo Eliminar usuario --*/
    protected static function eliminar_usuario_modelo($id)
    {
        
        $sql = mainModel::conectar()->prepare("DELETE FROM usuario WHERE id_usuario=:ID");

        $sql->bindParam(":ID", $id);
        $sql->execute();

        return $sql;
    }

    // Modelo datos del usuario
    protected static function datosUsuarioModelo($tipo, $id){
        if($tipo=="Unico"){
            $sql = mainModel::conectar()->prepare("SELECT *FROM usuario WHERE id_usuario=:ID");
            $sql->bindParam(":ID", $id);
        }elseif($tipo=="Conteo"){
            $sql = mainModel::conectar()->prepare("SELECT id_usuario FROM usuario WHERE id_usuario='1'");
        }

        $sql->execute();
        return $sql;

    }
}
