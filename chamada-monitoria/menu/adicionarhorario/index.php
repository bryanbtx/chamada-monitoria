<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../..",true,303);
    exit;
}
else{
    if(!$_SESSION['id']==1){
        header("Location: ..",true,303);
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
	<title>Adicionar horario</title>
</head>
<body>
    <div>
        <form action="processo.php" method="post" onsubmit="return validate()">
            <p>Adicionar horario</p>
            <p id="alerta" style="text-align:left; color:#AE0F15;"></p>
            <select name="id" required>
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
            <select name="dia_semana">
                <option value="1">Segunda</option checked>
                <option value="2">Terca</option>
                <option value="3">Quarta</option>
                <option value="4">Quinta</option>
                <option value="5">Sexta</option>
                <option value="6">Sabado</option>
            </select>
            <input id="hi" type="text" name="hora_inicio" placeholder="Hora do inicio" required>
            <input id="ht" type="text" name="hora_termino" placeholder="Hora do termino" required>
            Formato das horas: hh:mm<br>ex: 13:30
            <button type="submit">Adicionar horario</button>
        </form>
        <form action="..">
			<button type="submit">Voltar</button>
		</form>
    <div>
    <script>
    function validate(){
        var msg="";
        var hi=document.getElementById("hi").value.split(":");
        var ht=document.getElementById("ht").value.split(":");
        for(var i=0;i<hi.length;i++){
            if(isNaN(hi[i])){
                msg="Horarios devem ser numeros<br>";
                break;
            }
        }
        for(var i=0;i<ht.length;i++){
            if(isNaN(ht[i])){
                msg="Horarios devem ser numeros<br>";
                break;
            }
        }
        if(msg==""){
            if(hi[0]>23||hi[1]>59||ht[0]>23||ht[1]>59){
                msg+="Horarios estao incorretos<br>";
            }
        }
        if(hi.length!=2||ht.length!=2){
            msg+="Horarios estao em formatos errados<br>";
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
