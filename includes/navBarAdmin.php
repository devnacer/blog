<?php
session_start();
$currentPage = $_SERVER['PHP_SELF'];

// Check if the admin is connected
$isAdminConnected = isset($_SESSION['admin']);

//functions
require_once '../includes/functions.php';

// Check the admin's role 
$adminRole = isset($_SESSION['admin']['role']) ? $_SESSION['admin']['role'] : '';
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
                    <?php if (canEditDeleteAdmin($adminRole)): ?>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($currentPage == '/blog/admin/admin_create.php') echo 'active' ?>" 
                        href="admin_create.php">
                        Add Admin</a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link <?php if ($currentPage == '/blog/admin/admin_list.php') echo 'active' ?>" 
                        href="admin_list.php">
                        List of Other admins</a>
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
                        <a class="nav-link" href="article_list.php">List articles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="setting.php">Setting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

