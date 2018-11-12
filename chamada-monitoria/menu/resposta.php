<?php
$response;
if($_SERVER['REQUEST_METHOD']=='GET'){
	if(isset($_GET['m'])){
        switch ($_GET['m']) {
            case 0:
                $response="Usuário não encontrado\nRA ou Senha incorretos";
                break;
            case 1:
                $response="Campos requeridos estão faltando";
                break;
            case 2:
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
    <link rel="stylesheet" type="text/css" href="../zerar.css">
    <link rel="stylesheet" type="text/css" href="../style.css">
	<title>Voltar</title>
</head>
<body>
    <div>
        <p>'.$response.'</p>
        <form action="./index.php" method="post">
            <button type="submit">Voltar</button>
        </form>
    </div>
</body>
</html>
';
?>
