<?php
require_once(__DIR__ . '/../constantes.php');
include_once("class.usuario.php");

// Elimina estas líneas de echo
// echo "<br>VARIABLE POST: <br>";
// echo "<pre>";
// print_r($_POST);
// echo "</pre>";

if (!isset($_POST['idusuario']) || !isset($_POST['clave'])) {
    echo "Error en la autentificación";
} else {
    // Elimina estas líneas de echo
    // echo $_POST['idusuario'];
    // echo $_POST['clave'];
}

$usuario = $_POST['idusuario'];
$clave = $_POST['clave'];

$cn = conectar();
$v = new usuario($cn);

$sql = "SELECT * FROM usuarios WHERE idusuario = '$usuario' AND clave = '$clave';";
$res = $cn->query($sql);
$row = $res->fetch_assoc();
$filas = $res->num_rows;

if ($filas > 0) {
    session_start();
    $_SESSION['rol'] = $row['rolid'];
    $_SESSION['usuario'] = $row['usuario'];

    if ($row['rolid'] == 3) {
        $sql2 = "SELECT vehiculo.* FROM vehiculo JOIN usuarios ON vehiculo.usuarioid = usuarios.idusuario WHERE usuarios.idusuario = '$usuario';";
        $res2 = $cn->query($sql2);

        $vehiculo_usuario = array();

        if ($res2->num_rows > 0) {
            while ($row2 = $res2->fetch_assoc()) {
                $vehiculo_usuario[] = $row2;
            }
        }

        $_SESSION['vehiculo_usuario'] = $vehiculo_usuario;

    }
	//echo $_SESSION['rol'];
    header("location:../index.php?op=" . $usuario);
    exit(); // Importante salir después de redirigir
} else {
    // Elimina estas líneas de echo
    // echo "<br>VARIABLE USUARIO: ";
    // echo $usuario;
    // echo "<br>VARIABLE CLAVE: ";
    // echo $clave;
    header("location:ErrorAutentificacion.php");
    exit(); // Importante salir después de redirigir
}

// Liberar el resultado solo si existe
if ($res) {
    mysqli_free_result($res);
}

// Cerrar la conexión
$cn->close();

function conectar()
{
    $c = new mysqli(SERVER, USER, PASS, BD);

    if ($c->connect_errno) {
        die("Error de conexión: " . $c->mysqli_connect_errno() . ", " . $c->connect_error());
    } else {
        //echo "La conexión tuvo éxito .......<br><br>";
    }

    $c->set_charset("utf8");
    return $c;
}
?>
