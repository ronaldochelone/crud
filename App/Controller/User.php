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
     * Get User
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

    public function post()
    {
        echo __FUNCTION__;
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
