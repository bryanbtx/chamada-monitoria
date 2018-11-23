<?php
include_once dirname(__DIR__).'/bd_conn.php';
$response;
if($_SERVER['REQUEST_METHOD']=='POST'){
	if(isset($_POST['ra'])){
		$db=new bd_conn();
		$user=$db->selectUsuarioByRA($_POST['ra']);
		if($user!=NULL){
            $senha=uniqid("");
            if($db->alterUsuarioSenhaTrocar($_POST['ra'],$senha)){
                $to = $user['NM_EMAIL'];
                $subject = "Senha";
                $message = "Senha: ".$senha;
                if(mail($to, $subject, $message)){
                    $response=0;
                }
                else{
                    $response=1;
                }
            }
            else{
                $response=2;
            }
		}
		else{
			$response=3;
		}
		$db->disconnectFromDB();
	}
	else{
		$response=4;
	}
}
else{
	$response=5;
}
header('location: resposta.php?m='.$response,true,303);
die();
?>
