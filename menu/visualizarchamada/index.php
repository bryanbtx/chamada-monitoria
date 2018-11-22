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
		<title>Monitoria - Visualização das Chamada</title>
	</head>
	<body onload="load()">
		<div style="margin:1%">
			<div class="jumbotron">
				<h1 class="display-8">Chamadas dos Alunos</h1>
			</div>
			<div>
				<div id="resp">
				</div>
				<a class="btn btn-fatec-red btn-lg btn-block" href="../index.php" role="button">Voltar para o Menu</a>
			</div>
		</div>
		<script>
		var chamada;
		var select;
		function load(){
			var resp=document.getElementById("resp");
			chamada=(
			<?php
			$chamada=array();
			$chamada['data_pre']=array();
			$chamada['dia_semana']=array();
			$chamada['hora_inicio']=array();
			$chamada['hora_termino']=array();
			$chamada['nome']=array();
			include_once dirname(dirname(__DIR__)).'/bd_conn.php';
			$db=new bd_conn();
			$user=$db->selectChamada($_SESSION['id']);
			if ($user!=NULL&&$user->num_rows>0)
			{
				while($row=$user->fetch_assoc()){
					array_push($chamada['data_pre'],$row['data_pre']);
					switch($row['dia_semana']){
						case 1:
							array_push($chamada['dia_semana'],"Segunda");
							break;
						case 2:
							array_push($chamada['dia_semana'],"Terça");
							break;
						case 3:
							array_push($chamada['dia_semana'],"Quarta");
							break;
						case 4:
							array_push($chamada['dia_semana'],"Quinta");
							break;
						case 5:
							array_push($chamada['dia_semana'],"Sexta");
							break;
						case 6:
							array_push($chamada['dia_semana'],"Sábado");
							break;
					}
					array_push($chamada['hora_inicio'],$row['hora_inicio']);
					array_push($chamada['hora_termino'],$row['hora_termino']);
					array_push($chamada['nome'],$row['nome']);
				}
			}
			$db->disconnectFromDB();
			echo json_encode($chamada);
			?>
			);
			if(chamada['data_pre'].length<=0){
				resp.innerHTML='<p>Nenhuma chamada foi cadastrada!</p>';
			}
			else{
				resp.innerHTML='<select class="form-control form-control-lg" id="chamada" onchange="change()" required></select><div id="chama"></div>';
				select=document.getElementById("chamada");
				for(var i=0;i<chamada['data_pre'].length;i++){
					var opt=document.createElement('option');
					if(i>0){
						if(chamada['data_pre'][i]!=select.options[select.options.length - 1].value){
							opt.value=chamada['data_pre'][i];
							opt.innerHTML=chamada['data_pre'][i];
							select.appendChild(opt);
						}
					}
					else{
						opt.value=chamada['data_pre'][i];
						opt.innerHTML=chamada['data_pre'][i];
						select.appendChild(opt);
					}
				}
				change();
			}
		}
		function change(){
			var chama=document.getElementById("chama");
			var select=document.getElementById("chamada").value;
			var inner="";
			inner+='<table class="table"><thead></thead>';
			for(var i=0;i<chamada['data_pre'].length;i++){
				if(select==chamada['data_pre'][i]){
					inner+='<tr><td style="border-color:transparent;text-align: center;">'+chamada['nome'][i]+'</td></tr>';
					inner+='<tr><td style="border-color:transparent;text-align: center;">'+chamada['dia_semana'][i]+'</td></tr>';
					inner+='<tr><td style="';
					if(i!=chamada['data_pre'].length-1){inner+='border-bottom: 1px solid #dee2e6;';}
					inner+='border-top:0px;text-align: center;">'+chamada['hora_inicio'][i]+' - '+chamada['hora_termino'][i]+'</td></tr>';
				}
			}
			chama.innerHTML=inner;
		}
		</script>
	</body>
</html>
