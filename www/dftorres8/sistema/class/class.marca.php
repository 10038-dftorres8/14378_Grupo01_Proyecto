<?php   

class marca{

    private $id;
    private $descripcion;
    private $pais;
    private $direccion;
    private $foto;
    private $con;

    function __construct($cn){
		$this->con = $cn;
	}

    public function update_marca(){
        $this->id = $_POST['id'];
        $this->descripcion = $_POST['descripcion'];
        $this->pais = $_POST['pais'];
        $this->direccion = $_POST['direccion'];
        $this->foto = $_FILES['foto']['name'];

        $sql = "UPDATE marca SET descripcion = '$this->descripcion', 
                                 pais = '$this->pais',
                                 direccion = '$this->direccion',
                                 foto = '$this->foto' 
                WHERE id = '$this->id';";

        if($this->con->query($sql)){
            echo $this->_message_ok("modificó");
        }else{
            echo $this->_message_error("al modificar");
        }

    }
    
    public function save_marca(){
        $this->id = $_POST['id'];
        $this->descripcion = $_POST['descripcion'];
        $this->pais = $_POST['pais'];
        $this->direccion = $_POST['direccion'];

        $this->foto = $this->_get_name_file($_FILES['foto']['name'],12);

        $path = "../../imagenes/sellos/" . $this->foto;

        if(!move_uploaded_file($_FILES['foto']['tmp_name'],$path)){
			$mensaje = "Cargar la imagen";
			echo $this->_message_error($mensaje);
			exit;
		}

        $sql = "INSERT INTO marca VALUES(NULL,
                                         '$this->descripcion',
                                         '$this->pais',
                                         '$this->direccion',
                                         '$this->foto');";

        if($this->con->query($sql)){
            echo $this->_message_ok("guardó");
        }else{
            echo $this->_message_error("guardar");
        }

    }

    private function _get_name_file($nombre_original, $tamanio){
		$tmp = explode(".",$nombre_original); //Divido el nombre por el punto y guardo en un arreglo
		$numElm = count($tmp); //cuento el número de elemetos del arreglo
		$ext = $tmp[$numElm-1]; //Extraer la última posición del arreglo.
		$cadena = "";
			for($i=1;$i<=$tamanio;$i++){
				$c = rand(65,122);
				if(($c >= 91) && ($c <=96)){
					$c = NULL;
					 $i--;
				 }else{
					$cadena .= chr($c);
				}
			}
		return $cadena . "." . $ext;
	}

    public function get_list_marca(){
		$d_new = "new/0";
		$d_new_final = base64_encode($d_new);
		$html = '
		<div class = "container-fluid">
			<div class = "table-responsive">
				<table class = "table table-bordered">
					<thead class = "table-dark">
						<tr>
							<th scope = "col" colspan = "8" class = "text-center">Lista de Marcas</th>
						</tr>
						<tr>
							<th scope = "col" colspan = "8" class = "text-center"><a href="Marcas.php?d=' . $d_new_final . '">Nuevo</a></th>
						</tr>
					</thead>
					<tbody>
					 <tr class = "text-center table-primary">
					 	<td>Marca</td>
						<td>Pais</td>
						<td>direccion</td>
						<th colspan="3">Acciones</th>
					</tr>
			';
		//$sql = "SELECT v.id, v.placa, m.descripcion as marca, c.descripcion as color, v.anio, v.avaluo  FROM vehiculo v, color c, marca m WHERE v.marca=m.id AND v.color=c.id;";	
        $sql = "SELECT m.id, m.descripcion, m.pais, m.direccion FROM marca m ;";
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
					<td>' . $row['descripcion'] . '</td>
					<td>' . $row['pais'] . '</td>
					<td>' . $row['direccion'] . '</td>
					<td class="text-center" ><a href="Marcas.php?d=' . $d_del_final . '" class = "bi bi-x-circle btn btn-success btn-sm"> Borrar</a></td>
					<td class="text-center"><a href="Marcas.php?d=' . $d_act_final . '" class = "bi bi-database btn btn-info btn-sm"> Actualizar</a></td>
					<td class="text-center"><a href="Marcas.php?d=' . $d_det_final . '" class = "bi bi-card-list btn btn-warning btn-sm"> Detalle</a></td>
				</tr>';
		}
		$html .= '</tbody>
				</table>
			</div>
		</div>';
		
		return $html;
		
	}

    public function get_form_marca($id=NULL){
		
		if($id == NULL){
			$this->descripcion = NULL;
			$this->pais = NULL;
			$this->direccion = NULL;
			$this->foto = NULL;
			
			$flag = "enabled";
			$op = "new";
			
		}else{

			$sql = "SELECT * FROM marca WHERE id=$id;";
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
			
				$this->descripcion = $row['descripcion'];
                $this->pais = $row['pais'];
                $this->direccion = $row['direccion'];
                $this->foto = $row['foto'];
				
				$flag = "enabled";
				$op = "update";
			}
		}
		
		
		$paises = ["USA",
						 "Italia",
						 "China",
                         "Japón",
                         "Alemania",
                         "Francia",
                         "Corea del Sur",
                         "Suecia"
						 ];
		$html = '
		<form name="marca" method="POST" action="index2.php" enctype="multipart/form-data">
		
		<input type="hidden" name="id" value="' . $id  . '">
		<input type="hidden" name="op" value="' . $op  . '">
		<div class="container-fluid container-md">
			<div class="table-responsive">
			<table class="table table-bordered bordered-primary table-striped">
						<tr>
							<th colspan="2" class="table-dark text-center">DATOS Marca</th>
						</tr>
						<tr>
							<td>Marca:</td>
							<td><input  class="form-control" type="text" size="6" name="descripcion" value="' . $this->descripcion . '" required></td>
						</tr>
						<tr>
							<td>Pais:</td>
							<td>' . $this->_get_combo_pais($paises,"pais",$this->id) . '</td>
						</tr>
						<tr>
							<td>Direccion:</td>
							<td><input  class="form-control" type="text" size="15" name="direccion" value="' . $this->direccion . '" required></td>
						</tr>	
						<tr>
							<td>Foto:</td>
							<td><input class="form-control" type="file" name="foto"></td>
						</tr>
						<tr>
							<th colspan="2"><input class="btn btn-primary d-grid gap-2  mx-auto" type="submit" name="Guardar" value="GUARDAR"></th>
						</tr>	
						<tr>
							<th colspan="2"><a class="btn btn-primary d-grid gap-2  mx-auto " href="Vehiculos.php">Regresar</a></th>
						</tr>											
					</table>
					</div>
					</div>
					</form>';
		return $html;
	}
   

    private function _get_combo_pais($arreglo,$nombre,$defecto){
        $html = '<select class="form-select" name="' . $nombre . '">';
        foreach($arreglo as $etiqueta){
            $html .= ($defecto == $etiqueta)?'<option value="' . $etiqueta . '" selected>' . $etiqueta . '</option>' . "\n" : '<option value="' . $etiqueta . '">' . $etiqueta . '</option>' . "\n";
        }
        $html .= '</select>';
        return $html;
    }


    public function get_detail_marca($id){
		/*$sql = "SELECT v.placa, m.descripcion as marca, v.motor, v.chasis, v.combustible, v.anio, c.descripcion as color, v.foto, v.avaluo  
				FROM vehiculo v, color c, marca m 
				WHERE v.id=$id AND v.marca=m.id AND v.color=c.id;";*/
        $sql = "SELECT m.descripcion, m.pais, m.direccion, m.foto FROM marca m WHERE m.id=$id;";
		$res = $this->con->query($sql);
		$row = $res->fetch_assoc();
		
		$num = $res->num_rows;

		$enlace= PATH2;

        //Si es que no existiese ningun registro debe desplegar un mensaje 
        //$mensaje = "tratar de eliminar el vehiculo con id= ".$id;
        //echo $this->_message_error($mensaje);
        //y no debe desplegarse la tablas
        
        if($num==0){
            $mensaje = "tratar de editar la marca con id= ".$id;
            echo $this->_message_error($mensaje);
        }else{ 
				$html = '
				<div class="container-fluid container-md">
			            <div class="table-responsive">
                        <table class="table table-bordered bordered-primary table-striped">
                        <thead class = "table-dark">
							<tr>
								<th colspan="2" class = "text-center">DATOS DEL LA MARCA</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Marca: </td>
								<td>'. $row['descripcion'] .'</td>
							</tr>
							<tr>
								<td>Pais: </td>
								<td>'. $row['pais'] .'</td>
							</tr>
							<tr>
								<td>Direccion: </td>
								<td>'. $row['direccion'] .'</td>
							</tr>		
							<tr>
								<th class = "text-center" colspan="2"><img src="' .PATH2 .'' . $row['foto'] . '" width="300px"/></th>
							</tr>	
							<tr>
							<th scope = "col" colspan = "2"><a class="btn btn-primary"  href="Marcas.php">Regresar</a></th>
							</tr>
						</tbody>																						
						</table>
						</div>
						</div>';
				
				return $html;
		}
	}

    public function delete_marca($id){
		$sql = "DELETE FROM marca WHERE id=$id;";
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
				<th><a href="Marcas.php">Regresar</a></th>
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
				<th><a href="Marcas.php">Regresar</a></th>
			</tr>
		</table>';
		return $html;
	}

}

?>