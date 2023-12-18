<!-- Modal -->
<div class="modal fade" id="modalFormConsulta" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nueva Consulta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form id="formConsulta" name="formConsulta" class="form-horizontal">
              <input type="hidden" id="idConsulta" name="idConsulta" value="">
              <p class="text-primary">Todos los campos son obligatorios.</p>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="listPacientes">Paciente:</label>
                  <select class="form-control" data-live-search="true" id="listPacientes" name="listPacientes" required >
                  </select>
                </div>
                <div class="form-group col-md-6">
                  <label for="listMedicos">Médico:</label>
                  <select class="form-control" data-live-search="true" id="listMedicos" name="listMedicos" required >
                  </select>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="dateFecha">Fecha Consulta:</label>
                  <input type="date" class="form-control valid" id="dateFecha" name="dateFecha" required="">
                </div>
                <div class="form-group col-md-6">
                  <label for="txtDiagnostico">Diagnóstico:</label>
                  <input type="text" class="form-control valid" id="txtDiagnostico" name="txtDiagnostico" required="">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="timeInicio">Hora Inicio:</label>
                  <input type="time" class="form-control valid" id="timeInicio" name="timeInicio" required="">
                </div>
                <div class="form-group col-md-6">
                  <label for="timeFin">Hora Fin:</label>
                  <input type="time" class="form-control valid" id="timeFin" name="timeFin" required="">
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
<div class="modal fade" id="modalViewConsulta" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" >
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos de la consulta</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Paciente:</td>
              <td id="celPaciente">Luis Miguel</td>
            </tr>
            <tr>
              <td>Médico:</td>
              <td id="celMedico">Ibrahimovic Zlatan</td>
            </tr>
            <tr>
              <td>Fecha Consulta:</td>
              <td id="celFechaConsulta">2023-12-17</td>
            </tr>
            <tr>
              <td>Diagnóstico:</td>
              <td id="celDiagnostico">Sida</td>
            </tr>
            <tr>
              <td>Hora Inicio:</td>
              <td id="celHoraInicio">12:00:00</td>
            </tr>
            <tr>
              <td>Hora Fin:</td>
              <td id="celHoraFin">13:00:00</td>
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

