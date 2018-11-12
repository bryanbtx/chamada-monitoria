<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../..",true,303);
    exit;
}
else{
    if($_SESSION['id']!=1){
        header("Location: ..",true,303);
    exit;
    }
}
//melhorar isso?
?>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="../../zerar.css">
		<link rel="stylesheet" type="text/css" href="../../style.css">
		<title>Consultar aluno</title>
	</head>
	<body>
		<div>
			<p>Buscar aluno</p>
			<form action="veraluno.php" method="post">
				<input type="text" name="nome_aluno" placeholder="Digite o nome do aluno..." required/>
				<button type="submit">Procurar</button>
			</form>
			<form action="..">
				<button type="submit">Voltar</button>
			</form>

		</div>
	</body>
</html>
