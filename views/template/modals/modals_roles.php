<div class="modal fade" id="modalRol" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Crear | Rol  <i class="fa fa-plus"></i></h5>
        <button type="button" class="close" id="closeModal" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="needs-validation" id="fntRol" method="post" role="form" novalidate="">
            <input type="hidden" id="id_rol" name="id_rol" value="">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-append">
                        <span class="input-group-text">
                            <i class="fas fa-address-book"></i>
                        </span>
                    </div>
                    <input type="text" name="nombre_rol" class="form-control" id="nombre_rol"  placeholder="ingrese el nombre del rol">
                </div>
            </div>
            <div class="form-group">
                <textarea name="descripcion" cols="40" rows="2" maxlength="250" class="form-control" style="margin-top: 0px; margin-bottom: 0px; height: 100px;" placeholder="ingrese la descripcion" id="descripcion"></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-4 pr-4 pl-4 is-valid"><span class="changeText">Crear </span><i class="fa fa-plus"></i></button>
        </form>
      </div>
    </div>
  </div>
</div>
