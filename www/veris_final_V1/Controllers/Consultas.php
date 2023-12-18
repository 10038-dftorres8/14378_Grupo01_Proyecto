<?php 
session_start();
class Consultas extends Controllers{
	public function __construct()
	{
		parent::__construct();
		
		if(empty($_SESSION['login']))
		{
			header('Location: '.base_url().'/home');
		}
	}

	public function Consultas()
	{
		if($_SESSION['userData']['IdRol'] != 2){
			header("Location:".base_url().'/dashboard');
		}
		$data['page_tag'] = "Consultas";
		$data['page_title'] = "CONSULTAS <small>VERIS</small>";
		$data['page_name'] = "consultas";
		$data['page_functions_js'] = "functions_consultas.js";
		$this->views->getView($this,"consultas",$data);
	}

	public function setConsulta(){
		if($_POST){
			if(empty($_POST['listPacientes']) || empty($_POST['listMedicos']) || empty($_POST['dateFecha']) || empty($_POST['txtDiagnostico']) || empty($_POST['timeInicio']) || empty($_POST['timeFin']))
			{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{ 
				$idConsulta = intval($_POST['idConsulta']);
				$intPaciente = strClean($_POST['listPacientes']);
				$intMedico = strClean($_POST['listMedicos']);
				$strFecha = strClean($_POST['dateFecha']);
				$strDiagnostico = strClean($_POST['txtDiagnostico']);
				$strInicio = strClean($_POST['timeInicio']);
				$strFin = strClean($_POST['timeFin']);

				if($idConsulta == 0)
				{
					$option = 1;
					$request_user = $this->model->insertConsulta($intPaciente, 
																$intMedico,
																$strFecha,
																$strDiagnostico,
																$strInicio,
																$strFin);
				}else{
					$option = 2;
					$request_user = $this->model->updateConsulta($idConsulta,
																$intPaciente, 
																$intMedico,
																$strFecha,
																$strDiagnostico,
																$strInicio,
																$strFin);
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

	public function getConsultas()
	{
		$arrData = $this->model->selectConsultas();
		for ($i=0; $i < count($arrData); $i++) {
			$btnView = '';
			$btnEdit = '';
			$btnDelete = '';
				$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['IdConsulta'].')" title="Ver consulta"><i class="far fa-eye"></i></button>';
				$btnEdit = '<button class="btn btn-primary btn-sm" onClick="fntEditInfo('.$arrData[$i]['IdConsulta'].')" title="Editar consulta"><i class="fas fa-pencil-alt"></i></button>';
				$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['IdConsulta'].')" title="Eliminar consulta" disabled><i class="far fa-trash-alt"></i></button>';
			$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
		}
		echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		die();
	}

	public function getConsulta(int $idconsulta){
		$idConsulta = intval($idconsulta);
		if($idConsulta > 0){
			$arrData = $this->model->selectConsulta($idConsulta);
			if(empty($arrData)){
				$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
			}else{
				$arrResponse = array('status' => true, 'data' => $arrData);
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function delConsulta()
	{
		if($_POST){
			$idConsulta = intval($_POST['idConsulta']);
			$requestDelete = $this->model->deleteConsulta($idConsulta);
			if($requestDelete)
			{
				$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la consulta');
			}else{
				$arrResponse = array('status' => false, 'msg' => 'Error al eliminar la consulta');
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function getSelectPacientes(){
		$htmlOptions = "";
		$arrData = $this->model->selectPacientes();
		if(count($arrData) > 0 ){
			for ($i=0; $i < count($arrData); $i++) { 
				$htmlOptions .= '<option value="'.$arrData[$i]['IdPaciente'].'">'.$arrData[$i]['Nombre'].'</option>';
			}
		}
		echo $htmlOptions;
		die();		
	}


	public function getSelectMedicos(){
	    $htmlOptions = "";
	    $arrData = $this->model->selectMedicos();
	    if(count($arrData) > 0 ){
	        for ($i=0; $i < count($arrData); $i++) { 
	            $htmlOptions .= '<option value="'.$arrData[$i]['IdMedico'].'">'.$arrData[$i]['Nombre'].'</option>';
	        }
	    }
	    echo $htmlOptions;
	    die();        
	}


}

?>