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
<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
	echo '
	<div class="jumbotron">
		<h1 class="display-8">Pesquisa para "'.$_POST["nome_aluno"].'":</h1>
	</div>
	';
	include_once dirname(dirname(__DIR__)).'/constants.php';
	$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$sql = "select presenca.id_pr,aluno.nome,presenca.data_pre,presenca.obs from presenca inner join aluno on aluno.id_al=presenca.id_pr_al where aluno.nome like '%".$_POST["nome_aluno"]."%' order by presenca.data_pre;";
	$result = mysqli_query($connect, $sql);
	if (mysqli_num_rows($result) > 0){
		echo '
		<table class="table">
		<tr><th>Nome</th><th>Data da presença</th><th>Obs</th></tr>
		';
		while($row = mysqli_fetch_array($result)){
			echo '
			<tr>
				<td >'.$row['nome'].'</td>
				<td >'. $row['data_pre'] .'</td>
				<td> <button class="btn btn-fatec-red btn-block btn-lg" type="button"  onclick="myFunction('.$row['id_pr'].');" style="font-size:80%; heigth:100%;">Obs</button> </td>
			</tr>
			<tr id="o'. $row['id_pr'] . '" style="display:none;">
				<td id="o'. $row['id_pr'] . '" colspan="3">
			';
			if($row['obs']==""){
				echo 'Nenhum';
			}else{
				echo $row['obs'];
			}
			echo '
				</td>
			</tr>
			';
		}
	}
	else
	{
		$sql = "select nome from aluno where nome like '%".$_POST["nome_aluno"]."%';";
		$result = mysqli_query($connect, $sql);
		if (mysqli_num_rows($result) > 0){
			echo '<p>Nenhum Registro da chamada do aluno!</p>';
		}else{
			echo '<p>Aluno invalido!</p>';
		}
	}
	echo '</table>';
}
?>
		<a class="btn btn-fatec-red btn-lg btn-block rounded-top" href="./index.php" role="button">Voltar para a Pesquisa</a>
		<a class="btn btn-fatec-red btn-lg btn-block rounded-botton" href="../index.php" role="button">Voltar para o Menu</a>
	</div>
		<script>
			function myFunction(a) {
				var x = document.getElementById('o'+a);
				if (x.style.display === "none") {
					x.style.display = "";
				} else {
					x.style.display = "none";
				}
			}
		</script>
	</body>
</html>
