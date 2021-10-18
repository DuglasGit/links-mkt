<?php

require_once "MainModel.php";

class empresaModelo extends MainModel
{


    /* Agregar Empresa Modelo */
    protected static function agregarEmpresaModelo($datos, $op)
    {
        switch ($op) {
            case "empresa": {
                    $sql = mainModel::conectar()->prepare("INSERT INTO empresa (nombre_empresa, representante_legal, nit_empresa, telefono_empresa, correo_empresa, id_municipio, domicilio, ubicacion_gps) VALUES(:NOMBRE_EMPRESA, :REP_LEGAL, :NIT, :TELEFONO, :CORREO, :ID_MUNI, :DOMICILIO, :GPS)");

                    $sql->bindParam(":NOMBRE_EMPRESA", $datos['NOMBRE_EMPRESA']);
                    $sql->bindParam(":REP_LEGAL", $datos['REP_LEGAL']);
                    $sql->bindParam(":NIT", $datos['NIT']);
                    $sql->bindParam(":TELEFONO", $datos['TELEFONO']);
                    $sql->bindParam(":CORREO", $datos['CORREO']);
                    $sql->bindParam(":ID_MUNI", $datos['ID_MUNI']);
                    $sql->bindParam(":DOMICILIO", $datos['DOMICILIO']);
                    $sql->bindParam(":GPS", $datos['GPS']);
                    $sql->execute();
                    return $sql;
                    break;
                }
            case "router": {
                    $sql = mainModel::conectar()->prepare("INSERT INTO router_mikrotik (modelo, serie, ip_asignada, usuario_router, password_router) VALUES(:MODELO, :SERIE, :IP, :USUARIOR, :PASSWORDR)");

                    $sql->bindParam(":MODELO", $datos['MODELO']);
                    $sql->bindParam(":SERIE", $datos['SERIE']);
                    $sql->bindParam(":IP", $datos['IP']);
                    $sql->bindParam(":USUARIOR", $datos['USUARIOR']);
                    $sql->bindParam(":PASSWORDR", $datos['PASSWORDR']);
                    $sql->execute();
                    return $sql;
                    break;
                }
            default: {
                    break;
                }
        }
    }


    /* Agregar Empresa Modelo */
    protected static function actualizarEmpresaModelo($datos, $op)
    {
        switch ($op) {
            case "empresa": {
                    $sql = mainModel::conectar()->prepare("UPDATE empresa SET nombre_empresa=:NOMBRE_EMPRESA, representante_legal=:REP_LEGAL, nit_empresa=:NIT, telefono_empresa=:TELEFONO, correo_empresa=:CORREO, id_municipio=:ID_MUNI, domicilio=:DOMICILIO, ubicacion_gps=:GPS WHERE id_empresa=:ID");

                    $sql->bindParam(":NOMBRE_EMPRESA", $datos['NOMBRE_EMPRESA']);
                    $sql->bindParam(":REP_LEGAL", $datos['REP_LEGAL']);
                    $sql->bindParam(":NIT", $datos['NIT']);
                    $sql->bindParam(":TELEFONO", $datos['TELEFONO']);
                    $sql->bindParam(":CORREO", $datos['CORREO']);
                    $sql->bindParam(":ID_MUNI", $datos['ID_MUNI']);
                    $sql->bindParam(":DOMICILIO", $datos['DOMICILIO']);
                    $sql->bindParam(":GPS", $datos['GPS']);
                    $sql->bindParam(":ID", $datos['ID']);
                    $sql->execute();
                    return $sql;
                    break;
                }
            case "router": {
                    $sql = mainModel::conectar()->prepare("UPDATE router_mikrotik SET modelo=:MODELO, serie=:SERIE, ip_asignada=:IP, usuario_router=:USUARIOR, password_router=:PASSWORDR WHERE id_router=:IDR");

                    $sql->bindParam(":MODELO", $datos['MODELO']);
                    $sql->bindParam(":SERIE", $datos['SERIE']);
                    $sql->bindParam(":IP", $datos['IP']);
                    $sql->bindParam(":USUARIOR", $datos['USUARIOR']);
                    $sql->bindParam(":PASSWORDR", $datos['PASSWORDR']);
                    $sql->bindParam(":IDR", $datos['IDR']);
                    $sql->execute();
                    return $sql;
                    break;
                }
            default: {
                    break;
                }
        }
    }


    /* Modelo datos empresa */
    protected static function datosEmpresaModelo()
    {
        $sql = mainModel::conectar()->prepare("SELECT id_empresa, nombre_empresa, representante_legal, nit_empresa, telefono_empresa, correo_empresa, domicilio,nombre_municipio, nombre_departamento, ubicacion_gps FROM empresa JOIN municipio ON (empresa.id_municipio=municipio.id_municipio) JOIN departamento ON (municipio.id_departamento=departamento.id_departamento)");
        $sql->execute();
        return $sql;
    }


    /* Modelo datos Router */
    protected static function datosRouterModelo()
    {
        $sql = mainModel::conectar()->prepare("SELECT * FROM router_mikrotik");
        $sql->execute();
        return $sql;
    }


    //modelo para llenar selects de municipio
    protected static function datosSelect($tipo, $id, $tabla)
    {
        switch ($tabla) {
            case "muni": {
                    if ($tipo == 0) {
                        $sql = mainModel::conectar()->prepare("SELECT municipio.id_municipio, municipio.nombre_municipio FROM municipio JOIN empresa ON (municipio.id_municipio=empresa.id_municipio) WHERE empresa.id_empresa=:ID");
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
        }
    }
}
