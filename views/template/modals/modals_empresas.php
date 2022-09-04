<div class="modal fade" id="modalEmpresa" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Crear | Empresa <i class="fa fa-plus"></i></h5>
                <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" id="fntEmpresa" method="post" role="form" novalidate="">
                    <input type="hidden" id="id_empresa" name="id_empresa" value="">
                    <div class="card-body-lg row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-building"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="ruc_empresa" class="form-control" id="ruc_empresa" placeholder="ingrese el ruc de la empresa" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-signature"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="nombre_empresa" class="form-control" id="nombre_empresa" required placeholder="ingrese el nombre de la empresa">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-map-marked-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="direccion_empresa" class="form-control" id="direccion_empresa" required placeholder="ingrese la direccion de la empresa">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-phone-volume"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="telefono_empresa" class="form-control" id="telefono_empresa" required placeholder="ingrese el telefono de la empresa">
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
                                    <input type="email" name="correo_empresa" class="form-control" id="correo_empresa" required placeholder="ingrese el correo empresarial">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-address-card"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="cedula_representante" class="form-control" id="cedula_representante" placeholder="ingrese la cedula del representante" required>
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
                                    <input type="text" name="nombre_representante" class="form-control" id="nombre_representante" placeholder="ingrese el nombre de representante" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-mobile-alt"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="telefono_representante" class="form-control" id="telefono_representante" placeholder="ingrese el telefono representante" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea name="descripcion_empresa" cols="40" rows="2" 
                                    maxlength="250" class="form-control" style="margin-top: 0px; margin-bottom: 0px; height: 100px;" 
                                    placeholder="ingrese la descripcion de la empresa" id="descripcion_empresa"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="empresaCr" class="btn btn-primary mt-4 pr-4 pl-4 is-valid"><span class="changeText">Crear </span><i class="fa fa-plus"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>