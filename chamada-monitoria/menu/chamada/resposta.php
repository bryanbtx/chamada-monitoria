<?php
$response;
if($_SERVER['REQUEST_METHOD']=='GET'){
	if(isset($_GET['m'])){
		switch ($_GET['m']) {
            case 0:
                $response="Chamada realizada com sucesso!";
                break;
            case 1:
                $response="Você não deu presença para nenhum aluno!";
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
        <form action=".">
            <p>'.$response.'</p>
            <button type="submit">Voltar</button>
        </form>
        <form action="..">
			<button type="submit">Ir para o menu</button>
		</form>
    </div>
</body>
</html>
';
?>
