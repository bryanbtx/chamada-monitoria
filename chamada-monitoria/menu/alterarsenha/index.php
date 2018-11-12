<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../index.php",true,303);
    exit;
}
include_once dirname(dirname(__DIR__)).'/bd_conn.php';
$response;
if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_POST['senha']) and isset($_SESSION['id'])){
		$db=new bd_conn();
		if($_SESSION['id']==1){
			if(isset($_POST['id'])){
				if($db->alterUsuarioSenha($_POST['id'],$_POST['senha'])){
					$response=0;
				}
				else{
					$response=1;
				}
				$db->disconnectFromDB();
			}
			else{
				if($db->alterUsuarioSenha($_SESSION['id'],$_POST['senha'])){
					$response=0;
					$_SESSION['troca_senha']=0;
				}
				else{
					$response=1;
				}
				$db->disconnectFromDB();
			}
		}
		else{
			if($db->alterUsuarioSenha($_SESSION['id'],$_POST['senha'])){
				$response=0;
				$_SESSION['troca_senha']=0;
			}
			else{
				$response=1;
			}
			$db->disconnectFromDB();
		}
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
