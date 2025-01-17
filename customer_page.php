<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
   header('location:login.php');
}
;

if (isset($_POST['add_to_wishlist'])) {

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);

   $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
   $check_wishlist_numbers->execute([$p_name, $user_id]);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if ($check_wishlist_numbers->rowCount() > 0) {
      $message[] = 'already added to wishlist!';
   } elseif ($check_cart_numbers->rowCount() > 0) {
      $message[] = 'already added to cart!';
   } else {
      $insert_wishlist = $conn->prepare("INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES(?,?,?,?,?)");
      $insert_wishlist->execute([$user_id, $pid, $p_name, $p_price, $p_image]);
      $message[] = 'added to wishlist!';
   }

}

if (isset($_POST['add_to_cart'])) {

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $p_name = $_POST['p_name'];
   $p_name = filter_var($p_name, FILTER_SANITIZE_STRING);
   $p_price = $_POST['p_price'];
   $p_price = filter_var($p_price, FILTER_SANITIZE_STRING);
   $p_image = $_POST['p_image'];
   $p_image = filter_var($p_image, FILTER_SANITIZE_STRING);
   $p_qty = $_POST['p_qty'];
   $p_qty = filter_var($p_qty, FILTER_SANITIZE_STRING);

   $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
   $check_cart_numbers->execute([$p_name, $user_id]);

   if ($check_cart_numbers->rowCount() > 0) {
      $message[] = 'already added to cart!';
   } else {

      $check_wishlist_numbers = $conn->prepare("SELECT * FROM `wishlist` WHERE name = ? AND user_id = ?");
      $check_wishlist_numbers->execute([$p_name, $user_id]);

      if ($check_wishlist_numbers->rowCount() > 0) {
         $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE name = ? AND user_id = ?");
         $delete_wishlist->execute([$p_name, $user_id]);
      }

      $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES(?,?,?,?,?,?)");
      $insert_cart->execute([$user_id, $pid, $p_name, $p_price, $p_qty, $p_image]);
      $message[] = 'added to cart!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home page</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
   <link rel="stylesheet" href="css/style.css">
</head>

<body>
   <?php include 'header.php'; ?>

   <div class="home-bg">
      <section class="home">
         <div class="content">
            <h3>ABC Restaurant</h3>
            <p>Welcome to ABC Restaurant, your destination for delicious meals and a warm atmosphere. Explore our menu,
               make a reservation, or order for delivery-experience the best with us</p>
            <a href="about.php" class="btn">about us</a>
         </div>
      </section>
   </div>


   <section class="home-category">
      <div class="optionssection">
         <div class="options">
            <div class="optionsbox">
               <img src="images/dining.jpg" alt="">
               <a href="reservation.php" class="btn">Make a Reservation</a>
            </div>

            <div class="optionsbox">
               <img src="images/order.jpg" alt="">
               <a href="order_page.php" class="btn">Order Foods</a>
            </div>

            <div class="optionsbox">
               <img src="images/foodmenus.jpg" alt="">
               <a href="menu.php" class="btn">Explore Menu</a>
            </div>
         </div>
      </div>

      <h1 class="title">shop by category</h1>
      <div class="box-container">
         <div class="box">
            <img src="images/veg.png" alt="foods">
            <a href="category.php?category=vegfoods" class="btn">Veg Foods</a>
         </div>

         <div class="box">
            <img src="images/nonveg" alt="foods">
            <a href="category.php?category=nonvegfoods" class="btn">Non-Veg Foods</a>
         </div>

         <div class="box">
            <img src="images/drinks.png" alt="foods">
            <a href="category.php?category=drinks" class="btn">Soft Drink</a>
         </div>
      </div>

   </section>
   <section class="products">
   <h1 class="title">Our Delicious Menus</h1>
   <div class="box-container">
   <?php
         $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
         $select_products->execute();
         if ($select_products->rowCount() > 0) {
            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
               ?>
               <form action="" class="box" method="POST">
                  <a href="view_page.php?pid=<?= $fetch_products['id']; ?>">
                     <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                  </a>
   
                  <div class="name"><?= $fetch_products['name']; ?></div>
                  <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                  <input type="hidden" name="p_name" value="<?= $fetch_products['name']; ?>">
                  <div class="price">Rs<span><?= $fetch_products['price']; ?></span>/-</div>
   
                  <input type="hidden" name="p_price" value="<?= $fetch_products['price']; ?>">
                  <input type="hidden" name="p_image" value="<?= $fetch_products['image']; ?>">
   
                  <div class="cartlist">
                     <button type="submit" name="add_to_wishlist" class="iconbox">
                        <i class="material-icons">favorite</i>
                     </button>

                     <div>
                        <input type="number" min="1" value="1" name="p_qty" class="qty">
                     </div>
   
                     <button type="submit" name="add_to_cart" class="iconbox">
                        <i class="material-icons">shopping_cart</i>
                     </button>
                  </div>
               </form>
               <?php
            }
         } else {
            echo '<p class="empty">no products added yet!</p>';
         }
         ?>
      </div>
      <section class="p-category">
         <a href="shop.php">MORE</a>
      </section>
   </section>




   <?php include 'footer.php'; ?>
   <script src="js/script.js"></script>
</body>
</html>