
<!doctype html>
<html>
<head>
	<meta charset="utf-8">

	<!-- <link rel="shortcut icon" href="img/icono.ico"> -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Russo+One&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Baumans&display=swap" rel="stylesheet">
	<title>Home - VERIS</title>
</head>

<style>
	
	body{
		padding: 0;
		margin: 0;
		background-color: #C0F9F3;
	}

	.nombre{
		height: 6rem;
		font-size: 1.7em;
		text-align: center;
		padding-top: 5rem;
	}

	.nombre h1{
		margin: auto 0;
		font-family: 'Russo One', sans-serif;
	}

	.padre{
		width: 100%;
		display: flex;
		justify-content: center;
		flex-wrap: wrap;
	}

	.paciente, .medico, .administrador{
		background-color: #D4C0F9;
		width: 16rem;
		height: 16rem;
		margin: 2rem;
		padding-top: 2rem;
		padding-bottom: 4rem;
		padding-left: 2rem;
		padding-right: 2rem;
		text-align: center;
		font-family: 'Baumans', cursive;
		border-radius: 3rem;
		border: 0.4rem solid #000;
		cursor: pointer;
	}

	h2{
		margin-top: 1rem;
	}

	.padre a{
		color: #000;
		text-decoration: none;
	}

	.paciente img, .medico img, .administrador img{
		width: 100%;
		height: 100%;
		transition: transform 0.5s;
	}

	.paciente img:hover, .medico img:hover, .administrador img:hover{
		transform: scale(1.10);
	}

	@media screen and (max-width: 600px){
		.paciente{
		margin-top: 10rem;
		}
	}
</style>

<body>
	<div class="contenedor">
		<div class="nombre">
			<h1>CLINICA - VERIS</h1>
		</div>
		<div class="padre">
			<div class="paciente" id="myDiv" onclick="redireccionar()">
				<img src="./Assets/images/paciente.png" alt="paciente" id="paciente">
				<h2>PACIENTE</h2>
			</div>
			<div class="medico" id="myDiv2" onclick="redireccionar2()">
				<img src="./Assets/images/medico.png" alt="medico" id="medico">
				<h2>MÉDICO</h2>
			</div>
			<div class="administrador" id="myDiv2" onclick="redireccionar3()">
				<img src="./Assets/images/administrador.png" alt="administrador" id="administrador">
				<h2>ADMINISTRADOR</h2>
			</div>
		</div>
	</div>
</body>


<script>
	function redireccionar() {
  		window.location.href = "<?= base_url(); ?>/login"; 
  	}
  	function redireccionar2() {
  		window.location.href = "<?= base_url(); ?>/login"; 
  	}
  	function redireccionar3() {
  		window.location.href = "<?= base_url(); ?>/login2"; 
  	}
</script>

</html>