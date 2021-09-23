<?php
if ($_SESSION['id_rol_lmr'] != 1) {
    $login_controlador->forzar_cierre_sesion_controlador();
    exit();
}
?>

<div class="page-header">
    <h3 class="page-title"> Form elements </h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Forms</a></li>
            <li class="breadcrumb-item active" aria-current="page">Form elements</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Datos generales de la empresa</h4>
                <p class="card-description"> Datos necesarios para los comprobantes de pago</p>
                <form class="forms-sample FormularioAjax" action="" method="POST" data-form="save">
                    <div class="form-group">
                        <label for="exampleInputName1">Nombre de la Empresa</label>
                        <input type="text" class="form-control" id="exampleInputName1" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">Representante Legal</label>
                        <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Rep. Legal...">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword4">NIT Empresa</label>
                        <input type="text" class="form-control" id="exampleInputPassword4" placeholder="NIT">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword4">Teléfono Empresa</label>
                        <input type="text" class="form-control" id="exampleInputPassword5" placeholder="Tel">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail3">Dirección de Correo Electrónico Empresa</label>
                        <input type="email" class="form-control" id="exampleInputEmail4" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="exampleSelectGender">Municipio</label>
                        <select class="form-control" id="exampleSelectGender">
                            <option>Municipio 1</option>
                            <option>Municipio 2</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword4">Domicilio Fiscal</label>
                        <input type="text" class="form-control" id="exampleInputPasswor" placeholder="Dirección exacta...">
                    </div>
                    <div class="form-group">
                        <label>Logo Empresa</label>
                        <input type="file" name="img[]" class="file-upload-default">
                        <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Cargar</button>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputCity1">City</label>
                        <input type="text" class="form-control" id="exampleInputCity1" placeholder="Location">
                    </div>
                    <div class=" form-group w-100 justify-content-center">
                        <button class="btn btn-dark">Cancelar</button>
                        <button type="submit" class="btn btn-primary mr-2">Guardar Datos</button>
                        <button type="submit" class="btn btn-warning mr-2">Editar Datos</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">DATOS DEL ROUTER MIKROTIK</h4>
                <p class="card-description"> Datos necearios para realizar la conexión con la API del Router </p>
                <form class="forms-sample">
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Modelo</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="exampleInputUsername22" placeholder="RB 3011">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Serie</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="exampleInputEmail22" placeholder="Example UiAS-RM">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">IP Asignada</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="exampleInputMobile" placeholder="Example 192.168.0.100">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">Usuario router</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="exampleInputMobile1" placeholder="User...">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Password Router</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="exampleInputPassword23" placeholder="Password">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Registrar y Guardar</button>
                    <button type="submit" class="btn btn-success mr-2">Editar</button>
                    <button class="btn btn-dark">Cancel</button>
                </form>
            </div>
        </div>
    </div>

</div>