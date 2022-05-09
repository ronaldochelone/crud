<?php

namespace App\Controller;

use App\Models\UserModel;

class User
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Lista as informações de um ou mais usuários
     *
     * @param integer|null $id
     * @return array
     */
    public function get($id = null): array
    {
        $fields = null;

        $where = ($id != null) ? [
                                    //['nome' => 'Fulano'], Caso Precise de mais alguns filtro no GET
                                    ['id' => $id]
                                ] : null;

        http_response_code(200);
        return $this->userModel->get($fields, $where);
    }

    /**
     * Grava as informções do Usuário
     *
     * @return void
     */
    public function post()
    {
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_ADD_SLASHES);

        $rs = $this->userModel->insert($_POST);

        if ($rs > 0) {
            return 'Usuário inserido com Sucesso';
        } else {
            return $rs;//throw new \Exception("Error ao inserir o usuário", 1);
        }

        return $_POST;
    }

    public function put()
    {
        echo __FUNCTION__;
    }

    public function delete()
    {
        echo __FUNCTION__;
    }
}
