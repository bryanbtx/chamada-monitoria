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
		<title>Monitoria - Habilitar/Desabilitar Alunos</title>
	</head>
	<body>
		<div style="margin:1%">
			<div class="jumbotron">
				<h1 class="display-8">Habilitar ou Desabilitar Alunos</h1>
			</div>
			<div>
				<form action="processo.php" method="post">
					<?php
					$flag_horario=false;
					include_once dirname(dirname(__DIR__)).'/constants.php';
					$connect = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
					$sql = "SELECT ID_ALUN_SEC,NM_NOME,ST_DELETADO FROM TABFA4_W_ALUNO WHERE FK_ALUNO_MONITOR = ".$_SESSION['id']." ORDER BY NM_NOME";
					$result = mysqli_query($connect, $sql);
					if (mysqli_num_rows($result) > 0)
					{
                        echo '<button class="btn btn-fatec-red btn-lg btn-block rounded-top" onclick="habilitar()" type="button">Habilitar tudo</button>';
                        echo '<button class="btn btn-fatec-red btn-lg btn-block rounded-botton" onclick="desabilitar()" type="button">Desabilitar tudo</button>';
						echo '<table class="table"><tr><th>Nome</th><th>Desabilitado</th></tr>';
						while($row = mysqli_fetch_array($result)){
							echo '
							<tr>
								<td style="width:85%;">'.$row['NM_NOME'].'<input type="hidden" value='.$row['ID_ALUN_SEC'].' name="nomes[]">('.$row['ID_ALUN_SEC'].")</input>".'</td>
                                <td style="width:10%;"><div style="text-align: center" class="form-check"><input type="checkbox" class="form-check-input" value="'.$row['ID_ALUN_SEC'].'" name="check[]"';
                            if($row['ST_DELETADO']){
                                echo 'checked';
                            }
                            echo '
                                /></div></td>
							</tr>
							';
						}
                        echo '
                        </table>
                        <button class="btn btn-fatec-red btn-lg btn-block rounded-top" type="submit">Registrar mudanças</button>
                        ';
                    }
					else{
						echo '<p>Você Não possui nenhum Aluno!</p>';
					}
					echo '<a class="btn btn-fatec-red btn-lg btn-block rounded-botton" href="../index.php" role="button">Voltar para o Menu</a>';
					?>
				</form>
			</div>
		</div>
        <script>
		function habilitar(){
            var boxes = document.getElementsByTagName("input");
            for (var x = 0; x < boxes.length; x++) {
                var obj = boxes[x];
                if (obj.type == "checkbox") {
                    if (obj.name != "check"){
                        obj.checked = false;
                    }
                }
            }
		}
		function desabilitar(){
            var boxes = document.getElementsByTagName("input");
            for (var x = 0; x < boxes.length; x++) {
                var obj = boxes[x];
                if (obj.type == "checkbox") {
                    if (obj.name != "check"){
                        obj.checked = true;
                    }
                }
            }
		}
	    </script>
	</body>
</html>
