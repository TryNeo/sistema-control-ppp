<?php getHeaderDashboard($data);
?>
<section class="section">
    <div class="section-header">
        <h1>INSTITUTO SUPERIOR TECNOLÓGICO TRES DE MARZO -  
        <?php if ($_SESSION['user_data']['id_usuario'] == 1) { ?>
            ADMINISTRADOR
        <?php } else {?>
            <?php echo $_SESSION['user_data']['nombre']; ?> <?php echo $_SESSION['user_data']['apellido']; ?>
        <?php } ?>
        </h1>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-user-friends"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Alumnos</h4>
                    </div>
                    <div class="card-body">
                        <?php echo $data["total_alumnos"]; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Docentes</h4>
                    </div>
                    <div class="card-body">
                        <?php echo $data["total_profesores"]; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                <i class="fas fa-signal"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Usuarios Online</h4>
                    </div>
                    <div class="card-body">
                        <?php echo $data["total_usuarios_online"]; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="far fa-building"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Convenios</h4>
                    </div>
                    <div class="card-body">
                        <?php echo $data["total_empresas"]; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#carouselExampleIndicators2" data-slide-to="0" class="active"></li>
                        <li data-target="#carouselExampleIndicators2" data-slide-to="1" class=""></li>
                        <li data-target="#carouselExampleIndicators2" data-slide-to="2" class=""></li>
                        <li data-target="#carouselExampleIndicators2" data-slide-to="3" class=""></li>
                    </ol>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="https://i.ibb.co/6F73wYt/Negro-y-Azul-Ne-n-Tecnolog-a-Promoci-n-en-L-nea-Video-de-Promoci-n-de-Ciber-Lunes-600-1920-px-600-80.gif" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="https://i.ibb.co/8YcYdCZ/Navy-Grey-Modern-Minimalist-Business-Accounting-Banner-Landscape-1920-600-px.gif" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="https://i.ibb.co/pnJTYdV/Blue-Air-Conditioning-Promo-Instagram-Post.gif" alt="Third slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="https://i.ibb.co/5vSgD1r/Blue-Air-Conditioning-Promo-Facebook-Post-1920-600-px.gif" alt="four slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators2" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

<?php
getScriptsDashboard($data);
