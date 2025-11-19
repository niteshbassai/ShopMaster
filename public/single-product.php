<?php
$page_title = "Product Details";
$page_description = "See more details about the product.";
include('../includes/header.php');

// Fetch product ID from URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch product details from the database
    include('../config/database.php');
    $sql = "SELECT * FROM products WHERE id = $product_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        ?>
        <section class="single-product">
            <h2><?php echo $product['name']; ?></h2>
            <div class="product-details">
                <div class="product-image">
                    <img src="../uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                </div>
                <div class="product-info">
                    <p><strong>Price:</strong> $<?php echo number_format($product['price'], 2); ?></p>
                    <p><strong>Description:</strong> <?php echo nl2br($product['description']); ?></p>
                    <a href="cart.php?add=<?php echo $product['id']; ?>" class="cta-button">Add to Cart</a>
                </div>
            </div>
        </section>
        <?php
    } else {
        echo "<p>Product not found.</p>";
    }
} else {
    echo "<p>No product selected.</p>";
}

include('../includes/footer.php');
?>
