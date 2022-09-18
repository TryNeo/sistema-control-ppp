<?php getHeaderDashboard($data);
?>    

<section class="section">
    <div class="section-header">
        <h1>Practicas pre profesionales</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php  if ($_SESSION['permisos_modulo']['w']) {?>
                        <a href="<?php echo server_url; ?>practicas-pre-profesionales/agregar" class="btn btn-primary mb-3 btn-lg mb-3">Agregar <i class="fa fa-plus"></i>
                        </a>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-12">
                                <table  class="table tablePracticas table-striped table-bordered dt-responsive nowrap" cellspacing="0"  style="width:100%">
                                    <thead class="text-uppercase">
                                        <tr>
                                            <th scope="col">ALUMNO</th>
                                            <th scope="col">EMPRESA / DOCENTE</th>
                                            <th scope="col">FECHA INICIAL</th>
                                            <th scope="col">FECHA FINAL</th>
                                            <th scope="col">TIPO</th>
                                            <th scope="col">OPCIONES</th>
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
    </div>
</section>
<?php 
getScriptsDashboard($data);