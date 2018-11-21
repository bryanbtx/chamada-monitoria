<?php
include_once dirname(dirname(__DIR__)).'/bd_conn.php';
$response;
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST['id_mo'])){
        $db=new bd_conn();
        if($db->deleteMonitor($_POST['id_mo'])){
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
