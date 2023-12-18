<!-- Modal -->
<div class="modal fade" id="modalFormReceta" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nueva Receta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formReceta" name="formReceta" class="form-horizontal">
              <input type="hidden" id="idReceta" name="idReceta" value="">
              <p class="text-primary">Todos los campos son obligatorios.</p>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="listConsultas">Consulta (ID, Médico, Paciente, Fecha):</label>
                  <select class="form-control" data-live-search="true" id="listConsultas" name="listConsultas" required >
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="listMedicamentos">Medicamento:</label>
                  <select class="form-control" data-live-search="true" id="listMedicamentos" name="listMedicamentos" required >
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="intCantidad">Cantidad:</label>
                  <input type="number" class="form-control valid" id="intCantidad" name="intCantidad" required="">
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
<div class="modal fade" id="modalViewReceta" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos de la receta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>N° Consulta:</td>
              <td id="celConsulta">1</td>
            </tr>
            <tr>
              <td>Médico:</td>
              <td id="celMedico">1</td>
            </tr>
            <tr>
              <td>Paciente:</td>
              <td id="celPaciente">1</td>
            </tr>
            <tr>
              <td>Fecha Consulta:</td>
              <td id="celFecha">1</td>
            </tr>
            <tr>
              <td>Medicamento:</td>
              <td id="celMedicamento">Aspirina</td>
            </tr>
            <tr>
              <td>Cantidad:</td>
              <td id="celCantidad">3</td>
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

