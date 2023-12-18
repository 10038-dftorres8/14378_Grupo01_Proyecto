<?php   
require_once("../constantes.php");
require_once("class.vehiculo.php");

$cn = conectar();
$v = new vehiculo($cn);

if(isset($_GET['q'])){
    $id_usuario = $_GET['q'];
    //echo $id_paciente;
} else {
    echo "No se ha seleccionado un paciente";
    exit;
}

$sql = "SELECT * FROM usuarios WHERE idusuario = $id_usuario";
$res = $cn->query($sql);



if (!$res) {
    echo "Error en la consulta: " . $cn->error;
    exit;
}

$row = $res->fetch_assoc();


echo $html= '<td><input class="form-control" type="text" size="6" name="placa" value="' . $row['usuario']. '" readonly ></td>';



//*******************************************************
function conectar(){
    //echo "<br> CONEXION A LA BASE DE DATOS<br>";
    $c = new mysqli(SERVER,USER,PASS,BD);
    
    if($c->connect_errno) {
        die("Error de conexión: " . $c->mysqli_connect_errno() . ", " . $c->connect_error());
    }else{
        //echo "La conexión tuvo éxito .......<br><br>";
    }
    
    $c->set_charset("utf8");
    return $c;
}
//***
?>
