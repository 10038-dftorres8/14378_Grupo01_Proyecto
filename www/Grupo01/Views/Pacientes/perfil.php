<?php
  headerAdmin($data);
  getModal('modalPerfil',$data);
 ?>
<main class="app-content">
  <div class="row user">
    <div class="col-md-12">
      <div class="profile">
        <div class="info"><img class="user-img" src="<?= media();?>/images/avatar.png">
          <h4><?= $_SESSION['userData']['NombrePac'];?></h4>
          <p><?= $_SESSION['userData']['NombreRol']; ?></p>
        </div>
        <div class="cover-image"></div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="tile p-0">
        <ul class="nav flex-column nav-tabs user-tabs">
          <li class="nav-item"><a class="nav-link active" href="#user-timeline" data-toggle="tab">Datos personales</a></li>
        </ul>
      </div>
    </div>
    <div class="col-md-9">
      <div class="tab-content">
        <div class="tab-pane active" id="user-timeline">
          <div class="timeline-post">
            <div class="post-media">
              <div class="content">
                <h5>DATOS PERSONALES <button class="btn btn-sm btn-info" type="button" onclick="openModalPerfil();"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button></h5>
              </div>
            </div>

            <table class="table table-bordered">
              <tbody>
                <tr>
                  <td style="width:150px;">Nombre:</td>
                  <td><?= $_SESSION['userData']['NombrePac']; ?></td>
                </tr>
                <tr>
                  <td>Cédula:</td>
                  <td><?= $_SESSION['userData']['Cedula']; ?></td>
                </tr>
                <tr>
                  <td>Apellidos:</td>
                  <td><?= $_SESSION['userData']['Edad']; ?></td>
                </tr>
                <tr>
                  <td>Teléfono:</td>
                  <td><?= $_SESSION['userData']['Genero']; ?></td>
                </tr>
                <tr>
                  <td>Estatura:</td>
                  <td><?= $_SESSION['userData']['Estatura']; ?></td>
                </tr>
                <tr>
                  <td>Genero:</td>
                  <td><?= $_SESSION['userData']['Genero']; ?></td>
                </tr>
                <tr>
                  <td>Peso:</td>
                  <td><?= $_SESSION['userData']['Peso']; ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php footerAdmin($data); ?>