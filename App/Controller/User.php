<?php

namespace App\Controller;

use App\Models\UserModel;
use App\Models\AddressModel;

class User
{
    private $userModel;
    private $requiredFields = ['nome','email','data_nascimento','telefone','cpf','cep',];
    private $dataRequest = null;

    public function __construct()
    {
        $this->userModel = new UserModel();

         // Verifica o modelo de entrada de dados
        if (!empty(file_get_contents("php://input"))) {
            $this->dataRequest =  json_decode(file_get_contents("php://input"), true);
        } else {
            $this->dataRequest = filter_input_array(INPUT_POST, FILTER_SANITIZE_ADD_SLASHES);
        }
    }

    /**
     * Lista as informações de um ou mais usuários
     *
     * @param integer|null $id
     * @return array
     */
    public function get($id = null): array
    {
        $addressModel = new AddressModel();

        $fields = null;

        // É possível passar mais de um parâmetro para a pesquisar os registros.
        $where = ($id != null) ? [
                                    ['id' => $id]
                                ] : null;


        // Retorna a lista de usuários
        $userList = $this->userModel->get($fields, $where);

        // Pesquisa Endereço na Tabela de Endereços Pelo Cep
        foreach ($userList as $key => $value) {
            $r = $addressModel->get(null, ['cep' => $value['cep']]);
            if ($r) {
                $userList[$key]['address'] = ($r[0]) ? $r[0] : null;
            }
        }

        http_response_code(200);
        return $userList;
    }

    /**
     * Grava as informções do Usuário
     *
     * @return string // Mensagem de Sucesso ou Erro
     */
    public function post(): string
    {
        // Variavel de inserção
        $data = $this->dataRequest;
        $data['cep'] = str_replace('-', '', $data['cep']);

        // Verifica se os campos requiridos estão present.
        foreach ($this->requiredFields as $key => $value) {
            if (!isset($data[$value]) || empty($data[$value])) {
                throw new \Exception("Error: É necessário enviar os todos dados para inserir o usuário", 1);
            }
        }

        $rs = $this->userModel->insert($data);

        if ($rs > 0) {
            $cep =  $data['cep'];

            $rs = $this->insertUpdateAddress($cep);
            return ($rs > 0) ? 'Usuário inserido com Sucesso' : $rs;
        }

        return  $rs;
    }

    /**
     * Atualiza as informções do Usuário
     *
     * @param integer|null $id
     * @return string
     */
    public function put(int $id = null): string
    {
        // Variavel de Atualização
        $data = $this->dataRequest;

        $data['cep'] = str_replace('-', '', $data['cep']);

        if ($id == null) {
            throw new \Exception("Error: É necessário o id do usuário a ser atualizado", 1);
        }

        //Verifica se o usuário existe.
        $rs = $this->userModel->get(null, ['id' => $id]);

        if (!$rs) {
            throw new \Exception("Error: Não foi possível localizar o usuário", 1);
        }

        // É possível passar mais de um parâmetro para a atualização do registro.
        $where = [
            ['id' => $id],
            //['nome' => 'fulano']
        ];

        $rs = $this->userModel->update($data, $where);

        if ($rs > 0) {
            $cep =  $data['cep'];

            $rs = $this->insertUpdateAddress($cep);

            return ($rs > 0) ? 'Usuário atualizado com Sucesso'  : $rs;
        }

        return  'Não foi possível atualizar o usuário';
    }

    /**
     * Remove o Usuário
     *
     * @param integer|null $id
     * @return string
     */
    public function delete(int $id = null): string
    {

        if ($id == null) {
            throw new \Exception("Error: É necessário o id do usuário a ser deletado", 1);
        }

        //Verifica se o usuário existe.
        $rs = $this->userModel->get(null, ['id' => $id]);

        if (!$rs) {
            throw new \Exception("Error: Não foi possível localizar o usuário a ser deletado", 1);
        }

        // É possível passar mais de um parâmetro para a remoção do registro.
        $where = [
           ['id' => $id],
           //['nome' => 'fulano']
        ];

        $rs = $this->userModel->delete($where);

        return ($rs > 0) ? 'Usuário deletado com Sucesso' : 'Não foi possível remover o usuário';
    }

    /**
     * Função que insere ou Atualiza endereço do usuário
     *
     * @param string|null $cep
     * @return void
     */
    private function insertUpdateAddress(string $cep = null)
    {
        $cep = str_replace('-', '', $cep);

        $addressModel = new AddressModel();

        try {
            $result = json_decode($addressModel->getAddressByIntegrationViaZipCode($cep), true);

            if (isset($result['erro'])) {
                throw new \Exception("Error: Não foi possível localizar o endereço", 1);
            }

            //Parse de Variáveis
            $newCep = str_replace('-', '', $result['cep']);

            $where = ['cep' => $newCep];

            $result['cep'] = $newCep;
            $result['cidade'] = utf8_decode($result['localidade']);
            $result['estado'] = utf8_decode($result['uf']);

            // Remover itens não necessários
            unset($result['ibge']);
            unset($result['gia']);
            unset($result['ddd']);
            unset($result['siafi']);
            unset($result['localidade']);
            unset($result['complemento']);
            unset($result['uf']);

            $listAddress =  $addressModel->get(null, $where);

            // Verifica se existe o Endereço
            return (!$listAddress) ? $addressModel->insert($result) : $addressModel->update($result, $where);
        } catch (\Throwable $th) {
            throw new \Exception("Error: Não foi possível localizar o endereço", 1);
        }
    }
}
