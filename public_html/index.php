<?php

namespace App;

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");
    }
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }
    exit(0);
}



require_once('../vendor/autoload.php');


// Verificação Basica de Token da API

if ($_SERVER['HTTP_TOKEN'] !== HTTP_TOKEN) {
    echo json_encode(['status' => false,'data' => 'Token de Autorização inválido'], JSON_UNESCAPED_UNICODE);
                exit;
}



$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_SPECIAL_CHARS);

if ($url) {
    $url = explode('/', $url);

    if (strtolower($url[0]) === 'api') {
        // Modificando o cabeçalho para JSON
        header('Content-Type: application/json');

        if (count($url) < 2) {
            echo json_encode(['status' => false,'data' => 'Não foi possível localizar a class selecionada'], JSON_UNESCAPED_UNICODE);
                exit;
        }

        array_shift($url);

        $controller = $url[0];
        array_shift($url);

        $params = $url;
        switch ($_SERVER["REQUEST_METHOD"]) {
            case "GET":
                $method = "GET";
                break;
            case "POST":
                $method = "POST";
                break;
            case "PUT":
                $method = "PUT";
                parse_str(file_get_contents("php://input"), $_POST);
                break;
            case "DELETE":
                $method = "DELETE";
                break;
            default:
                $method = null;
                break;
        }

        if ($method == null) {
            http_response_code(404);
            echo json_encode(['status' => false,'data' => 'Método não suportado'], JSON_UNESCAPED_UNICODE);
            exit;
        }

        $method = strtolower($method);
        $className = __NAMESPACE__ . '\\Controller\\' . ucwords($controller);

        try {
            // Verifica se a entidade chamada existe
            if (!class_exists($className)) {
                http_response_code(404);
                echo json_encode(['status' => false,'data' => 'Não foi possível localizar a class selecionada'], JSON_UNESCAPED_UNICODE);
                exit;
            }

            // Verifica se o metodo chamado existe
            if (!method_exists($className, $method)) {
                http_response_code(404);
                echo json_encode(['status' => false,'data' => 'Não foi possível localizar o método selecionado'], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $response = call_user_func_array(array( new $className(), $method), $params);

            echo json_encode(['status' => true,'data' => $response], JSON_UNESCAPED_UNICODE);
            exit;
        } catch (\Exception $e) {
            http_response_code(404);
            echo json_encode(['status' => false,'data' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }
} else {
    echo '<h1>Controle padrão</h1>';
}
