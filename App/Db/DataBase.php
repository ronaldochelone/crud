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
                    } else {
                        $sql .= $key . ' = :' . $key;
                    }
                }
            }

            $stmt = $this->con->prepare($sql);


            // Bind Value In SQL String
            if ($where) {
                foreach ($where as $keyValue => $value) {
                    if (is_array($value)) {
                        foreach ($value as $key => $valueParameter) {
                            $bindKey = ':' . $key;
                            $bindValue = $valueParameter;
                            $stmt->bindValue($bindKey, $bindValue);
                        }
                    } else {
                        $bindKey = ':' . $keyValue;
                        $bindValue = $value;
                        $stmt->bindValue($bindKey, $bindValue);
                    }
                }
            }


            $stmt->execute();

            $rs = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return ($rs) ? $rs : [];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Realiza a inserção das Entidades
     *
     * @param string|null $table
     * @param array|null $data
     * @return integer| numero do registro inserido
     */
    public function insert(string $table = null, array $data = null): int
    {
        if (!$table) {
            throw new \Exception("Error: É necessário informar a tabela.", 1);
            exit;
        }

        if (!is_array($data)) {
            throw new \Exception("Error: É necessário informar os dados para serem inseridos.", 1);
            exit;
        }

        try {
            $dataFieds  = array_keys($data);
            $dataValues = array_values($data);
            $binds      = array_pad([], count($dataValues), '?');

            $sql = "INSERT INTO " . $table . " ( " . implode(',', $dataFieds) . " ) " . " VALUES ( " . implode(',', $binds) . " )";

            $stmt = $this->con->prepare($sql);

            $stmt->execute(array_values($data));
            return $this->con->lastInsertId();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Realiza a atualização das Entidades
     *
     * @param string|null $table
     * @param array|null $data
     * @param array|null $where
     * @return integer
     */
    public function update(string $table = null, array $data = null, array $where = null): int
    {
        if (!$table) {
            throw new \Exception("Error: É necessário informar a tabela.", 1);
            exit;
        }

        if (!is_array($data)) {
            throw new \Exception("Error: É necessário informar os dados para serem atualizados.", 1);
            exit;
        }

        if (!is_array($where)) {
            throw new \Exception("Error: É necessário informar as condições para serem atualizados.", 1);
            exit;
        }

        try {
            $dataFieds  = array_keys($data);
            $dataValues = array_values($data);

            $sql = "UPDATE " . $table . ' SET ';

            foreach ($dataFieds as $key => $value) {
                $sql .= $value . ' = "' . htmlspecialchars(addslashes($dataValues[$key])) . '",';
            }

            $sql = substr($sql, 0, -1);

            if ($where) {
                $sql .= " WHERE ";
                $contParameter = 0;
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        foreach ($value as $keyParameter => $parametFilter) {
                            $sql .= $keyParameter . ' = "' . htmlspecialchars(addslashes($parametFilter)) . '"';
                            $sql .= ($contParameter < (count($where) - 1)) ? " AND " : "";
                            $contParameter++;
                        }
                    } else {
                        $sql .= $key . ' = "' . htmlspecialchars(addslashes($value)) . '"';
                    }
                }
            }

            $stmt = $this->con->prepare($sql);
            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }


    /**
     * Remove um registro da Entidade
     *
     * @param string|null $table
     * @param array|null $where
     * @return integer
     */
    public function delete(string $table = null, array $where = null): int
    {
        if (!$table) {
            throw new \Exception("Error: É necessário informar a tabela.", 1);
            exit;
        }

/*
        try {
            $sql = "DELETE " . $table . ' SET ';

            foreach ($dataFieds as $key => $value) {
                $sql .= $value . ' = "' . htmlspecialchars(addslashes($dataValues[$key])) . '",';
            }

            $sql = substr($sql, 0, -1);

            if ($where) {
                $sql .= " WHERE ";
                $contParameter = 0;
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        foreach ($value as $keyParameter => $parametFilter) {
                            $sql .= $keyParameter . ' = "' . htmlspecialchars(addslashes($parametFilter)) . '"';
                            $sql .= ($contParameter < (count($where) - 1)) ? " AND " : "";
                            $contParameter++;
                        }
                    } else {
                        $sql .= $key . ' = "' . htmlspecialchars(addslashes($value)) . '"';
                    }
                }
            }

            $stmt = $this->con->prepare($sql);
            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }



        $sql = "DELETE FROM users WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        */


        return 1;
    }
}
