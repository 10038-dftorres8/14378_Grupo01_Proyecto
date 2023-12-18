<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form | Dan Aleko</title>
  <link rel="stylesheet" href="css/styles.css">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
  <?php
    require_once(__DIR__.'/constantes.php');
		include_once("class/class.usuario.php");
    
		$cn = conectar();
		$v = new usuario($cn);
    
    $html='

          <div class="wrapper">
          <form action="class/class.validar.php" method="POST">
            <h1>Login</h1>
            <div class="input-box text-center">
              <td>'.$v->_get_combo_db("usuarios","idusuario","usuario","idusuario").'</td>
            </div>
            <div class="input-box">
              <input type="password" placeholder="Password" name="clave" required>
              <i class="bx bxs-lock-alt" ></i>
            </div>
            <div class="remember-forgot">
              <label><input type="checkbox">Remember Me</label>
              <a href="#">Forgot Password</a>
            </div>
            <button type="submit" class="btn" value="LOGIN" >Login</button>
            <div class="register-link">
              <p>Quieres salir? <a href="../index.html">Regresar</a></p>
            </div>
            
          </form>
        </div>
    ';


    echo $html;


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
	//**********************************************************	

    
  ?>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>