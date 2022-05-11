<?php

namespace App\Models;

class AddressModel extends BaseModel
{
    protected $table = 'address';

    public function __construct()
    {
        parent::__construct();
    }

    public function getAddressByIntegrationViaZipCode(string $cep = null)
    {
        if ($cep == null) {
            throw new \Exception("Error: É necessário informar o cep", 1);
        }

        try {
            return file_get_contents('https://viacep.com.br/ws/' . $cep . '/json/');
        } catch (\Exception $e) {
            throw new \Exception("Error: Não foi possível localizar o endereço", 1);
        }
    }
}
