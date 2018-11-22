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
                $_SESSION['id']=$user['id_mo'];
                $response['error']=false;
                $_SESSION['ra']=$user['ra'];
                $_SESSION['nome']=$user['nome'];
                $_SESSION['email']=$user['email'];
                $_SESSION['troca_senha']=$user['troca_senha'];
                $_SESSION['prof_resp']=$user['prof_resp'];
                $_SESSION['disciplina']=$user['disciplina'];
                $_SESSION['curso']=$user['curso'];
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
