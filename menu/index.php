<?php
session_start();
if(!isset($_SESSION['id'])){
	header("Location: ../index.php",true,303);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../custom.css">
	<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Monitoria - Tela de Menu</title>
</head>
<body>
	<?php
	if($_SESSION['troca_senha']){
		echo '
		<div style="margin:1%">
			<div class="jumbotron">
				<h1 class="display-8">'.$_SESSION['nome'].'! Insira uma Nova Senha para Acessar o Sistema. </h1>
				<p id="alerta" style="text-align:left; color:#AE0F15;"></p>
			</div>
			<div>
				<form action="./alterarsenha/index.php" method="post" onsubmit="return validate()">
					<div class="form-group">
						<input id="senha" type="password" class="form-control form-control-lg" placeholder="Nova senha" name="senha" required>
					</div>
					<div class="form-group">
						<input id="r_senha" type="password" class="form-control form-control-lg" placeholder="Repetir nova senha" name="r_senha" required>
					</div>
					<button type="submit" class="btn btn-fatec-red btn-block btn-lg">Mudar senha</button>
				</form>
			</div>
		</div>
		';
	}
	else{
		echo '
		<div style="margin:1%">
			<div class="jumbotron">
				<h1>Menu</h1>
				<p> Bem vindo '.$_SESSION['nome'].'!</p>
		';
		if($_SESSION['id']==1){
			if($_SESSION['email']==""){
				echo '<p id="alerta" style="text-align:left; color:#AE0F15;">Email Vazio! Vai em (Modificar Informações do Admin/Monitor) e digite o seu Email valido!</p>';
			}
			echo '
			</div>
				<a class="btn btn-fatec-red btn-lg btn-block rounded-top" href="./criar/index.php" role="button">Criar um Novo Monitor</a>
				<a class="btn btn-fatec-red btn-lg btn-block rounded-0" href="./visualizarinfo/index.php" role="button">Visualizar Informações do Monitor</a>
				<a class="btn btn-fatec-red btn-lg btn-block rounded-0" href="./modificarinfo/index.php" role="button">Modificar Informações do Admin/Monitor</a>
				<a class="btn btn-fatec-red btn-lg btn-block rounded-0" href="./adicionarhorario/index.php" role="button">Adicionar Horários para um Monitor</a>
				<a class="btn btn-fatec-red btn-lg btn-block rounded-0" href="./consultar/index.php" role="button">Consultar as Chamadas de um Aluno</a>
				<a class="btn btn-fatec-red btn-lg btn-block rounded-botton" href="./sair.php" role="button">Sair</a>
			</div>
			';
		}
		else{
			echo '
			</div>
				<a class="btn btn-fatec-red btn-lg btn-block rounded-top" href="./adicionar/index.php" role="button">Cadastrar Novos Alunos</a>
				<a class="btn btn-fatec-red btn-lg btn-block rounded-0" href="./chamada/index.php" role="button">Realizar Chamada</a>
				<a class="btn btn-fatec-red btn-lg btn-block rounded-0" href="./visualizarhorario/index.php" role="button">Visualizar os Horários da Monitoria</a>
				<a class="btn btn-fatec-red btn-lg btn-block rounded-0" href="./visualizarchamada/index.php" role="button">Visualizar as Presenças</a>
				<a class="btn btn-fatec-red btn-lg btn-block rounded-0" href="./quantidadepresenca/index.php" role="button">Quantidade de Presença Total dos Alunos</a>
				<a class="btn btn-fatec-red btn-lg btn-block rounded-0" href="./visualizarobs/index.php" role="button">Visualizar Observações</a>
				<a class="btn btn-fatec-red btn-lg btn-block rounded-0" href="./visualizarinfo/index.php" role="button">Visualizar Informações</a>
				<a class="btn btn-fatec-red btn-lg btn-block rounded-0" href="./modificarinfo/index.php" role="button">Modificar Informações</a>
				<a class="btn btn-fatec-red btn-lg btn-block rounded-botton" href="./sair.php" role="button">Sair</a>
			</div>
			';
		}
	}
	?>
	<script>
        function validate(){
            var msg="";
            var senha=document.getElementById("senha").value;
            var r_senha=document.getElementById("r_senha").value;
            if(r_senha!=senha){
                msg+="Senhas estão diferentes</br>";
            }
            if(msg!=""){
				document.getElementById("alerta").innerHTML = msg;
                return false;
            }
			return true;
        }
    </script>
</body>
</html>
