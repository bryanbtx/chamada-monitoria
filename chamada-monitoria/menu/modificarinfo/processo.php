<?php
session_start();
include_once dirname(dirname(__DIR__)).'/bd_conn.php';
$response;
if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_POST['ra']) and isset($_POST['nome']) and isset($_POST['email']) and isset($_POST['prof_resp']) and isset($_POST['disciplina']) and isset($_POST['curso']) and isset($_SESSION['id'])){
		$db=new bd_conn();
		if($_SESSION['id']==1){
			if(isset($_POST['id'])){
				if($db->alterUsuarioInfo($_POST['id'],$_POST['ra'],$_POST['nome'],$_POST['email'],$_POST['prof_resp'],$_POST['disciplina'],$_POST['curso'])){
					$response=0;
					if($_POST['id']==1){
						atualizar();
					}
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
			if($db->alterUsuarioInfo($_SESSION['id'],$_POST['ra'],$_POST['nome'],$_POST['email'],$_POST['prof_resp'],$_POST['disciplina'],$_POST['curso'])){
				$response=0;
				atualizar();
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
function atualizar(){
	if($_POST['ra']!=""){
		$_SESSION['ra']=$_POST['ra'];
	}
	if($_POST['nome']!=""){
		$_SESSION['nome']=$_POST['nome'];
	}
	if($_POST['email']!=""){
		$_SESSION['email']=$_POST['email'];
	}
	if($_POST['prof_resp']!=""){
		$_SESSION['prof_resp']=$_POST['prof_resp'];
	}
	if($_POST['disciplina']!=""){
		$_SESSION['disciplina']=$_POST['disciplina'];
	}
	if($_POST['curso']!=""){
		$_SESSION['curso']=$_POST['curso'];
	}
}
?>
