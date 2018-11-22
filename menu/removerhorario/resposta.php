<?php
$response;
if($_SERVER['REQUEST_METHOD']=='GET'){
    if(isset($_GET['m'])){
        switch ($_GET['m']) {
            case 0:
                $response="Horário removido com Sucesso!";
                break;
            case 1:
                $response="Algum erro ocorreu, Tente novamente mais tarde!";
                break;
            case 2:
                $response="Campos requeridos estão Faltando!";
                break;
            case 3:
                $response="Requisição Inválida";
                break;
        }
    }
    else{
        $response="Campos requeridos estão Faltando!";
    }
}
else{
    $response="Requisição Inválida";
}
echo '
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../../custom.css">
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Monitoria - Resposta</title>
</head>
<body>
    <div style="margin:1%">
        <div class="jumbotron">
            <h1 class="display-8">'.$response.'</h1>
        </div>
        <a class="btn btn-fatec-red btn-lg btn-block rounded-top" href="./index.php" role="button">Voltar no Remover Horário</a>
        <a class="btn btn-fatec-red btn-lg btn-block rounded-botton" href="../index.php" role="button">Voltar para o menu</a>
    </div>
</body>
</html>
';
?>
