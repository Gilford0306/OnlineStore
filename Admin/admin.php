<?php
session_start();

//Checking  -  user is an administrator
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../User/user.php');
    exit();
}
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "online_store";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_product"])) {
    $product_id = $_POST["product_id"];
    $new_name = $_POST["new_name"];
    $new_price = $_POST["new_price"];
    $new_image_url = $_POST["new_image_url"];

    $update_query = "UPDATE products SET name='$new_name', price='$new_price', image_url='$new_image_url' WHERE id=$product_id";
    if ($conn->query($update_query) === TRUE) {
        echo "The product has been successfully edited.";
    } else {
        echo "Error when editing product: " . $conn->error;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_product"])) {
    $new_name = $_POST["new_name"];
    $new_price = $_POST["new_price"];
    $new_image_url = $_POST["new_image_url"];


    $insert_query = "INSERT INTO products (name, price, image_url) VALUES ('$new_name', '$new_price', '$new_image_url')";
    if ($conn->query($insert_query) === TRUE) {
        echo "New product added successfully.";
    } else {
        echo "Error when adding a new product: " . $conn->error;
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_product"])) {
    $product_id = $_POST["product_id"];
    $delete_query = "DELETE FROM products WHERE id=$product_id";
    if ($conn->query($delete_query) === TRUE) {
        echo "The item has been successfully removed.";
    } else {
        echo "Error when deleting a product: " . $conn->error;
    }
}

$product_query = "SELECT * FROM products";
$product_result = $conn->query($product_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<header>
    <h1>Admin panel</h1>
    <a href="../Enter/logout.php">Exit</a>
</header>

<section>
    <h2>Editing products</h2>

    <?php
    if ($product_result->num_rows > 0) {
        while ($row = $product_result->fetch_assoc()) {
            ?>
            <form action="" method="post">
                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                <label for="new_name">New Name:</label>
                <input type="text" name="new_name" value="<?php echo $row['name']; ?>" required>
                <label for="new_price">New price:</label>
                <input type="text" name="new_price" value="<?php echo $row['price']; ?>" required>
                <label for="new_image_url">New image link:</label>
                <input type="text" name="new_image_url" value="<?php echo $row['image_url']; ?>" required>
                <button type="submit" name="edit_product">Edit</button>
                <button type="submit" name="delete_product" onclick="return confirm('Are you sure you want to remove this item??');">Удалить</button>
            </form>
            <?php
        }
    } else {
        echo "No products available for editing.";
    }
    ?>
</section>

<section>
    <h2>Adding a new product</h2>

    <form action="" method="post">
        <label for="new_name">New product name:</label>
        <input type="text" name="new_name" required>
        <label for="new_price">New product price:</label>
        <input type="text" name="new_price" required>
        <label for="new_image_url">Link to new product image:</label>
        <input type="text" name="new_image_url" required>
        <button type="submit" name="add_product">Add product</button>
    </form>
</section>
</body>
</html>

<?php
$conn->close();
?>
