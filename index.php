<?php
require_once 'config.php';
require_once 'models/Auth.php';

$auth = new Auth($pdo, $base);
$userInfo = $auth->checkToken();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=$base;?>/assets/css/style.css">
    <title>Página Inicial</title>
</head>
<body>
    
    <div class="pagina-inicial">
        <h1>Bem vindo <?=$userInfo->name;?>!</h1>
        <a href="<?=$base;?>/logout.php">Sair</a>
    </div>

</body>
</html>