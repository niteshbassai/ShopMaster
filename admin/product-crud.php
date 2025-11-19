<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../public/login.php");
    exit();
}

$page_title = "Product Management";
$page_description = "Add, edit, or delete products.";
include('../includes/header.php');

// Handle add, edit, delete actions
include('../config/database.php');

$action = isset($_GET['action']) ? $_GET['action'] : '';

// Add Product
if ($action == 'add' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    // Move uploaded image to the uploads folder
    $image_path = '../uploads/' . $image;
    move_uploaded_file($image_tmp, $image_path);

    // Insert product into database
    $sql = "INSERT INTO products (name, description, price, category_id, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdis", $name, $description, $price, $category_id, $image);
    $stmt->execute();
    header("Location: dashboard.php");
    exit();
}

// Edit Product
if ($action == 'edit' && isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get updated product data
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $category_id = $_POST['category_id'];
        
        // Handle image upload (if new image is provided)
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        if ($image) {
            $image_path = '../uploads/' . $image;
            move_uploaded_file($image_tmp, $image_path);
        } else {
            $image_path = $_POST['current_image']; // Use current image if no new one is provided
        }

        // Update the product in the database
        $sql = "UPDATE products SET name = ?, description = ?, price = ?, category_id = ?, image = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdisi", $name, $description, $price, $category_id, $image_path, $id);
        $stmt->execute();
        header("Location: dashboard.php");
        exit();
    }

    // Fetch product data for editing
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = $id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();
}

// Delete Product
if ($action == 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM products WHERE id = $id";
    $conn->query($sql);
    header("Location: dashboard.php");
    exit();
}
?>

<section class="product-crud">
    <h2><?php echo $action == 'edit' ? 'Edit Product' : 'Add Product'; ?></h2>

    <form action="product-crud.php?action=<?php echo $action == 'edit' ? 'edit&id=' . $product['id'] : 'add'; ?>" method="POST" enctype="multipart/form-data">
        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" value="<?php echo isset($product['name']) ? $product['name'] : ''; ?>" required>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo isset($product['description']) ? $product['description'] : ''; ?></textarea>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" value="<?php echo isset($product['price']) ? $product['price'] : ''; ?>" required>

        <label for="category_id">Category:</label>
        <input type="number" id="category_id" name="category_id" value="<?php echo isset($product['category_id']) ? $product['category_id'] : ''; ?>" required>

        <label for="image">Product Image:</label>
        <input type="file" id="image" name="image">
        <?php if (isset($product['image'])): ?>
            <img src="../uploads/<?php echo $product['image']; ?>" alt="Product Image" width="100">
            <input type="hidden" name="current_image" value="<?php echo $product['image']; ?>">
        <?php endif; ?>

        <button type="submit" class="cta-button"><?php echo $action == 'edit' ? 'Update Product' : 'Add Product'; ?></button>
    </form>
</section>

<?php
include('../includes/footer.php');
?>
