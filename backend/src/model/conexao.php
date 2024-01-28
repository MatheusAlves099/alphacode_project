<?php
/**********************************************************************************
 * Objetivo: Arquivo responsável pela conexão com o banco de dados.
 * Autor: Matheus Alves
 * Data: 24/01/2024
 * Versão: 1.0
 ***********************************************************************************/

 $hostname = "localhost";
 $bancodedados = "db_alphacode";
 $usuario = "root";
 $senha = "12345";

 $mysqli = new mysqli($hostname, $usuario, $senha, $bancodedados);
 if ($mysqli->connect_errno) {
     echo "falha ao conectar:(" . $mysqli->connect_errno . ")" . $mysqli->connect_errno;
 }
 else
     echo "Conectado ao Banco de Dados";
?>