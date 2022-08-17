<div class="modal fade" id="modalUsuario" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Crear | Usuario  <i class="fa fa-plus"></i></h5>
        <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="fntUsuario" method="post" role="form" novalidate="">
            <input type="hidden" id="id_usuario" name="id_usuario" value="">
            <div class="card-body-lg row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                                <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-address-book"></i>
                                </span>
                            </div>
                            <input type="text" name="nombre" class="form-control" id="nombre" placeholder="ingrese el nombre">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                                <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-address-book"></i>
                                </span>
                            </div>
                            <input type="text" name="apellido" class="form-control" id="apellido" placeholder="ingrese el apellido">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                                <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                            <input type="text" name="usuario" class="form-control" id="usuario"  placeholder="ingrese el usuario">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                                <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                            <input type="email" name="email" class="form-control" id="email" required placeholder="ingrese el email">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                                <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </div>
                            <input type="password" name="password" class="form-control" id="password"  placeholder="ingrese la contraseña">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="input-group">
                                <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-users"></i>
                                </span>
                            </div>
                            <select name="id_rol" id="id_rol" class="form-control" required>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-link"></i>
                                </span> 
                            </div>
                            <input type="url" name="foto" pattern="https://.*" class="form-control" id="foto"  value="<?php echo server_url_image; ?>default.png" placeholder="url de la foto">
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4 is-valid"><span class="changeText">Crear </span><i class="fa fa-plus"></i></button>
        </form>
      </div>
    </div>
  </div>
</div>
