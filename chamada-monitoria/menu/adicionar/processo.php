<?php
session_start();
include_once dirname(dirname(__DIR__)).'/bd_conn.php';
$response;
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['nome_a'])){
        $db=new bd_conn();
        $alunos=explode("<br>",$_POST['nome_a']);
        for($i=0;$i<count($alunos)-1;$i++){
            if($db->insertAlunos($_SESSION['id'],$alunos[$i])){
                $response=0;
            }
            else{
                $response=1;
                break;
            }
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
