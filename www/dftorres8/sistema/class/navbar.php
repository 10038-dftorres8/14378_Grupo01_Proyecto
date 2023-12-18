<?php 
    $mn = $_SESSION['rol'];

    $html ='
            <nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark mb-3">
            <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <a class="navbar-brand" href="#">Sistema de Matriculacion</a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>';

                if($mn == 1){
                    $html.='    <li class="nav-item">
                    <a class="nav-link" href="Vehiculos.php">Vehiculos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Marcas.php">Marca</a>
                </li>';
                }elseif($mn == 2){
                    $html .= '<li class="nav-item">
                    <a class="nav-link" href="Matriculacion.php">Matriculacion</a>
                        </li>
                        ';
                    

                }elseif($mn == 3){
                    $html .= '<li class="nav-item">
                    <a class="nav-link" href="mostrar_vehiculo.php">Vehiculo</a>
                        </li>
                        ';
                }

                $html.='   

                <form class="d-flex" style="position: absolute; right: 0; ">
                    <a class="nav-link active bi bi-door-closed " href="class/cerrar.php"> Cerrar Sesion</a>
                </form>
            
                </div>
                </div>
            </nav>
            ';
            

                   

    echo $html;
?>