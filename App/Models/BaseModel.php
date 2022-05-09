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
     * Pesquisa as Entidades do Sistema
     *
     * @param [type] $id
     * @return array
     */

    public function get(array $fields = null, array $where = null): array
    {
        return $this->db->get($this->table, $fields, $where);
    }

     /**
     * Inseri dados nas Entidades do Sistema
     *
     * @param [type] $data
     * @return int
     */
    public function insert(array $data = null): int
    {
        return $this->db->insert($this->table, $data);
    }
}
