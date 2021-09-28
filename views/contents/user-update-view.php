<!-- modal modalEditarUsuario -->
<div class="modal fade" id="modalEditarUsuario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog border border-warning rounded d-md-warning" role="document">
        <div class="modal-content d-mc-warning">
            <div class="modal-header">
                <h5 class="modal-title w-100 text-center" id="exampleModalLabel">EDITAR DATOS DE USUARIO</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">



                <form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/usuarioAjax.php" method="POST" data-form="update" autocomplete="off">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">NOMBRE USUARIO</label>
                        <input type="text" class="form-control border-warning text-warning d-inp-warning" value="Nombre de Usuario">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">PASSWORD USUARIO</label>
                        <input type="text" class="form-control border-warning text-warning d-inp-warning" value="AbcPass">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">ROL USUARIO</label>
                        <select class="custom-select custom-select-sm form-control form-control border-warning text-warning d-inp-warning">
                            <option selected>Elegir...</option>
                            <option value="1">Administrador</option>
                            <option value="2">Oficina</option>
                            <option value="3">Técnico de Redes</option>
                        </select>
                    </div>
                </form>

            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-inverse-danger" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-inverse-warning submitBtn">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<div class="full-box page-header">
	<h3 class="text-left">
		<i class="fas fa-sync-alt fa-fw"></i> &nbsp; ACTUALIZAR USUARIO
	</h3>
	<p class="text-justify">
		Lorem ipsum dolor sit amet, consectetur adipisicing elit. Suscipit nostrum rerum animi natus beatae ex. Culpa blanditiis tempore amet alias placeat, obcaecati quaerat ullam, sunt est, odio aut veniam ratione.
	</p>
</div>

<div class="container-fluid">
	<ul class="full-box list-unstyled page-nav-tabs">
		<li>
			<a href="<?php echo SERVERURL; ?>user-new/"><i class="fas fa-plus fa-fw"></i> &nbsp; NUEVO USUARIO</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>user-list/"><i class="fas fa-clipboard-list fa-fw"></i> &nbsp; LISTA DE USUARIOS</a>
		</li>
		<li>
			<a href="<?php echo SERVERURL; ?>user-search/"><i class="fas fa-search fa-fw"></i> &nbsp; BUSCAR USUARIO</a>
		</li>
	</ul>	
</div>

<div class="container-fluid">

<form class="FormularioAjax" action="<?php echo SERVERURL; ?>ajax/usuarioAjax.php" method="POST" data-form="update" autocomplete="off">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">NOMBRE USUARIO</label>
                        <input type="text" class="form-control border-warning text-warning d-inp-warning" value="Nombre de Usuario">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">PASSWORD USUARIO</label>
                        <input type="text" class="form-control border-warning text-warning d-inp-warning" value="AbcPass">
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">ROL USUARIO</label>
                        <select class="custom-select custom-select-sm form-control form-control border-warning text-warning d-inp-warning">
                            <option selected>Elegir...</option>
                            <option value="1">Administrador</option>
                            <option value="2">Oficina</option>
                            <option value="3">Técnico de Redes</option>
                        </select>
                    </div>
                </form>

	<div class="alert alert-danger text-center" role="alert">
		<p><i class="fas fa-exclamation-triangle fa-5x"></i></p>
		<h4 class="alert-heading">¡Ocurrió un error inesperado!</h4>
		<p class="mb-0">Lo sentimos, no podemos mostrar la información solicitada debido a un error.</p>
	</div>
	
</div>