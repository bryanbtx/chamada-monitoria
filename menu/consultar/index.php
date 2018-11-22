<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../index.php",true,303);
    exit;
}
else{
    if($_SESSION['id']!=1){
        header("Location: ../index.php",true,303);
    exit;
    }
}
?>
<html>
	<head>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="../../custom.css">
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Monitoria - Consultar Aluno</title>
	</head>
	<body>
		<div style="margin:1%">
			<div class="jumbotron">
				<h1 class="display-8">Pesquisar as Presença do Aluno</h1>
			</div>
			<form action="veraluno.php" method="post">
				<div class="form-group">
					<input class="form-control form-control-lg" type="text" name="nome_aluno" placeholder="Digite o nome do Aluno..." required/>
				</div>
				<button class="btn btn-fatec-red btn-block btn-lg rounded-top" type="submit">Procurar o Aluno</button>
			</form>
			<a class="btn btn-fatec-red btn-lg btn-block rounded-botton" href="../index.php" role="button">Voltar para o Menu</a>
		</div>
	</body>
</html>
