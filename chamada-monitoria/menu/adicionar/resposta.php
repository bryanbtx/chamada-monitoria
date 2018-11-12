<?php
$response;
if($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset($_GET['m'])){
        switch ($_GET['m']) {
            case 0:
                $response="Aluno adicionado";
                break;
            case 1:
                $response="Algum erro ocorreu, tente novamente mais tarde";//talvez tenha add alguns alunos -.-
                break;
            case 2:
                $response="Campos requeridos estão faltando";
                break;
            case 3:
                $response="Requisição invalida";
                break;
        }
    }
    else{
        $response="Campos requeridos estão faltando";
    }
}
else{
    $response="Requisição invalida";
}
echo '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../zerar.css">
    <link rel="stylesheet" type="text/css" href="../../style.css">
	<title>Voltar</title>
</head>
<body>
    <div>
        <form action="./index.php" method="post">
            <p>'.$response.'</p>
            <button type="submit">Voltar</button>
        </form>
        <form action="../index.php" method="post">
			<button type="submit">Ir para o menu</button>
		</form>
    </div>
</body>
</html>
';
?>
