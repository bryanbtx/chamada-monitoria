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
?>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="../../zerar.css">
		<link rel="stylesheet" type="text/css" href="../../style.css">
		<title>Observacoes</title>
	</head>
	<body onload="load()">
		<div>
			<p>Observacoes</p>
		</div>
		<div>
			<div id="resp">
			</div>
			<form action=".." method="post">
				<button type="submit">Voltar</button>
			</form>
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
			$chamada['obs']=array();
			include_once dirname(dirname(__DIR__)).'/bd_conn.php';
			$db=new bd_conn();
			$user=$db->selectChamada($_SESSION['id']);
			if ($user!=NULL&&$user->num_rows>0)
			{
				while($row=$user->fetch_assoc()){
					if($row['obs']!=""){
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
								array_push($chamada['dia_semana'],"Sabado");
								break;
						}
						array_push($chamada['hora_inicio'],$row['hora_inicio']);
						array_push($chamada['hora_termino'],$row['hora_termino']);
						array_push($chamada['nome'],$row['nome']);
						array_push($chamada['obs'],$row['obs']);
					}
				}
			}
			$db->disconnectFromDB();
			echo json_encode($chamada);
			?>
			);
			if(chamada['data_pre'].length<=0){
				resp.innerHTML="<p>Nenhuma observacao foi registrada!</p>";
			}
			else{
				resp.innerHTML='<select id="chamada" onchange="change()" required></select><div id="chama"></div>';
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
			inner+="<table>";
			for(var i=0;i<chamada['data_pre'].length;i++){
				if(select==chamada['data_pre'][i]){
					inner+='<tr><td style="border-color:transparent;">'+chamada['nome'][i]+':</td></tr>';
					inner+='<tr><td>'+chamada['obs'][i]+'</td></tr>';
				}
			}
			chama.innerHTML=inner;
		}
		</script>
	</body>
</html>
