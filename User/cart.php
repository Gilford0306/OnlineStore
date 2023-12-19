<?php
session_start();
//remove_from_cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["remove_from_cart"])) {
    $product_id = $_POST["product_id"];
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $key => $cart_item) {
            if ($cart_item['id'] == $product_id) {
                unset($_SESSION['cart'][$key]);
                echo "Product removed from cart.";
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-...." crossorigin="anonymous" />
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        section {
            width: 100%;
            max-width: 600px;
            text-align: center;
        }

        .cart-item {
            position: relative;
            border: 1px solid #ddd;
            padding: 10px;
            margin: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .remove-icon {
            position: absolute;
            top: 5px;
            right: 5px;
            cursor: pointer;
            color: red;
        }
    </style>
</head>
<body>
<header>
    <h1>Your Cart</h1>
    <a href="user.php">Back to catalog</a><br><br>
    <a href="../Enter/logout.php">Exit</a><br><br>

</header>

<section>
    <?php
    $total_cost = 0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $cart_item) {
            $total_cost += $cart_item['price'];
            ?>
            <div class="cart-item">
                    <span class="remove-icon" onclick="removeFromCart(<?php echo $cart_item['id']; ?>)">
                        <i class="fas fa-times"></i>
                    </span>
                <h3><?php echo $cart_item['name']; ?></h3>
                <p>Price: <?php echo $cart_item['price']; ?> ₴</p>
                <form action="" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $cart_item['id']; ?>">
                    <button type="submit" name="remove_from_cart" style="display: none;"></button>
                </form>
            </div>
            <?php
        }
    } else {
        echo "Your cart is empty.";
    }

    echo "<p>Total purchase price:" . number_format($total_cost, 2) . " ₴</p>";
    ?>

</section>

<script>
    function removeFromCart(productId) {
        if (confirm("Are you sure you want to remove this item from your cart??")) {
            document.querySelector('input[name="product_id"]').value = productId;
            document.querySelector('button[name="remove_from_cart"]').click();
        }
    }
</script>

</body>
</html>