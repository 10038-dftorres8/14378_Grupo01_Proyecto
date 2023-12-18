<?php

class matricula{
    private $id;
    private $fecha;
    private $vehiculo;
    private $agencia;
    private $anio;

    private $con;
	
	function __construct($cn){
		$this->con = $cn;
	}

    public function update_matricula(){
        $this->id = $_POST['id'];
        $this->fecha = $_POST['fecha'];
        $this->vehiculo = $_POST['vehiculoCMB'];
        $this->agencia = $_POST['agenciaCMB'];
        $this->anio = $_POST['anio'];

        $sql = "UPDATE matricula SET fecha = '$this->fecha', 
                                     vehiculo = '$this->vehiculo', 
                                     agencia = '$this->agencia', 
                                     anio = '$this->anio' 
                                     WHERE id = '$this->id'";
        if($this->con->query($sql)){
			echo $this->_message_ok("modificó");
		}else{
			echo $this->_message_error("al modificar");
		}
    }

    public function save_matricula(){
        $this->fecha = $_POST['fecha'];
        $this->vehiculo = $_POST['vehiculoCMB'];
        $this->agencia = $_POST['agenciaCMB'];
        $this->anio = $_POST['anio'];

        $sql = "INSERT INTO matricula (fecha, vehiculo, agencia, anio) 
                VALUES ('$this->fecha', '$this->vehiculo', '$this->agencia', '$this->anio')";

        if($this->con->query($sql)){
			echo $this->_message_ok("guardó");
		}else{
			echo $this->_message_error("guardar");
		}	
    }

    private function _get_combo_db($tabla,$valor,$etiqueta,$nombre,$defecto){
		$html = '<select  class="form-select" name="' . $nombre . '">';
		$sql = "SELECT $valor,$etiqueta FROM $tabla;";
		$res = $this->con->query($sql);
		while($row = $res->fetch_assoc()){
			//ImpResultQuery($row);
			$html .= ($defecto == $row[$valor])?'<option value="' . $row[$valor] . '" selected>' . $row[$etiqueta] . '</option>' . "\n" : '<option value="' . $row[$valor] . '">' . $row[$etiqueta] . '</option>' . "\n";
		}
		$html .= '</select>';
		return $html;
	}

    private function _get_combo_anio($nombre,$anio_inicial,$defecto){
		$html = '<select  class="form-select" name="' . $nombre . '">';
		$anio_actual = date('Y');
		for($i=$anio_inicial;$i<=$anio_actual;$i++){
			$html .= ($i == $defecto)? '<option value="' . $i . '" selected>' . $i . '</option>' . "\n":'<option value="' . $i . '">' . $i . '</option>' . "\n";
		}
		$html .= '</select>';
		return $html;
	}

    public function get_form($id=NULL){

        if($id == NULL){
            $this->fecha = NULL;
            $this->vehiculo = NULL;
            $this->agencia = NULL;
            $this->anio = NULL;

            $flag = "enabled";
            $op = "new";

        }else{

			$sql = "SELECT * FROM matricula WHERE id=$id;";
			$res = $this->con->query($sql);
			$row = $res->fetch_assoc();
			
			$num = $res->num_rows;
            if($num==0){
                $mensaje = "tratar de actualizar el vehiculo con id= ".$id;
                echo $this->_message_error($mensaje);
            }else{   
			
              // ***** TUPLA ENCONTRADA *****
				echo "<br>TUPLA <br>";
				echo "<pre>";
					print_r($row);
				echo "</pre>";
			
				$this->fecha = $row['fecha'];
                $this->vehiculo = $row['vehiculo'];
                $this->agencia = $row['agencia'];
                $this->anio = $row['anio'];

				
				$flag = "disabled";
				$op = "update";
			}
		}
		
		
		$html = '
		<form name="vehiculo" method="POST" action="Matriculacion.php" enctype="multipart/form-data">
		
		<input type="hidden" name="id" value="' . $id  . '">
		<input type="hidden" name="op" value="' . $op  . '">
		<div class="container-fluid container-md">
			<div class="table-responsive">
			<table class="table table-bordered bordered-primary table-striped">
				<tr>
					<th class="table-dark text-center" colspan="2">DATOS VEHÍCULO</th>
				</tr>
					 <td>Fecha:</td>
                     <td><input class="form-control" type="date" size="10" name="fecha" value="' . $this->fecha . '" required></td>    
				<tr>
				</tr>
				<tr>
					<td>Vehículo:</td>
                    <td>' . $this->_get_combo_db("vehiculo","id","placa","vehiculoCMB",$this->vehiculo) . '</td>
				</tr>
				<tr>
					<td>Agencia:</td>
                    <td>' . $this->_get_combo_db("agencia","id","descripcion","agenciaCMB",$this->agencia) . '</td>
				</tr>	
				<tr>
					<td>Anio:</td>
                    <td>' . $this->_get_combo_anio("anio",2000,$this->anio) . '</td>

				</tr>
				<tr>
				<th colspan="2"><input class="btn btn-primary d-grid gap-2  mx-auto" type="submit" name="Guardar" value="GUARDAR"></th>
				</tr>
				<tr>
				<th colspan="2"><a class="btn btn-primary d-grid gap-2  mx-auto " href="Matriculacion.php">Regresar</a></th>
				</tr>												
			</table>
			</div>
			</div>
			</form>';
		return $html;

    }


    public function get_list(){
		$d_new = "new/0";
		$d_new_final = base64_encode($d_new);
		$html = '
		<div class = "container-fluid">
			<div class = "table-responsive">
				<table class = "table table-bordered">
					<thead class = "table-dark">
						<tr>
							<th scope = "col" colspan = "8" class = "text-center">Lista de Matricula</th>
						</tr>
						<tr>
							<th scope = "col" colspan = "8" class = "text-center"><a href="Matriculacion.php?d=' . $d_new_final . '">Nuevo</a></th>
						</tr>
					</thead>
					<tbody>
					 <tr class = "text-center table-primary">
					 	<td>Fecha</td>
                        <td>Vehiculo</td>
                        <td>Agencia</td>
                        <td>Anio</td>

	
						<th colspan="3">Acciones</th>
					</tr>
			';
		$sql = "SELECT matricula.*, vehiculo.placa, agencia.descripcion AS agencia_descripcion
        FROM matricula
        JOIN vehiculo ON matricula.vehiculo = vehiculo.id
        JOIN agencia ON matricula.agencia = agencia.id;
        ";	
		$res = $this->con->query($sql);
		// Sin codificar <td><a href="index.php?op=del&id=' . $row['id'] . '">Borrar</a></td>
		while($row = $res->fetch_assoc()){
			$d_del = "del/" . $row['id'];
			$d_del_final = base64_encode($d_del);
			$d_act = "act/" . $row['id'];
			$d_act_final = base64_encode($d_act);
			$d_det = "det/" . $row['id'];
			$d_det_final = base64_encode($d_det);					
			$html .= '
				<tr>
					<td>' . $row['fecha'] . '</td>
					<td>' . $row['placa'] . '</td>
					<td>' . $row['agencia_descripcion'] . '</td>
					<td>' . $row['anio'] . '</td>
					<td class="text-center" ><a href="Matriculacion.php?d=' . $d_del_final . '" class = "bi bi-x-circle btn btn-success btn-sm" disabled style="pointer-events: none; opacity: 0.5;"> Borrar</a></td>
					<td class="text-center"><a href="Matriculacion.php?d=' . $d_act_final . '" class = "bi bi-database btn btn-info btn-sm"> Actualizar</a></td>
					<td class="text-center"><a href="Matriculacion.php?d=' . $d_det_final . '" class = "bi bi-card-list btn btn-warning btn-sm"> Detalle</a></td>
				</tr>';
		}
		$html .= '</tbody>
				</table>
			</div>
		</div>';
		
		return $html;
		
	}

    public function get_detail_matricula($id){
        $sql = "SELECT v.placa, ma.descripcion AS marca, v.motor, v.combustible, v.anio, c.descripcion AS color, v.foto, a.descripcion, a.direccion
                FROM vehiculo v, agencia a, matricula m, marca ma, color c 
                WHERE v.color = c.id AND v.marca = ma.id AND v.id = m.vehiculo AND a.id = m.agencia AND m.id = $id;";
                

        $res = $this->con->query($sql);
        $row = $res->fetch_assoc();

        $num = $res->num_rows;

        if($num==0){
            $mensaje = "tratar de actualizar el vehiculo con id= ".$id;
            echo $this->_message_error($mensaje);
        }else{
            $html = '
				<div class="container-fluid container-md">
			            <div class="table-responsive">
                        <table class="table table-bordered bordered-primary table-striped">
                        <thead class = "table-dark">
							<tr>
								<th colspan="2" class = "text-center">DATOS DE LA MATRICULA</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Placa: </td>
								<td>'. $row['placa'] .'</td>
							</tr>
							<tr>
								<td>Marca: </td>
								<td>'. $row['marca'] .'</td>
							</tr>
							<tr>
								<td>Motor: </td>
								<td>'. $row['motor'] .'</td>
							</tr>
							<tr>
								<td>Combustible: </td>
								<td>'. $row['combustible'] .'</td>
							</tr>
							<tr>
								<td>Anio: </td>
								<td>'. $row['anio'] .'</td>
							</tr>
							<tr>
								<td>Color: </td>
								<td>'. $row['color'] .'</td>
							</tr>		
							<tr>
								<th class = "text-center" colspan="2"><img src="' .PATH .'' . $row['foto'] . '" width="300px"/></th>
							</tr>
                            <tr>
                                <td>Agencia: </td>
                                <td>'. $row['descripcion'] .'</td>
                            </tr>
                            <tr>
                                <td>Dirección: </td>
                                <td>'. $row['direccion'] .'</td>
                            ';	
							
								$html .= '<tr>
								<th scope = "col" colspan = "2"><a class="btn btn-primary"  href="Matriculacion.php">Regresar</a></th>
								</tr>';
							
							
					$html .='	</tbody>																						
						</table>
						</div>
						</div>';
				
				return $html;
		}

    }

    public function delete_matricula($id){
		$sql = "DELETE FROM matricula WHERE id=$id;";
			if($this->con->query($sql)){
			echo $this->_message_ok("ELIMINÓ");
		}else{
			echo $this->_message_error("eliminar");
		}	
	}
	

	
//*************************************************************************	
	
	private function _message_error($tipo){
		$html = '
		<table border="0" align="center">
			<tr>
				<th>Error al ' . $tipo . '. Favor contactar a .................... </th>
			</tr>
			<tr>
				<th><a href="Matriculacion.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}
	
	
	private function _message_ok($tipo){
		$html = '
		<table border="0" align="center">
			<tr>
				<th>El registro se  ' . $tipo . ' correctamente</th>
			</tr>
			<tr>
				<th><a href="Matriculacion.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}
	
//********************


}

?>