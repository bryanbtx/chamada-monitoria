<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../..",true,303);
    exit;
}
else{
    if($_SESSION['id']==1){
        header("Location: ..",true,303);
    exit;
    }
}
//deixar o usu selecionar a data???<- nao fassa isso so estou pensando
?>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="../../zerar.css">
		<link rel="stylesheet" type="text/css" href="../../style.css">
		<title>Monitoria - Chamada</title>
	</head>
	<body>
		<div>
			<p>Lista de presenca para monitor</p>
		</div>
		<div>
			<div>
				<form action="processo.php" method="post">
					<?php
					$flag_horario=false;
					include_once dirname(dirname(__DIR__)).'/bd_conn.php';
					$db=new bd_conn();
					$user=$db->selectHorarioById_mo($_SESSION['id']);
					if($user->num_rows>0){
						echo '<select name="id_pr_ho" required>';
						$combo="";
						while($row=$user->fetch_assoc()){
							$combo.='<option value="'.$row['id_ho'].'">';
							switch($row['dia_semana']){
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
									$combo.="Sabado";
									break;
							}
							$combo.=" ".substr($row['hora_inicio'],0,-3).' - '.substr($row['hora_termino'],0,-3)."</option>";
						}
						echo $combo."</select>";
						$flag_horario=true;
					}
					else{
						echo '<p>Voce nao tem horario!</p>';
					}
					$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
					$sql = "SELECT nome,id_al FROM aluno WHERE id_al_mo = ".$_SESSION['id']." ORDER BY nome";
					$result = mysqli_query($connect, $sql);
					if (mysqli_num_rows($result) > 0)
					{
						echo '<table>';
						while($row = mysqli_fetch_array($result)){
							echo '
							<tr>
								<td style="width:85%;text-align:left;font-size:4vm;">' . $row['nome'].' <input type="hidden" value='. $row['id_al'] .' name="nomes[]">('.$row['id_al'].")</input>" . '</td>
								<td style="width:10%;"> <input type="checkbox" onchange="onoff('. $row['id_al'] .')" value="'.$row['id_al'].'" name="check[]"/></td>
							<td> <button type="button" id="bota'. $row['id_al'] .'" onclick="myFunction('.$row['id_al'].');" style="font-size:80%; heigth:100%;" disabled="true">Obs</button> </td>
							</tr>
								<tr id="o'. $row['id_al'] . '" style="display:none;">
								<td id="o'. $row['id_al'] . '" colspan="3"> <input type="text" id="limp'.$row['id_al'].'" style="margin:0px; width:99.5%; heigth:99.5%;" maxlength="255" name="obs[]" placeholder="observação"> </td>
							</tr>
							';
						}
						echo '</table>';
						if($flag_horario){
							echo '</table><button type="submit">Finalizar</button>';
						}
					}
					else{
						echo '<p>Você não possui nenhum aluno!</p>';
					}
					?>
				</form>
			</div>
			<form action="..">
				<button type="submit">Voltar</button>
			</form>
		</div>
	<script>
		function onoff(a){
			var x = document.getElementById("bota"+a);

			if(x.disabled){
				x.disabled = false;
			}else{
				x.disabled = true;
				document.getElementById('limp'+a).value='';
				document.getElementById('o'+a).style.display="none";
			}
		}
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
