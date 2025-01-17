<?php
class Database {
    private static $instance = null;
    private $conn;
    private $host = 'localhost';
    private $dbName = 'restaurant';
    private $username = 'root';
    private $password = '';
    private function __construct() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbName}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    public function getConnection() {
        return $this->conn;
    }
}
?>
<?php
include_once 'config.php';
$db = Database::getInstance();
$conn = $db->getConnection();
?>
