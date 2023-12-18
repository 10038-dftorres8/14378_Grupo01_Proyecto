<?php

class usuario{
    private $idusuario;
    private $usuario;
    private $clave;
    private $rolid;
    private $con;

    function __construct($cn){
		$this->con = $cn;
	}


    public function getidusuario(){
        return $this->idusuario;
    }

    public function setidusuario($idusuario){
        $this->idusuario = $idusuario;
    }

    public function getusuario(){
        return $this->usuario;
    }

    public function setusuario($usuario){
        $this->usuario = $usuario;
    }

    public function getclave(){
        return $this->clave;
    }

    public function setclave($clave){
        $this->clave = $clave;
    }

    public function _get_combo_db($tabla,$valor,$etiqueta,$nombre){
		$html = '<select class="form-select" name="' . $nombre . '">';
		$sql = "SELECT $valor,$etiqueta  FROM $tabla;";
		$res = $this->con->query($sql);
		while($row = $res->fetch_assoc()){
			//ImpResultQuery($row);
			$html .= '<option value="' . $row[$valor] . '" selected>' . $row[$etiqueta] . '</option>' . "\n" ;
		}
		$html .= '</select>';
		return $html;
	}




}

?>