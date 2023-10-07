<?php

namespace bases;

use cores\Application,
    PDOException;
use Exception;

abstract class BaseRepository
{
    protected static BaseRepository $instance;
    abstract public static function tableName(): string;
    abstract public static function attributes(): array;
    abstract public static function primaryKey(): string | array;
    abstract public static function getInstance();

    public function findOne($where) {
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

            $stmt = Application::$app->db->prepare($query);

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

    public function insert(array $data): bool
    {
        try {
            $tableName = $this->tableName();
            $attributes = $this->attributes();
            $params = array_map(fn($attr) => ":$attr", $attributes);

            $query = "INSERT INTO {$tableName} (" . implode(",", $attributes) . ")
                        VALUES (" . implode(",", $params) . ")";

            $stmt = Application::$app->db->prepare($query);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            return true;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function update($id, array $data): bool
    {
        try {
            $tableName = $this->tableName();
            $updateFields = '';

            foreach ($data as $key => $value) {
                $updateFields .= "$key = :$key, ";
            }

            $updateFields = rtrim($updateFields, ', ');

            $whereClause = "{$this->primaryKey()} = :where_{$this->primaryKey()} ";

            $query = "UPDATE {$tableName} SET $updateFields WHERE $whereClause";
            $stmt = Application::$app->db->prepare($query);

            // Binding nilai update
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->bindValue(":where_{$this->primaryKey()}", $id);

            $stmt->execute();
            return true;

        } catch (PDOException $e) {
            // Handle kesalahan koneksi atau query di sini
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function delete($id): bool
    {
        try {
            $tableName = $this->tableName();
            $query = "DELETE FROM {$tableName}";

            if (is_string($this->primaryKey())) {
                // string
                $query .= " WHERE {$this->primaryKey()} = :where_{$this->primaryKey()}";
                $stmt = Application::$app->db->prepare($query);
                $stmt->bindValue(":where_{$this->primaryKey()}", $id);
            } else {
                // array
                $conditions = [];
                $query .= " WHERE ";
                foreach ($id as $key => $value) {
                    $conditions[] = "$key = :where_$key";
                }
                $query .= implode(" AND ", $conditions);
                $stmt = Application::$app->db->prepare($query);
                foreach ($id as $key => $value) {
                    $stmt->bindValue(":where_$key", $value);
                }
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

    public function findAll(
        $order = null,
        $is_desc = false,
        $where = [],
        $where_like = [],
        $limit = null,
        $offset = null,
        $options = '',
        $natural_join = []
    ): bool|array
    {
        try {
            $tableName = $this->tableName();
            if ($options !== '') {
                $query = "SELECT {$options}";
            } else {
                $query = "SELECT *";
            }
            $query .= " FROM {$tableName}";

            if (count($natural_join) > 0) {
                foreach ($natural_join as $table) {
                    $query .= " NATURAL JOIN {$table}";
                }
            }

            if (count($where) > 0) {
                $query .= " WHERE ";
                $conditions = [];

                foreach ($where as $key => $value) {
                    $conditions[] = "$key = :$key";
                }

                $query .= implode(" AND ", $conditions);
            }

            if (count($where_like) > 0) {
                if (count($where) > 0) {
                    $query .= " AND ";
                } else {
                    $query .= " WHERE ";
                }
                $conditions = [];

                foreach ($where_like as $key => $value) {
                    $conditions[] = "$key LIKE :wl_$key";
                }

                $query .= implode(" OR ", $conditions);
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

            $stmt = Application::$app->db->prepare($query);

            foreach ($where as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            foreach ($where_like as $key => $value) {
                $stmt->bindValue(":wl_$key", '%' . $value . '%');
            }


            $stmt->execute();
            return $stmt->fetchAll();

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return [];
        }
    }

    public function aggregate($method, $alias, $where = [], $where_like = [], $column = "*")
    {
        try {
            $tableName = $this->tableName();
            $query = "SELECT {$method}({$column}) AS {$alias} FROM {$tableName}";

            if (count($where) > 0) {
                $query .= " WHERE ";
                $conditions = [];

                foreach ($where as $key => $value) {
                    $conditions[] = "$key = :$key";
                }

                $query .= implode(" AND ", $conditions);
            }

            if (count($where_like) > 0) {
                if (count($where) > 0) {
                    $query .= " AND ";
                } else {
                    $query .= " WHERE ";
                }
                $conditions = [];

                foreach ($where_like as $key => $value) {
                    $conditions[] = "$key LIKE :wl_$key";
                }

                $query .= implode(" OR ", $conditions);
            }

            $stmt = Application::$app->db->prepare($query);

            foreach ($where as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            foreach ($where_like as $key => $value) {
                $stmt->bindValue(":wl_$key", '%' . $value . '%');
            }

            $stmt->execute();
            return $stmt->fetch();

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return 0;
        }
    }

}