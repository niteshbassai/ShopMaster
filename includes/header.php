<?php
// header.php
$current_page = basename($_SERVER['PHP_SELF']);  // Get the current page name
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopMaster - <?php echo isset($page_title) ? $page_title : "Home"; ?></title>
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : "Welcome to ShopMaster, your go-to e-commerce platform!"; ?>">
    <link rel="stylesheet" href="/ShopMaster/assets/css/styles.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="/ShopMaster/public/index.php" class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">Home</a></li>
                <li><a href="/ShopMaster/public/about.php" class="<?php echo $current_page == 'about.php' ? 'active' : ''; ?>">About</a></li>
                <li><a href="/ShopMaster/public/shop.php" class="<?php echo $current_page == 'shop.php' ? 'active' : ''; ?>">Shop</a></li>
                <li><a href="/ShopMaster/public/contact.php" class="<?php echo $current_page == 'contact.php' ? 'active' : ''; ?>">Contact</a></li>
                <li><a href="/ShopMaster/public/login.php" class="<?php echo $current_page == 'login.php' ? 'active' : ''; ?>">Admin Login</a></li>
                <li><a href="/ShopMaster/public/admin-register.php" class="<?php echo $current_page == 'admin-register.php' ? 'active' : ''; ?>">Admin Register</a></li> <!-- Added link to admin registration -->
            </ul>
        </nav>
    </header>
    <main>
