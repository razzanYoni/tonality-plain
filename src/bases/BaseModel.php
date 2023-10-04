<?php

namespace bases;

use cores;
use PDOException, Exception;

abstract class BaseModel extends cores\Model
{
    abstract public static function tableName(): string;
    abstract public static function primaryKey(): string;

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

            $stmt = cores\Application::$app->db->prepare($query);

            foreach ($where as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            $stmt->execute();
            return $stmt->fetchObject(static::class);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function insert(): bool
    {
        try {
            $tableName = $this->tableName();
            $attributes = $this->attributes();
            $params = array_map(fn($attr) => ":$attr", $attributes);

            $query = "INSERT INTO {$tableName} (" . implode(",", $attributes) . ")
                        VALUES (" . implode(",", $params) . ")";
            $stmt = cores\Application::$app->db->prepare($query);
            foreach ($attributes as $attribute) {
                $stmt->bindValue(":$attribute", $this->{$attribute});
            }
            $stmt->execute();
            return true;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public function update($where, $data): bool
    {
        try {
            $tableName = $this->tableName();
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

            $query = "UPDATE {$tableName} SET $updateFields WHERE $whereClause";
            $stmt = cores\Application::$app->db->prepare($query);

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

    public function delete($where): bool
    {
        try {
            $tableName = $this->tableName();
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

            $stmt = cores\Application::$app->db->prepare($query);

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

    public function set($attr, $value): BaseModel
    {
        $this->$attr = $value;
        return $this;
    }

    public function get($attr)
    {
        return $this->$attr;
    }

    abstract public function constructFromArray(array $data);

    abstract public function toResponse(): array;
}
