<?php
require_once 'system/load_env.inc.php';

function connectToDatabase($forceReConnect = false): PDO
{
    static $db; // persistent across function calls

    if ($forceReConnect || !$db) {
        try {
            $db_host = $_ENV['DB_HOST'];
            $db_port = $_ENV['DB_PORT'];
            $db_user = $_ENV['DB_USER'];
            $db_password = $_ENV['DB_PASS'];
            $db_db = $_ENV['DB_DATABASE'];

            $db = new PDO(
                "mysql:host=$db_host; port=$db_port; dbname=$db_db",
                $db_user,
                $db_password
            );
        } catch (PDOException $e) {
            echo "Error!: " . $e->getMessage() . "<br />";
            die();
        }
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
    }

    return $db;
}

function getClubs(): array
{
    $sql = 'SELECT * FROM clubs';
    $stmt = connectToDatabase()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getProvinces(): array
{
    $sql = 'SELECT province FROM clubs GROUP BY province';
    $stmt = connectToDatabase()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
