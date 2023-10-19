<?php

require_once './config.php';

class Database {

    private $connection;

    public function __construct() {
        $this->connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($this->connection->connect_error) {
            die("Erreur de connexion : " . $this->connection->connect_error);
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}


?>

