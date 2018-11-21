<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../../index.php",true,303);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="../../custom.css">
	<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Monitoria - Modificar Informações</title>
</head>
<body>
    <div style="margin:1%">
        <div class="jumbotron">
            <h1 class="display-8">Modificar Informações</h1>
        </div>
    <?php
    if($_SESSION['id']==1){
        echo '
        <div>
            <form action="processo.php" method="post" onsubmit="return validate()">
                <p id="alerta" style="text-align:left; color:#AE0F15;"></p>
                <select style="margin-bottom: 1rem;" class="form-control form-control-lg" name="id" required>
        ';
        include_once dirname(dirname(__DIR__)).'/bd_conn.php';
        $db=new bd_conn();
        $user=$db->selectUsuarioAll();
        $combo="";
        while($row=$user->fetch_assoc()){
            $combo.='<option value="'.$row['id_mo'].'">'.$row['ra'].'</option>';
        }
        echo $combo.'
                </select>
                <div class="form-group">
                    <input class="form-control form-control-lg" id="ra" type="text" placeholder="RA" name="ra">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" id="nome" type="text" placeholder="Nome" name="nome">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" id="email" type="text" placeholder="Email" name="email">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" id="prof_resp" type="text" placeholder="Professor responsável" name="prof_resp">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" id="disciplina" type="text" placeholder="Disciplina" name="disciplina">
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" id="curso" type="text" placeholder="Curso" name="curso">
                </div>

                <button class="btn btn-fatec-red btn-block btn-lg" type="submit">Alterar Informações</button>
            </form>

            <form action="../alterarsenha/index.php" method="post" onsubmit="return validateSenha()">
            <select style="margin-top:1rem;margin-bottom: 1rem;" class="form-control form-control-lg" name="id" required>
            ';
        echo $combo.'
            </select>
                <div class="form-group">
                    <input class="form-control form-control-lg" id="senha" type="password" placeholder="Senha" name="senha" required>
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" id="r_senha" type="password" placeholder="Repete a senha" name="r_senha" required>
                </div>

                <button class="btn btn-fatec-red btn-block btn-lg rounded-top" type="submit">Alterar senha</button>
            </form>
        </div>
        ';
    }
    else{
        echo '
        <div>
            <form action="processo.php" method="post" onsubmit="return validate()">
                <p id="alerta" style="text-align:left; color:#AE0F15;"></p>

                <input id="ra" type="hidden" placeholder="RA" name="ra">

                <input id="nome" type="hidden" placeholder="Nome" name="nome">
                <div class="form-group">
                    <input class="form-control form-control-lg" id="email" type="text" placeholder="Email" name="email">
                </div>

                <input id="prof_resp" type="hidden" placeholder="Professor responsável" name="prof_resp">

                <input id="disciplina" type="hidden" placeholder="Disciplina" name="disciplina">

                <input id="curso" type="hidden" placeholder="Curso" name="curso">

                <button class="btn btn-fatec-red btn-block btn-lg" type="submit">Alterar Email</button>
            </form>

            <form action="../alterarsenha/index.php" method="post" onsubmit="return validateSenha()">
                <div class="form-group">
                    <input style="margin-top: 1rem;" class="form-control form-control-lg" id="senha" type="password" placeholder="Senha" name="senha" required>
                </div>
                <div class="form-group">
                    <input class="form-control form-control-lg" id="r_senha" type="password" placeholder="Repete a senha" name="r_senha" required>
                </div>

                <button class="btn btn-fatec-red btn-block btn-lg rounded-top" type="submit">Alterar senha</button>
            </form>
        </div>
        ';
    }
    ?>
        <a class="btn btn-fatec-red btn-lg btn-block rounded-botton" href="../index.php" role="button">Voltar para o Menu</a>
    </div>
    <script>
        function validate(){
            var msg="";
            var ra=document.getElementById("ra").value;
            var vazio=ra;
            vazio+=document.getElementById("nome").value;
            vazio+=document.getElementById("email").value;
            vazio+=document.getElementById("prof_resp").value;
            vazio+=document.getElementById("disciplina").value;
            vazio+=document.getElementById("curso").value;
            if(vazio==""){
                msg+="Todos os campos estao vazios"
            }
            if((ra.length!=13 || isNaN(ra))&&!ra==""){
                    msg+="RA não esta no formato correto</br>";
            }
            if(msg!=""){
                document.getElementById("alerta").innerHTML = msg;
                return false;
            }
            return true;
        }
    </script>
    <script>
        function validateSenha(){
            var msg="";
            var senha=document.getElementById("senha").value;
            var r_senha=document.getElementById("r_senha").value;
            if(r_senha!=senha){
                msg+="Senhas estão diferentes</br>";
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
