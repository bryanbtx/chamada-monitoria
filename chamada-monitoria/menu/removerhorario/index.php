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
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../zerar.css">
    <link rel="stylesheet" type="text/css" href="../../style.css">
	<title>Remover horario</title>
</head>
<body onload="load()">
    <div>
        <form action="processo.php" method="post">
            <p>Remover horario</p>
            <p id="alerta" style="text-align:left; color:#AE0F15;"></p>
            <select id="monitores" name="id_mo" onchange="change()" required>
                <?php
                include_once dirname(dirname(__DIR__)).'/bd_conn.php';
                $db=new bd_conn();
                $user=$db->selectUsuarioAll();
                $combo="";
                while($row=$user->fetch_assoc()){
                    if($row['id_mo']!=1){
                        $combo.='<option value="'.$row['id_mo'].'">'.$row['ra'].'</option>';
                    }
                }
                echo $combo
                ?>
            </select>
            <select id="horarios" name="id_ho" required>

            </select>
            <button type="submit">Remover horario</button>
        </form>
        <form action="../index.php" method="post">
			<button type="submit">Voltar</button>
		</form>
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
				$dia="Sabado";
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
            array_push($horarios['id_ho'],$row['id_ho']);
            array_push($horarios['id_ho_mo'],$row['id_ho_mo']);
            array_push($horarios['dia_semana'],$row['dia_semana']);
            array_push($horarios['hora_inicio'],substr($row['hora_inicio'],0,-3));
            array_push($horarios['hora_termino'],substr($row['hora_termino'],0,-3));
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
