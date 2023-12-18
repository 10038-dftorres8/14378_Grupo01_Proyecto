<?php 

	class MisconsultasModel extends Mysql
	{
		private $intIdConsulta;
		private $intIdPaciente;
		private $intIdMedico;
		private $dateFechaConsulta;
		private $strDiagnostico;
		private $timeFechaInicio;
		private $timeFechaFin;

		public function __construct()
		{
			parent::__construct();
		}	

		public function insertConsulta(int $paciente, int $medico, string $fechaConsulta, string $diagnostico, string $fechaInicio, string $fechaFin){

			$this->intIdPaciente = $paciente;
			$this->intIdMedico = $medico;
			$this->dateFechaConsulta = $fechaConsulta;
			$this->strDiagnostico = $diagnostico;
			$this->timeFechaInicio = $fechaInicio;
			$this->timeFechaFin = $fechaFin;
			
			// $return = 0;

			$query_insert  = "INSERT INTO consultas(IdPaciente,IdMedico,FechaConsulta,Diagnostico,HI,HF) 
							  VALUES(?,?,?,?,?,?)";
        	$arrData = array($this->intIdPaciente,
    						 $this->intIdMedico,        						
    						 $this->dateFechaConsulta,
    						 $this->strDiagnostico,
    						 $this->timeFechaInicio,
    						 $this->timeFechaFin);
        	$request_insert = $this->insert($query_insert,$arrData);
        	$return = $request_insert;

	        return $return;
		}

		public function updateConsulta(int $idConsulta, int $paciente, int $medico, string $fechaConsulta, string $diagnostico, string $fechaInicio, string $fechaFin){

			$this->intIdConsulta = $idConsulta;
			$this->intIdPaciente = $paciente;
			$this->intIdMedico = $medico;
			$this->dateFechaConsulta = $fechaConsulta;
			$this->strDiagnostico = $diagnostico;
			$this->timeFechaInicio = $fechaInicio;
			$this->timeFechaFin = $fechaFin;

			$sql = "UPDATE consultas SET IdPaciente=?, IdMedico=?, FechaConsulta=?, Diagnostico=?, HI=?, HF=?
					WHERE IdConsulta = $this->intIdConsulta";
			$arrData = array($this->intIdPaciente,
    						 $this->intIdMedico,        						
    						 $this->dateFechaConsulta,
    						 $this->strDiagnostico,
    						 $this->timeFechaInicio,
    						 $this->timeFechaFin);
	
			$request = $this->update($sql,$arrData);
			return $request;
		
		}

		public function selectPacientes()
		{
			$sql = "SELECT * FROM pacientes";
			$request = $this->select_all($sql);
			return $request;
		}


		public function selectMedicos()
		{
	        $sql = "SELECT * FROM medicos";
		    $request = $this->select_all($sql);
		    return $request;
		}


		public function selectConsultas(int $idmedico){
			$this->intIdMedico = $idmedico;
			$sql = "SELECT c.IdConsulta, c.IdMedico, c.IdPaciente, c.FechaConsulta, c.HI, c.HF, c.Diagnostico, p.Nombre AS NombrePaciente, m.Nombre AS NombreMedico
					FROM consultas c INNER JOIN pacientes p ON c.IdPaciente = p.IdPaciente
					INNER JOIN medicos m ON c.IdMedico = m.IdMedico
					WHERE c.IdPaciente = $this->intIdMedico";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectConsulta(int $idconsulta){
			$this->intIdConsulta = $idconsulta;
			$sql = "SELECT  c.IdConsulta, c.IdMedico, m.IdMedico AS idmed, p.IdPaciente AS idpac, c.IdPaciente, c.FechaConsulta, c.HI, c.HF, c.Diagnostico, p.Nombre AS NombreP, m.Nombre AS NombreM
					FROM consultas c INNER JOIN pacientes p ON c.IdPaciente = p.IdPaciente
					INNER JOIN medicos m ON c.IdMedico = m.IdMedico
					WHERE c.IdConsulta = $this->intIdConsulta";
			$request = $this->select($sql);
			return $request;
		}

		public function deleteConsulta(int $idConsulta)
		{
			$this->intIdConsulta = $idConsulta;
			$sql = "DELETE FROM consultas WHERE IdConsulta = $this->intIdConsulta";
			$request = $this->delete($sql);
			return $request;
		}

	}
 ?>