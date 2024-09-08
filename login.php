<?php
include_once 'config.php';
session_start();
class Res_Database {
    private $host = "localhost";  
    private $dbname = "restaurant";  
    private $username = "root";  
    private $password = ""; 
    public $conn; 
    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}


class User {
    private $db; 
    public function __construct($db) {
        $this->db = $db; 
    }

    public function login($email, $pass, $usertype) {
      
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $pass = md5($pass);
        $usertype = filter_var($usertype, FILTER_SANITIZE_STRING);

        $sql = "SELECT * FROM users WHERE email = ? AND password = ? AND usertype = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email, $pass, $usertype]); 
        $rowCount = $stmt->rowCount(); 
        $row = $stmt->fetch(PDO::FETCH_ASSOC); 
         if ($rowCount > 0) {
         if ($row['usertype'] == 'Admin') {
            $_SESSION['admin_id'] = $row['id']; 
            header('location:admin_page.php');
         } elseif ($row['usertype'] == 'Staff') {
            $_SESSION['admin_id'] = $row['id']; 
            header('location:staff_page.php');
         } elseif ($row['usertype'] == 'Customer') {
            $_SESSION['user_id'] = $row['id'];
            header('location:customer_page.php');
         }
        } else {
            return 'Incorrect email, password, or user type!'; 
        }
        return null;
    }
}

$dbInstance = new Res_Database(); 
$user = new User($dbInstance->conn); 


if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $usertype = $_POST['usertype'];
    $message = $user->login($email, $pass, $usertype);

    if ($message) {
        echo '<div class="message">
                 <span>' . $message . '</span>
                 <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
              </div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/components.css">
</head>
<body class="login-body">

<section class="form-containerlogin">
    <form action="" method="POST">
        <h3>LOGIN TO ABC RESTAURANTS</h3>
        <select name="usertype" class="dropdownbox" required>
            <option value="" disabled selected hidden>Select user type</option>
            <option value="Admin" class="dropdownmenu">Admin</option>
            <option value="Staff" class="dropdownmenu">Restaurant Staff</option>
            <option value="Customer" class="dropdownmenu">Customer</option>
        </select>
        <input type="email" name="email" class="box" placeholder="Enter your email" required>
        <input type="password" name="pass" class="box" placeholder="Enter your password" required>
        <input type="submit" value="Login Now" class="btn" name="submit">
        <p class="login-para">Don't have an account? <a href="register.php">Register now</a></p>
    </form>
</section>
</body>
</html>