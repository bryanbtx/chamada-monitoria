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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../custom.css">
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Monitoria - Resposta</title>
</head>
<body>
    <div style="margin:1%">
        <div class="jumbotron">
            <h1 class="display-8">'.$response.'</h1>
        </div>
        <a class="btn btn-fatec-red btn-lg btn-block" href="../index.php" role="button">Voltar</a>
    </div>
</body>
</html>
';
?>
