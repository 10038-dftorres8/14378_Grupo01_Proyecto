<?php 
session_start();

class Medicos extends Controllers{
	public function __construct()
	{
		parent::__construct();
		
		if(empty($_SESSION['login']))
		{
			header('Location: '.base_url().'/home');
		}
	}

	public function Medicos()
	{
		if($_SESSION['userData']['IdRol'] != 1){
			header("Location:".base_url().'/dashboard');
		}
		$data['page_tag'] = "Medicos";
		$data['page_title'] = "MÉDICOS <small>VERIS</small>";
		$data['page_name'] = "medicos";
		$data['page_functions_js'] = "functions_medicos.js";
		$this->views->getView($this,"medicos",$data);
	}

	public function setMedico(){
		if($_POST){
			if(empty($_POST['txtNombre']) || empty($_POST['listEspecialidad']) )
			{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{ 
				$idUsuario = intval($_POST['idUsuario']);
				$intUser = strClean($_POST['listUsers']);
				$strNombre = ucwords(strClean($_POST['txtNombre']));
				$intEspecialidad = strClean($_POST['listEspecialidad']);

				if($idUsuario == 0)
				{
					$option = 1;
					$request_user = $this->model->insertMedico($strNombre, 
																$intEspecialidad,
																$intUser);
				}else{
					$option = 2;
					$request_user = $this->model->updateMedico($idUsuario,
																$strNombre,
																$intEspecialidad,
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

	public function getMedicos()
	{
		$arrData = $this->model->selectMedicos();
		for ($i=0; $i < count($arrData); $i++) {
			$btnView = '';
			$btnEdit = '';
			$btnDelete = '';
				$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['IdMedico'].')" title="Ver médico"><i class="far fa-eye"></i></button>';
				$btnEdit = '<button class="btn btn-primary btn-sm" onClick="fntEditInfo('.$arrData[$i]['IdMedico'].')" title="Editar médico"><i class="fas fa-pencil-alt"></i></button>';
				$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['IdMedico'].')" title="Eliminar médico"><i class="far fa-trash-alt"></i></button>';
			$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
		}
		echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		die();
	}

	public function getMedico(int $idpersona){
		$idusuario = intval($idpersona);
		if($idusuario > 0){
			$arrData = $this->model->selectMedico($idusuario);
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

	public function delMedico()
	{
		if($_POST){
			$intIdpersona = intval($_POST['idUsuario']);
			$requestDelete = $this->model->deleteMedico($intIdpersona);
			if($requestDelete)
			{
				$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el médico');
			}else{
				$arrResponse = array('status' => false, 'msg' => 'Error al eliminar al médico');
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function getSelectEspecialidades(){
		$htmlOptions = "";
		$arrData = $this->model->selectEspecialidades();
		if(count($arrData) > 0 ){
			for ($i=0; $i < count($arrData); $i++) { 
				$htmlOptions .= '<option value="'.$arrData[$i]['IdEsp'].'">'.$arrData[$i]['Descripcion'].'</option>';
			}
		}
		echo $htmlOptions;
		die();		
	}


	public function getSelectUsers(){
	    $htmlOptions = "";
	    $arrData = $this->model->selectUsuarios();
	    if(count($arrData) > 0 ){
	        for ($i=0; $i < count($arrData); $i++) { 
	            $htmlOptions .= '<option value="'.$arrData[$i]['IdUsuario'].'">'.$arrData[$i]['Nombre']."-----".$arrData[$i]['NombreMed'].'</option>';
	        }
	    }
	    echo $htmlOptions;
	    die();        
	}



}

?>