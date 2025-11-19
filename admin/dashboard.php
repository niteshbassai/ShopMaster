<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../public/login.php");
    exit();
}

$page_title = "Admin Dashboard";
$page_description = "Manage products and other admin tasks.";
include('../includes/header.php');
?>

<section class="admin-dashboard">
    <h2>Admin Dashboard</h2>
    <a href="product-crud.php?action=add" class="cta-button">Add New Product</a>
    
    <h3>Products List</h3>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch products from the database
            include('../config/database.php');
            
            $sql = "SELECT * FROM products ORDER BY created_at DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($product = $result->fetch_assoc()) {
                    echo '
                    <tr>
                        <td>' . $product['id'] . '</td>
                        <td>' . $product['name'] . '</td>
                        <td>$' . number_format($product['price'], 2) . '</td>
                        <td>' . $product['category_id'] . '</td>
                        <td>
                            <a href="product-crud.php?action=edit&id=' . $product['id'] . '">Edit</a> |
                            <a href="product-crud.php?action=delete&id=' . $product['id'] . '" onclick="return confirm(\'Are you sure?\')">Delete</a>
                        </td>
                    </tr>';
                }
            } else {
                echo "<tr><td colspan='5'>No products found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="logout.php" class="cta-button">Logout</a>
</section>

<?php
include('../includes/footer.php');
?>
