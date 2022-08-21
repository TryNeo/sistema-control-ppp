<div class="modal fade" id="modalAlumno" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Crear | Alumno <i class="fa fa-plus"></i></h5>
                <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" id="fntAlumno" method="post" role="form" novalidate="">
                    <input type="hidden" id="id_alumno" name="id_alumno" value="">
                    <div class="card-body-lg row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-address-card"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="cedula" class="form-control" id="cedula" placeholder="ingrese la cedula" required>
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
                                    <input type="email" name="email_personal" class="form-control" id="email_personal" required placeholder="ingrese el email personal">
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
                                    <input type="text" name="nommbre" class="form-control" id="nombre" placeholder="ingrese los nombres" required>
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
                                    <input type="text" name="apellido" class="form-control" id="apellido" placeholder="ingrese los apellidos" required>
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
                                    <input type="text" name="telefono" class="form-control" id="telefono" placeholder="ingrese el telefono personal" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-venus-mars"></i>
                                        </span>
                                    </div>
                                    <select name="sexo" id="sexo" class="form-control" required>
                                        <option value="" selected disabled>Seleccione el sexo</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-graduation-cap"></i>
                                        </span>
                                    </div>
                                    <select name="id_carrera" id="id_carrera" class="form-control" required>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <select id="id_usuario" class="form-control select2" required>
                                </select>
                            </div>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4 is-valid"><span class="changeText">Crear </span><i class="fa fa-plus"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>