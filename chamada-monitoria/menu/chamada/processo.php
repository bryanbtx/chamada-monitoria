<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../index.php",true,303);
    exit;
}
else{
    if($_SESSION['id']==1){
        header("Location: ../index.php",true,303);
    exit;
    }
}
include_once dirname(dirname(__DIR__)).'/bd_conn.php';
$response;
if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_POST["check"]) and isset($_POST["obs"]) and isset($_POST["nomes"])){
		$obs = array_values($_POST["obs"]);
		$db=new bd_conn();
		date_default_timezone_set('America/Sao_Paulo');
		foreach($_POST["check"] as $index => $hi){
			$vazio = "";
			foreach($_POST["nomes"] as $posicao => $he){
				if($he==$hi){
					$vazio = $obs[$posicao];
				}
			}
			$db->insertPresenca($hi,$_POST["id_pr_ho"],date("Y-m-d"),$vazio);
		}
		$db->disconnectFromDB();
		$response=0;
	}
	else{
		$response=1;
	}
}
header('location: resposta.php?m='.$response,true,303);
die();
?>
