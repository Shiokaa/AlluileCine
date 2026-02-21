<?php

namespace App\Models;

use Helpers\ResponseHandler;
use PDOException;

class Room {
    private $pdo;

    public function __construct($db)
    {
        $this->pdo = $db;
    }

    public function findAll()
    {
        $sql = "SELECT id, name, capacity FROM rooms";

        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
            $rooms = $statement->fetchAll();

            return ResponseHandler::format(true, 'Succès', $rooms);
        } catch (PDOException $e) {
            return ResponseHandler::format(false, $e->getMessage());
        }
    }
}

?>
