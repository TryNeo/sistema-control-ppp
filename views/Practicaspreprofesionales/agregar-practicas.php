<?php getHeaderDashboard($data);
?>    
<section class="section">
    <div class="section-header">
        <h1>Agregando pasantias</h1>
    </div>
    <div class="section-body">
        <form class="needs-validation" id="fntPracticas" method="post" role="form" novalidate="">
            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="card-body">
                            <input type="hidden" id="id_practicas" name="id_practicas" value="">
                            <div class="card-body-lg row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select id="id_alumno" class="form-control select2" name="id_alumno">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="cedula_temp_al" class="form-control col-md-3" id="cedula_temp_al" placeholder="cedula" disabled style="margin-right: 30px">

                                            <input type="text" name="nombre_apellido_al" class="form-control" id="nombre_apellido_al" placeholder="nombre y apellido" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="carrera" class="form-control" id="carrera" placeholder="carrera" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select id="id_profesor" class="form-control select2" name="id_profesor">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="cedula_temp_pr" class="form-control col-md-3" id="cedula_temp_pr" placeholder="cedula" disabled style="margin-right: 30px">

                                            <input type="text" name="nombre_apellido_pr" class="form-control" id="nombre_apellido_pr" placeholder="nombre y apellido" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="campus" class="form-control" id="campus" placeholder="campus" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <select name="id_tipo_practica" id="id_tipo_practica" class="form-control" required>
                                                <option value="" selected disabled>Seleccione el Tipo de Practica</option>
                                                <option value="1">Empresarial</option>
                                                <option value="2">Servicio a la comunidad</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <select name="id_alcance_proyecto" id="id_alcance_proyecto" class="form-control" required>
                                                <option value="" selected disabled>Seleccione el Alcance Proyecto</option>
                                                <option value="1">Nacional</option>
                                                <option value="2">Provincial</option>
                                                <option value="3">Cantonal</option>
                                                <option value="4">Parroquial</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <select id="id_empresa" class="form-control select2" name="id_empresa">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" id="PracticaCr" class="btn btn-primary mt-4 pr-4 pl-4 is-valid"><span class="changeText">Crear </span><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<?php 
getScriptsDashboard($data);