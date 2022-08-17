<div class="navbar-bg"></div>
    <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
            <ul class="navbar-nav mr-3">
                <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            </ul>
        </form>
        <ul class="navbar-nav navbar-right">
            <li class="dropdown dropdown-list-toggle reloj" style="margin-right:20px;margin-top:6px;color:white;font-size:17px;">
                <a class="nav-link reloj" href="#">
                </a>
            </li>
            <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <figure class="avatar mr-2 avatar-sm">
              
              <?php if($_SESSION['user_data']['foto'] == '') {?>
                <img alt="image" src="<?php echo server_url_image; ?>default.png" class="rounded-circle mr-1">
              <?php }else{ ?>
                <img alt="image" src="<?php echo $_SESSION['user_data']['foto']; ?>" class="rounded-circle mr-1">
              <?php } ?>

              <?php if($_SESSION['user_data']['ultimo_online'] == 1) {?>
                <i class="avatar-presence online"></i>
              <?php } ?>

              <?php if($_SESSION['user_data']['ultimo_online'] == 0) {?>
                <i class="avatar-presence offline"></i>
              <?php } ?>
            </figure>
            
            <div class="d-sm-none d-lg-inline-block">Hola, <?= $_SESSION['user_data']['nombre'] ?> <?= $_SESSION['user_data']['apellido'] ?></div></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-divider"></div>
                    <a href="<?php echo server_url; ?>logout/" class="dropdown-item has-icon text-danger">
                      <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </a>
                </div>
            </li>
        </ul>
    </nav>
    <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html">PANEL CONTROL PPP</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">PCE</a>
          </div>
          <ul class="sidebar-menu">
              <li class="menu-header">Dashboard</li>
              <li class="nav-item">
                <?php if (!empty($_SESSION['permisos'][1]['r'])) {?>
                  <?php if($data['page_id'] == 1 ){ ?>
                    <li class="active">
                      <a href="<?php echo server_url; ?>dashboard/" class="nav-link"><i class="fas fa-home"></i><span>Dashboard</span></a>
                    </li>
                  <?php }else{ ?>
                    <li>
                      <a href="<?php echo server_url; ?>dashboard/" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                    </li>               
                  <?php } ?>
                <?php } ?>
              </li>
              <li class="menu-header">Seguridad</li>
              <li class="dropdown">
              <a href="#" class="has-dropdown"><i class="fas fa-lock"></i><span>Configuracion</span></a>
              <ul class="dropdown-menu" style="display: block;">

                <?php if (!empty($_SESSION['permisos'][2]['r'])) {?>
                    <?php if($data['page_id'] == 2){ ?>
                      <li class="active"><a class="nav-link" href="<?php echo server_url; ?>usuarios/"><i class="fas fa-user-circle"></i>Usuarios</a></li>                
                    <?php }else{ ?>
                      <li><a class="nav-link" href="<?php echo server_url; ?>usuarios/"><i class="fas fa-user-circle"></i>Usuarios</a></li>                
                    <?php } ?>
                  <?php } ?>


                  <?php if (!empty($_SESSION['permisos'][3]['r'])) {?>
                    <?php if($data['page_id'] == 3 ){ ?>
                      <li class="active"><a class="nav-link" href="<?php echo server_url; ?>roles/"><i class="fas fa-users" aria-hidden="true"></i>Roles</a></li>
                    <?php }else{ ?>
                      <li><a class="nav-link" href="<?php echo server_url; ?>roles/"><i class="fas fa-users" aria-hidden="true"></i>Roles</a></li>                
                    <?php } ?>
                  <?php } ?>

                  <?php if (!empty($_SESSION['permisos'][5]['r'])) {?>
                    <?php if($data['page_id'] == 5 ){ ?>
                      <li class="active"><a class="nav-link" href="<?php echo server_url; ?>permisos/"><i class="fas fa-shield-alt"></i>Permisos</a></li>                
                    <?php }else{ ?>
                      <li><a class="nav-link" href="<?php echo server_url; ?>permisos/"><i class="fas fa-shield-alt"></i>Permisos</a></li>                
                    <?php } ?>
                  <?php } ?>

                  
                  <?php if (!empty($_SESSION['permisos'][4]['r'])) {?>
                    <?php if($data['page_id'] == 4 ){ ?>
                      <li class="active"><a class="nav-link" href="<?php echo server_url; ?>respaldo/"><i class="fas fa-database" ></i>Respaldos</a></li>                
                    <?php }else{ ?>
                      <li><a class="nav-link" href="<?php echo server_url; ?>respaldo/"><i class="fas fa-database"></i>Respaldos</a></li>                
                    <?php } ?>
                  <?php } ?>
                </ul>
              </li>
            </ul>
        </aside>
    </div>
