<?php

namespace bases;

use db\PDOInstance, PDOException, Exception;

abstract class BaseRepository {
    protected $table = "";
    protected $pdo;
    protected static $instance;

    protected function __construct() {
        $this->pdo = PDOInstance::getInstance()->getDbh();
        $stmt =  $this->pdo->query("SELECT * FROM users");
        while ($row = $stmt->fetch()) {
            echo $row['username']."<br />\n";
        }
    }

    public function getPDO() {
        return $this->pdo;
    }

    // Fungsi untuk mengambil data berdasarkan ID
    public function getOne($where) {
        try {
            $query = "SELECT * FROM {$this->table}";

            if (count($where) > 0) {
                $query .= " WHERE ";
                $conditions = [];

                foreach ($where as $key => $value) {
                    $conditions[] = "$key = :$key";
                }

                $query .= implode(" AND ", $conditions);
            }

            $stmt = $this->pdo->prepare($query);

            foreach ($where as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    // Fungsi untuk menambahkan data
    public function insert($data) {
        try {
            $columns = implode(', ', array_keys($data));
            $values = ':' . implode(', :', array_keys($data));
            $query = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($data);
            return true;

        } catch (PDOException $e) {

            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    // Fungsi untuk mengubah data berdasarkan ID
    public function update($where, $data) {
        try {
            $updateFields = '';
            foreach ($data as $key => $value) {
                $updateFields .= "$key = :$key, ";
            }
            $updateFields = rtrim($updateFields, ', ');

            $whereClause = '';
            foreach ($where as $key => $value) {
                $whereClause .= "$key = :where_$key AND ";
            }
            $whereClause = rtrim($whereClause, ' AND ');

            $query = "UPDATE {$this->table} SET $updateFields WHERE $whereClause";
            $stmt = $this->pdo->prepare($query);

            // Binding nilai update
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            // Binding nilai WHERE
            foreach ($where as $key => $value) {
                $stmt->bindValue(":where_$key", $value);
            }

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // Handle kesalahan koneksi atau query di sini
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    // Fungsi untuk menghapus data berdasarkan ID
    public function delete($where) {
        try {
            $query = "DELETE FROM {$this->table}";

        if (!empty($where)) {
            if (count($where) === 1) {
                $key = key($where);
                $value = current($where);
                $query .= " WHERE $key = :where_$key";
            } else {
                $whereClause = '';
                foreach ($where as $key => $value) {
                    $whereClause .= "$key = :where_$key AND ";
                }
                $whereClause = rtrim($whereClause, ' AND ');
                $query .= " WHERE $whereClause";
            }
        }

        $stmt = $this->pdo->prepare($query);

        foreach ($where as $key => $value) {
            $stmt->bindValue(":where_$key", $value);
        }

        $stmt->execute();
        return true;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;

        } catch (Exception $e) {
            echo "Error : " . $e->getMessage();
            return false;
        }
    }


    // Fungsi untuk mengambil semua data
    public function getAll($order, $is_desc, $where, $limit, $offset) {
        try {
            $query = "SELECT * FROM {$this->table}";

            if (count($where) > 0) {
                $query .= " WHERE";
                $conditions = [];

                foreach ($where as $key => $value) {
                    $conditions[] = "$key = :$key";
                }

                $query .= implode(" AND ", $conditions);
            }

            if ($order) {
                $query .= " ORDER BY $order";
            }

            if ($is_desc) {
                $query .= " DESC";
            }

            if ($limit) {
                $query .= " LIMIT $limit";
            }

            if ($offset) {
                $query .= " OFFSET $offset";
            }

            $stmt = $this->pdo->prepare($query);

            foreach ($where as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            return $stmt->fetchAll();

        } catch (PDOException $e) {

            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
        self::$instance = new static();
        }
        return self::$instance;
    }
}

