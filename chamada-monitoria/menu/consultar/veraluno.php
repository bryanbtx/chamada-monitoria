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
//remover o ano para diminuir o espaco
?>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../../zerar.css">
<link rel="stylesheet" type="text/css" href="../../style.css">
<?php
if($_SERVER['REQUEST_METHOD']=='POST'){
	echo '<table>';
	include_once dirname(dirname(__DIR__)).'/constants.php';
	$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$sql = "select presenca.id_pr,aluno.nome,presenca.data_pre,presenca.obs from presenca inner join aluno on aluno.id_al=presenca.id_pr_al where aluno.nome like '%".$_POST["nome_aluno"]."%' order by presenca.data_pre;";
	$result = mysqli_query($connect, $sql);
	if (mysqli_num_rows($result) > 0){
		while($row = mysqli_fetch_array($result)){
			echo '
			<tr>
				<td >'.$row['nome'].'</td>
				<td >'. $row['data_pre'] .'</td>
				<td> <button type="button"  onclick="myFunction('.$row['id_pr'].');" style="font-size:80%; heigth:100%;">Obs</button> </td>
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
<form action="./index.php" method="post">
	<button type="submit">Voltar</button>
</form>
<form action="../index.php" method="post">
	<button type="submit">Ir para o menu</button>
</form>
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
