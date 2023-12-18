<?php 

	class LoginModel extends Mysql
	{
		private $intIdUsuario;
		private $strUsuario;
		private $strPassword;
		private $strToken;

		public function __construct()
		{
			parent::__construct();
		}	

		public function loginUser(string $usuario, string $password)
		{
			$this->strUsuario = $usuario;
			$this->strPassword = $password;
			$sql = "SELECT IdUsuario FROM usuarios WHERE 
					Nombre = '$this->strUsuario' and 
					Password = '$this->strPassword' ";
			$request = $this->select($sql);
			return $request;
		}

		public function sessionLogin(int $iduser){
			$this->intIdUsuario = $iduser;
			//BUSCAR ROLE 
			$sql = "SELECT p.IdUsuario,
							p.Nombre,
							r.IdRol,
							r.Nombre as NombreRol
					FROM usuarios p
					INNER JOIN roles r
					ON p.Rol = r.IdRol
					WHERE p.IdUsuario = $this->intIdUsuario";
			$request = $this->select($sql);
			$_SESSION['userData'] = $request;
			return $request;
		}

		
	}
 ?>