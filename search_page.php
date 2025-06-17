<?php
include 'config.php';
session_start();

// Check if user is logged in
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
   header('location:login.php');
   exit();
}

// Add to cart logic
if (isset($_POST['add_to_cart'])) {
   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $check_cart = mysqli_query($conn, "SELECT * FROM cart WHERE name = '$product_name' AND user_id = '$user_id'") or die('Query failed');

   if (mysqli_num_rows($check_cart) > 0) {
      $message[] = 'Already added to cart!';
   } else {
      mysqli_query($conn, "INSERT INTO cart(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('Query failed');
      $message[] = 'Product added to cart!';
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Book Nest | Shop</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<?php include 'header.php'; ?>

<div class="heading">
   <h3>Shop by Genre</h3>
   <p><a href="home.php">Home</a> / Shop</p>
</div>

<section class="products">

   <?php
   // Fetch distinct genres
   $get_genres = mysqli_query($conn, "SELECT DISTINCT genre FROM products") or die('Query failed');

   while ($genre_row = mysqli_fetch_assoc($get_genres)) {
      $genre = $genre_row['genre'];
   ?>

   <h2 style="margin-top: 30px; color: #333; text-align:center;"><?php echo htmlspecialchars($genre); ?></h2>

   <div class="box-container">
      <?php
      $genre_products = mysqli_query($conn, "SELECT * FROM products WHERE genre = '$genre'") or die('Query failed');

      if (mysqli_num_rows($genre_products) > 0) {
         while ($fetch = mysqli_fetch_assoc($genre_products)) {
      ?>
         <form action="" method="post" class="box">
            <img class="image" src="uploaded_img/<?php echo $fetch['image']; ?>" alt="<?php echo $fetch['name']; ?>">
            <div class="name"><?php echo $fetch['name']; ?></div>
            <div class="price">Rs. <?php echo $fetch['price']; ?>/-</div>
            <input type="number" min="1" name="product_quantity" value="1" class="qty">
            <input type="hidden" name="product_name" value="<?php echo $fetch['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch['image']; ?>">
            <input type="submit" value="add to cart" name="add_to_cart" class="btn">
         </form>
      <?php
         }
      } else {
         echo "<p class='empty'>No books available in this genre.</p>";
      }
      ?>
   </div>

   <?php } ?>

</section>

<?php include 'footer.php'; ?>
<script src="js/script.js"></script>

</body>
</html>
