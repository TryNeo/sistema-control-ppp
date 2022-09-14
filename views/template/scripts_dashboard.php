</div>
<footer class="main-footer">
    <div class="footer-left">
        Copyright © <?php echo date("Y"); ?> <div class="bullet"></div>Desarrollado por estudiantes del <a href="https://istg.edu.ec/" target="_blank">istg</a>
    </div>
    <div class="footer-right">
        Version 1.0
    </div>
    <!--
            AUTHOR:JOEL JOSUE HUACON LOPEZ
            GITHUB:https://github.com/TryNeo
            MAIL:ts.josu3@gmail.com
        --->
</footer>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@emretulek/jbvalidator"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.js" integrity="sha512-tlmsbYa/wD9/w++n4nY5im2NEhotYXO3k7WP9/ds91gJk3IqkIXy9S0rdMTsU4n7BvxCR3G4LW2fQYdZedudmg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js" integrity="sha512-2xXe2z/uA+2SyT/sTSt9Uq4jDKsT0lV4evd3eoE/oxKih8DSAsOF6LUb+ncafMJPAimWAXdu9W+yMXGrCVOzQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/i18n/es.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-colorpicker@3.4.0/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>

<script src="<?php echo server_url; ?>assets/libs/stisla/assets/js/stisla.js"></script>
<script src="<?php echo server_url; ?>assets/libs/stisla/assets/js/scripts.js"></script>
<script src="<?php echo server_url; ?>assets/libs/stisla/assets/js/custom.js"></script>
<script src="<?php echo server_url; ?>assets/js/dashboard_validate.js"></script>
<script src="<?php echo server_url; ?>assets/js/functions_principales.js"></script>
<script src="<?php echo server_url; ?>assets/js/dashboard_reloj.js"></script>

<?php if (isset($data['page'])) { ?>
    <?php if ($data['page'] == 'roles') { ?>
        <script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_rol.js"></script>
    <?php } ?>
    <?php if ($data['page'] == 'permisos') { ?>
        <script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_permisos.js"></script>
    <?php } ?>

    <?php if ($data['page'] == 'respaldo') { ?>
        <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
        <script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_respaldo.js"></script>
    <?php } ?>

    <?php if ($data['page'] == 'usuario') { ?>
        <script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_usuarios.js"></script>
    <?php } ?>


    <?php if ($data['page'] == 'alumnos') { ?>
        <script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_alumnos.js"></script>
    <?php } ?>

    <?php if ($data['page'] == 'empresas') { ?>
        <script type="text/javascript" src="<?php echo server_url; ?>assets/js/functions_empresas.js"></script>
    <?php } ?>

<?php } else { ?>
<?php } ?>

<script src="<?php echo server_url; ?>assets/libs/datatables/datatables.min.js"></script>
<!--<script src="/assets/libs/datatables/DataTables-1.10.16/js/dataTables.boostrap4.min.js"></script>-->
</body>
</html>