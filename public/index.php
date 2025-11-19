<?php
$page_title = "Home";
$page_description = "Welcome to ShopMaster, your go-to e-commerce platform!";
include('../includes/header.php');
?>

<section class="hero">
    <h1>Welcome to ShopMaster</h1>
    <p>Your one-stop shop for the best products at unbeatable prices!</p>
    <a href="shop.php" class="cta-button">Shop Now</a>
</section>

<section class="featured-products">
    <h2>Featured Products</h2>
    <div class="product-list">
        <?php
        // Fetch featured products from the database (for now, all products)
        include('../config/database.php');
        
        $sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT 3";  // Fetching the 3 most recent products
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Loop through and display the products
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

<section class="about">
    <h2>About Us</h2>
    <p>At ShopMaster, we offer a variety of products that cater to your every need. From electronics to clothing, we have it all. Explore our store and find something you'll love!</p>
    <a href="about.php" class="cta-button">Learn More</a>
</section>

<?php
include('../includes/footer.php');
?>
