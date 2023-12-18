<?php 

	class RecetasModel extends Mysql
	{
		private $intIdReceta;
		private $intIdConsulta;
		private $intIdMedicamento;
		private $intCantidad;
		private $intIdMedico;

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

		public function selectConsultas(int $idmedico){
			$this->intIdMedico = $idmedico;
			$sql = "SELECT c.IdConsulta, c.IdMedico, c.IdPaciente, c.FechaConsulta, c.HI, c.HF, c.Diagnostico, m.IdMedico, m.Nombre as NombreMedico, p.Nombre as NombrePaciente
					FROM consultas c 
					INNER JOIN medicos m ON c.IdMedico = m.IdMedico
					INNER JOIN pacientes p ON c.IdPaciente = p.IdPaciente
					WHERE c.IdMedico = $this->intIdMedico";
			$request = $this->select_all($sql);
			return $request;
		}


		public function selectMedicamentos()
		{
	        $sql = "SELECT * FROM medicamentos";
		    $request = $this->select_all($sql);
		    return $request;
		}

		public function selectRecetas(int $idmedico){
			$this->intIdMedico = $idmedico;
			$sql = "SELECT r.IdReceta, r.IdConsulta, r.IdMedicamento, r.Cantidad, c.IdConsulta AS N_Consulta, c.IdMedico, m.Nombre AS NombreMedicamento, med.Nombre AS NombreMed, med.IdMedico
					FROM recetas r 
					INNER JOIN consultas c ON r.IdConsulta = c.IdConsulta
					INNER JOIN medicamentos m ON r.IdMedicamento = m.IdMedicamento
					INNER JOIN medicos med ON c.IdMedico = med.IdMedico
					WHERE c.IdMedico = $this->intIdMedico";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectReceta(int $idreceta){
			$this->intIdReceta = $idreceta;
			$sql = "SELECT r.IdReceta, r.IdConsulta, r.IdMedicamento, r.Cantidad, c.IdConsulta AS N_Consulta, m.IdMedicamento AS idmedi, m.Nombre AS Nombre_M, med.Nombre AS NombreMed, pac.Nombre AS NombrePac, c.FechaConsulta AS FechaConsulta
					FROM recetas r INNER JOIN consultas c ON r.IdConsulta = c.IdConsulta
					INNER JOIN medicamentos m ON r.IdMedicamento = m.IdMedicamento
					INNER JOIN medicos med ON med.IdMedico = c.IdMedico
					INNER JOIN pacientes pac ON pac.IdPaciente = c.IdPaciente
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