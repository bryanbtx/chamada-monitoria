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
	<title>Monitoria - Adicionar Aluno</title>
</head>
<body>
	<div style="margin:1%">
		<div class="jumbotron">
			<h1 class="display-8">Cadastro dos Alunos</h1>
			<p id="alerta" style="text-align:left; color:#AE0F15;"></p>
		</div>
		<div>
			<form action="./processo.php" method="post"  onsubmit="return validate()">
				<input type="hidden" id="nomes" name="nome_a" placeholder="Nome">
				<input type="hidden" id="cursos" name="curso_a" placeholder="Nome">
				<div class="form-group">
					<input type="text" id="nome" placeholder="Nome" class="form-control form-control-lg">
				</div>
				<div class="form-group">
					<input type="text" id="curso" placeholder="Curso" class="form-control form-control-lg">
				</div>
				<div class="form-group">
					<button type="button" class="btn btn-fatec-red btn-block btn-lg" onclick="add()">Adicionar o Aluno na Lista</button>
				</div>
				<h4 id="alunos" class="label label-default"></h4>
				<button type="submit" class="btn btn-fatec-red btn-block btn-lg rounded-top">Cadastrar os Alunos Registrados na Lista</button>
			</form>
			<a class="btn btn-fatec-red btn-lg btn-block rounded-botton" href="../index.php" role="button">Voltar Para o Menu</a>
		</div>
	</div>
	<script>
		function add(){
			var alunos=document.getElementById("alunos");
			var cursos=document.getElementById("cursos");
			var aluno=document.getElementById("nome").value;
			var curso=document.getElementById("curso").value;
			var inner=alunos.innerHTML;
			var inner1=document.getElementById("cursos").value;
			if(aluno.replace(/ /g,'')!="" && curso.replace(/ /g,'')!=""){
				inner+=aluno+"<br>";
				document.getElementById("nomes").value=inner;
				alunos.innerHTML=inner;
				document.getElementById("nome").placeholder="Nome";

				inner1+=curso+"<br>";
				document.getElementById("cursos").value=inner1;
				document.getElementById("curso").placeholder="Curso";

				document.getElementById("nome").value="";
				document.getElementById("curso").value="";
			}else{
				if(aluno.replace(/ /g,'')==""){
					document.getElementById("nome").placeholder="Preencha esse campo!";
				}
				if(curso.replace(/ /g,'')==""){
					document.getElementById("curso").placeholder="Preencha esse campo!";
				}
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
