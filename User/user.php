<?php
session_start();
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "online_store";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_to_cart"])) {
    $product_id = $_POST["product_id"];
    $product_query = "SELECT * FROM products WHERE id = $product_id";
    $product_result = $conn->query($product_query);

    if ($product_result->num_rows > 0) {
        $product = $product_result->fetch_assoc();

        // Добавление товара в корзину (используем сессию для хранения корзины)
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Проверка, есть ли товар уже в корзине
        $product_in_cart = false;
        foreach ($_SESSION['cart'] as &$cart_item) {
            if ($cart_item['id'] == $product_id) {
                $cart_item['quantity'] += 1;
                $product_in_cart = true;
                break;
            }
        }

        // Если товара еще нет в корзине, добавляем его
        if (!$product_in_cart) {
            $cart_item = array(
                'id' => $product_id,
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1
            );
            $_SESSION['cart'][] = $cart_item;
        }

        echo "The item has been added to the cart.";
    } else {
        echo "Product not found.";
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
        <button id="theme-toggle"> </button>
        <title>Phone Store</title>
        <link rel="stylesheet" href="../styles.css">
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
            }

            header {
                background-color: #333;
                color: #fff;
                padding: 10px;
                text-align: center;
            }

            section {
                padding: 20px;
                display: flex;
                flex-wrap: wrap;
                justify-content: space-around;
            }

            .product {
                border: 1px solid #ddd;
                padding: 10px;
                margin: 10px;
                background-color: #fff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                width: 200px;
                text-align: center;
                transition: transform 0.3s ease;
            }

            .product:hover {
                transform: scale(1.3);
            }

            img {
                max-width: 100%;
                height: auto;
                max-height: 150px;
            }
        </style>
    </head>
    <body>
    <header>
        <h1>Wellcome, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'User'; ?>!</h1>
        <a href="../User/cart.php">View cart</a><br><br>
        <a href="../Enter/logout.php">Exit</a>
    </header>

    <section>


        <?php
        // Отобразите все товары
        if ($product_result->num_rows > 0) {
            while ($row = $product_result->fetch_assoc()) {
                ?>
                <div class="product" style= "background-color: whitesmoke;">
                    <h3><?php echo $row['name']; ?></h3>
                    <p>Price: <?php echo $row['price']; ?> ₴</p>
                    <img src="<?php echo $row['image_url']; ?>" alt="Product Image">
                    <form action="" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="add_to_cart">Add to Cart</button>
                    </form>
                </div>
                <?php
            }
        } else {
            echo "No products available.";
        }
        ?>
    </section>
    </body>
    <script src="../theme.js"></script>
    </html>

<?php
$conn->close();
?>