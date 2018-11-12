<?php
session_start();
if(!isset($_SESSION['id'])){
    header("Location: ../..",true,303);
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../zerar.css">
    <link rel="stylesheet" type="text/css" href="../../style.css">
	<title>Modificar Monitor</title>
</head>
<body>
<?php
  echo "<p>Modificar informacoes</p>";
  if($_SESSION['id']==1){
      echo '
      <div>
          <form action="processo.php" method="post" onsubmit="return validate()">
              <p id="alerta" style="text-align:left; color:#AE0F15;"></p>
              <select name="id" required>
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

              <input id="ra" type="text" placeholder="RA" name="ra">

              <input id="nome" type="text" placeholder="Nome" name="nome">

              <input id="email" type="text" placeholder="Email" name="email">

              <input id="prof_resp" type="text" placeholder="Professor responsavel" name="prof_resp">

              <input id="disciplina" type="text" placeholder="Disciplina" name="disciplina">

              <input id="curso" type="text" placeholder="Curso" name="curso">

              <button type="submit">Alterar informacoes</button>
          </form>

          <form action="../alterarsenha/index.php" method="post" onsubmit="return validateSenha()">
          <select name="id" required>
          ';
      echo $combo.'
                  </select>
              <input id="senha" type="password" placeholder="Senha" name="senha" required>

              <input id="r_senha" type="password" placeholder="Repetir senha" name="r_senha" required>

              <button type="submit">Alterar senha</button>
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

              <input id="email" type="text" placeholder="Email" name="email">

              <input id="prof_resp" type="hidden" placeholder="Professor responsavel" name="prof_resp">

              <input id="disciplina" type="hidden" placeholder="Disciplina" name="disciplina">

              <input id="curso" type="hidden" placeholder="Curso" name="curso">

              <button type="submit">Alterar Email</button>
          </form>

          <form action="../alterarsenha/index.php" method="post" onsubmit="return validateSenha()">
              <input id="senha" type="password" placeholder="Senha" name="senha" required>

              <input id="r_senha" type="password" placeholder="Repetir senha" name="r_senha" required>

              <button type="submit">Alterar senha</button>
          </form>
      </div>
      ';
  }
?>
    <form action="..">
		<button type="submit">Voltar</button>
	</form>
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
