<?php
require_once "mainModel.php";

class clienteModelo extends mainModel
{

    /* -- Modelo agregar cliente --*/
    protected static function agregar_cliente_modelo($datos, $tipo)
    {

        switch ($tipo) {
            case 'cliente': {
                    $sql = mainModel::conectar()->prepare("INSERT INTO cliente(nombre_cliente,telefono_cliente,id_municipio,domicilio,ubicacion_gps,id_tipo_cliente) VALUES(:NOMBRE,:TELEFONO,:IDMUNICIPIO,:DOMICILIO,:GPS,:TIPOCLIENTE)");

                    $sql->bindParam(":NOMBRE", $datos['NOMBRE']);
                    $sql->bindParam(":TELEFONO", $datos['TELEFONO']);
                    $sql->bindParam(":IDMUNICIPIO", $datos['IDMUNICIPIO']);
                    $sql->bindParam(":DOMICILIO", $datos['DOMICILIO']);
                    $sql->bindParam(":GPS", $datos['GPS']);
                    $sql->bindParam(":TIPOCLIENTE", $datos['TIPOCLIENTE']);
                    $sql->execute();
                    return $sql;
                    break;
                }
            case 'contrato': {
                    $sql = mainModel::conectar()->prepare("INSERT INTO contrato_servicio(id_cliente,fecha_contrato,id_plan,estado_contrato,ip_asignada) VALUES(:IDCLIENTE,:FECHACONTRATO,:IDPLAN,:ESTADOCONTRATO,:IP)");

                    $sql->bindParam(":IDCLIENTE", $datos['IDCLIENTE']);
                    $sql->bindParam(":FECHACONTRATO", $datos['FECHACONTRATO']);
                    $sql->bindParam(":IDPLAN", $datos['IDPLAN']);
                    $sql->bindParam(":ESTADOCONTRATO", $datos['ESTADOCONTRATO']);
                    $sql->bindParam(":IP", $datos['IP']);
                    $sql->execute();
                    return $sql;
                    break;
                }
            case 'idCliente': {
                    $sql = mainModel::conectar()->prepare("SELECT id_cliente FROM cliente WHERE nombre_cliente=:NOMBRE");

                    $sql->bindParam(":NOMBRE", $datos);
                    $sql->execute();
                    return $sql;
                    break;
                }
            default: {
                    break;
                }
        }
    }

    /* -- Modelo Eliminar cliente --*/
    protected static function eliminar_usuario_modelo($id)
    {

        $sql = mainModel::conectar()->prepare("DELETE FROM usuario WHERE id_usuario=:ID");

        $sql->bindParam(":ID", $id);
        $sql->execute();

        return $sql;
    }

    // Modelo datos del cliente
    protected static function datosUsuarioModelo($tipo, $id)
    {
        if ($tipo == "Unico") {
            $sql = mainModel::conectar()->prepare("SELECT usuario.id_usuario, usuario.nombre_usuario, usuario.password_usuario, usuario.id_rol, rol_usuario.nombre_rol FROM rol_usuario JOIN usuario ON (rol_usuario.id_rol=usuario.id_rol) WHERE usuario.id_usuario=:ID");
            $sql->bindParam(":ID", $id);
        } elseif ($tipo == "Conteo") {
            $sql = mainModel::conectar()->prepare("SELECT id_usuario FROM rol_usuario JOIN usuario ON (rol_usuario.id_rol=usuario.id_rol) WHERE id_usuario='1'");
        }

        $sql->execute();
        return $sql;
    }

    //modelo para llenar select de rol cliente
    protected static function datosSelect($tipo, $id, $tabla)
    {
        switch ($tabla) {
            case "muni": {
                    if ($tipo == 0) {
                        $sql = mainModel::conectar()->prepare("SELECT municipio.id_municipio, municipio.nombre_municipio FROM municipio JOIN cliente ON (municipio.id_municipio=cliente.id_municipio) WHERE cliente.id_cliente=:ID");
                        $sql->bindParam(":ID", $id);
                        $sql->execute();
                        return $sql;
                    } elseif ($tipo == 1) {
                        $sql = mainModel::conectar()->prepare("SELECT id_municipio, nombre_municipio FROM municipio");
                        $sql->execute();
                        return $sql;
                    }
                    break;
                }
            case "tcliente": {
                    if ($tipo == 0) {
                        $sql = mainModel::conectar()->prepare("SELECT tipo_cliente.id_tipo_cliente, tipo_cliente.nombre_tipo_cliente FROM tipo_cliente JOIN cliente ON (tipo_cliente.id_tipo_cliente=cliente.id_tipo_cliente) WHERE cliente.id_cliente=:ID");
                        $sql->bindParam(":ID", $id);
                        $sql->execute();
                        return $sql;
                    } elseif ($tipo == 1) {
                        $sql = mainModel::conectar()->prepare("SELECT id_tipo_cliente, nombre_tipo_cliente FROM tipo_cliente");
                        $sql->execute();
                        return $sql;
                    }
                    break;
                }
            case "plan": {
                    break;
                }
            case "perfil": {
                    break;
                }
            default: {
                    break;
                }
        }
    }

    // Modelo para actualizar cliente
    protected static function actualizarUsuarioModelo($datos)
    {
        $sql = mainModel::conectar()->prepare("UPDATE usuario SET nombre_usuario=:NOMBRE, password_usuario=:PASS, id_rol=:ROL WHERE id_usuario=:ID");
        $sql->bindParam(":NOMBRE", $datos['NOMBRE']);
        $sql->bindParam(":PASS", $datos['PASS']);
        $sql->bindParam(":ROL", $datos['ROL']);
        $sql->bindParam(":ID", $datos['ID']);
        $sql->execute();

        return $sql;
    }
}
