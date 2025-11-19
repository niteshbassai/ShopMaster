<?php
$page_title = "Shop";
$page_description = "Browse our products and find the best deals.";
include('../includes/header.php');
?>

<section class="shop">
    <h2>Our Products</h2>
    <div class="product-list">
        <?php
        // Fetch products from the database
        include('../config/database.php');
        
        $sql = "SELECT * FROM products ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Display products
            while ($product = $result->fetch_assoc()) {
                echo '
                <div class="product-card">
                    <img src="../uploads/' . $product['image'] . '" alt="' . $product['name'] . '">
                    <h3>' . $product['name'] . '</h3>
                    <p>$' . number_format($product['price'], 2) . '</p>
                    <a href="single-product.php?id=' . $product['id'] . '">View Product</a>
                </div>';
            }
        } else {
            echo "<p>No products available at the moment.</p>";
        }
        ?>
    </div>
</section>

<?php
include('../includes/footer.php');
?>
