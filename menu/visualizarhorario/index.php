<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../index.php",true,303);
    exit;
}
else{
    if($_SESSION['id']==1){
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
		<title>Monitoria - Visualização dos Horários da Monitoria</title>
	</head>
	<body>
		<div style="margin:1%">
			<div class="jumbotron">
				<h1 class="display-8">Horários da Monitoria</h1>
			</div>
			<div>
				<div>
					<table class="table">
							<?php
								include_once dirname(dirname(__DIR__)).'/constants.php';
								$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
								$sql = "SELECT dia_semana,hora_inicio,hora_termino FROM horario WHERE id_ho_mo = ".$_SESSION['id']." ORDER BY dia_semana";
								$result = mysqli_query($connect, $sql);
								if (mysqli_num_rows($result) > 0)
								{
									echo '<tr><th>Dia da semana</th><th>Horário</th></tr>';
									while($row = mysqli_fetch_array($result)){
										echo '<tr>';
										echo '<td style="text-align:left;font-size:4vm;">';
										switch($row['dia_semana']){
											case 1:
												echo "Segunda";
											break;
											case 2:
												echo "Terça";
												break;
											case 3:
												echo "Quarta";
												break;
											case 4:
												echo "Quinta";
												break;
											case 5:
												echo "Sexta";
												break;
											case 6:
												echo "Sábado";
												break;
										}
										echo "</td><td>".substr($row['hora_inicio'],0,-3).' - '.substr($row['hora_termino'],0,-3).'</td>';
										echo '</tr>';
									}
								}else{
									echo '<p>Você não possui nenhum horário!</p>';
								}
							?>
						</table>
				</div>
				<a class="btn btn-fatec-red btn-lg btn-block" href="../index.php" role="button">Voltar para o Menu</a>
			</div>
		</div>
	</body>
</html>
