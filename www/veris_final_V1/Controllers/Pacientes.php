<?php 
session_start();
class Pacientes extends Controllers{
	public function __construct()
	{
		parent::__construct();
		
		if(empty($_SESSION['login']))
		{
			header('Location: '.base_url().'/home');
		}
	}

	public function Pacientes()
	{
		if($_SESSION['userData']['IdRol'] != 1){
			header("Location:".base_url().'/dashboard');
		}
		$data['page_tag'] = "Pacientes";
		$data['page_title'] = "PACIENTES <small>VERIS</small>";
		$data['page_name'] = "pacientes";
		$data['page_functions_js'] = "functions_pacientes.js";
		$this->views->getView($this,"pacientes",$data);
	}

	public function setPaciente(){
		if($_POST){
			if(empty($_POST['txtNombre']) || empty($_POST['intCedula']) || empty($_POST['intEdad']) || empty($_POST['txtGenero']) || empty($_POST['intEstatura']) || empty($_POST['floatPeso']))
			{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{ 
				$idUsuario = intval($_POST['idUsuario']);
				$strNombre = ucwords(strClean($_POST['txtNombre']));
				$intCedula = strClean($_POST['intCedula']);	
				$intEdad = strClean($_POST['intEdad']);
				$strGenero = strClean($_POST['txtGenero']);
				$intEstatura = strClean($_POST['intEstatura']);
				$floatPeso = strClean($_POST['floatPeso']);
				$intUser = strClean($_POST['listUsers']);

				if($idUsuario == 0)
				{
					$option = 1;
					$request_user = $this->model->insertPaciente($strNombre, 
																$intCedula,
																$intEdad,
																$strGenero,
																$intEstatura,
																$floatPeso,
																$intUser);
				}else{
					$option = 2;
					$request_user = $this->model->updatePaciente($idUsuario,
																$strNombre, 
																$intCedula,
																$intEdad,
																$strGenero,
																$intEstatura,
																$floatPeso,
																$intUser);
				}

				if($request_user != '0' )
				{
					if($option == 1){
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
					}else{
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function getPacientes()
	{
		$arrData = $this->model->selectPacientes();
		for ($i=0; $i < count($arrData); $i++) {
			$btnView = '';
			$btnEdit = '';
			$btnDelete = '';
				$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['IdPaciente'].')" title="Ver paciente"><i class="far fa-eye"></i></button>';
				$btnEdit = '<button class="btn btn-primary btn-sm" onClick="fntEditInfo('.$arrData[$i]['IdPaciente'].')" title="Editar paciente"><i class="fas fa-pencil-alt"></i></button>';
				$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['IdPaciente'].')" title="Eliminar paciente"><i class="far fa-trash-alt"></i></button>';
			$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
		}
		echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		die();
	}

	public function getPaciente(int $idpersona){
		$idusuario = intval($idpersona);
		if($idusuario > 0){
			$arrData = $this->model->selectPaciente($idusuario);
			if(empty($arrData)){
				$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
			}else{
				$arrData['url_portada'] = media().'/images/uploads/'.$arrData['Foto'];
				$arrResponse = array('status' => true, 'data' => $arrData);
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function delPaciente()
	{
		if($_POST){
			$intIdpersona = intval($_POST['idUsuario']);
			$requestDelete = $this->model->deletePaciente($intIdpersona);
			if($requestDelete)
			{
				$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el paciente');
			}else{
				$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el paciente');
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function getSelectUsers(){
	    $htmlOptions = "";
	    $arrData = $this->model->selectUsuarios();
	    if(count($arrData) > 0 ){
	        for ($i=0; $i < count($arrData); $i++) { 
	            $htmlOptions .= '<option value="'.$arrData[$i]['IdUsuario'].'">'.$arrData[$i]['Nombre'].'</option>';
	        }
	    }
	    echo $htmlOptions;
	    die();        
	}


}

?>