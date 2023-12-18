<?php 
session_start();
	class Usuarios extends Controllers{
		public function __construct()
		{
			parent::__construct();
			
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/home');
			}
		}

		public function Usuarios(){
			if($_SESSION['userData']['IdRol'] != 1){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Usuarios";
			$data['page_title'] = "USUARIOS <small>VERIS</small>";
			$data['page_name'] = "usuarios";
			$data['page_functions_js'] = "functions_usuarios.js";
			$this->views->getView($this,"usuarios",$data);
		}

		public function setUsuario(){
			if($_POST){
				if(empty($_POST['txtNombre']) || empty($_POST['listRolid']) || empty($_POST['txtPassword'])){
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{ 
					$idUsuario = intval($_POST['idUsuario']);
					$strNombre = strClean($_POST['txtNombre']);
					$intTipoId = intval(strClean($_POST['listRolid']));
					$strPassword = strClean($_POST['txtPassword']);

					$foto   	 	= $_FILES['foto'];
					$nombre_foto 	= $foto['name'];
					$type 		 	= $foto['type'];
					$url_temp    	= $foto['tmp_name'];
					$imgPortada 	= 'portada_categoria.png';
					$request_cateria = "";
					if($nombre_foto != ''){
						$imgPortada = $nombre_foto;
					}

					if($idUsuario == 0)
					{
						$option = 1;
						$request_user = $this->model->insertUsuario($strNombre,
																	$intTipoId,
																	$strPassword, 
																	$imgPortada);
					}else{
						$option = 2;
						if($nombre_foto == ''){
							if($_POST['foto_actual'] != 'portada_categoria.png' && $_POST['foto_remove'] == 0 ){
								$imgPortada = $_POST['foto_actual'];
							}
						}
						$request_user = $this->model->updateUsuario($idUsuario,
																	$strNombre,
																	$intTipoId,
																	$strPassword, 
																	$imgPortada);

					}

					 if ($request_user != "0"){
						if($option == 1){
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
							if($nombre_foto != ''){ uploadImage($foto,$imgPortada); }
						}else{
							$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
							if($nombre_foto != ''){ uploadImage($foto,$imgPortada); }

							// if(($nombre_foto == '' && $_POST['foto_remove'] == 1 && $_POST['foto_actual'] != 'portada_categoria.png')
							// 	|| ($nombre_foto != '' && $_POST['foto_actual'] != 'portada_categoria.png')){
							// 	deleteFile($_POST['foto_actual']);
							// }
						}
					}else if($request_user == '0'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! El usuario ya existe, ingrese otro.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getUsuarios(){
				$arrData = $this->model->selectUsuarios();
				for ($i=0; $i < count($arrData); $i++) {
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					$btnView = '<button class="btn btn-info btn-sm btnViewUsuario" onClick="fntViewUsuario('.$arrData[$i]['IdUsuario'].')" title="Ver usuario"><i class="far fa-eye"></i></button>';

					$btnEdit = '<button class="btn btn-primary  btn-sm btnEditUsuario" onClick="fntEditUsuario('.$arrData[$i]['IdUsuario'].')" title="Editar usuario"><i class="fas fa-pencil-alt"></i></button>';

					// $btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario('.$arrData[$i]['IdUsuario'].')" title="Eliminar usuario"><i class="far fa-trash-alt"></i></button>';

					if(($_SESSION['idUser'] == 1 AND $_SESSION['userData']['IdRol'] == 1) ||
						($_SESSION['userData']['IdRol'] == 1 AND $arrData[$i]['IdRol'] != 1) AND
						($_SESSION['userData']['IdUsuario'] != $arrData[$i]['IdUsuario'] )
						 ){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario('.$arrData[$i]['IdUsuario'].')" title="Eliminar usuario"><i class="far fa-trash-alt"></i></button>';
					}else{
						$btnDelete = '<button class="btn btn-secondary btn-sm" disabled ><i class="far fa-trash-alt"></i></button>';
					}
	
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function getUsuario($idpersona){
			$idusuario = intval($idpersona);
			if($idusuario > 0){
				$arrData = $this->model->selectUsuario($idusuario);
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

		public function delUsuario()
		{
			if($_POST){
				$intIdpersona = intval($_POST['idUsuario']);
				$requestDelete = $this->model->deleteUsuario($intIdpersona);
				if($requestDelete)
				{
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario');
				}else{
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelectRoles(){
			$htmlOptions = "";
			$arrData = $this->model->selectRoles();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					$htmlOptions .= '<option value="'.$arrData[$i]['IdRol'].'">'.$arrData[$i]['Nombre'].'</option>';
				}
			}
			echo $htmlOptions;
			die();		
		}


	}
 ?>