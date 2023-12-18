<!-- Modal -->
<div class="modal fade" id="modalFormPerfil" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerUpdate">
        <h5 class="modal-title" id="titleModal">Actualizar Datos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formPerfil" name="formPerfil" class="form-horizontal">
              <p class="text-primary">Los campos con asterisco (<span class="required">*</span>) son obligatorios.</p>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="txtNombre">Nombre <span class="required">*</span></label>
                  <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" value="<?= $_SESSION['userData']['NombrePac']; ?>" required="">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="intCedula">Cedula <span class="required">*</span></label>
                  <input type="text" class="form-control valid" id="intCedula" name="intCedula" value="<?= $_SESSION['userData']['Cedula']; ?>" required="">
                </div>
                <div class="form-group col-md-6">
                  <label for="intEdad">Edad <span class="required">*</span></label>
                  <input type="number" class="form-control valid" id="intEdad" name="intEdad" value="<?= $_SESSION['userData']['Edad']; ?>" required="">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="txtGenero">Genero <span class="required">*</span></label>
                  <select class="form-control selectpicker" id="txtGenero" name="txtGenero" value="<?= $_SESSION['userData']['Genero']; ?>" required >
                      <option value="Masculino">Masculino</option>
                      <option value="Femenino">Femenino</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="intEstatura">Estatura <span class="required">*</span></label>
                  <input type="text" class="form-control valid" id="intEstatura" name="intEstatura" value="<?= $_SESSION['userData']['Estatura']; ?>" required="">
                </div>
                <div class="form-group col-md-6">
                  <label for="floatPeso">Peso (kg):</label>
                  <input type="number" step="0.01" class="form-control valid" id="floatPeso" name="floatPeso" value="<?= $_SESSION['userData']['Peso']; ?>" required="">
                </div>
              </div>
              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-info" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Actualizar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>