<?php
$servidor = "127.0.0.1";
$utilizador = "root";
$pass = "";
$bd = "bill_v8e1";
//$bd = "hns";
try {
    //conecta o php com a base de dados:
    $pdo = new PDO("mysql:host=$servidor;dbname=$bd;charset=UTF8", $utilizador, $pass);
    //set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro ao conectar a base de dados: " . $e->getMessage();
}
?>