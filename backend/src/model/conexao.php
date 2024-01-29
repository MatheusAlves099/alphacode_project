<?php
/**********************************************************************************
 * Objetivo: Arquivo responsável pela conexão com o banco de dados.
 * Autor: Matheus Alves
 * Data: 24/01/2024
 * Versão: 1.0
 ***********************************************************************************/

const SERVER = "localhost";
const USER = "root";
const PASSWORD = "12345";
const DATABASE = "db_alphacode";

function conexaoBancoDeDados()
{
    $mysqli = new mysqli(SERVER, USER, PASSWORD, DATABASE);

    if ($mysqli->connect_errno) {
        echo "falha ao conectar: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    } else {
        echo "Conectado ao Banco de Dados";
    }

    return $mysqli;
}
?>