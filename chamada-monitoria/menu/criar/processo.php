<?php
include_once dirname(dirname(__DIR__)).'/bd_conn.php';
$response;
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['ra']) and isset($_POST['nome']) and isset($_POST['email']) and isset($_POST['senha']) and isset($_POST['prof_resp']) and isset($_POST['disciplina']) and isset($_POST['curso'])){
        $db=new bd_conn();
        if($db->insertUsuario($_POST['ra'],$_POST['nome'],$_POST['email'],$_POST['senha'],$_POST['prof_resp'],$_POST['disciplina'],$_POST['curso'])){
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
