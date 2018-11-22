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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../custom.css">
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Monitoria - Informações dos Monitores</title>
</head>
	<?php
		if($_SESSION['id']==1){
            echo '
                <body onload="load()">
                <div style="margin:1%">
                <div class="jumbotron">
                    <h1 class="display-8">Selecione um monitor</h1>
                </div>
                <select id="monitores" class="form-control form-control-lg" onchange="change()" required>
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
                <table id="info" class="table">
                </table>
                <a class="btn btn-fatec-red btn-lg btn-block" href="../index.php" role="button">Voltar para o Menu</a>
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
                            inner="</tr><tr><td>Nome: "+info["nome"][i]+"</td></tr><tr><td>Email: "+info["email"][i]+"</td></tr><tr><td>Professor responsável: "+info["prof_resp"][i]+"</td></tr><tr><td>Disciplina: "+info["disciplina"][i]+"</td></tr><tr><td>Curso: "+info["curso"][i]+"</td></tr><tr><td>Número de alunos: "+info["qtd"][i]+"</td></tr>";
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
                    <body>
                    <div style="margin:1%">
                    <div class="jumbotron">
                        <h1 class="display-8">Informações do(a) '.$_SESSION['nome'].'</h1>
                    </div>
                    <table class="table">
                        <tr>
                            <td>RA: '.$_SESSION['ra'].'</td>
                        </tr>
                        <tr>
                            <td>Nome: '.$_SESSION['nome'].'</td>
                        </tr>
                        <tr>
                            <td>Email: '.$_SESSION['email'].'</td>
                        </tr>
                        <tr>
                            <td>Professor responsável: '.$_SESSION['prof_resp'].'</td>
                        </tr>
                        <tr>
                            <td>Disciplina: '.$_SESSION['disciplina'].'</td>
                        </tr>
                        <tr>
                            <td>Curso: '.$_SESSION['curso'].'</td>
                        </tr>
                        <tr>
                            <td>Número de alunos: '.$user['qtd'].'</td>
                        </tr>
                    </table>
                ';
            }
            else{
                echo '
                <body>
                <div class="jumbotron">
				    <h1 class="display-8">Não foi possível recuperar as Informações, Tente novamente mais tarde</h1>
			    </div>
                ';
            }
            echo '
            <a class="btn btn-fatec-red btn-lg btn-block" href="../index.php" role="button">Voltar para o Menu</a>
            ';
		}
	?>
    </div>
</body>
</html>
