<?php getHeaderDashboard($data);
?>
<section class="section">
    <div class="section-header">
        <h1>
            Editando pasantia 
            <?php dep($data['practicas_data']); ?>
        </h1>
    </div>
    <div class="section-body">
        <form class="needs-validation" id="fntPracticas" method="post" role="form" novalidate="">
            <input type="hidden" id="id_practicas" name="id_practicas" value="<?php echo $data['practicas_data']['id_practica']; ?>">
            <div class="row">
                <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body-lg row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select id="id_alumno" class="form-control form-controls select2" name="id_alumno">
                                        </select>
                                    </div>
                                    <input type="hidden" id="id_alumno_ppp" name="id_alumno_ppp" value="<?php echo $data['practicas_data']['id_alumno']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select id="id_profesor" class="form-control select2" name="id_profesor">
                                        </select>
                                    </div>
                                    <input type="hidden" id="id_profesor_ppp" name="id_profesor_ppp" value="<?php echo $data['practicas_data']['id_profesor']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><b>Cedula alumno:</b></label>

                                        <div class="input-group">
                                            <input type="text" name="cedula_temp_al" class="form-control" id="cedula_temp_al" value="<?php echo $data['practicas_data']['cedula']; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><b>Nombre y apellido alumno:</b></label>
                                        <div class="input-group">
                                            <input type="text" name="nombre_apellido_al" class="form-control" id="nombre_apellido_al" value="<?php echo $data['practicas_data']['nombre_apellido_al']; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><b>Tutor docente:</b></label>

                                        <div class="input-group">
                                            <input type="text" name="nombre_apellido_pr" class="form-control" id="nombre_apellido_pr" value="<?php echo $data['practicas_data']['nombre_apellido_pr']; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><b>Alcance proyecto:</b></label>
                                        <div class="input-group">
                                        <select name="id_alcance_proyecto" id="id_alcance_proyecto" class="form-control">
                                                <option value="" selected disabled>Seleccione el Alcance Proyecto</option>
                                                <option value="1" <?php echo ($data['practicas_data']['alcance_proyecto'] == 1 ? 'selected' : '');  ?>>Nacional</option>
                                                <option value="2" <?php echo ($data['practicas_data']['alcance_proyecto'] == 2 ? 'selected' : '');  ?>>Provincial</option>
                                                <option value="3" <?php echo ($data['practicas_data']['alcance_proyecto'] == 3 ? 'selected' : '');  ?>>Cantonal</option>
                                                <option value="4" <?php echo ($data['practicas_data']['alcance_proyecto'] == 4 ? 'selected' : '');  ?>>Parroquial</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><b>Carrera:</b></label>

                                        <div class="input-group">
                                            <input type="text" name="carrera" class="form-control" id="carrera" value="<?php echo $data['practicas_data']['nombre_carrera']; ?>" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><b>Tipo practica:</b></label>
                                        <div class="input-group">
                                            <select name="id_tipo_practica" id="id_tipo_practica" class="form-control">
                                                <option value="" selected disabled>Seleccione el Tipo de Practica</option>
                                                <option value="1">Empresarial</option>
                                                <option value="2">Servicio a la comunidad</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select id="id_empresa" class="form-control select2" name="id_empresa">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><b>Nombre empresa:</b></label>
                                        <div class="input-group">
                                            <input type="text" name="nombre_empresa_ep" class="form-control" id="nombre_empresa_ep" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><b>Tutor empresa:</b></label>
                                        <div class="input-group">
                                            <input type="text" name="nombre_representante_ep" class="form-control" id="nombre_representante_ep" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><b>Telefono empresa:</b></label>
                                        <div class="input-group">
                                            <input type="text" name="telefono_ep" class="form-control" id="telefono_ep" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><b>deparamento (maximo 80 caracteres):</b></label>
                                        <div class="input-group">
                                            <input type="text" name="departamento_ep" class="form-control" id="departamento_ep">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label><b>Especifique el Nivel o Semestre en que se encontraba el alumno al momento de realizar estas pasantias:</b></label>
                                        <div class="input-group">
                                            <select name="id_nivel_pasantias" id="id_nivel_pasantias" class="form-control">
                                                <option value="" selected disabled>Seleccione el nivel</option>
                                                <option value="1">Primer nivel</option>
                                                <option value="2">Segundo nivel</option>
                                                <option value="3">Tercer nivel</option>
                                                <option value="4">Cuarto nivel</option>
                                                <option value="5">Quinto nivel</option>
                                                <option value="6">Sexto nivel</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<?php
getScriptsDashboard($data);
