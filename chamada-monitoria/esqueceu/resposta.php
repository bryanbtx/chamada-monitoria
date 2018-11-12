<?php
$response;
if($_SERVER['REQUEST_METHOD']=='GET'){
	if(isset($_GET['m'])){
        switch ($_GET['m']) {
            case 0:
                $response="Um e-mail com a senha foi enviado";
                break;
            case 1:
                $response="Falha no envio";
                break;
            case 2:
                $response="Falha na alteração da senha";
                break;
            case 3:
                $response="RA não encontrado";
                break;
            case 4:
                $response="Campos requeridos estão faltando";
                break;
            case 5:
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
        <form action=".">
            <button type="submit">Voltar</button>
        </form>
        <form action="..">
            <button type="submit">Ir para o login</button>
        </form>
    </div>
</body>
</html>
';
?>
