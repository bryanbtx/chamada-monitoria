<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../index.php",true,303);
    exit;
}
include_once dirname(dirname(__DIR__)).'/bd_conn.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../../zerar.css">
	<link rel="stylesheet" type="text/css" href="../../style.css">
	<title>Informacoes</title>
</head>
	<?php
		if($_SESSION['id']==1){
            echo '
                <body onload="load()">
                <p>Selecione um monitor</p>
                <select id="monitores" onchange="change()" required>
            ';
            $db=new bd_conn();
            $user=$db->selectUsuarioAll();
            $combo="";
            while($row=$user->fetch_assoc()){
                if($row['id_mo']!=1){
                    $combo.='<option value="'.$row['id_mo'].'">'.$row['ra'].'</option>';
                }
            }
            $db->disconnectFromDB();
            echo $combo;
            echo '
                </select>
                <table id="info">
                </table>
                <form action="../index.php" method="post">
                    <button type="submit">Voltar</button>
                </form>
                <script>
                var info;
                function load(){
                    var table=document.getElementById("info");
                    info=(
            ';
            include_once dirname(dirname(__DIR__)).'/bd_conn.php';
            $db=new bd_conn();
            $user=$db->selectInfoAll();
            $info=array();
            $info['id_mo']=array();
            $info['nome']=array();
            $info['email']=array();
            $info['prof_resp']=array();
            $info['disciplina']=array();
            $info['curso']=array();
            $info['qtd']=array();
            while($row=$user->fetch_assoc()){
                array_push($info['id_mo'],$row['id_mo']);
                array_push($info['nome'],$row['nome']);
                array_push($info['email'],$row['email']);
                array_push($info['prof_resp'],$row['prof_resp']);
                array_push($info['disciplina'],$row['disciplina']);
                array_push($info['curso'],$row['curso']);
                array_push($info['qtd'],$row['qtd']);
            }
            echo json_encode($info);
            echo '
                    );
                    change();
                }
                function change(){
                    var table=document.getElementById("info");
                    var id_mo=document.getElementById("monitores").value;
                    var inner;
                    table.innerHTML="";
                    for(var i=0;i<info[\'id_mo\'].length;i++){
                        if(info[\'id_mo\'][i]==id_mo){
                            inner="</tr><tr><td>Nome:</td></tr><tr><td>"+info["nome"][i]+"</td></tr><tr><td>Email:</td></tr><tr><td>"+info["email"][i]+"</td></tr><tr><td>Professor responsavel:</td></tr><tr><td>"+info["prof_resp"][i]+"</td></tr><tr><td>Disciplina:</td></tr><tr><td>"+info["disciplina"][i]+"</td></tr><tr><td>Curso:</td></tr><tr><td>"+info["curso"][i]+"</td></tr><tr><td>Numero de alunos:</td></tr><tr><td>"+info["qtd"][i]+"</td></tr>";
                            break;
                        }
                    }
                    table.innerHTML=inner;
                }
                </script>
                ';
		}
		else{
            $db=new bd_conn();
            $user=$db->selectQtdAluno($_SESSION['id']);
            if($user!=NULL){
                echo '
                    <p>Informacoes do(a) '.$_SESSION['nome'].'</p>
                    <table>
                        <tr>
                            <td>RA:</td>
                        </tr>
                        <tr>
                            <td>'.$_SESSION['ra'].'</td>
                        </tr>
                        <tr>
                            <td>Nome:</td>
                        </tr>
                        <tr>
                            <td>'.$_SESSION['nome'].'</td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                        </tr>
                        <tr>
                            <td>'.$_SESSION['email'].'</td>
                        </tr>
                        <tr>
                            <td>Professor responsavel:</td>
                        </tr>
                        <tr>
                            <td>'.$_SESSION['prof_resp'].'</td>
                        </tr>
                        <tr>
                            <td>Disciplina:</td>
                        </tr>
                        <tr>
                            <td>'.$_SESSION['disciplina'].'</td>
                        </tr>
                        <tr>
                            <td>Curso:</td>
                        </tr>
                        <tr>
                            <td>'.$_SESSION['curso'].'</td>
                        </tr>
                        <tr>
                            <td>Numero de alunos:</td>
                        </tr>
                        <tr>
                            <td>'.$user['qtd'].'</td>
                        </tr>
                    </table>
                ';
            }
            else{
                echo '<body><p>Nao foi possivel recuperar as informacoes, tente novamente mais tarde</p>';
            }
            echo '
            <form action="../index.php" method="post">
                <button type="submit">Voltar</button>
            </form>
            ';
		}
	?>
</body>
</html>
