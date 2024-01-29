<?php

/********************************************************************************************
 * Objetivo: Arquivo responsável pelo gerenciamento dos dados dos usuários no banco de dados.
 * Autor: Matheus Alves
 * Data: 24/01/2024
 * Versão: 1.0
 *******************************************************************************************/

require_once('./src/model/conexao.php');

//Função para listar todos os usuários
function selectAllUsers()
{
    $conexao = conexaoBancoDeDados();

    $sql = "select * from tbl_usuario order by id desc";

    $result = mysqli_query($conexao, $sql);

    if ($result) {

        $cont = 0;

        while ($rsDados = mysqli_fetch_assoc($result)) {

            $arrayDados[$cont] = array(
                "id"                 =>  $rsDados['id'],
                "nome"               =>  $rsDados['nome'],
                "data_nascimento"    =>  $rsDados['data_nascimento'],
                "email"              =>  $rsDados['email'],
                "profissao"          =>  $rsDados['profissao'],
                "telefone"           =>  $rsDados['telefone'],
                "celular"            =>  $rsDados['celular'],
                "numero_whatsapp"    =>  $rsDados['numero_whatsapp'],
                "notificacoes_email" =>  $rsDados['notificacoes_email'],
                "notificacoes_sms"   =>  $rsDados['notificacoes_sms'],
            );
            $cont++;
        }

        if (isset($arrayDados))
            return $arrayDados;
        else
            return false;
    }
}

//Função para buscar um usuário pelo ID
function selectUserByID($id)
{
    $conexao = conexaoBancoDeDados();

    $sql = "select * from tbl_usuario where id =" . $id;

    $result = mysqli_query($conexao, $sql);

    if ($result) {

        while ($rsDados = mysqli_fetch_assoc($result)) {

            $arrayDados = array(
                "id"                 =>  $rsDados['id'],
                "nome"               =>  $rsDados['nome'],
                "data_nascimento"    =>  $rsDados['data_nascimento'],
                "email"              =>  $rsDados['email'],
                "profissao"          =>  $rsDados['profissao'],
                "telefone"           =>  $rsDados['telefone'],
                "celular"            =>  $rsDados['celular'],
                "numero_whatsapp"    =>  $rsDados['numero_whatsapp'],
                "notificacoes_email" =>  $rsDados['notificacoes_email'],
                "notificacoes_sms"   =>  $rsDados['notificacoes_sms'],
            );
        }

        if (isset($arrayDados))
            return $arrayDados;
        else
            return false;
    }
}

//Função para inserir um novo usuário
function createUser($dadosUser)
{

    $statusResposta = (bool) false;

    $conexao = conexaoBancoDeDados();

    $sql = "insert into tbl_usuario (
            nome, 
            data_nascimento, 
            email, 
            profissao, 
            telefone,
            celular,
            numero_whatsapp,
            notificacoes_email,
            notificacoes_sms
            ) values (
            '" . $dadosUser['nome'] . "', 
            '" . $dadosUser['data_nascimento'] . "', 
            '" . $dadosUser['email'] . "', 
            '" . $dadosUser['profissao'] . "', 
            '" . $dadosUser['telefone'] . "',
            '" . $dadosUser['celular'] . "',
            '" . $dadosUser['numero_whatsapp'] . "',
            '" . $dadosUser['notificacoes_email'] . "',
            '" . $dadosUser['notificacoes_sms'] . "'
    );";

    if (mysqli_query($conexao, $sql)) {

        if (mysqli_affected_rows($conexao))
            $statusResposta = true;
    }

    return $statusResposta;
}

//Função para atualizar um usuário existente
function userUpdate($dadosUser)
{
    $statusResposta = (bool) false;

    $conexao = conexaoBancoDeDados();

    $sql = "update tbl_usuario set 
            nome                 = '" . $dadosUser['nome'] . "', 
            data_nascimento      = '" . $dadosUser['data_nascimento'] . "', 
            email                = '" . $dadosUser['email'] . "', 
            profissao            = '" . $dadosUser['profissao'] . "', 
            telefone             = '" . $dadosUser['telefone'] . "',
            celular              = '" . $dadosUser['celular'] . "',
            numero_whatsapp      = '" . $dadosUser['numero_whatsapp'] . "',
            notificacoes_email   = '" . $dadosUser['notificacoes_email'] . "',
            notificacoes_sms     = '" . $dadosUser['notificacoes_sms'] . "'
            WHERE id = " . $dadosUser['id'];


    if (mysqli_query($conexao, $sql))
        $statusResposta = true;

        return $statusResposta;
}

//Função para deletar um usuário existente
function userDelete($id)
{
    $statusResposta = (bool) false;

    $conexao = conexaoBancoDeDados();

    $sql = "delete from tbl_usuario where id = " . $id;

    if (mysqli_query($conexao, $sql)) {
        if (mysqli_affected_rows($conexao))
            $statusResposta = true;
    }

    return $statusResposta;
}

//Função que retorna o último ID inserido
function selectLastId()
{

    $conexao = conexaoBancoDeDados();

    $sql = "select * from tbl_usuario order by id desc limit 1";

    $result = mysqli_query($conexao, $sql);

    if ($result) {

        while ($rsDados = mysqli_fetch_assoc($result)) {

            $arrayDados = array(
                "id"                =>  $rsDados['id'],
                "nome"              =>  $rsDados['nome'],
                "data_nascimento"   =>  $rsDados['data_nascimento'],
                "email"             =>  $rsDados['email'],
                "profissao"         =>  $rsDados['profissao'],
                "telefone"          =>  $rsDados['telefone'],
                "celular"           =>  $rsDados['celular'],
                "numero_whatsapp"   =>  $rsDados['numero_whatsapp'],
                "notificacoes_email" =>  $rsDados['notificacoes_email'],
                "notificacoes_sms"   =>  $rsDados['notificacoes_sms'],
            );
        }

        if (isset($arrayDados))
            return $arrayDados;
        else
            return false;
    }
}