<?php

namespace App;

require_once('../vendor/autoload.php');

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
            if (!class_exists($className)) {
                http_response_code(404);
                echo json_encode(['status' => false,'data' => 'Não foi possível localizar a class selecionada'], JSON_UNESCAPED_UNICODE);
                exit;
            }

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
