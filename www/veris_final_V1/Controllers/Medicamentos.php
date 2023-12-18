<?php 
session_start();
class Medicamentos extends Controllers{
	public function __construct()
	{
		parent::__construct();
		
		if(empty($_SESSION['login']))
		{
			header('Location: '.base_url().'/home');
		}
	}

	public function Medicamentos()
	{
		if($_SESSION['userData']['IdRol'] != 1){
			header("Location:".base_url().'/dashboard');
		}
		$data['page_tag'] = "Medicamentos";
		$data['page_title'] = "MEDICAMENTOS <small>VERIS</small>";
		$data['page_name'] = "medicamentos";
		$data['page_functions_js'] = "functions_medicamentos.js";
		$this->views->getView($this,"medicamentos",$data);
	}

	public function setMedicamento(){
		if($_POST){
			if(empty($_POST['txtNombre']) || empty($_POST['txtTipo']))
			{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{ 
				$idMedicamento = intval($_POST['idMedicamento']);
				$strNombre = ucwords(strClean($_POST['txtNombre']));
				$strTipo = ucwords(strClean($_POST['txtTipo']));

				if($idMedicamento == 0)
				{
					$option = 1;
					$request_user = $this->model->insertMedicamento($strNombre, $strTipo);
				}else{
					$option = 2;
					$request_user = $this->model->updateMedicamento($idMedicamento, $strNombre, $strTipo);
				}

				if($request_user != '0' )
				{
					if($option == 1){
						$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
					}else{
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}
				}else if($request_user == '0'){
					$arrResponse = array('status' => false, 'msg' => '¡Atención! el medicamento ya existe, ingrese otro.');		
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function getMedicamentos()
	{
		$arrData = $this->model->selectMedicamentos();
		for ($i=0; $i < count($arrData); $i++) {
			$btnView = '';
			$btnEdit = '';
			$btnDelete = '';
				$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['IdMedicamento'].')" title="Ver medicamento"><i class="far fa-eye"></i></button>';
				$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo('.$arrData[$i]['IdMedicamento'].')" title="Editar medicamento"><i class="fas fa-pencil-alt"></i></button>';	
				$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['IdMedicamento'].')" title="Eliminar medicamento"><i class="far fa-trash-alt"></i></button>';
			$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
		}
		echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		die();
	}

	public function getMedicamento(int $idmedicamento){
		$idMedicamento = intval($idmedicamento);
		if($idMedicamento > 0)
		{
			$arrData = $this->model->selectMedicamento($idMedicamento);
			if(empty($arrData))
			{
				$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
			}else{
				$arrResponse = array('status' => true, 'data' => $arrData);
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function delMedicamento()
	{
		if($_POST){
			$idMedicamento = intval($_POST['idMedicamento']);
			$requestDelete = $this->model->deleteMedicamento($idMedicamento);
			if($requestDelete)
			{
				$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el medicamento');
			}else{
				$arrResponse = array('status' => false, 'msg' => 'Error al eliminar al medicamento');
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}



}

?>