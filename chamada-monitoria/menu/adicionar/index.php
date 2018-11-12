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
	<title>Monitoria - Adicionar Aluno</title>
</head>
<body>
	<div>
		<p>Cadastro do aluno</p>
	</div>
	<div>
		<form action="processo.php" method="post" onsubmit="return validate()">
			<div>
				<p id="alerta" style="text-align:left; color:#AE0F15;"></p>
				<input type="hidden" id="nomes" name="nome_a" placeholder="Nome">
				<input type="text" id="aluno" placeholder="Nome">
				<button type="reset" onclick="add()">Adicionar a lista</button>
				<label id="alunos"></label>
				<button type="submit">Cadastrar alunos que estao na lista</button>
			</div>
		</form>
		<form action="../index.php" method="post">
			<button type="submit">Voltar</button>
		</form>
	</div>
	<script>
		function add(){
			var alunos=document.getElementById("alunos");
			var aluno=document.getElementById("aluno").value;
			var inner=alunos.innerHTML;
			if(aluno.replace(/ /g, '')!=""){
			inner+=aluno+"<br>";
			document.getElementById("nomes").value=inner;
			alunos.innerHTML=inner;
			document.getElementById("aluno").placeholder="Nome";
			}else{
				document.getElementById("aluno").placeholder="Preencha esse campo!";
			}
		}
		function validate(){
			var msg="";
            var nomes=document.getElementById("nomes").value;
            if(nomes==""){
                msg+="Nenhum aluno foi adicionado a lista</br>";
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
