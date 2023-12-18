<?php 

	class UsuariosModel extends Mysql
	{
		private $intIdUsuario;
		private $strNombre;
		private $strPassword;
		private $intTipoId;
		public $strPortada;

		public function __construct()
		{
			parent::__construct();
		}	

		public function insertUsuario(string $nombre, int $tipoid, string $password, string $portada){

			$this->strNombre = $nombre;
			$this->intTipoId = $tipoid;
			$this->strPassword = $password;
			$this->strPortada = $portada;
			
			$return = 0;

			$sql = "SELECT * FROM usuarios WHERE 
					Nombre = '{$this->strNombre}' ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO usuarios(Nombre,Rol,Password,Foto) 
								  VALUES(?,?,?,?)";
	        	$arrData = array($this->strNombre,
        						$this->intTipoId,
        						$this->strPassword,
        						$this->strPortada);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "0";
			}
	        return $return;
		}

		public function selectRoles()
		{
			$sql = "SELECT * FROM roles";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectUsuarios()
		{
			$sql = "SELECT p.IdUsuario,p.Nombre,p.Foto,r.IdRol,r.Nombre as NombreRol
					FROM usuarios p 
					INNER JOIN roles r
					ON p.Rol = r.IdRol";
					$request = $this->select_all($sql);
					return $request;
		}
		public function selectUsuario(int $idpersona){
			$this->intIdUsuario = $idpersona;
			$sql = "SELECT p.IdUsuario,p.Nombre,p.Password,p.Foto,r.IdRol,r.Nombre as NombreRol
					FROM usuarios p
					INNER JOIN roles r
					ON p.Rol = r.IdRol
					WHERE p.IdUsuario = $this->intIdUsuario";
			$request = $this->select($sql);
			return $request;
		}

		public function updateUsuario(int $idUsuario, string $nombre, int $tipoid, string $password, string $portada){

			$this->intIdUsuario = $idUsuario;
			$this->strNombre = $nombre;
			$this->intTipoId = $tipoid;
			$this->strPassword = $password;
			$this->strPortada = $portada;

			$sql = "SELECT * FROM usuarios WHERE (Nombre = '{$this->strNombre}' AND IdUsuario != $this->intIdUsuario)";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE usuarios SET Nombre=?, Rol=?, Password=?, Foto=?
							WHERE IdUsuario = $this->intIdUsuario ";
				$arrData = array($this->strNombre,
	        					$this->intTipoId,
	        					$this->strPassword,
	        					$this->strPortada);

				$request = $this->update($sql,$arrData);
			}else{
				$request = "0";
			}
			return $request;
		
		}
		
		public function deleteUsuario(int $intIdpersona)
		{
			$this->intIdUsuario = $intIdpersona;
			$sql = "DELETE FROM usuarios WHERE IdUsuario = $this->intIdUsuario";
			$request = $this->delete($sql);
			return $request;
		}


	}
 ?>