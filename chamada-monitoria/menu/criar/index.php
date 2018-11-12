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
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../zerar.css">
    <link rel="stylesheet" type="text/css" href="../../style.css">
    <title>Criar conta</title>
</head>
<body>
    <h1>Criar conta</h1>
    <div>
        <form action="processo.php" method="post" onsubmit="return validate()">
            <p id="alerta" style="text-align:left; color:#AE0F15;"></p>

            <input id="ra" type="text" placeholder="RA" name="ra" required>

            <input id="nome" type="text" placeholder="Nome" name="nome" required>

            <input id="email" type="text" placeholder="Email" name="email" required>

            <input id="senha" type="password" placeholder="Senha" name="senha" required>

            <input id="r_senha" type="password" placeholder="Repetir senha" name="r_senha" required>

            <input id="prof_resp" type="text" placeholder="Professor responsavel" name="prof_resp" required>

            <input id="disciplina" type="text" placeholder="Disciplina" name="disciplina" required>

            <input id="curso" type="text" placeholder="Curso" name="curso" required>

            <button type="submit">Criar</button>
        </form>
        <form action="../index.php" method="post">
			<button type="submit">Voltar</button>
		</form>
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
