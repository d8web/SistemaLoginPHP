<?php

session_start();
$base = 'http://localhost/sistemaLogin';

$dbName = 'loginsistem';
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';

try {
    $pdo = new PDO('mysql:dbname='.$dbName.';host='.$dbHost, $dbUser, $dbPass);
}
catch(PDOException $e)
{
    echo 'Erro na conexão: '.$e->getMessage();
}