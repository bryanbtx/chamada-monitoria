<?php
session_start();
if(!isset($_SESSION['id'])){
    include_once dirname(__DIR__).'/bd_conn.php';
    $response=array();
    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['uname']) and	isset($_POST['pwd'])){
            $db=new bd_conn();
            $user=$db->selectUsuario($_POST['uname'],$_POST['pwd']);
            if($user!=NULL){
                $_SESSION['id']=$user['ID_MONI_SEC'];
                $response['error']=false;
                $_SESSION['ra']=$user['NM_RA'];
                $_SESSION['nome']=$user['NM_NOME'];
                $_SESSION['email']=$user['NM_EMAIL'];
                $_SESSION['troca_senha']=$user['ST_TROCAR_SENHA'];
                $_SESSION['prof_resp']=$user['NM_PROF_RESPONSAVEL'];
                $_SESSION['disciplina']=$user['NM_DISCIPLINA'];
                $_SESSION['curso']=$user['NM_CURSO'];
            }
            else{
                $response['error']=true;
                $response['message']=0;
            }
            $db->disconnectFromDB();
        }
        else{
            $response['error']=true;
            $response['message']=1;
        }
    }
    else{
        $response['error']=true;
        $response['message']=2;
    }
    if($response['error']){
			header('location: resposta.php?m='.$response['message'],true,303);
			die();
    }
}
header("Location: ./index.php",true,303);
exit;
?>
