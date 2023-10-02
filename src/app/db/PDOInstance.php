<?php

namespace db;

class PDOInstance
{
    private static $instance;
    private $dbh;

    protected function __construct()
    {
        $DB_HOST = HOST;
        $DB_USER = USER;
        $DB_PASSWORD = PASSWORD;
        $DB_NAME = DATABASE;

        try {
            $this->dbh = new PDO('mysql:host=' . $DB_HOST . ';dbname=' . $DB_NAME, $DB_USER, $DB_PASSWORD, );
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Unable to connect: ". $e->getMessage());
        }
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new PDOInstance();
        }
        return self::$instance;
    }

    public function __destruct()
    {
        $this->dbh = null;
    }

    public function getDbh()
    {
        return $this->dbh;
    }
}
