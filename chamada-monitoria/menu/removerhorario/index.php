<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../index.php",true,303);
    exit;
}
else{
    if(!$_SESSION['id']==1){
        header("Location: ../index.php",true,303);
    exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../custom.css">
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Monitoria - Remover o horário</title>
</head>
<body onload="load()">
    <div style="margin:1%">
        <div class="jumbotron">
            <h1 class="display-8">Remover o horário dos monitores</h1>
        </div>
        <p id="alerta" style="text-align:left; color:#AE0F15;"></p>
        <form action="processo.php" method="post">
            <select style="margin-bottom: 1rem;" class="form-control form-control-lg" id="monitores" name="id_mo" onchange="change()" required>
                <?php
                include_once dirname(dirname(__DIR__)).'/bd_conn.php';
                $db=new bd_conn();
                $user=$db->selectUsuarioAll();
                $combo="";
                while($row=$user->fetch_assoc()){
                    if($row['ID_MONI_SEC']!=1){
                        $combo.='<option value="'.$row['ID_MONI_SEC'].'">'.$row['NM_RA'].'</option>';
                    }
                }
                echo $combo
                ?>
            </select>
            <select style="margin-bottom: 1rem;" class="form-control form-control-lg" id="horarios" name="id_ho" required>
            </select>
            <button class="btn btn-fatec-red btn-block btn-lg rounded-top" type="submit">Remover Horário</button>
        </form>
        <a class="btn btn-fatec-red btn-lg btn-block rounded-botton" href="../index.php" role="button">Voltar para o Menu</a>
    </div>
    <script>
    var horarios;
    var select;
	function chamar(x){
		var $dia;
		switch(x){
			case 1:
				$dia="Segunda";
			break;
			case 2:
				$dia="Terça";
			break;
			case 3:
				$dia="Quarta";
			break;
			case 4:
				$dia="Quinta";
			break;
			case 5:
				$dia="Sexta";
			break;
			case 6:
				$dia="Sábado";
			break;
		}
		return $dia;
	}
    function load(){
        var id_mo=document.getElementById("monitores").value;
        select=document.getElementById("horarios");
        horarios=(<?php
        include_once dirname(dirname(__DIR__)).'/bd_conn.php';
        $db=new bd_conn();
        $user=$db->selectHorariosAll();
        $horarios=array();
        $horarios['id_ho']=array();
        $horarios['id_ho_mo']=array();
        $horarios['dia_semana']=array();
        $horarios['hora_inicio']=array();
        $horarios['hora_termino']=array();
        while($row=$user->fetch_assoc()){
            array_push($horarios['id_ho'],$row['ID_HORA_SEC']);
            array_push($horarios['id_ho_mo'],$row['FK_HORARIO_MONITOR']);
            array_push($horarios['dia_semana'],$row['CS_DIA']);
            array_push($horarios['hora_inicio'],substr($row['HR_INICIO'],0,-3));
            array_push($horarios['hora_termino'],substr($row['HR_TERMINO'],0,-3));
        }
        echo json_encode($horarios);
        ?>);
        for(var i=0;i<horarios['id_ho'].length;i++){
            if(id_mo==horarios['id_ho_mo'][i]){
                var opt=document.createElement('option');
                opt.value=horarios['id_ho'][i];
                opt.innerHTML=chamar(horarios['dia_semana'][i])+" "+horarios['hora_inicio'][i]+" "+horarios['hora_termino'][i];
                select.appendChild(opt);
            }
        }
    }
    function change(){
        var id_mo=document.getElementById("monitores").value;
        while (select.firstChild){
            select.removeChild(select.firstChild);
        }
        for(var i=0;i<horarios['id_ho'].length;i++){
            if(id_mo==horarios['id_ho_mo'][i]){
                var opt=document.createElement('option');
                opt.value=horarios['id_ho'][i];
                opt.innerHTML=chamar(horarios['dia_semana'][i])+" "+horarios['hora_inicio'][i]+" "+horarios['hora_termino'][i];
                select.appendChild(opt);
            }
        }
    }
    </script>
</body>
</html>
