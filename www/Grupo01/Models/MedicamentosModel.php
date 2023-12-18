<?php 

	class MedicamentosModel extends Mysql
	{
		private $idMedicamento;
		private $strNombre;
		private $strTipo;

		public function __construct()
		{
			parent::__construct();
		}	

		public function insertMedicamento(string $nombre, string $tipo){

			$this->strNombre = $nombre;
			$this->strTipo = $tipo;
			
			$return = 0;

			$sql = "SELECT * FROM medicamentos WHERE 
					Nombre = '{$this->strNombre}' ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO medicamentos(Nombre,Tipo) 
								  VALUES(?,?)";
	        	$arrData = array($this->strNombre,
        						$this->strTipo);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "0";
			}
	        return $return;
		}


		public function selectMedicamentos(){
			$sql = "SELECT IdMedicamento,Nombre,Tipo 
					FROM medicamentos";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectMedicamento(int $idmedicamento){
			$this->idMedicamento = $idmedicamento;
			$sql = "SELECT IdMedicamento,Nombre,Tipo 
					FROM medicamentos
					WHERE IdMedicamento = $this->idMedicamento";
			$request = $this->select($sql);
			return $request;
		}

		public function updateMedicamento(int $idMedicamento, string $nombre, string $tipo){

			$this->idMedicamento = $idMedicamento;
			$this->strNombre = $nombre;
			$this->strTipo = $tipo;

			$sql = "SELECT * FROM medicamentos WHERE (Nombre = '{$this->strNombre}' AND idmedicamento != $this->idMedicamento)";
			$request = $this->select_all($sql);

			if(empty($request)){
				$sql = "UPDATE medicamentos SET Nombre=?, Tipo=? 
						WHERE IdMedicamento = $this->idMedicamento";
				$arrData = array($this->strNombre,
        						$this->strTipo);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "0";
			}
			return $request;
		
		}

		public function deleteMedicamento(int $idMedicamento)
		{
			$this->idMedicamento = $idMedicamento;
			$sql = "DELETE FROM medicamentos WHERE IdMedicamento = $this->idMedicamento";
			$request = $this->delete($sql);
			return $request;
		}

	}
 ?>