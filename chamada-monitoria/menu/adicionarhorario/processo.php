<?php
include_once dirname(dirname(__DIR__)).'/bd_conn.php';
$response;
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['id']) and isset($_POST['dia_semana']) and isset($_POST['hora_inicio']) and isset($_POST['hora_termino'])){
        $db=new bd_conn();
        if($db->insertHora($_POST['id'],$_POST['dia_semana'],$_POST['hora_inicio'].":00",$_POST['hora_termino'].":00")){
            $response=0;
        }
        else{
            $response=1;
        }
        $db->disconnectFromDB();
    }
    else{
        $response=2;
    }
}
else{
    $response=3;
}
header('location: resposta.php?m='.$response,true,303);
die();
?>
