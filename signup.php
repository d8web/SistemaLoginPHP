<?php
    require_once 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Cadastro - Devsbook</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1"/>
    <link rel="stylesheet" href="<?=$base;?>/assets/css/login.css" />
</head>
<body>
    <header>
        <div class="container">
            <a class="title-login" href="<?=$base;?>">Sitema de Cadastro</a>
        </div>
    </header>
    <section class="container main">
        <form method="POST" action="<?=$base;?>/signup_action.php">

            <?php if(!empty($_SESSION['flash'])): ?>
                <div class="flash">
                    <?=$_SESSION['flash'];?>
                    <?=$_SESSION['flash'] = '';?>
                </div>
            <?php endif; ?>
            
            <input placeholder="Digite seu Nome Completo" class="input" type="text" name="name" />

            <input placeholder="Digite seu e-mail" class="input" type="email" name="email" />

            <input placeholder="Digite sua senha" class="input" type="password" name="password" />

            <input placeholder="Digite sua Data de Nascimento" class="input" type="text"
            name="birthdate" id="birthdate" />

            <input class="button" type="submit" value="Fazer Cadastro" />

            <a href="<?=$base;?>/login.php">Já tem conta? Faça o Login</a>
        </form>
    </section>

    <script src="https://unpkg.com/imask"></script>
    <script src="<?=$base;?>/assets/js/script.js"></script>
</body>
</html>