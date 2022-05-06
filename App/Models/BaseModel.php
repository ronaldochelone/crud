<?php

namespace App\Models;

use App\Db\DataBase;

class BaseModel
{
    protected $table;
    protected $db = null;

    public function __construct()
    {
        $this->db = new DataBase();
    }

    /**
     * GET Entity
     *
     * @param [type] $id
     * @return array
     */

    public function get(array $fields = null, array $where = null): array
    {
        return $this->db->get($this->table, $fields, $where);
    }
}
