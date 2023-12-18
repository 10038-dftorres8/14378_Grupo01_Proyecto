<?php 

	class MedicosModel extends Mysql
	{
		private $intIdUsuario;
		private $strNombre;
		private $intEspecialidad;
		private $intUser;

		public function __construct()
		{
			parent::__construct();
		}	

		public function insertMedico(string $nombre, int $especialidad, int $iduser){

			$this->strNombre = $nombre;
			$this->intEspecialidad = $especialidad;
			$this->intUser = $iduser;
			
			// $return = 0;

			$query_insert  = "INSERT INTO medicos(Nombre,Especialidad,IdUsuario) 
							  VALUES(?,?,?)";
        	$arrData = array($this->strNombre,
    						 $this->intEspecialidad,        						
    						 $this->intUser);
        	$request_insert = $this->insert($query_insert,$arrData);
        	$return = $request_insert;

	        return $return;
		}

		public function updateMedico(int $idUsuario, string $nombre, int $especialidad, int $iduser){

			$this->intIdUsuario = $idUsuario;
			$this->strNombre = $nombre;
			$this->intEspecialidad = $especialidad;
			$this->intUser = $iduser;

			$sql = "UPDATE medicos SET Nombre=?, Especialidad=?, IdUsuario=?
					WHERE IdMedico = $this->intIdUsuario AND IdUsuario = $this->intUser";
			$arrData = array($this->strNombre,
    						$this->intEspecialidad,
    						$this->intUser);
	
			$request = $this->update($sql,$arrData);
			return $request;
		
		}

		public function selectEspecialidades()
		{
			$sql = "SELECT * FROM especialidades";
			$request = $this->select_all($sql);
			return $request;
		}


		public function selectUsuarios()
		{
	        // $sql = "SELECT u.*
	        //     FROM usuarios u
	        //     LEFT JOIN medicos p ON u.IdUsuario = p.IdUsuario
	        //     WHERE p.IdMedico IS NULL AND u.Rol = 2";
	        $sql = "SELECT * FROM usuarios WHERE Rol = 2";

		    $request = $this->select_all($sql);
		    return $request;
		}


		public function selectMedicos(){
			$sql = "SELECT m.IdMedico,m.Nombre,e.Descripcion AS Descripcion,u.Nombre AS User,u.Foto 
					FROM medicos m INNER JOIN especialidades e ON e.IdEsp = m.Especialidad 
					INNER JOIN usuarios u ON m.IdUsuario = u.IdUsuario";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectMedico(int $idpersona){
			$this->intIdUsuario = $idpersona;
			$sql = "SELECT m.IdUsuario AS UserMedico,m.IdMedico,m.Nombre,m.Especialidad AS Espe, e.Descripcion AS Descripcion,u.Nombre AS User,u.Foto
					FROM medicos m 
					INNER JOIN especialidades e ON e.IdEsp = m.Especialidad 
					INNER JOIN usuarios u ON m.IdUsuario = u.IdUsuario
					WHERE m.IdMedico = $this->intIdUsuario";
			$request = $this->select($sql);
			return $request;
		}

		public function deleteMedico(int $intIdpersona)
		{
			$this->intIdUsuario = $intIdpersona;
			$sql = "DELETE FROM medicos WHERE IdMedico = $this->intIdUsuario";
			$request = $this->delete($sql);
			return $request;
		}

	}
 ?>