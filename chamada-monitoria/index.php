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
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="zerar.css">
		<link rel="stylesheet" type="text/css" href="style.css">
		<title>Monitoria</title>
	</head>
	<body>
		<div>
			<p>Lista de presença para monitor</p>
		</div>
		<div>
			<form action="./menu/processo.php" method="post">
				<div>
					<input type="text" placeholder="RA" name="uname" required>
					<input type="password" placeholder="Senha" name="pwd" required>
					<button type="submit">Login</button>
				</div>
			</form>
			<div>
				<form action="./esqueceu/index.php" method="post">
					<button type="submit">Esqueceu a senha?</button>
				</form>
			</div>
		</div>
	</body>
</html>
