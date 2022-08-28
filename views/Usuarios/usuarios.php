<?php getHeaderDashboard($data);
    getModal('modals_usuarios',$data);

?>
    <section class="section">
        <div class="section-header">
            <h1>Usuarios</h1>
        </div>
        <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                        <?php  if ($_SESSION['permisos_modulo']['w']) {?>
                            <button id="openModal" type="button" class="btn btn-primary mb-3 btn-lg mb-3">Agregar <i class="fa fa-plus"></i></button>
                        <?php } ?>
                        <div class="row">
                                <div class="col-md-12">
                                    <table class="table tableUsuarios table-striped table-bordered dt-responsive nowrap" cellspacing="0" style="width:100%">
                                        <thead class="text-uppercase">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">USUARIO</th>
                                            <th scope="col">EMAIL INSTITUCIONAL</th>
                                            <th scope="col">EMAIL ACTIVO</th>
                                            <th scope="col">ACTIVIDAD</th>
                                            <th scope="col">ROL</th>
                                            <th scope="col">ESTADO</th>
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
    </section>
<?php
getScriptsDashboard($data);