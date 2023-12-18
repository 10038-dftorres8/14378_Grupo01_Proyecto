<?php 

	class RecetasModel extends Mysql
	{
		private $intIdReceta;
		private $intIdConsulta;
		private $intIdMedicamento;
		private $intCantidad;

		public function __construct()
		{
			parent::__construct();
		}	

		public function insertReceta(int $consulta, int $medicamento, int $cantidad){

			$this->intIdConsulta = $consulta;
			$this->intIdMedicamento = $medicamento;
			$this->intCantidad = $cantidad;

			$query_insert  = "INSERT INTO recetas(IdConsulta,IdMedicamento,Cantidad) 
							  VALUES(?,?,?)";
        	$arrData = array($this->intIdConsulta,
    						 $this->intIdMedicamento,        						
    						 $this->intCantidad);
        	$request_insert = $this->insert($query_insert,$arrData);
        	$return = $request_insert;

	        return $return;
		}

		public function updateReceta(int $idReceta, int $consulta, int $medicamento, int $cantidad){

			$this->intIdReceta = $idReceta;
			$this->intIdConsulta = $consulta;
			$this->intIdMedicamento = $medicamento;
			$this->intCantidad = $cantidad;

			$sql = "UPDATE recetas SET IdConsulta=?, IdMedicamento=?, Cantidad=?
					WHERE IdReceta = $this->intIdReceta";
			$arrData = array($this->intIdConsulta,
    						 $this->intIdMedicamento,        						
    						 $this->intCantidad);
	
			$request = $this->update($sql,$arrData);
			return $request;
		
		}

		public function selectConsultas()
		{
			$sql = "SELECT * FROM consultas";
			$request = $this->select_all($sql);
			return $request;
		}


		public function selectMedicamentos()
		{
	        $sql = "SELECT * FROM medicamentos";
		    $request = $this->select_all($sql);
		    return $request;
		}

		public function selectRecetas(){
			$sql = "SELECT r.IdReceta, r.IdConsulta, r.IdMedicamento, r.Cantidad, c.IdConsulta AS N_Consulta, m.Nombre AS NombreMedicamento
					FROM recetas r INNER JOIN consultas c ON r.IdConsulta = c.IdConsulta
					INNER JOIN medicamentos m ON r.IdMedicamento = m.IdMedicamento";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectReceta(int $idreceta){
			$this->intIdReceta = $idreceta;
			$sql = "SELECT r.IdReceta, r.IdConsulta, r.IdMedicamento, r.Cantidad, c.IdConsulta AS N_Consulta, m.IdMedicamento AS idmedi, m.Nombre AS Nombre_M
					FROM recetas r INNER JOIN consultas c ON r.IdConsulta = c.IdConsulta
					INNER JOIN medicamentos m ON r.IdMedicamento = m.IdMedicamento
					WHERE r.IdReceta = $this->intIdReceta";
			$request = $this->select($sql);
			return $request;
		}

		public function deleteReceta(int $idReceta)
		{
			$this->intIdReceta = $idReceta;
			$sql = "DELETE FROM recetas WHERE IdReceta = $this->intIdReceta";
			$request = $this->delete($sql);
			return $request;
		}

	}
 ?>