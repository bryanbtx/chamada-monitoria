<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../index.php",true,303);
    exit;
}
else{
    if(!$_SESSION['id']==1){
        header("Location: ../index.php",true,303);
    exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../../custom.css">
	<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Monitoria - Criar conta do Monitor</title>
</head>
<body>
    <div style="margin:1%">
        <div class="jumbotron">
            <h1 class="display-8">Criar conta</h1>
        </div>
        <form action="processo.php" method="post" onsubmit="return validate()">
            <p id="alerta" style="text-align:left; color:#AE0F15;"></p>
            <div class="form-group">
                <input class="form-control form-control-lg" id="ra" type="text" placeholder="RA" name="ra" required>
            </div>
            <div class="form-group">
                <input class="form-control form-control-lg" id="nome" type="text" placeholder="Nome" name="nome" required>
            </div>
            <div class="form-group">
                <input class="form-control form-control-lg" id="email" type="text" placeholder="Email" name="email" required>
            </div>
            <div class="form-group">
                <input class="form-control form-control-lg" id="senha" type="password" placeholder="Senha" name="senha" required>
            </div>
            <div class="form-group">
                <input class="form-control form-control-lg" id="r_senha" type="password" placeholder="Repete a senha" name="r_senha" required>
            </div>
            <div class="form-group">
                <input class="form-control form-control-lg" id="prof_resp" type="text" placeholder="Professor responsável" name="prof_resp" required>
            </div>
            <div class="form-group">
                <input class="form-control form-control-lg" id="disciplina" type="text" placeholder="Disciplina" name="disciplina" required>
            </div>
            <div class="form-group">
                <input class="form-control form-control-lg" id="curso" type="text" placeholder="Curso" name="curso" required>
            </div>
            <button class="btn btn-fatec-red btn-block btn-lg rounded-top" type="submit">Criar Conta</button>
        </form>
        <a class="btn btn-fatec-red btn-lg btn-block rounded-botton" href="../index.php" role="button">Voltar para o Menu</a>
    </div>
    <script>
        function validate(){
            var msg="";
            var ra=document.getElementById("ra").value;
            var senha=document.getElementById("senha").value;
            var r_senha=document.getElementById("r_senha").value;
            if(r_senha!=senha){
                msg+="Senhas estão diferentes</br>";
            }
            if(ra.length!=13 || isNaN(ra)){
                    msg+="RA não esta no formato correto</br>";
            }
            if(msg!=""){
                document.getElementById("alerta").innerHTML = msg;
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
