<?php 
session_start();
class Recetas extends Controllers{
	public function __construct()
	{
		parent::__construct();
		
		if(empty($_SESSION['login']))
		{
			header('Location: '.base_url().'/home');
		}
	}

	public function Recetas()
	{
		if($_SESSION['userData']['IdRol'] != 2){
			header("Location:".base_url().'/dashboard');
		}
		$data['page_tag'] = "Recetas";
		$data['page_title'] = "RECETAS <small>VERIS</small>";
		$data['page_name'] = "recetas";
		$data['page_functions_js'] = "functions_recetas.js";
		$this->views->getView($this,"recetas",$data);
	}

	public function setReceta(){
		if($_POST){
			if(empty($_POST['listConsultas']) || empty($_POST['listMedicamentos']) || empty($_POST['intCantidad'])){
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}else{ 
				$idReceta = intval($_POST['idReceta']);
				$intConsulta = strClean($_POST['listConsultas']);
				$intMedicamento = strClean($_POST['listMedicamentos']);
				$intCantidad = strClean($_POST['intCantidad']);

				if($idReceta == 0)
				{
					$option = 1;
					$request_user = $this->model->insertReceta($intConsulta, 
																$intMedicamento,
																$intCantidad);
				}else{
					$option = 2;
					$request_user = $this->model->updateReceta($idReceta,
																$intConsulta, 
																$intMedicamento,
																$intCantidad);
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

	public function getRecetas()
	{
		$arrData = $this->model->selectRecetas();
		for ($i=0; $i < count($arrData); $i++) {
			$btnView = '';
			$btnEdit = '';
			$btnDelete = '';
				$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['IdReceta'].')" title="Ver receta"><i class="far fa-eye"></i></button>';
				$btnEdit = '<button class="btn btn-primary btn-sm" onClick="fntEditInfo('.$arrData[$i]['IdReceta'].')" title="Editar receta"><i class="fas fa-pencil-alt"></i></button>';
				$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['IdReceta'].')" title="Eliminar receta"><i class="far fa-trash-alt"></i></button>';
			$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
		}
		echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
		die();
	}

	public function getReceta(int $idreceta){
		$idReceta = intval($idreceta);
		if($idReceta > 0){
			$arrData = $this->model->selectReceta($idReceta);
			if(empty($arrData)){
				$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
			}else{
				$arrResponse = array('status' => true, 'data' => $arrData);
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function delReceta()
	{
		if($_POST){
			$idReceta = intval($_POST['idReceta']);
			$requestDelete = $this->model->deleteReceta($idReceta);
			if($requestDelete)
			{
				$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la receta');
			}else{
				$arrResponse = array('status' => false, 'msg' => 'Error al eliminar la receta');
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function getSelectConsultas(){
		$htmlOptions = "";
		$arrData = $this->model->selectConsultas();
		if(count($arrData) > 0 ){
			for ($i=0; $i < count($arrData); $i++) { 
				$htmlOptions .= '<option value="'.$arrData[$i]['IdConsulta'].'">'.$arrData[$i]['IdConsulta'].'</option>';
			}
		}
		echo $htmlOptions;
		die();		
	}


	public function getSelectMedicamentos(){
	    $htmlOptions = "";
	    $arrData = $this->model->selectMedicamentos();
	    if(count($arrData) > 0 ){
	        for ($i=0; $i < count($arrData); $i++) { 
	            $htmlOptions .= '<option value="'.$arrData[$i]['IdMedicamento'].'">'.$arrData[$i]['Nombre'].'</option>';
	        }
	    }
	    echo $htmlOptions;
	    die();        
	}


}

?>