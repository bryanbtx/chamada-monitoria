<?php
session_start();
if(isset($_SESSION['id'])){
	header("Location: ./menu/index.php",true,303);
    exit;
}
?>
<!DOCTYPE html>
<html>
	<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="custom.css">
	<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Monitoria - Login</title>
	</head>
	<body>
		<div style="margin:1%">
			<div class="jumbotron">
				<h1 class="display-8">Lista de Presença para monitoria</h1>
				<p>Tela de Acesso</p>
			</div>
			<div>
				<form action="./menu/processo.php" method="post">
					<div class="form-group">
						<input type="text" class="form-control form-control-lg" placeholder="RA" name="uname" required>
					</div>
					<div class="form-group">
						<input type="password" class="form-control form-control-lg" placeholder="Senha" name="pwd" required>
					</div>
					<button type="submit" class="btn btn-fatec-red btn-block btn-lg rounded-top">Login</button>
				</form>
				<a class="btn btn-fatec-red btn-lg btn-block rounded-botton" href="./esqueceu/index.php" role="button">Esqueceu a senha?</a>
			</div>
		</div>
	</body>
</html>
