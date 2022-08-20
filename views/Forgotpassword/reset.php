<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Restablecer contraseña</title>
    <link rel="icon" type="image/png" href="https://i.ibb.co/DQstGsn/favicon1.png" sizes="16x16" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php echo server_url; ?>assets/libs/stisla/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo server_url; ?>assets/libs/stisla/assets/css/components.css">
</head>

<body oncontextmenu="return false;">
    <div id="app">
        <section class="section">
        <div class="container mt-5">
            <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="login-brand">
                    <img src="https://i.ibb.co/bgQYpYd/279874955-1027702184620744-1030435789778340311-n.jpg" alt="logo" width="200" class="shadow-light">
                </div>
                
                <div class="card card-primary">
                <div class="card-body">
                <form  id="fntResetpassword" name="fntResetpassword" method="POST" 
                        action="<?php echo server_url; ?>forgotpassword/resetPassword" class="needs-validation" novalidate="">
                    <input id="csrf" name="csrf" type="hidden" value="<?php echo $data["csrf"]; ?>">

                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <div class="input-group">
                                <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </div>
                            <input type="password" name="password" class="form-control" id="password" placeholder="ingrese la contraseña">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Confirmar contraseña</label>
                        <div class="input-group">
                                <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </div>
                            <input type="password" name="password_confirm" class="form-control" id="password_confirm" placeholder="ingrese nuevamente la contraseña">
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">Restablecer la contraseña</button>
                    </div>
                    </form>
                </div>
                </div>
                <div class="simple-footer">
                Copyright &copy; Instituto Tecnológico Superior Tres De Marzo - <?php echo date("Y");?>
                </div>
            </div>
            </div>
        </div>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>

    <script >
        let data = <?php echo $data['error']; ?>;
    </script>

    <script src="<?php echo server_url; ?>assets/libs/stisla/assets/js/stisla.js"></script>
    <script src="<?php echo server_url; ?>assets/libs/stisla/assets/js/scripts.js"></script>
    <script src="<?php echo server_url; ?>assets/libs/stisla/assets/js/custom.js"></script>
    <script src="<?php echo server_url; ?>assets/js/dashboard_validate.js"></script>
    <script src="<?php echo server_url; ?>assets/js/functions_principales.js"></script>
    <script src="<?php echo server_url; ?>assets/js/functions_resetpassword.js"></script>

</body>
</html>