<?php
include_once dirname(dirname(__DIR__)).'/bd_conn.php';
$response=0;
if($_SERVER['REQUEST_METHOD']=='POST'){
    if(isset($_POST["nomes"])){
        $check = array_values($_POST["check"]);
        $nomes = array_values($_POST["nomes"]);
        $db=new bd_conn();
        for($i=0;$i<count($nomes);$i++){
            $checked=0;
            for($k=0;$k<count($check);$k++){
                if($nomes[$i]==$check[$k]){
                    $checked=1;
                }
            }
            if(!$db->deleteAluno($nomes[$i],$checked)){
                $response=1;
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
