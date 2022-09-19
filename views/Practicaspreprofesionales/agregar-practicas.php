<?php getHeaderDashboard($data);
?>    
<section class="section">
    <div class="section-header">
        <h1>Agregando pasantias</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    <form class="needs-validation" id="fntPracticas" method="post" role="form" novalidate="">
                        <input type="hidden" id="id_practicas" name="id_practicas" value="">
                        <div class="card-body-lg row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select id="id_alumno" class="form-control select2" name="id_alumno">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="cedula_temp" class="form-control col-md-3" id="cedula_temp" placeholder="cedula" disabled style="margin-right: 30px">

                                        <input type="text" name="nombre_apellido" class="form-control" id="nombre_apellido" placeholder="nombre y apellido" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="input-group">
                                        <input type="text" name="carrera" class="form-control col-md-3" id="carrera" placeholder="carrera" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" id="PracticaCr" class="btn btn-primary mt-4 pr-4 pl-4 is-valid"><span class="changeText">Crear </span><i class="fa fa-plus"></i></button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php 
getScriptsDashboard($data);