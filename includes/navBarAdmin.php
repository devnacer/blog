<?php
session_start();
$currentPage = $_SERVER['PHP_SELF'];

// Check if the admin is connected
$isAdminConnected = isset($_SESSION['admin']);
?>

<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Area</a>
        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav me-auto">
                <?php if ($isAdminConnected): ?>
                    <!-- Display these links only if the admin is connected -->
                    <li class="nav-item">
                        <a class="nav-link <?php if ($currentPage == '/blog/admin/homeAdmin.php') echo 'active' ?>" 
                        href="homeAdmin.php">
                        Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($currentPage == '/blog/admin/admin_create.php') echo 'active' ?>" 
                        href="admin_create.php">
                        Add Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($currentPage == '/blog/admin/admin_list.php') echo 'active' ?>" 
                        href="admin_list.php">
                        List Admin</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($currentPage == '/blog/admin/category_create.php') echo 'active' ?>" 
                        href="category_create.php">
                        Add category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($currentPage == '/blog/admin/category_list.php') echo 'active' ?>" 
                        href="category_list.php">
                        List category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($currentPage == '/blog/admin/article_create.php') echo 'active' ?>" 
                        href="article_create.php">
                        Add article</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

