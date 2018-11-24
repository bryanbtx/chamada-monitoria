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
	$sql = "select NM_CURSO,ID_PRES_SEC,NM_NOME,DT_PRESENCA,DS_OBS from TABFA4_W_PRESENCA inner join TABFA4_W_ALUNO on ID_ALUN_SEC=FK_PRESENCA_ALUNO left join tabfa4_w_horario on FK_PRESENCA_HORARIO=ID_HORA_SEC where NM_NOME like '%".$_POST["nome_aluno"]."%' and TABFA4_W_ALUNO.ST_DELETADO=0 order by DT_PRESENCA,CS_DIA;";
	$result = mysqli_query($connect, $sql);
	if (mysqli_num_rows($result) > 0){
		echo '
		<table class="table">
		<tr><th>Nome</th><th>Curso</th><th>Data da presença</th><th>Obs</th></tr>
		';
		while($row = mysqli_fetch_array($result)){
			echo '
			<tr>
				<td >'.$row['NM_NOME'].'</td>
				<td > '.$row['NM_CURSO'].'</td>
				<td >'. $row['DT_PRESENCA'] .'</td>
				<td> <button class="btn btn-fatec-red btn-block btn-lg" type="button"  onclick="myFunction('.$row['ID_PRES_SEC'].');" style="font-size:80%; heigth:100%;">Obs</button> </td>
			</tr>
			<tr id="o'. $row['ID_PRES_SEC'] . '" style="display:none;">
				<td id="o'. $row['ID_PRES_SEC'] . '" colspan="3">
			';
			if($row['DS_OBS']==""){
				echo 'Nenhum';
			}else{
				echo $row['DS_OBS'];
			}
			echo '
				</td>
			</tr>
			';
		}
	}
	else
	{
		$sql = "select NM_NOME from TABFA4_W_ALUNO where NM_NOME like '%".$_POST["nome_aluno"]."%' and ST_DELETADO=0;";
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
