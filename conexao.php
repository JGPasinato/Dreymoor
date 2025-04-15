<?php 

    $hostname = "localhost";
    $bancodedados = "reunioes_db";
    $usuario = "root";
    $senha = "";


    $mysql = new mysqli($hostname, $usuario, $senha, $bancodedados);
    if ($mysql->connect_errno) {
        die("Falha na conexão: " . $mysql->connect_error);
    } else {
        // echo "Conexão bem-sucedida!";
    }






?>