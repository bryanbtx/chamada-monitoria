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
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="../../zerar.css">
		<link rel="stylesheet" type="text/css" href="../../style.css">
		<title>Visualização do Horario de Monitoria</title>
	</head>
	<body>
		<div>
			<p>Horários de Monitoria</p>
		</div>
		<div>
			<div>
				<table>
						<?php
							include_once dirname(dirname(__DIR__)).'/constants.php';
							$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
							$sql = "SELECT dia_semana,hora_inicio,hora_termino FROM horario WHERE id_ho_mo = ".$_SESSION['id']." ORDER BY dia_semana";
							$result = mysqli_query($connect, $sql);
							if (mysqli_num_rows($result) > 0)
							{
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
											echo "Sabado";
											break;
									}
									echo "</td><td>".substr($row['hora_inicio'],0,-3).' - '.substr($row['hora_termino'],0,-3).'</td>';
									echo '</tr>';
								}
							}else{
								echo 'Você não possui nenhum horario!';
							}
						?>
					</table>
			</div>
			<form action="../index.php" method="post">
				<button type="submit">Voltar</button>
			</form>
		</div>
	</body>
</html>
