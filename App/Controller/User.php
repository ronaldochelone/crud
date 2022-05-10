<?php

namespace App\Controller;

use App\Models\UserModel;

class User
{
    private $userModel;
    private $requiredFields = ['nome','email','data_nascimento','telefone','cpf','cep'];

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
                                    ['id' => $id]
                                ] : null;

        http_response_code(200);
        return $this->userModel->get($fields, $where);
    }

    /**
     * Grava as informções do Usuário
     *
     * @return string // Mensagem de Sucesso ou Erro
     */
    public function post(): string
    {

        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_ADD_SLASHES);

        // Verifica se os campos requiridos estão present.
        foreach ($this->requiredFields as $key => $value) {
            if (!isset($_POST[$value]) || empty($_POST[$value])) {
                throw new \Exception("Error: É necessário enviar os todos dados para inserir o usuário", 1);
            }
        }

        $rs = $this->userModel->insert($_POST);

        return ($rs > 0) ? 'Usuário inserido com Sucesso' : $rs;
    }

    public function put($id = null): string
    {

        $_REQUEST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_ADD_SLASHES);

        if ($id == null) {
            throw new \Exception("Error: É necessário o id do usuário a ser atualizado", 1);
        }

        //Verifica se o usuário existe.
        $rs = $this->userModel->get(null, ['id' => $id]);

        if (!$rs) {
            throw new \Exception("Error: Não foi possível localizar o usuário", 1);
        }




        $data = $_POST;
        $where = ['id' => $id];

        $rs = $this->userModel->update($data, $where);

        return ($rs > 0) ? 'Usuário atualizado com Sucesso' : 'Não foi possível atualizar o usuário';
    }

    public function delete()
    {
        echo __FUNCTION__;
    }
}
