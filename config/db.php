<?php
class Database {
    private $server = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'wanderlust';
    
    private $pdo;

    public function connect() {
        try {
            $dsn = "mysql:host={$this->server};dbname={$this->dbname};charset=utf8mb4";

            $opt = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $this->pdo = new PDO(
               $dsn, 
               $this->user,
                $this->pass,
                 $opt
                 );

            return $this->pdo;

        } catch (PDOException $e) {
            
    logError("Database Connection Error: " . $e->getMessage());
    die("Something went wrong. Please try again later.");
        }
    }
}
?>
