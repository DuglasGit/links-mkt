<?php
    require_once "mainModel.php";

    class loginModelo extends mainModel{

        /* -- Modelo iniciar Sesion -- */
        protected static function iniciar_sesion_modelo($datos){
            $sql=mainModel::conectar()->prepare("SELECT * FROM rol_usuario JOIN usuario ON (rol_usuario.id_rol=usuario.id_rol) WHERE usuario.nombre_usuario=:Usuario AND usuario.password_usuario=:Clave");

            $sql->bindParam(":Usuario",$datos['Usuario']);
            $sql->bindParam(":Clave",$datos['Clave']);
            $sql->execute();

            return $sql;
        }
    }

?>