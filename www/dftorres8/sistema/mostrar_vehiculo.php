<?php
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Matriculas Vehículos</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
	<?php
		require_once(__DIR__.'/constantes.php');
		include_once("class/class.vehiculo.php");
		include_once("class/navbar.php");
       
        $objeto = $_SESSION['vehiculo_usuario'];
		
		$cn = conectar();
		$v = new vehiculo($cn);

            
        /*
        echo "<tr>
                    <td>$placa</td>
                    <td>$marca</td>
                    <td>$motor</td>
                    <td>$chasis</td>
                </tr>";*/

                $html = '
                    <div class = "container-fluid">
                        <div class = "table-responsive">
                            <table class = "table table-bordered">
                                <thead class = "table-dark">
                                    <tr>
                                        <th scope = "col" colspan = "8" class = "text-center">Lista de Vehiculos</th>
                                    </tr>
                                    
                                </thead>
                                <tbody>
                                <tr class = "text-center table-primary">
                                    <td>Placa</td>
                                    <td>Marca</td>
                                    <td>Color</td>
                                    <td>Anio</td>
                                    <th colspan="3">Acciones</th>
                                </tr>
                        ';

                        foreach ($objeto as $vehiculo) {
                            $id = $vehiculo['id'];
                            $placa = $vehiculo['placa'];
                            $marca = $vehiculo['marca'];
                            $motor = $vehiculo['motor'];
                            $chasis = $vehiculo['chasis'];
                        }
                        $d_del = "del/" . $id;
                        $d_del_final = base64_encode($d_del);
                        $d_act = "act/" . $id;
                        $d_act_final = base64_encode($d_act);
                        $d_det = "det/" . $id;
                        $d_det_final = base64_encode($d_det);

                        $html .= '
				<tr>
					<td>' .$placa . '</td>
					<td>' . $marca. '</td>
					<td>' . $motor. '</td>
					<td>' . $chasis. '</td>
					<td class="text-center" ><a href="Vehiculos.php?d=' . $d_del_final . ' " class = "bi bi-x-circle btn btn-success btn-sm"disabled style="pointer-events: none; opacity: 0.5;"> Borrar</a></td>
					<td class="text-center"><a href="Vehiculos.php?d=' . $d_act_final . '" class = "bi bi-database btn btn-info btn-sm"disabled style="pointer-events: none; opacity: 0.5;"> Actualizar</a></td>
					<td class="text-center"><a href="Vehiculos.php?d=' . $d_det_final . '" class = "bi bi-card-list btn btn-warning btn-sm"> Detalle</a></td>
				</tr>';
		
		$html .= '</tbody>
				</table>
			</div>
		</div>';

        echo $html;
		

		
	//*******************************************************
		function conectar(){
			//echo "<br> CONEXION A LA BASE DE DATOS<br>";
			$c = new mysqli(SERVER,USER,PASS,BD);
			
			if($c->connect_errno) {
				die("Error de conexión: " . $c->mysqli_connect_errno() . ", " . $c->connect_error());
			}else{
				//echo "La conexión tuvo éxito .......<br><br>";
			}
			
			$c->set_charset("utf8");
			return $c;
		}
	//**********************************************************	

		
	?>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
