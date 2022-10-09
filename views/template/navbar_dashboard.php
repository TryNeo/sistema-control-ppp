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
        <?php if ($_SESSION['user_data']['id_usuario'] == 1) { ?>
          <figure class="avatar mr-2 avatar-sm bg-primary" 
              data-initial="AD">
              <?php if ($_SESSION['user_data']['ultimo_online'] == 1) { ?>
                  <i class="avatar-presence online"></i>
              <?php } ?>

              <?php if ($_SESSION['user_data']['ultimo_online'] == 0) { ?>
                  <i class="avatar-presence offline"></i>
              <?php } ?>
          </figure>
        <?php }else{ ?>
          <?php if ($_SESSION['user_data']['id_rol'] != 2 and ($_SESSION['user_data']['id_rol'] != 3) ) { ?>
            <figure class="avatar mr-2 avatar-sm bg-primary" 
                data-initial="<?php echo strtoupper($_SESSION['user_data']['usuario'][0]); ?><?php echo strtoupper($_SESSION['user_data']['usuario'][1]); ?>">
                <?php if ($_SESSION['user_data']['ultimo_online'] == 1) { ?>
                    <i class="avatar-presence online"></i>
                <?php } ?>

                <?php if ($_SESSION['user_data']['ultimo_online'] == 0) { ?>
                    <i class="avatar-presence offline"></i>
                <?php } ?>
            </figure>
          <?php }else { ?>
            <figure class="avatar mr-2 avatar-sm bg-primary" 
                data-initial="<?php echo $_SESSION['user_data']['nombre'][0]; ?><?php echo $_SESSION['user_data']['apellido'][0]; ?>">
                <?php if ($_SESSION['user_data']['ultimo_online'] == 1) { ?>
                    <i class="avatar-presence online"></i>
                <?php } ?>

                <?php if ($_SESSION['user_data']['ultimo_online'] == 0) { ?>
                    <i class="avatar-presence offline"></i>
                <?php } ?>
            </figure>
          <?php } ?>
        <?php } ?>

        <div class="d-sm-none d-lg-inline-block">HOLA , 
          <?php if ($_SESSION['user_data']['id_usuario'] == 1) { ?>
            ADMINISTRADOR
          <?php }else { ?>
            <?php if ($_SESSION['user_data']['id_rol'] != 2 and ($_SESSION['user_data']['id_rol'] != 3) ) { ?>
              <?php echo strtoupper($_SESSION['user_data']['usuario']); ?>
            <?php }else { ?>
              <?php echo strtoupper($_SESSION['user_data']['nombre']); ?> <?php echo strtoupper($_SESSION['user_data']['apellido']); ?>
            <?php } ?>
          <?php } ?>
        </div>

      </a>
      <div class="dropdown-menu dropdown-menu-right">
        <div class="dropdown-title text-center" >Sesión<h6 id="tiempoRestante">00:00.0</h6></div>
        <a href="<?php echo server_url; ?>logout/" class="dropdown-item has-icon text-danger">
          <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
        </a>
      </div>
    </li>
  </ul>
</nav>
<div class="main-sidebar">
  <aside id="sidebar-wrapper">
    <hr style="border-top:1px solid white;">
    <div class="sidebar-brand">
      <a href="<?php echo server_url; ?>dashboard">
        <img src="https://i.ibb.co/DQstGsn/favicon1.png" alt="logo" width="70" class="shadow-light">
      </a>
    </div>
    <hr style="border-top:1px solid white;">
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="<?php echo server_url; ?>dashboard">
        <img src="https://i.ibb.co/DQstGsn/favicon1.png" alt="logo" width="50" class="shadow-light">
      </a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">MENU PRINCIPAL</li>
      <li class="nav-item">
        <?php if (!empty($_SESSION['permisos'][1]['r'])) { ?>
          <?php if ($data['page_id'] == 1) { ?>
            <li class="active">
              <a href="<?php echo server_url; ?>dashboard/" class="nav-link"><i class="fas fa-home"></i><span>Principal</span></a>
            </li>
          <?php } else { ?>
            <li>
              <a href="<?php echo server_url; ?>dashboard/" class="nav-link"><i class="fas fa-fire"></i><span>Principal</span></a>
            </li>
          <?php } ?>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][6]['r'])) { ?>
          <?php if ($data['page_id'] == 6) { ?>
            <li class="active">
              <a href="<?php echo server_url; ?>alumnos/" class="nav-link"><i class="fas fa-user-friends"></i><span>Estudiantes</span></a>
            </li>
          <?php } else { ?>
            <li>
              <a href="<?php echo server_url; ?>alumnos/" class="nav-link"><i class="fas fa-user-friends"></i><span>Estudiantes</span></a>
            </li>
          <?php } ?>
        <?php } ?>

        <?php if (!empty($_SESSION['permisos'][7]['r'])) { ?>
          <?php if ($data['page_id'] == 7) { ?>
            <li class="active">
              <a href="<?php echo server_url; ?>profesores/" class="nav-link"><i class="fas fa-user-tie"></i><span>Docentes</span></a>
            </li>
          <?php } else { ?>
            <li>
              <a href="<?php echo server_url; ?>profesores/" class="nav-link"><i class="fas fa-user-tie"></i><span>Docentes</span></a>
            </li>
          <?php } ?>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][8]['r'])) { ?>
          <?php if ($data['page_id'] == 8) { ?>
            <li class="active">
              <a href="<?php echo server_url; ?>empresas/" class="nav-link"><i class="far fa-building"></i><span>Convenios</span></a>
            </li>
          <?php } else { ?>
            <li>
              <a href="<?php echo server_url; ?>empresas/" class="nav-link"><i class="far fa-building"></i><span>Convenios</span></a>
            </li>
          <?php } ?>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][9]['r'])) { ?>
          <?php if ($data['page_id'] == 9) { ?>
            <li class="active">
              <a href="<?php echo server_url; ?>practicas-pre-profesionales/" class="nav-link"><i class="fas fa-pencil-ruler"></i><span>Pasantias</span></a>
            </li>
          <?php } else { ?>
            <li>
              <a href="<?php echo server_url; ?>practicas-pre-profesionales/" class="nav-link"><i class="fas fa-pencil-ruler"></i><span>Pasantias</span></a>
            </li>
          <?php } ?>
        <?php } ?>
        <?php if (!empty($_SESSION['permisos'][10]['r'])) { ?>
          <?php if ($data['page_id'] == 10) { ?>
            <li class="active">
              <a href="<?php echo server_url; ?>historial-estudiante/" class="nav-link"><i class="fas fa-history"></i><span>Historial Estudiante</span></a>
            </li>
          <?php } else { ?>
            <li>
              <a href="<?php echo server_url; ?>historial-estudiante/" class="nav-link"><i class="fas fa-history"></i><span>Historial Estudiante</span></a>
            </li>
          <?php } ?>
        <?php } ?>
      </li>
      <?php if ($_SESSION['user_data']['id_rol'] != 2) {?>
      <li class="menu-header">Seguridad</li>
        <li class="nav-item">
          <?php if (!empty($_SESSION['permisos'][2]['r'])) { ?>
            <?php if ($data['page_id'] == 2) { ?>
                <li class="active">
                  <a class="nav-link" href="<?php echo server_url; ?>usuarios/"><i class="fas fa-user-circle"></i><span>Usuarios</span></a></li>
              <?php } else { ?>
                <li><a class="nav-link" href="<?php echo server_url; ?>usuarios/"><i class="fas fa-user-circle"></i><span>Usuarios</span></a></li>
            <?php } ?>
          <?php } ?>
          <?php if (!empty($_SESSION['permisos'][3]['r'])) { ?>
            <?php if ($data['page_id'] == 3) { ?>
                <li class="active"><a class="nav-link" href="<?php echo server_url; ?>roles/"><i class="fas fa-users" aria-hidden="true"></i>
                  <span>Roles</span></a></li>
            <?php } else { ?>
                <li><a class="nav-link" href="<?php echo server_url; ?>roles/"><i class="fas fa-users" aria-hidden="true"></i><span>Roles</span></a></li>
            <?php } ?>
          <?php } ?>
          <?php if (!empty($_SESSION['permisos'][5]['r'])) { ?>
            <?php if ($data['page_id'] == 5) { ?>
                <li class="active"><a class="nav-link" href="<?php echo server_url; ?>permisos/"><i class="fas fa-shield-alt"></i><span>Permisos</span></a></li>
            <?php } else { ?>
                <li><a class="nav-link" href="<?php echo server_url; ?>permisos/"><i class="fas fa-shield-alt"></i><span>Permisos</span></a></li>
            <?php } ?>
          <?php } ?>
          <?php if (!empty($_SESSION['permisos'][4]['r'])) { ?>
            <?php if ($data['page_id'] == 4) { ?>
              <li class="active"><a class="nav-link" href="<?php echo server_url; ?>respaldo/"><i class="fas fa-database"></i><span>Respaldos</span></a></li>
            <?php } else { ?>
              <li><a class="nav-link" href="<?php echo server_url; ?>respaldo/"><i class="fas fa-database"></i><span>Respaldos</span></a></li>
            <?php } ?>
          <?php } ?>
          </li>
        </li>
      <?php } ?>
      <div class="p-3 hide-sidebar-mini">
            <a href="https://institutotresdemarzo.edu.ec/" class="btn btn-primary btn-lg btn-block btn-icon-split" target="_blank">
                Pagina web <i class="fas fa-pager"></i>
            </a>
      </div>
      <?php if ($_SESSION['user_data']['id_rol'] != 2) {?>
          <div class="p-3 hide-sidebar-mini">
            <a href="https://drive.google.com/drive/my-drive" class="btn btn-success btn-lg btn-block btn-icon-split" target="_blank">
                Google Drive  <i class="fab fa-google-drive"></i>
            </a>
          </div>
      <?php } ?>
    </ul>
  </aside>
</div>