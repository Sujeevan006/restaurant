<?php

include 'config.php';

// OOP: Class Definition for Database Connection
class Res_Database {
    private $host = "localhost";
    private $dbname = "restaurant";
    private $username = "root";
    private $password = "";
    public $conn;

    // OOP: Constructor Method - Initializes the Database Connection
    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}

// OOP: Class Definition for User-related Actions
class User {
    private $db;

    // OOP: Constructor Method - Initializes the User Object with a Database Connection
    public function __construct($db) {
        $this->db = $db;
    }

    // OOP: Method to Register a New User
    public function register($name, $email, $pass, $cpass, $usertype, $image, $image_tmp_name, $image_folder, $image_size) {
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = filter_var($email, FILTER_SANITIZE_STRING);
        $pass = md5($pass);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);
        $cpass = md5($cpass);
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
        $usertype = filter_var($usertype, FILTER_SANITIZE_STRING);
        $image = filter_var($image, FILTER_SANITIZE_STRING);

        $select = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $select->execute([$email]);

        if($select->rowCount() > 0){
            return 'User email already exists!';
        } else {
            if($pass != $cpass){
                return 'Confirm password does not match!';
            } else {
                $insert = $this->db->prepare("INSERT INTO users(name, email, password, usertype, image) VALUES(?,?,?,?,?)");
                $insert->execute([$name, $email, $pass, $usertype, $image]);

                if($insert){
                    if($image_size > 2000000){
                        return 'Image size is too large!';
                    } else {
                        move_uploaded_file($image_tmp_name, $image_folder);
                        header('location:login.php');
                        return 'Registered successfully!';
                    }
                }
            }
        }
        return null;
    }
}

// OOP: Creating Instances (Objects) of Classes
$dbInstance = new Database(); // OOP: Object Instantiation for Database
$user = new User($dbInstance->conn); // OOP: Object Instantiation for User with Dependency Injection

// Process the registration form submission
if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];
    $usertype = $_POST['usertype'];
    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/'.$image;
    $image_size = $_FILES['image']['size'];

    // OOP: Invoking the register method on the User object
    $message = $user->register($name, $email, $pass, $cpass, $usertype, $image, $image_tmp_name, $image_folder, $image_size);

    // Display message if registration fails or succeeds
    if($message){
        echo '
        <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/components.css">

</head>
<body class="login-body">

<?php

if(isset($message)){
    foreach($message as $message){
        echo '
        <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}

?>

<section class="form-containerlogin">
    <form action="" enctype="multipart/form-data" method="POST">
        <h3>Register Now</h3>
        <select name="usertype" class="dropdownbox" required>
            <option value="" disabled selected hidden>Select user type</option>
            <option value="Admin" class="dropdownmenu">Admin</option>
            <option value="Staff" class="dropdownmenu">Restaurant Staff</option>
            <option value="Customer" class="dropdownmenu">Customer</option>
        </select>
        <input type="text" name="name" class="box" placeholder="Enter your name" required>
        <input type="email" name="email" class="box" placeholder="Enter your email" required>
        <input type="password" name="pass" class="box" placeholder="Enter your password" required>
        <input type="password" name="cpass" class="box" placeholder="Confirm your password" required>
        <input type="file" name="image" class="box" required accept="image/jpg, image/jpeg, image/png">
        <input type="submit" value="Register Now" class="btn" name="submit">
        <p class="login-para">Already have an account? <a href="login.php">Login now</a></p>
    </form>
</section>

</body>
</html>