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
    protected static function datosUsuarioModelo($tipo, $id)
    {
        if($tipo=="Unico"){
            $sql = mainModel::conectar()->prepare("SELECT usuario.id_usuario, usuario.nombre_usuario, usuario.password_usuario, usuario.id_rol, rol_usuario.nombre_rol FROM rol_usuario JOIN usuario ON (rol_usuario.id_rol=usuario.id_rol) WHERE usuario.id_usuario=:ID");
            $sql->bindParam(":ID", $id);
        }elseif($tipo=="Conteo"){
            $sql = mainModel::conectar()->prepare("SELECT id_usuario FROM rol_usuario JOIN usuario ON (rol_usuario.id_rol=usuario.id_rol) WHERE id_usuario='1'");
        }

        $sql->execute();
        return $sql;
    }

    //modelo para llenar select de rol usuario
    protected static function datosRol($tipo, $id){
        if($tipo==0){
            $sql = mainModel::conectar()->prepare("SELECT usuario.id_rol, rol_usuario.nombre_rol FROM rol_usuario JOIN usuario ON (rol_usuario.id_rol=usuario.id_rol) WHERE id_usuario=:ID");
            $sql->bindParam(":ID", $id);
        }elseif($tipo==1){
            $sql = mainModel::conectar()->prepare("SELECT id_rol, nombre_rol FROM rol_usuario");
        }
        $sql->execute();
        return $sql;
    }

    // Modelo para actualizar usuario
    protected static function actualizarUsuarioModelo($datos){
        $sql = mainModel::conectar()->prepare("UPDATE usuario SET nombre_usuario=:NOMBRE, password_usuario=:PASS, id_rol=:ROL WHERE id_usuario=:ID");
        $sql->bindParam(":NOMBRE", $datos['NOMBRE']);
        $sql->bindParam(":PASS", $datos['PASS']);
        $sql->bindParam(":ROL", $datos['ROL']);
        $sql->bindParam(":ID", $datos['ID']);
        $sql->execute();
        
        return $sql;
    }
}
