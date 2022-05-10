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
     * Pesquisa as Entidades do Sistema.
     *
     * @param [type] $id
     * @return array
     */

    public function get(array $fields = null, array $where = null): array
    {
        return $this->db->get($this->table, $fields, $where);
    }

     /**
     * Inseri dados nas Entidades do Sistema.
     *
     * @param [type] $data
     * @return int
     */
    public function insert(array $data = null): int
    {
        return $this->db->insert($this->table, $data);
    }

    /**
     * Atualiza os dados das Entidades do Sistema.
     *
     * @param array|null $data
     * @param array|null $where
     * @return integer
     */
    public function update(array $data = null, array $where = null): int
    {
        return $this->db->update($this->table, $data, $where);
    }


    public function delete(array $where = null)
    {
        return $this->db->delete($this->table, $where);
    }
}
