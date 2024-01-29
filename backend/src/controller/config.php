<?php

/***************************************************************************************
* Objetivo: Arquivo responsável pelas váriaveis e constantes de todo o projeto.
* Data: 24/01/2024
* Autor: Matheus Alves
* Versão: 1.0
***************************************************************************************/

$SUCCESS_STATUS = array('status' => 200, 'message' => 'Requisição bem sucedida!');

define('NEW_JSON', '{"status": 200, "message": "Requisição bem sucedida!"}');

function createJSON ($arrayDados)
    {
        //Validação para tratar array sem dados
        if (!empty($arrayDados))
        {
            //configura o padrão da conversão para o formato JSON
            header('Content-Type: application/json');
            $dadosJSON = json_encode($arrayDados);
            
            //json_encode(); - converte um array para JSON
            return $dadosJSON;
        }else
        {
            return false;
        }
    }
?>