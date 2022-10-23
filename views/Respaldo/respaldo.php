<?php getHeaderDashboard($data);
?>
<section class="section">
    <div class="section-header">
        <h1>Listado de las copias de la base de datos</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                    <?php if ($_SESSION['permisos_modulo']['w']) { ?>
                        <button id="backupbd" type="button" class="btn btn-outline-primary mb-3 btn-lg mb-3">Realizar copia de seguridad <i class="fa fa-plus"></i></button>
                    <?php } ?>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table tableRespaldo table-striped table-bordered dt-responsive nowrap" cellspacing="0" style="width:100%">
                                    <thead>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Opciones</th>
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
<script type="text/javascript">

</script>
<?php
getScriptsDashboard($data);
