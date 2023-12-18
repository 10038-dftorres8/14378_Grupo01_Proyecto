    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?= media();?>/images/avatar.png" alt="User Image">
        <div>
          <p class="app-sidebar__user-name"><?= $_SESSION['userData']['NombreUser']; ?></p>
          <p class="app-sidebar__user-designation"><?= $_SESSION['userData']['NombreRol']; ?></p>
        </div>
      </div>
      <ul class="app-menu">
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/dashboard">
                <i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>
        <?php if($_SESSION['userData']['IdRol'] == 1){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/usuarios">
                <i class="app-menu__icon fa fa-users" aria-hidden="true"></i>
                <span class="app-menu__label">Usuarios</span>
            </a>
        </li>
        <?php } ?>
        <?php if($_SESSION['userData']['IdRol'] == 1){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/medicos">
                <i class="app-menu__icon fas fa-user-md" aria-hidden="true"></i>
                <span class="app-menu__label">Médicos</span>
            </a>
        </li>
        <?php } ?>
        <?php if($_SESSION['userData']['IdRol'] == 1){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/pacientes">
                <i class="app-menu__icon fas fa-head-side-virus" aria-hidden="true"></i>
                <span class="app-menu__label">Pacientes</span>
            </a>
        </li>
        <?php } ?>
        <?php if($_SESSION['userData']['IdRol'] == 2){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/consultas">
                <i class="app-menu__icon fas fa-clipboard-list" aria-hidden="true"></i>
                <span class="app-menu__label">Consultas</span>
            </a>
        </li>
        <?php } ?>
        <?php if($_SESSION['userData']['IdRol'] == 2){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/recetas">
                <i class="app-menu__icon fas fa-receipt" aria-hidden="true"></i>
                <span class="app-menu__label">Recetas</span>
            </a>
        </li>
        <?php } ?>
        <?php if($_SESSION['userData']['IdRol'] == 1){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/medicamentos">
                <i class="app-menu__icon fas fa-prescription-bottle-alt" aria-hidden="true"></i>
                <span class="app-menu__label">Medicamentos</span>
            </a>
        </li>
        <?php } ?>
        <?php if($_SESSION['userData']['IdRol'] == 3){ ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/misconsultas">
                <i class="app-menu__icon fas fa-clipboard-list" aria-hidden="true"></i>
                <span class="app-menu__label">Mis Consultas</span>
            </a>
        </li>
        <?php } ?>
        <li>
            <a class="app-menu__item" href="<?= base_url(); ?>/logout">
                <i class="app-menu__icon fa fa-sign-out" aria-hidden="true"></i>
                <span class="app-menu__label">Cerrar Sesión</span>
            </a>
        </li>
      </ul>
    </aside>