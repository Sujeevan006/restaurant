<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = md5($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $usertype = $_POST['usertype'];
   $usertype = filter_var($usertype, FILTER_SANITIZE_STRING);

   $sql = "SELECT * FROM users WHERE email = ? AND password = ? AND usertype = ?";
   $stmt = $conn->prepare($sql);
   $stmt->execute([$email, $pass, $usertype]);
   $rowCount = $stmt->rowCount();  

   $row = $stmt->fetch(PDO::FETCH_ASSOC);

   if($rowCount > 0){

      if($row['usertype'] == 'Admin'){

         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');

      }elseif($row['usertype'] == 'Staff'){

         $_SESSION['staff_id'] = $row['id'];
         header('location:staff_page.php');

      }elseif($row['usertype'] == 'Customer'){

         $_SESSION['customer_id'] = $row['id'];
         header('location:customer_page.php');
      }
      
   }else{
      $message[] = 'Incorrect email, password, or user type!';
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
