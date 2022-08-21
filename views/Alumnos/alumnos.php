<?php getHeaderDashboard($data); 
?>    

<section class="section">
    <div class="section-header">
        <h1>Alumnos</h1>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <button id="openModal" type="button"  class="btn btn-primary mb-3 btn-lg mb-3">Agregar <i class="fa fa-plus"></i>
                        </button>
                        <div class="row">
                            <div class="col-md-12">
                                <table  class="table tableAlumno table-striped table-bordered dt-responsive nowrap" cellspacing="0"  style="width:100%">
                                    <thead class="text-uppercase">
                                        <tr>
                                            <th scope="col">ID</th>
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
<script type="text/javascript">

</script>
<?php 
getScriptsDashboard($data);