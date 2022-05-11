<?php

namespace App\Controller;

use App\Models\AddressModel;

class Address
{
    private $AddressModel;

    public function __construct()
    {
        $this->AddressModel = new AddressModel();
    }
}
