<?php

/*************************************************************************************
 * Objetivo: Arquivo responsável pelo gerenciamento dos dados dos usuários no sistema.
 * Data: 24/01/2023
 * Versão: 1.0
 ***********************************************************************************/

require_once('./src/model/DAO/usuariosDAO.php');

//Função que retorna a lista de todos os usuários
function getUsers() {
    $dados = selectAllUsers();

    if(!empty($dados)) {

        return array(
            'status' => 200,
            'message' => 'Requisição realizada com sucesso!',
            'quantidade' => count($dados),
            'dados' => $dados
        );

    } else
        return array (
            'status' => 404,
            'message' => 'Nenhum usuário encontrado.',
        );
}

//Função que retorna um usuário pelo ID
function getUsersByID($id) {
    if($id == 0 || empty($id) || !is_numeric($id)) {
        $dados = selectUsersByID($id);

        if(!empty($dados)) {

            return array(
                'status' => 200,
                'message' => 'Requisição realizada com sucesso!',
                'dados' => $dados
            );
        } else {
            return array (
                'status' => 404,
                'message' => 'Nenhum usuário encontrado.'
            );
        }
    } else {
        $dadosArray = array (
            'status' => 400,
            'message' => 'Não foi possível realizar a busca, pois, o ID informado é inválido ou inexistente.'
        );
        $dadosUsersJSON = json_encode($dadosArray);

        return $dadosUsersJSON;
    }
}

//Função que insere um novo usuário
function insertUser($dadosUser) {
    if (
        empty($dadosUser[0]['nome'])                      || is_numeric($dadosUser[0]['nome'])            || strlen($dadosUser[0]['nome'])            > 150           ||
        empty($dadosUser[0]['data_nascimento'])           || is_numeric($dadosUser[0]['data_nascimento']) || strlen($dadosUser[0]['data_nascimento']) > 10            ||
        empty($dadosUser[0]['email'])                     || is_numeric($dadosUser[0]['email'])           || strlen($dadosUser[0]['email'])           > 255           ||
        empty($dadosUser[0]['profissao'])                 || is_numeric($dadosUser[0]['profissao'])       || strlen($dadosUser[0]['profissao'])       > 150           ||
        empty($dadosUser[0]['telefone'])                  || is_numeric($dadosUser[0]['telefone'])        || strlen($dadosUser[0]['telefone'])        > 18            ||
        empty($dadosUser[0]['celular'])                   || is_numeric($dadosUser[0]['celular'])         || strlen($dadosUser[0]['celular'])         > 18            ||
        !is_numeric($dadosUser[0]['numero_whatsapp'])     ||
        !is_numeric($dadosUser[0]['notiificacoes_email']) ||
        !is_numeric($dadosUser[0]['notificacoes_sms'])
    ) {
        $errorRequiredFields = array (
            'status' => 400,
            'message' => 'Algum campo obrigatório não foi preenchido corretamente, favor verificar.'
        );

        return $errorRequiredFields;

    } else {
        $arrayDados = array(
            "nome"              => $dadosContato[0]['nome'],
            "data_nascimento"   => $dadosContato[0]['data_nascimento'],
            "email"             => $dadosContato[0]['email'],
            "profissao"         => $dadosContato[0]['profissao'],
            "telefone"          => $dadosContato[0]['telefone'],
            "celular"           => $dadosContato[0]['celular'],
            "numero_whatsapp"   => $dadosContato[0]['numero_whatsapp'],
            "notificacoes_email" => $dadosContato[0]['notificacoes_email'],
            "notificacoes_sms"   => $dadosContato[0]['notificacoes_sms']
        );

        if (insertUser($arrayDados)) {

            $newUser = selectLastId();

            $sucessCreateItem = array(
                'status'    => 201,
                'message'   => 'Item criado com sucesso!',
                'usuario'   => $newUser
            );

            return $sucessCreateItem;

    } else {
        $errorRequiredFields = array(
            'status' => 500,
            'message' => 'Erro interno. Não foi possível a requisição.'
        );
        return $errorInternalServer;
        }
    }
}

//Função que atualiza um usuário já existente
function updateUser($dadosUser) {

    $id = $dadosUser['id'];

    if (
        empty($dadosUser[0]['nome'])                      || is_numeric($dadosUser[0]['nome'])            || strlen($dadosUser[0]['nome'])            > 150           ||
        empty($dadosUser[0]['data_nascimento'])           || is_numeric($dadosUser[0]['data_nascimento']) || strlen($dadosUser[0]['data_nascimento']) > 10            ||
        empty($dadosUser[0]['email'])                     || is_numeric($dadosUser[0]['email'])           || strlen($dadosUser[0]['email'])           > 255           ||
        empty($dadosUser[0]['profissao'])                 || is_numeric($dadosUser[0]['profissao'])       || strlen($dadosUser[0]['profissao'])       > 150           ||
        empty($dadosUser[0]['telefone'])                  || is_numeric($dadosUser[0]['telefone'])        || strlen($dadosUser[0]['telefone'])        > 18            ||
        empty($dadosUser[0]['celular'])                   || is_numeric($dadosUser[0]['celular'])         || strlen($dadosUser[0]['celular'])         > 18            ||
        !is_numeric($dadosUser[0]['numero_whatsapp'])     ||
        !is_numeric($dadosUser[0]['notiificacoes_email']) ||
        !is_numeric($dadosUser[0]['notificacoes_sms'])
    ) {
        $errorRequiredFields = array (
            'status' => 400,
            'message' => 'Algum campo obrigatório não foi preenchido corretamente, favor verificar.'
        );

        return $errorRequiredFields;

    } else if ($id == 0 || empty($id) || !is_numeric($id)) {
        $IDInvalidError = array (
            'status' => 400,
            'message' => 'O ID informado é inválido ou não foi digitado corretamente.'
        );

        return $IDInvalidError;

    } else {

        $statusId = selectUserByID($id);

        if ($statusId) {

            $arrayDados = array(
                "id"                 => $id,
                "nome"               => $dadosUser[0]['nome'],
                "data_nascimento"    => $dadosUser[0]['data_nascimento'],
                "email"              => $dadosUser[0]['email'],
                "profissao"          => $dadosUser[0]['profissao'],
                "telefone"           => $dadosUser[0]['telefone'],
                "celular"            => $dadosUser[0]['celular'],
                "numero_whatsapp"    => $dadosUser[0]['numero_whatsapp'],
                "notificacoes_email" => $dadosUser[0]['notificacoes_email'],
                "notificacoes_sms"   => $dadosUser[0]['notificacoes_sms']
            );

            if (updateUser($arrayDados, $id)) {

                $sucessUpdateItem = array(
                    'status'    => 200,
                    'message'   => 'Item atualizado com sucesso!',
                    'contato'   => $arrayDados
                );

                return $sucessUpdateItem;
            } else {

                $errorInternalServer = array(
                    'status' => 500,
                    'message' => 'Erro interno. Não foi possível a requisição.',
                );

                return $errorInternalServer;
            }
        } else {

            $errorIDNotFound = array(
                'status' => 404,
                'message' => 'O ID digitado está correto, mas não existe.',
            );

            return $errorIDNotFound;
        }
    }
}

//Função que deleta um usuário
function deleteUser($id){
    
    if ($id != 0 && !empty($id) && is_numeric($id)) {

        if(selectUserByID($id)){

            if (deleteUser($id)) {
                return array(
                    'status' => 200,
                    'message' => "O usuário foi deletado com sucesso!"
                );

            } else {
                return array(
                    'status'   => 500,
                    'message'  => 'Erro interno. Não foi possível a requisição.'
                );
            }

            } else {
            return array(
                'status'   => 404,
                'message'  => 'O ID informado é inválido!'
            );
        }
        
        } else {
        return array(
            'status' => 400,
            'message' => 'O ID informado na requisição não é válido ou não foi encaminhado.'
        );
    }
}