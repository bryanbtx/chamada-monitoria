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
	<title>Monitoria - Adicionar Horário do Monitor</title>
</head>
<body>
    <div style="margin:1%">
        <div class="jumbotron">
            <h1 class="display-8">Adicionar o novo Horario para o Monitor</h1>
        </div>
        <form action="processo.php" method="post" onsubmit="return validate()">
            <p id="alerta" style="text-align:left; color:#AE0F15;"></p>
            <select style="margin-bottom: 1rem;" class="form-control form-control-lg" name="id" required>
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
            <select style="margin-bottom: 1rem;" class="form-control form-control-lg" name="dia_semana">
                <option value="1">Segunda</option checked>
                <option value="2">Terça</option>
                <option value="3">Quarta</option>
                <option value="4">Quinta</option>
                <option value="5">Sexta</option>
                <option value="6">Sábado</option>
            </select>
            <div class="form-group">
                <input class="form-control form-control-lg" id="hi" type="text" name="hora_inicio" placeholder="Hora do Início" required>
            </div>
            <div class="form-group">
                <input class="form-control form-control-lg" id="ht" type="text" name="hora_termino" placeholder="Hora do Término" required>
            </div>
            <p style="text-align:center">Formato das horas: hh:mm<br>ex: 13:30</p>
            <button class="btn btn-fatec-red btn-block btn-lg rounded-top" type="submit">Adicionar o Horário</button>
        </form>
        <a class="btn btn-fatec-red btn-lg btn-block rounded-botton" href="../index.php" role="button">Voltar para o Menu</a>
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
