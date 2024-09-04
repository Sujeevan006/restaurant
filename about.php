<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="about">
   <div class="row">
        <div class="box">
         <h3>why choose us?</h3>
         <img src="images/aboutimg.jpg" alt="">        
         <p>ABC Restaurant is a beloved Sri Lankan restaurant chain known for its delicious cuisine and warm hospitality. With locations across the country, we offer a taste of authentic Sri Lankan flavors in every bite. Whether you're a local or a visitor, come experience the vibrant atmosphere and unforgettable dining experience at ABC Restaurant.</p>     
      </div>
   </div>
</section>










<?php include 'footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>