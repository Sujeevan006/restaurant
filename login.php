

<?php

include_once 'config.php';

session_start();

// OOP: Class Definition for Database connection
class Res_Database {
    private $host = "localhost"; // OOP: Encapsulated property for host
    private $dbname = "restaurant"; // OOP: Encapsulated property for database name
    private $username = "root"; // OOP: Encapsulated property for database username
    private $password = ""; // OOP: Encapsulated property for database password
    public $conn; // OOP: Property for storing the database connection object

    // OOP: Constructor Method - Initializes the Database Object
    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password); // OOP: Creates PDO Object
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // OOP: Method chaining to set attributes
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}

// OOP: Class Definition for User-related Actions
class User {
    private $db; // OOP: Encapsulated property for the database connection

    // OOP: Constructor Method - Initializes the User Object with a Database Connection
    public function __construct($db) {
        $this->db = $db; // OOP: Dependency Injection - Injecting Database object into User class
    }

    // OOP: Method Definition - Handles User Login
    public function login($email, $pass, $usertype) {
        // OOP: Encapsulation - Sanitizing and hashing input data
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $pass = md5($pass); // OOP: Basic hashing (Consider using password_hash() for better security)
        $usertype = filter_var($usertype, FILTER_SANITIZE_STRING);

        $sql = "SELECT * FROM users WHERE email = ? AND password = ? AND usertype = ?";
        $stmt = $this->db->prepare($sql); // OOP: Using the injected database connection to prepare the statement
        $stmt->execute([$email, $pass, $usertype]); // OOP: Method invocation
        $rowCount = $stmt->rowCount(); // OOP: Getting the count of matching rows

        $row = $stmt->fetch(PDO::FETCH_ASSOC); // OOP: Fetching the result set

         if ($rowCount > 0) {
         // Check user type
         if ($row['usertype'] == 'Admin') {
            $_SESSION['admin_id'] = $row['id']; // For admin
            header('location:admin_page.php');
         } elseif ($row['usertype'] == 'Staff') {
            $_SESSION['staff_id'] = $row['id']; // Use 'staff_id' for staff
            header('location:staff_page.php');
         } elseif ($row['usertype'] == 'Customer') {
            $_SESSION['user_id'] = $row['id']; // For customer
            header('location:customer_page.php');
         }
         
        } else {
            return 'Incorrect email, password, or user type!'; // OOP: Encapsulation - Returning error message
        }
        return null;
    }
}

// OOP: Creating Instances (Objects) of Classes
$dbInstance = new Res_Database(); // OOP: Object Instantiation for Database
$user = new User($dbInstance->conn); // OOP: Object Instantiation for User with Dependency Injection

// Process the login form submission
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $usertype = $_POST['usertype'];

    // OOP: Invoking the login method on the User object
    $message = $user->login($email, $pass, $usertype);

    // Display error message if login failed
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