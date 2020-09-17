# SistemaLoginPHP
Sistema de Login feito em PHP estrutural.

Para usar esse sistema, basta criar um banco de dados sql e renomear o nome do banco no arquivo config.php.
Em seguida importar a base de dados users.sql.

É necessário também mudar o nome da url base também no arquivo no arquivo config.php.

O usuário vem em forma de objeto, para acessar as propriedades do mesmo basta usar a variável.

Ex:
$userInfo->name.
$userInfo->email.
$userInfo->birthdate.
