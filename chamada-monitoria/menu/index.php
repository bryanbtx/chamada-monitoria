<?php
session_start();
if(!isset($_SESSION['id'])){
	header("Location: ..",true,303);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../zerar.css">
	<link rel="stylesheet" type="text/css" href="../style.css">
	<title>Menu</title>
</head>
<body>
	<?php
	if($_SESSION['troca_senha']){
		echo '
		<p>Por favor insira uma nova senha para o '.$_SESSION['nome'].'</p>
		<form action="./alterarsenha/index.php" method="post" onsubmit="return validate()">
			<p id="alerta" style="text-align:left; color:#AE0F15;"></p>

			<input id="senha" type="password" placeholder="Nova senha" name="senha" required>

			<input id="r_senha" type="password" placeholder="Repetir nova senha" name="r_senha" required>

			<button type="submit">Mudar senha</button>
		</form>
		';
	}
	else{
		echo "
		<h1>Menu</h1>
		<p> Bem vindo ".$_SESSION['nome']."!</p>
		";
		if($_SESSION['id']==1){
			if($_SESSION['email']==""){
				echo '<p id="alerta" style="text-align:left; color:#AE0F15;">Por favor trocar o email padrao por um email valido</p>';
			}
			echo '
			<div>
				<form action="./criar">
					<button type="submit">Criar Monitor</button>
				</form>
				
				<form action="./consultar">
					<button type="submit">Consultar Aluno</button>
				</form>

				<form action="./visualizarinfo">
					<button type="submit">Visualizar Informacoes de um monitor</button>
				</form>

				<form action="./modificarinfo">
					<button type="submit">Modificar informacoes de um monitor</button>
				</form>

				<form action="./adicionarhorario">
					<button type="submit">Adicionar horarios de um monitor</button>
				</form>

				<form action="./removerhorario">
					<button type="submit">Remover horarios de um monitor</button>
				</form>

				<form action="./sair.php" method="post">
					<button type="submit">Sair</button>
				</form>
			</div>
			';
		}
		else{
			echo '
			<div>
			<form action="./adicionar">
				<button type="submit">Cadastrar aluno</button>
			</form>

			<form action="./chamada">
				<button type="submit">Realizar presenca</button>
			</form>

			<form action="./visualizarhorario">
				<button type="submit">Visualizar Horario de Monitoria</button>
			</form>
			
			<form action="./visualizarchamada">
				<button type="submit">Visualizar Chamada</button>
			</form>

			<form action="./quantidadepresenca">
				<button type="submit">Quantidade de presenca para cada aluno</button>
			</form>

			<form action="./visualizarobs">
				<button type="submit">Visualizar Observacoes</button>
			</form>

			<form action="./visualizarinfo">
				<button type="submit">Visualizar Informacoes</button>
			</form>
			
			<form action="./modificarinfo">
				<button type="submit">Modificar informacoes</button>
			</form>

			<form action="./sair.php" method="post">
					<button type="submit">Sair</button>
				</form>
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
