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
		<title>Monitoria - Presença dos Alunos</title>
	</head>
	<body onload="load()">
		<div style="margin:1%">
			<div class="jumbotron">
				<h1 class="display-8">Presença Atuais dos Alunos</h1>
			</div>
			<div>
				<div id="resp">
				</div>
				<a class="btn btn-fatec-red btn-lg btn-block" href="../index.php" role="button">Voltar para o Menu</a>
			</div>
		</div>
		<script>
		function load(){
			var resp=document.getElementById("resp");
			var presenca=(
			<?php
			$presenca=array();
			$presenca['nome']=array();
			$presenca['qtd']=array();
			include_once dirname(dirname(__DIR__)).'/bd_conn.php';
			$db=new bd_conn();
			$user=$db->selectQtdPresenca($_SESSION['id']);
			if ($user!=NULL&&$user->num_rows>0)
			{
				while($row=$user->fetch_assoc()){
                    array_push($presenca['nome'],$row['nome']);
                    array_push($presenca['qtd'],$row['qtd']);
				}
			}
            $db->disconnectFromDB();
			echo json_encode($presenca);
			?>
			);
			if(presenca['nome'].length<=0){
				resp.innerHTML="<p>Nenhuma presença foi Registrada!</p>";
			}
			else{
                var inner;
				inner='<table class="table">';
                inner+="<tr><th>Aluno</th><th>Qtd.</th></tr>";
                for(var i=0;i<presenca["nome"].length;i++){
                    inner+="<tr><td>"+presenca["nome"][i]+"</td><td>"+presenca["qtd"][i]+"</td></tr>";
                }
                inner+="</table>";
                resp.innerHTML=inner;
			}
		}
		</script>
	</body>
</html>
