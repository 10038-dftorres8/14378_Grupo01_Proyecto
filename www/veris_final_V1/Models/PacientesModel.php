<?php 

	class PacientesModel extends Mysql
	{
		private $intIdUsuario;
		private $strNombre;
		private $intCedula;
		private $intEdad;
		private $strGenero;
		private $intEstatura;
		private $floatPeso;
		private $intUser;

		public function __construct()
		{
			parent::__construct();
		}	

		public function insertPaciente(string $nombre, int $cedula, int $edad, string $genero, int $estatura, float $peso, int $iduser){

			$this->strNombre = $nombre;
			$this->intCedula = $cedula;
			$this->intEdad = $edad;
			$this->strGenero = $genero;
			$this->intEstatura = $estatura;
			$this->floatPeso = $peso;
			$this->intUser = $iduser;
			
			// $return = 0;

			$query_insert  = "INSERT INTO pacientes(Nombre,Cedula,Edad,Genero,Estatura,Peso,IdUsuario) 
							  VALUES(?,?,?,?,?,?,?)";
        	$arrData = array($this->strNombre,
    						 $this->intCedula,        						
    						 $this->intEdad,
    						 $this->strGenero,
    						 $this->intEstatura,
    						 $this->floatPeso,
    						 $this->intUser);
        	$request_insert = $this->insert($query_insert,$arrData);
        	$return = $request_insert;

	        return $return;
		}

		public function updatePaciente(int $idUsuario, string $nombre, int $cedula, int $edad, string $genero, int $estatura, float $peso, int $iduser){

			$this->intIdUsuario = $idUsuario;
			$this->strNombre = $nombre;
			$this->intCedula = $cedula;
			$this->intEdad = $edad;
			$this->strGenero = $genero;
			$this->intEstatura = $estatura;
			$this->floatPeso = $peso;
			$this->intUser = $iduser;

			$sql = "UPDATE pacientes SET Nombre=?, Cedula=?, Edad=?, Genero=?, Estatura=?, Peso=?, IdUsuario=?
					WHERE IdPaciente = $this->intIdUsuario AND IdUsuario = $this->intUser";
			$arrData = array($this->strNombre,
    						 $this->intCedula,        						
    						 $this->intEdad,
    						 $this->strGenero,
    						 $this->intEstatura,
    						 $this->floatPeso,
    						 $this->intUser);
	
			$request = $this->update($sql,$arrData);
			return $request;
		
		}

		public function selectUsuarios()
		{
	        $sql = "SELECT u.*
	            FROM usuarios u
	            LEFT JOIN pacientes p ON u.IdUsuario = p.IdUsuario
	            WHERE p.IdPaciente IS NULL AND u.Rol = 3";
	        // $sql = "SELECT * FROM usuarios WHERE Rol = 2";

		    $request = $this->select_all($sql);
		    return $request;
		}


		public function selectPacientes(){
			$sql = "SELECT p.IdPaciente,p.nombre AS Nombre,u.Nombre AS User,p.Cedula,p.Edad,p.Genero,p.Estatura,p.Peso,u.Foto
					FROM pacientes p INNER JOIN usuarios u ON p.IdUsuario = u.IdUsuario";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectPaciente(int $idpersona){
			$this->intIdUsuario = $idpersona;
			$sql = "SELECT p.IdUsuario AS UserPaciente,p.IdUsuario,p.Nombre,p.Cedula,p.Edad,p.Genero,p.Estatura,p.Peso,u.Nombre AS User,u.Foto
					FROM pacientes p 
					INNER JOIN usuarios u ON p.IdUsuario = u.IdUsuario
					WHERE p.IdPaciente = $this->intIdUsuario";
			$request = $this->select($sql);
			return $request;
		}

		public function deletePaciente(int $intIdpersona)
		{
			$this->intIdUsuario = $intIdpersona;
			$sql = "DELETE FROM pacientes WHERE IdPaciente = $this->intIdUsuario";
			$request = $this->delete($sql);
			return $request;
		}

	}
 ?>