<!-- Modal -->
<div class="modal fade" id="modalFormPaciente" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Paciente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formPaciente" name="formPaciente" class="form-horizontal">
              <input type="hidden" id="idUsuario" name="idUsuario" value="">
              <p class="text-primary">Todos los campos son obligatorios.</p>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="listUsers">Usuario</label>
                  <select class="form-control" data-live-search="true" id="listUsers" name="listUsers" required >
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="txtNombre">Nombre:</label>
                  <input type="text" class="form-control valid validText" id="txtNombre" name="txtNombre" required="">
                </div>
                <div class="form-group col-md-6">
                  <label for="intCedula">Cédula:</label>
                  <input type="number" class="form-control valid" id="intCedula" name="intCedula" maxlength="10" minlength="10" required="">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="intEdad">Edad (años):</label>
                  <input type="number" class="form-control valid" id="intEdad" name="intEdad" maxlength="3" required="">
                </div>
                <div class="form-group col-md-6">
                  <label for="txtGenero">Género:</label>
                  <select class="form-control selectpicker" id="txtGenero" name="txtGenero" required >
                      <option value="Masculino">Masculino</option>
                      <option value="Femenino">Femenino</option>
                    </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="intEstatura">Estatura (cm):</label>
                  <input type="number" class="form-control valid" id="intEstatura" name="intEstatura" maxlength="3" minlength="2" required="">
                </div>
                <div class="form-group col-md-6">
                  <label for="floatPeso">Peso (kg):</label>
                  <input type="number" step="0.01" class="form-control valid" id="floatPeso" name="floatPeso" required="">
                </div>
              </div>

              <div class="tile-footer">
                <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
                <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
              </div>
            </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del médico</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Nombre:</td>
              <td id="celNombre">Lionel</td>
            </tr>
            <tr>
              <td>Usuario:</td>
              <td id="celUser">User</td>
            </tr>
            <tr>
              <td>Cédula:</td>
              <td id="celCedula">1234567890</td>
            </tr>
            <tr>
              <td>Edad:</td>
              <td id="celEdad">36</td>
            </tr>
            <tr>
              <td>Género:</td>
              <td id="celGenero">Masculino</td>
            </tr>
            <tr>
              <td>Estatura:</td>
              <td id="celEstatura">170</td>
            </tr>
            <tr>
              <td>Peso:</td>
              <td id="celPeso">57.2</td>
            </tr>
            <tr>
              <td>Foto:</td>
              <td id="imgCategoria"></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

