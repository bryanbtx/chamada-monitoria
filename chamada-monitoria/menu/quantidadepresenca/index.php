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
		<title>Presenca</title>
	</head>
	<body onload="load()">
		<div>
			<p>Presenca</p>
		</div>
		<div>
			<div id="resp">
			</div>
			<form action="..">
				<button type="submit">Voltar</button>
			</form>
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
				resp.innerHTML="<p>Nenhuma presenca foi registrada!</p>";
			}
			else{
                var inner;
				inner="<table>";
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
