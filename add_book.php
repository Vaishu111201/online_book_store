<?php
$conn = mysqli_connect("localhost", "root", "", "shop_db");

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $desc = $_POST['description'];

    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];

    // Save uploaded image to the images folder
    move_uploaded_file($tmp_name, "images/" . $image);

    $sql = "INSERT INTO products (name, price, image, description) VALUES ('$name', '$price', '$image', '$desc')";
    mysqli_query($conn, $sql);

    echo "<script>alert('Book added successfully!');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <style>
        body {
            font-family: Arial;
            padding: 20px;
            background: #f5f5f5;
        }
        form {
            background: #fff;
            padding: 25px;
            width: 400px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
        input, textarea {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
        }
        input[type="submit"] {
            background: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>

<h2>Add New Book</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Book Name" required>
    <input type="number" name="price" placeholder="Price (₹)" required>
    <textarea name="description" placeholder="Book Description" required></textarea>
    <input type="file" name="image" accept="image/*" required>
    <input type="submit" name="submit" value="Add Book">
</form>

</body>
</html>