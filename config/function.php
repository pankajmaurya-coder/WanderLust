<?php  

require_once __DIR__ . "/../config/db.php";
class Query extends Database{
    private PDO $conn;
    private array $allowedTables = [];

    public function __construct(){
        $this->conn = $this->connect();

        if (!$this->conn) {
            throw new Exception("DB connection failed");
        }
          
         $tablesPath = __DIR__ . "/../setup/tables.php";
        // $tables = ['hotel', 'user', 'cookies'];
         
         if (!file_exists($tablesPath)) {
        throw new Exception("Tables config not found");
    }

     $tables = require $tablesPath;

        if (!is_array($tables)) {
            throw new Exception("TABLE is not in array");
        }

        $this->allowedTables = $tables;
    }

    private function validateTable(string $table): void{
        if (!in_array($table, $this->allowedTables, true)) {
            throw new Exception("Invalid table: {$table}");
        }
    }

    // QUERY
    public function RunQuery(string $sql, array $params = []): PDOStatement{
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            throw new Exception("Prepare failed.");
        }

        foreach ($params as $key => $value){

            $type = match (true) {
                is_int($value)  => PDO::PARAM_INT,
                is_bool($value) => PDO::PARAM_BOOL,
                is_null($value) => PDO::PARAM_NULL,
                default         => PDO::PARAM_STR,
            };

            if (is_int($key)) {
                $stmt->bindValue($key + 1, $value, $type);
            } else {
                $stmt->bindValue($key, $value, $type);
            }
        }

        $stmt->execute();

        return $stmt;
    }


    // INSERT
    public function insertdata(string $table, array $data): int{

        $this->validateTable($table);

        $fields       = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$table} ({$fields}) VALUES ({$placeholders})";

        $this->runquery($sql, array_values($data));

       return (int) $this->conn->lastInsertId();
    }

    // // LIST
    public function viewdata(string $table ,int $limit = 20, int $offset = 0): array{
        $this->validateTable($table);

        $sql  = "SELECT * FROM {$table}  ORDER BY id DESC LIMIT ? OFFSET ?";
        $stmt = $this->RunQuery($sql, [$limit, $offset]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);;
    }

    // // SINGLE RECORD
public function getData(string $table, int $id): array{
    $this->validateTable($table);

    $sql  = "SELECT * FROM {$table} WHERE id = ? LIMIT 1";
    $stmt = $this->runQuery($sql, [$id]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result;
    }
    throw new Exception("Record not found");
}

    // // UPDATE 
    public function updateData(string $table, int $id, array $data): bool{
    $this->validateTable($table);

    if (empty($data)) {
        throw new Exception("No fields provided for update.");
    }

    $setParts = [];

    foreach ($data as $field => $value) {
        $setParts[] = "{$field} = ?";
    }

    $setfield = implode(', ', $setParts);

    $sql = "UPDATE {$table} SET {$setfield} WHERE id = ? LIMIT 1";

    $params = array_values($data);
    $params[] = $id;

    $stmt = $this->runQuery($sql, $params);

    return $stmt->rowCount() > 0;
}


    // DELETE
  public function deleteData(string $table, int $id): bool{
    $this->validateTable($table);

    $sql = "DELETE FROM {$table} WHERE id = ? LIMIT 1";

    $stmt = $this->runQuery($sql, [$id]);

    return $stmt->rowCount() > 0;
}

//login
public function login(string $table, string $email, string $password): ?array{
    $sql = "SELECT * FROM {$table} WHERE email = ? LIMIT 1";

    $stmt = $this->runQuery($sql, [$email]);
    $user = $stmt->fetch();
    if (!$user) {
        return null;
    }
    if (!password_verify($password, $user['password'])) {
        return null;
    }
    unset($user['password']);
    return $user;
}

//emailexist
public function emailExists(string $table, string $email): bool{
    $this->validateTable($table);
    $sql = "SELECT 1 FROM {$table} WHERE email = ? LIMIT 1";
    $stmt = $this->runQuery($sql, [$email]);

    return  $stmt->fetchColumn();
}

 
//admin
public function totalUsers(): int{
    $sql = "SELECT COUNT(*) AS total FROM users";
    $stmt = $this->runQuery($sql);
    $row = $stmt->fetch();
    return (int) $row['total'];
}


//FOR COKKIES
public function getRememberUser(string $token): ?array
{

   $sql = "SELECT users.*, cookies.expires_at FROM cookies 
        JOIN users ON users.id = cookies.user_id WHERE cookies.token = ? 
        AND cookies.expires_at > NOW() LIMIT 1";

    $stmt = $this->runQuery($sql, [$token]);

    $user = $stmt->fetch();

    if (!$user) {
        return null;
    }

    unset($user['password']);

    return $user;
}
//token generate
public function createRememberToken(int $userId): string
{
    $token = bin2hex(random_bytes(32)); 
    $expiry = date('Y-m-d H:i:s', strtotime('+30 days'));

    $sql = "INSERT INTO cookies (user_id, token, expires_at)
            VALUES (?, ?, ?)";

    $this->runQuery($sql, [$userId, $token, $expiry]);

    return $token;
}


}


?>