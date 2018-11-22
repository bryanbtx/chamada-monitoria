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
            <h1 class="display-8">Remover Monitore</h1>
            <p>Todos os alunos e horários registrados desse monitor serão removidos!</p>
        </div>
        <form action="processo.php" method="post">
            <select style="margin-bottom: 1rem;" class="form-control form-control-lg" id="monitor" name="id_mo" required>
            </select>
            <button class="btn btn-fatec-red btn-block btn-lg rounded-top" type="submit">Remover Monitor</button>
        </form>
        <a class="btn btn-fatec-red btn-lg btn-block rounded-botton" href="../index.php" role="button">Voltar para o Menu</a>
    </div>
    <script>
    function load(){
        select=document.getElementById("monitor");
        monitor=(<?php
        include_once dirname(dirname(__DIR__)).'/bd_conn.php';
        $db=new bd_conn();
        $user=$db->selectUsuarioAll();
        $monitor=array();
        $monitor['id_mo']=array();
        $monitor['ra']=array();
        $monitor['nome']=array();
        while($row=$user->fetch_assoc()){
            if($row['id_mo']!=1){
                array_push($monitor['id_mo'],$row['id_mo']);
                array_push($monitor['ra'],$row['ra']);
                array_push($monitor['nome'],$row['nome']);
            }
        }
        echo json_encode($monitor);
        ?>);
        for(var i=0;i<monitor['id_mo'].length;i++){
            var opt=document.createElement('option');
            opt.value=monitor['id_mo'][i];
            opt.innerHTML=(monitor['ra'][i]+' - '+monitor['nome'][i]);
            select.appendChild(opt);
        }
    }
    </script>
</body>
</html>
