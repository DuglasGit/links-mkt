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
                    $sql = mainModel::conectar()->prepare("INSERT INTO contrato_servicio(id_cliente,fecha_contrato,plan_contrato,estado_contrato,ip_asignada) VALUES(:IDCLIENTE,:FECHACONTRATO,:PLAN,:ESTADOCONTRATO,:IP)");

                    $sql->bindParam(":IDCLIENTE", $datos['IDCLIENTE']);
                    $sql->bindParam(":FECHACONTRATO", $datos['FECHACONTRATO']);
                    $sql->bindParam(":PLAN", $datos['PLAN']);
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
    protected static function datosClienteModelo($ip)
    {
        $sql = mainModel::conectar()->prepare("SELECT cliente.id_cliente, cliente.nombre_cliente, cliente.telefono_cliente, cliente.domicilio, cliente.ubicacion_gps, cliente.id_tipo_cliente, contrato_servicio.id_contrato_servicio, contrato_servicio.fecha_contrato, contrato_servicio.estado_contrato, contrato_servicio.ip_asignada FROM cliente JOIN contrato_servicio ON(cliente.id_cliente=contrato_servicio.id_cliente) WHERE contrato_servicio.ip_asignada=:IP");
        $sql->bindParam(":IP", $ip);
        $sql->execute();
        return $sql;
    }

    // Modelo datos del cliente para la factura
    protected static function datosClienteFacturaModelo($idfactura)
    {
        $sql = mainModel::conectar()->prepare("SELECT cliente.id_cliente, cliente.nombre_cliente, cliente.telefono_cliente, municipio.nombre_municipio, cliente.domicilio, tipo_cliente.nombre_tipo_cliente FROM cliente JOIN municipio ON(cliente.id_municipio=municipio.id_municipio) JOIN tipo_cliente ON (cliente.id_tipo_cliente=tipo_cliente.id_tipo_cliente) JOIN factura ON (factura.id_cliente=cliente.id_cliente) WHERE factura.idfactura=:IDFACTURA");
        $sql->bindParam(":IDFACTURA", $idfactura);
        $sql->execute();
        return $sql;
    }

    //modelo para llenar selects de formulario actualizar-cliente
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
    protected static function actualizarClienteModelo($datos)
    {
        $sql = mainModel::conectar()->prepare("UPDATE cliente SET nombre_cliente=:NOMBRE, telefono_cliente=:TELEFONO, id_municipio=:MUNICIPIO, domicilio=:DOMICILIO, ubicacion_gps=:UBICACION_GPS, id_tipo_cliente=:ID_TIPO_CLIENTE WHERE id_cliente=:ID_CLIENTE");

        $sql->bindParam(":NOMBRE", $datos['NOMBRE']);
        $sql->bindParam(":TELEFONO", $datos['TELEFONO']);
        $sql->bindParam(":MUNICIPIO", $datos['MUNICIPIO']);
        $sql->bindParam(":DOMICILIO", $datos['DOMICILIO']);
        $sql->bindParam(":UBICACION_GPS", $datos['UBICACION_GPS']);
        $sql->bindParam(":ID_TIPO_CLIENTE", $datos['ID_TIPO_CLIENTE']);
        $sql->bindParam(":ID_CLIENTE", $datos['ID_CLIENTE']);

        $sql->execute();
        return $sql;
    }

     // Modelo para actualizar contrato cliente
     protected static function actualizarContratoClienteModelo($datos)
     {
         $sql = mainModel::conectar()->prepare("UPDATE contrato_servicio SET fecha_contrato=:FECHA_CONTRATO, plan_contrato=:PLAN, estado_contrato=:ESTADO_CONTRATO, ip_asignada=:IP_ASIGNADA WHERE id_cliente=:ID_CLIENTEC");
         $sql->bindParam(":FECHA_CONTRATO", $datos['FECHA_CONTRATO']);
         $sql->bindParam(":PLAN", $datos['PLAN']);
         $sql->bindParam(":ESTADO_CONTRATO", $datos['ESTADO_CONTRATO']);
         $sql->bindParam(":IP_ASIGNADA", $datos['IP_ASIGNADA']);
         $sql->bindParam(":ID_CLIENTEC", $datos['ID_CLIENTEC']);

         $sql->execute();
         return $sql;
     }

     // Modelo para actualizar estado del contrato del cliente
     protected static function actualizarEstadoContratoClienteModelo($datos)
     {
         $sql = mainModel::conectar()->prepare("UPDATE contrato_servicio SET estado_contrato=:ESTADO_CONTRATO WHERE ip_asignada=:IP_ASIGNADA");
         $sql->bindParam(":ESTADO_CONTRATO", $datos['ESTADO_CONTRATO']);
         $sql->bindParam(":IP_ASIGNADA", $datos['IP_ASIGNADA']);

         $sql->execute();
         return $sql;
     }
}
