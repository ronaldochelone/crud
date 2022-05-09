<?php

namespace App\Db;

class DataBase
{
    private $con;

    /**
     * Construtor da Class DataBase
     */

    public function __construct()
    {
        $this->con = new \PDO(DBDRIVE . ':' . 'host=' . DBHOST . ';dbname=' . DBNAME, DBUSER, DBPASS);
    }

    /**
     * Realliza Consultas nas Entidades do Sistema
     *
     * @param string $table
     * @param string|array $fields
     * @param array|null $where
     * @return array
     */
    public function get(string $table = null, array $fields = null, array $where = null): array
    {
        if (!$table) {
            throw new \Exception("Error: É necessário informar a tabela.", 1);
            exit;
        }

        try {
            $sql = "SELECT";

            $sql .= (is_array($fields)) ? implode(',', $fields) : ' * ';

            $sql .= " FROM " . $table;

            // Builder Where
            if ($where) {
                $sql .= " WHERE ";
                $contParameter = 0;

                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        foreach ($value as $keyParameter => $parametFilter) {
                            $sql .= $keyParameter . ' = :' . $keyParameter;
                            $sql .= ($contParameter < (count($where) - 1)) ? " AND " : "";

                            $contParameter++;
                        }
                    }
                }
            }

            $stmt = $this->con->prepare($sql);

            // Bind Value In SQL String
            if ($where) {
                foreach ($where as $value) {
                    if (is_array($value)) {
                        foreach ($value as $key => $valueParameter) {
                            $bindKey = ':' . $key;
                            $bindValue = $valueParameter;
                            $stmt->bindValue($bindKey, $bindValue);
                        }
                    }
                }
            }


            $stmt->execute();

            $rs = $stmt->fetch(\PDO::FETCH_ASSOC);
            return ($rs) ? $rs : [];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Undocumented function
     *
     * @param string|null $table
     * @param array|null $data
     * @return int| numero do registro inserido
     *
     */
    public function insert(string $table = null, array $data = null): int
    {
        if (!$table) {
            throw new \Exception("Error: É necessário informar a tabela.", 1);
            exit;
        }

        try {
            $sql = "INSERT INTO " . $table;
            $sql .= " ( " . implode(',', array_keys($data)) . " )";
            $sql .= " VALUES ( ";


            foreach ($data as $key => $value) {
                $sql .= '?,';
            }

            $sql = substr($sql, 0, -1);

            $sql .= ")";

            $stmt = $this->con->prepare($sql);
            $stmt->execute(array_values($data));
            return ($stmt->rowCount() > 0) ? $stmt->lastInsertId() : -1;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(string $table = null, array $condition = null)
    {
    }

    public function delete(string $table = null, array $condition = null)
    {
    }
}
