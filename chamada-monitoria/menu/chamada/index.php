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
		<title>Monitoria - Chamada</title>
	</head>
	<body>
		<div style="margin:1%">
			<div class="jumbotron">
				<h1 class="display-8">Lista de Presença para o Monitor</h1>
			</div>
			<div>
				<form action="processo.php" method="post">
					<?php
					$flag_horario=false;
					include_once dirname(dirname(__DIR__)).'/bd_conn.php';
					$db=new bd_conn();
					$user=$db->selectHorarioById_mo($_SESSION['id']);
					if($user->num_rows>0){
						echo '<select name="id_pr_ho" class="form-control form-control-lg" required>';
						$combo="";
						while($row=$user->fetch_assoc()){
							$combo.='<option value="'.$row['ID_HORA_SEC'].'">';
							switch($row['CS_DIA']){
								case 1:
									$combo.="Segunda";
								break;
								case 2:
									$combo.="Terça";
									break;
								case 3:
									$combo.="Quarta";
									break;
								case 4:
									$combo.="Quinta";
									break;
								case 5:
									$combo.="Sexta";
									break;
								case 6:
									$combo.="Sábado";
									break;
							}
							$combo.=" ".substr($row['HR_INICIO'],0,-3).' - '.substr($row['HR_TERMINO'],0,-3)."</option>";
						}
						echo $combo."</select>";
						$flag_horario=true;
					}
					else{
						echo '<p>Você não possui Horário!</p>';
					}
					$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
					$sql = "SELECT NM_NOME,ID_ALUN_SEC FROM TABFA4_W_ALUNO WHERE FK_ALUNO_MONITOR = ".$_SESSION['id']." and ST_DELETADO=0 ORDER BY NM_NOME";
					$result = mysqli_query($connect, $sql);
					if (mysqli_num_rows($result) > 0)
					{
						echo '<table class="table"><tr><th>Nome</th><th>Presença</th></tr>';
						while($row = mysqli_fetch_array($result)){
							echo '
							<tr>
								<td style="width:85%;text-align:left;font-size:4vm;">' . $row['NM_NOME'].' <input type="hidden" value='. $row['ID_ALUN_SEC'] .' name="nomes[]">('.$row['ID_ALUN_SEC'].")</input>" . '</td>
								<td style="width:10%;"> <div style="text-align: center" class="form-check"><input type="checkbox" class="form-check-input" onchange="onoff('. $row['ID_ALUN_SEC'] .')" value="'.$row['ID_ALUN_SEC'].'" name="check[]"/></div></td>
							
							</tr>
								<tr id="o'. $row['ID_ALUN_SEC'] . '" style="display:none;">
								<td id="o'. $row['ID_ALUN_SEC'] . '" colspan="3"> <input type="text" class="form-control form-control-lg" id="limp'.$row['ID_ALUN_SEC'].'" style="margin:0px; width:99.5%; heigth:99.5%;" maxlength="255" name="obs[]" placeholder="Descrição da dúvida"> </td>
							</tr>
							';
						}
						echo '</table>';
						if($flag_horario){
							echo '
							</table>
							<button class="btn btn-fatec-red btn-lg btn-block rounded-top" type="submit">Finalizar a Chamada</button>
							<a class="btn btn-fatec-red btn-lg btn-block rounded-botton" href="../index.php" role="button">Voltar para o Menu</a>
							';
						}
					}
					else{
						echo '
						<p>Você Não possui nenhum Aluno!</p>
						<a class="btn btn-fatec-red btn-lg btn-block" href="../index.php" role="button">Voltar para o Menu</a>
						';
					}
					if(!$flag_horario){
						echo '<a class="btn btn-fatec-red btn-lg btn-block" href="../index.php" role="button">Voltar para o Menu</a>';
					}
					?>
				</form>
			</div>
		</div>
	<script>
		function onoff(a){
			var x = document.getElementById('o'+a);
			if (x.style.display === "none") {
				x.style.display = "";
				document.getElementById('limp'+a).required = true;
			} else {
				x.style.display = "none";
				document.getElementById('limp'+a).required = false;
			}
		}
	</script>

	</body>
</html>
