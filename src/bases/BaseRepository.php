<?php

namespace bases;

use cores,
    PDOException,
    Exception,
    PDO;

abstract class BaseRepository
{
    protected static BaseRepository $instance;
    abstract public static function tableName(): string;

    public function findOne($where)
    {
        try {
            $tableName = $this->tableName();
            $query = "SELECT * FROM {$tableName}";

            if (count($where) > 0) {
                $query .= " WHERE ";
                $conditions = [];

                foreach ($where as $key => $value) {
                    $conditions[] = "$key = :$key";
                }

                $query .= implode(" AND ", $conditions);
            }

            $stmt = cores\Application::$app->db->prepare($query);

            foreach ($where as $key => $value) {
                $stmt->bindValue(":$key", $value, PDO::PARAM_STR);
            }

            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    // Fungsi untuk mengambil semua data
    public function findAll($order = null, $is_desc = false, $where = [], $limit = null, $offset = null): bool|array
    {
        try {
            $tableName = $this->tableName();
            $query = "SELECT * FROM {$tableName}";

            if (count($where) > 0) {
                $query .= " WHERE ";
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