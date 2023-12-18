<?php 
session_start();
	class Login2 extends Controllers{
		public function __construct()
		{
			
			if(isset($_SESSION['login']))
			{
				header('Location: '.base_url().'/dashboard');
			}
			parent::__construct();
		}

		public function login2()
		{
			$data['page_tag'] = "Login - VERIS";
			$data['page_title'] = "VERIS";
			$data['page_name'] = "login2";
			$data['page_functions_js'] = "functions_login.js";
			$this->views->getView($this,"login2",$data);
		}

		public function loginUser(){
			//dep($_POST);
			if($_POST){
				if(empty($_POST['txtUser']) || empty($_POST['txtPassword'])){
					$arrResponse = array('status' => false, 'msg' => 'Error de datos' );
				}else{
					$strUsuario  =  strtolower(strClean($_POST['txtUser']));
					$strPassword = strClean($_POST['txtPassword']);
					$requestUser = $this->model->loginUser($strUsuario, $strPassword);
					if(empty($requestUser)){
						$arrResponse = array('status' => false, 'msg' => 'El usuario o la contraseña es incorrecto.' ); 
					}else{
						$arrData = $requestUser;

						$_SESSION['idUser'] = $arrData['IdUsuario'];
						$_SESSION['login'] = true;

						$arrData = $this->model->sessionLogin($_SESSION['idUser']);
						sessionUser($_SESSION['idUser']);							
						$arrResponse = array('status' => true, 'msg' => 'ok');

					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

	}
 ?>