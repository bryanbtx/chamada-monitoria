<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../index.php",true,303);
    exit;
}
include_once dirname(dirname(__DIR__)).'/bd_conn.php';
?>
<html>
	<head>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="../../custom.css">
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Monitoria - Visualização dos Horários da Monitoria</title>
	</head>
			<?php
			if($_SESSION['id']==1){
				echo '
                <body onload="load()">
                <div style="margin:1%">
				<div class="jumbotron">
					<h1 class="display-8">Horários da Monitoria</h1>
				</div>
                <select id="monitores" class="form-control form-control-lg" onchange="change()" required>
				';
				$db=new bd_conn();
				$user=$db->selectUsuarioAll();
				$combo="";
				while($row=$user->fetch_assoc()){
					if($row['id_mo']!=1){
						$combo.='<option value="'.$row['id_mo'].'">'.$row['ra'].'</option>';
					}
				}
				$db->disconnectFromDB();
				echo $combo;
				echo '
					</select>
					<table id="info" class="table">
					</table>
					<script>
					var info;
					function load(){
						var table=document.getElementById("info");
						info=(
				';
				include_once dirname(dirname(__DIR__)).'/bd_conn.php';
				$db=new bd_conn();
				$user=$db->selectHorariosAll();
				$info=array();
				$info['id_ho']=array();
				$info['id_ho_mo']=array();
				$info['dia_semana']=array();
				$info['hora']=array();
				while($row=$user->fetch_assoc()){
					array_push($info['id_ho'],$row['id_ho']);
					array_push($info['id_ho_mo'],$row['id_ho_mo']);
					switch($row['dia_semana']){
						case 1:
							array_push($info['dia_semana'],"Segunda");
							break;
						case 2:
							array_push($info['dia_semana'],"Terça");
							break;
						case 3:
							array_push($info['dia_semana'],"Quarta");
							break;
						case 4:
							array_push($info['dia_semana'],"Quinta");
							break;
						case 5:
							array_push($info['dia_semana'],"Sexta");
							break;
						case 6:
							array_push($info['dia_semana'],"Sábado");
							break;
					}
					array_push($info['hora'],substr($row['hora_inicio'],0,-3).' - '.substr($row['hora_termino'],0,-3));
				}
				echo json_encode($info);
				echo '
						);
						change();
					}
					function change(){
						var table=document.getElementById("info");
						var id_mo=document.getElementById("monitores").value;
						var inner="<tr><th>Dia da semana</th><th>Horário</th></tr>";
						for(var i=0;i<info[\'id_ho\'].length;i++){
							if(info[\'id_ho_mo\'][i]==id_mo){
								inner+="<tr><td>"+info["dia_semana"][i]+"</td><td>"+info["hora"][i]+"</td></tr>";
							}
						}
						table.innerHTML=inner;
					}
					</script>
					';
			}
			else{
				echo '
				<body>
				<div style="margin:1%">
				<div class="jumbotron">
					<h1 class="display-8">Horários da Monitoria</h1>
				</div>
				';
				include_once dirname(dirname(__DIR__)).'/constants.php';
				$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
				$sql = "SELECT dia_semana,hora_inicio,hora_termino FROM horario WHERE id_ho_mo = ".$_SESSION['id']." ORDER BY dia_semana";
				$result = mysqli_query($connect, $sql);
				if (mysqli_num_rows($result) > 0)
				{
					echo '<table class="table"><tr><th>Dia da semana</th><th>Horário</th></tr>';
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
					echo '</table>';
				}else{
					echo '<p>Você não possui nenhum horário!</p>';
				}
			}
			?>
			<a class="btn btn-fatec-red btn-lg btn-block" href="../index.php" role="button">Voltar para o Menu</a>
		</div>
	</body>
</html>
