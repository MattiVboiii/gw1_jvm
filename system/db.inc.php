<?php
require_once 'system/load_env.inc.php';
require_once 'system/Site/User.php';

use Site\User;

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

function getClub(int $id): array|false
{
    $sql = 'SELECT * FROM clubs WHERE id = :id LIMIT 1';
    $stmt = connectToDatabase()->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function isUniqClubName(string $name): bool
{
    $sql = 'SELECT 1 FROM clubs WHERE name = :name LIMIT 1';
    $stmt = connectToDatabase()->prepare($sql);
    $stmt->execute([':name' => $name]);
    return $stmt->rowCount() < 1;
}

function isUniqClubLogo(string $logo_url): bool
{
    $sql = 'SELECT 1 FROM clubs WHERE logo_url = :logo_url LIMIT 1';
    $stmt = connectToDatabase()->prepare($sql);
    $stmt->execute([':logo_url' => $logo_url]);
    return $stmt->rowCount() < 1;
}

function updateClub(
    int $id,
    string $name,
    string $province,
    string $zip,
    string $city,
    string $street,
    string $address,
    string $bus,
    string $logo_url,
    float $longitude,
    float $latitude,
    string $description
): int|false {
    $vars = get_defined_vars(); // THIS MUST STAY AS THE FIRST LINE IN THE FUNCTION!
    unset($vars['id']);
    $columns = [];
    foreach ($vars as $key => $value) {
        unset($vars[$key]);
        $vars[":$key"] = $value;
        $columns[] = "$key = :$key";
    }
    $columns = implode(', ', $columns);


    $sql = "UPDATE clubs SET $columns WHERE id = :id";
    $stmt = connectToDatabase()->prepare($sql);
    $success = $stmt->execute([':id' => $id, ...$vars]);
    return $success
        ? $stmt->rowCount()
        : false;
}

function deleteClub(int $id): int|false
{
    $sql = 'DELETE FROM clubs WHERE id = :id';
    $stmt = connectToDatabase()->prepare($sql);
    $success = $stmt->execute([':id' => $id]);
    $success = true;
    return $success
        ? $stmt->rowCount()
        : false;
}

function createClub(
    string $name,
    string $province,
    string $zip,
    string $city,
    string $street,
    string $address,
    string $bus = null,
    string $logo_url,
    float $longitude,
    float $latitude,
    string $description = null
): int|false {
    $vars = get_defined_vars(); // THIS MUST STAY AS THE FIRST LINE IN THE FUNCTION!
    $vars['country'] = 'BE'; // default value
    $columns = implode(', ', array_keys($vars));
    foreach ($vars as $key => $value) {
        unset($vars[$key]);
        $vars[":$key"] = $value;
    }
    $placeHolders = implode(', ', array_keys($vars));


    $sql = "INSERT INTO clubs ($columns) VALUES ($placeHolders)";
    $stmt = connectToDatabase()->prepare($sql);
    $success = $stmt->execute($vars);
    return $success
        ? connectToDatabase()->lastInsertId()
        : false;
}

function getClubManagement(int $clubId): array
{
    $sql = 'SELECT management.* FROM management
        LEFT JOIN management_roles ON management_role_id = management_roles.id 
        WHERE club_id = :club_id
        ORDER BY role_rank DESC';
    $stmt = connectToDatabase()->prepare($sql);
    $stmt->execute([':club_id' => $clubId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getManagementRoles(): array
{
    $sql = 'SELECT id, role_name FROM management_roles ORDER BY role_rank desc';
    $stmt = connectToDatabase()->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
}

function updateManagement(
    int $id,
    int $management_role_id,
    string $role_description = null,
    string $firstname,
    string $lastname,
    string $email = null,
    string $tel = null,
    int $show_on_club
): int|false {
    $vars = get_defined_vars(); // THIS MUST STAY AS THE FIRST LINE IN THE FUNCTION!
    unset($vars['id']);
    $columns = [];
    foreach ($vars as $key => $value) {
        unset($vars[$key]);
        $vars[":$key"] = $value;
        $columns[] = "$key = :$key";
    }
    $columns = implode(', ', $columns);


    $sql = "UPDATE management SET $columns WHERE id = :id";
    $stmt = connectToDatabase()->prepare($sql);
    $success = $stmt->execute([':id' => $id, ...$vars]);
    return $success
        ? $stmt->rowCount()
        : false;
}

function deleteManagement(int $id): int|false
{
    $sql = 'DELETE FROM management WHERE id = :id';
    $stmt = connectToDatabase()->prepare($sql);
    $success = $stmt->execute([':id' => $id]);
    $success = true;
    return $success
        ? $stmt->rowCount()
        : false;
}

function createManagement(
    int $club_id,
    int $management_role_id,
    string $role_description = null,
    string $firstname,
    string $lastname,
    string $email = null,
    string $tel = null,
    int $show_on_club
): int|false {
    $vars = get_defined_vars(); // THIS MUST STAY AS THE FIRST LINE IN THE FUNCTION!
    $columns = implode(', ', array_keys($vars));
    foreach ($vars as $key => $value) {
        unset($vars[$key]);
        $vars[":$key"] = $value;
    }
    $placeHolders = implode(', ', array_keys($vars));


    $sql = "INSERT INTO management ($columns) VALUES ($placeHolders)";
    $stmt = connectToDatabase()->prepare($sql);
    $success = $stmt->execute($vars);
    return $success
        ? connectToDatabase()->lastInsertId()
        : false;
}

function getTeams(): array
{
    $sql = 'SELECT * FROM teams';
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

function getUser(string $email): User|false
{
    $sql = 'SELECT 
        id, 
        username, 
        password as passwordHash, 
        email,
        permissionRole,
        firstname,
        lastname
        FROM users WHERE email = :email LIMIT 1';
    $stmt = connectToDatabase()->prepare($sql);
    $stmt->execute([':email' => $email]);
    $row = $stmt->fetch(PDO::FETCH_NUM);
    return $row
        ? new User(...$row)
        : false;
}
