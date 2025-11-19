<?php
session_start();

// If the 'add' parameter is passed in the URL
if (isset($_GET['add'])) {
    $product_id = $_GET['add'];
    
    // Check if the product_id exists in the database
    include('../config/database.php');
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // If the cart doesn't exist, create it
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Add the product to the cart (we'll store the product ID and quantity)
        $product_exists = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['id'] == $product_id) {
                $item['quantity']++;
                $product_exists = true;
                break;
            }
        }

        // If the product is not already in the cart, add it
        if (!$product_exists) {
            $_SESSION['cart'][] = [
                'id' => $product_id,
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1,
                'image' => $product['image']
            ];
        }

        // Redirect back to the shop page or cart page
        header('Location: shop.php');
        exit();
    } else {
        echo "Product not found!";
    }
}
?>

<!-- Optionally, display cart contents here -->
<section class="cart">
    <h2>Your Cart</h2>
    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
        <table>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $item):
                $item_total = $item['price'] * $item['quantity'];
                $total += $item_total;
            ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td>$<?php echo $item['price']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>$<?php echo $item_total; ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" align="right">Total</td>
                <td>$<?php echo $total; ?></td>
            </tr>
        </table>
    <?php else: ?>
        <p>Your cart is empty.</p>
    <?php endif; ?>
    <a href="checkout.php" class="cta-button">Proceed to Checkout</a>
</section>
