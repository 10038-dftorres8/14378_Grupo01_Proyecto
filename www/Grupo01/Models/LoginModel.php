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
                    p.Nombre AS NombreUser,
                    r.IdRol,
                    r.Nombre as NombreRol,
                    m.IdMedico,
                    pa.IdPaciente, pa.Nombre as NombrePac, pa.Cedula, pa.Edad, pa.Genero, pa.Estatura, pa.Peso
            FROM usuarios p
            INNER JOIN roles r ON p.Rol = r.IdRol
            LEFT JOIN pacientes pa ON p.IdUsuario = pa.IdUsuario
            LEFT JOIN medicos m ON p.IdUsuario = m.IdUsuario

            WHERE p.IdUsuario = $this->intIdUsuario";
            
			$request = $this->select($sql);
			if ($request && !empty($request)) {
		        $_SESSION['userData'] = $request;

		        // Verificar si es un médico
		        if (!empty($request['IdMedico'])) {
		            $_SESSION['IdMedico'] = $request['IdMedico'];
		        }

		        // Verificar si es un paciente
		        if (!empty($request['IdPaciente'])) {
		            $_SESSION['IdPaciente'] = $request['IdPaciente'];
		        }
		    }
			return $request;
		}

		
	}
 ?>