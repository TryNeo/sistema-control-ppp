<?php getHeaderError($data); ?>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="page-error">
                    <div class="page-inner">
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <img class="mx-auto d-block" src="https://i.ibb.co/DQstGsn/favicon1.png" width="150">
                                </div>
                            </div>
                            <hr width="350">
                            <div class="row">
                                <div class="col-12 text-center">
                                    <h1 class="error-title" style="font-size: 75px;">403</h1>
                                    <h2 class="error-subtitle">Acceso Restringido</h2>
                                    <p class="error-message" style="font-size: 20px;">
                                        La pagina a la que intenta acceder no le esta permitida su accesso
                                    </p>
                                    <p class="error-message">
                                        <button class="btn  btn-sm  btn-outline-primary" onclick="javascript:history.go(-1)">
                                            Regresar a la pagina anterior
                                        </button>
                                        <span style="font-size: 25px;">&nbsp;&nbsp;&nbsp;O&nbsp;&nbsp;&nbsp;</span> 
                                        <a href="<?php echo server_url; ?>" class="btn btn-sm  btn-outline-primary">Ir a la pagina principal</a>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="simple-footer mt-5">
                    Copyright &copy; Instituto Tecnológico Superior Tres De Marzo - <?php echo date("Y"); ?> </div>
            </div>
        </section>
    </div>


    <script src="<?php echo server_url; ?>assets/libs/stisla/assets/js/custom.js"></script>

</body>