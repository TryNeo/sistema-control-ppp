<?php getHeaderDashboard($data);
getModal('modals_reporte_ppp_empresarial', $data);
getModal('modals_reporte_ppp_comunitario', $data);
?>

<section class="section">
    <div class="section-header">
        <h1 class="mx-auto">Historial estudiante</h1>
    </div>
    <div class="section-body">
    <?php if ($_SESSION['permisos_modulo']['u']) { ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                            <div class="form-group row form-control-sm">
                                <div class="col-sm-12">
                                    <select class="form-control select2" id="SearchAlumno"></select>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table tableHistorialAlumno table-striped table-bordered dt-responsive nowrap" cellspacing="0" style="width:100%">
                                    <thead class="text-uppercase">
                                        <tr>
                                            <th scope="col" style="width:2%">No.</th>
                                            <th scope="col">EMPRESA</th>
                                            <th scope="col">TUTOR DOCENTE</th>
                                            <th scope="col">TIPO</th>
                                            <th scope="col">HORAS</th>
                                            <th scope="col">DESDE</th>
                                            <th scope="col">HASTA</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row  mb-4">
            <?php if ($_SESSION['permisos_modulo']['r']) { ?>
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <button class="btn btn-outline-info" id="pppEmpresarial"><i class="fas fa-print" aria-hidden="true"></i>
                        Imprimir certificado de practicas pre-profesionales (Empresariales)</button>
                    <button class="btn btn-outline-warning"  id="pppComunitario"><i class="fas fa-print" aria-hidden="true"></i>
                        Imprimir certificado de practicas pre-profesionales (Vinculacion con la Sociedad)</button>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<?php
getScriptsDashboard($data);
