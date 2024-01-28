<?php

/***************************************************************************************
 * Objetivo: API para integração entre backend e banco de dados (GET, POST, PUT, DELETE)
 * Data: 24/01/2024
 * Autor: Matheus Alves
 * Versão: 1.0
 ***************************************************************************************/

header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header('Content-Type: application/json');

require_once('./vendor/autoload.php');
require_once('./src/controller/controllerUsuarios.php');
include("./src/model/conexao.php");

$config = ['settings' => ['displayErrorDetails' => true]];
$app = new \Slim\App($config);

//EndPoint: Retorna todos os usuários.
$app->get('/usuarios', function ($request, $response, $args) {

    if ($dadosUser = getUsers()) {

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write($dadosUser);
    } else {
        return $response->withStatus(404);
    }
});

//EndPoint: Retorna um usuário filtrando pelo ID.
$app->get('/usuarios/{id}', function ($request, $response, $args) {

    $id = $args['id'];

    if ($dadosUser = getUsersByID($id)) {

        return $response->withStatus(200)
            ->withHeader('Content-Type', 'application/json')
            ->write($dadosUser);
    } else {
        return $response->withStatus(404);
    }
});

//EndPoint: Insere um novo usuário.
$app->post('/usuarios', function ($request, $response, $args) {

    $contentTypeHeader = $request->getHeaderLine('Content-Type');
    $contentType =  explode(";", $contentTypeHeader);

    switch ($contentType[0]) {

        case 'application/json':
            $dadosBody = $request->getParsedBody();
            $arrayDados = array($dadosBody);
            $resposta = insertUser($arrayDados);
            $dadosJSON = createJSON($resposta);

            if ($resposta == true) {

                return $response->withStatus(201)
                    ->withHeader('Content-Type', 'application/json')
                    ->write($dadosJSON);
            } elseif (is_array($resposta)) {

                return $response->withStatus(400)
                    ->withHeader('Content-Type', 'application/json')
                    ->write($dadosJSON);
            }

            break;

        case 'multipart/form-data':

        default:

            return $response->withStatus(415)
                ->withHeader('Content-Type', 'application/json')
                ->write('{"status": 415, "message": "O tipo de mídia Content-type da solicitação não é compatível com o servidor. Tipo aceito:[application/json]"}');

            break;
    }
});

//EndPoint: Atualiza um contato existente pelo ID.
$app->put('/usuarios/{id}', function ($request, $response, $args) {

    if (is_numeric($args['id'])) {

        $id = $args['id'];
        $contentTypeHeader = $request->getHeaderLine('Content-Type');
        $contentType =  explode(";", $contentTypeHeader);

        switch ($contentType[0]) {

            case 'application/json':

                $dadosBody = $request->getParsedBody();

                $arrayDados = array(
                    $dadosBody,
                    "id" => $id,
                );

                $resposta = updateUser($arrayDados);
                $dadosJSON = createJSON($resposta);

                if ($resposta == true) {

                    return $response->withStatus(200)
                        ->withHeader('Content-Type', 'application/json')
                        ->write($dadosJSON);
                } elseif (is_array($resposta)) {

                    return $response->withStatus(400)
                        ->withHeader('Content-Type', 'application/json')
                        ->write($dadosJSON);
                }

                break;

            case 'multipart/form-data':

            default:

                return $response->withStatus(415)
                    ->withHeader('Content-Type', 'application/json')
                    ->write('{"status": 415, "message": "O tipo de mídia Content-type da solicitação não é compatível com o servidor. Tipo aceito:[application/json]"}');
                break;
        }
    } else {

        return $response->withStatus(400)
            ->withHeader('Content-Type', 'application/json')
            ->write('{"status": 400, "message": "O ID informado não é válido. Digite um número e tente novamente."}');
    }
});

//EndPoint: Deleta um usuário existente pelo ID.
$app->delete('/usuarios/{id}', function ($request, $response, $args) {

    if (is_numeric($args['id'])) {

        $id = $args['id'];
        $resposta = deleteUser($id);

        if ($resposta == true) {

            return $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($resposta));
        } else {

            return $response->withStatus(404)
                ->withHeader('Content-Type', 'application/json')
                ->write(json_encode($resposta));
        }
    } else {

        return $response->withStatus(404)
            ->withHeader('Content-Type', 'application/json')
            ->write('{"status": 400, "message": "O ID informado não é válido. Digite um número e tente novamente."}');
    }
});

$app->run()

?>