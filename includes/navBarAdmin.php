<?php
session_start();
$AdminConnected = false;
if (isset($_SESSION['admin'])) {
    $AdminConnected = true;
}

$currentPage = $_SERVER['PHP_SELF'];
?>
<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Area</a>
        <!-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> -->
        <div class="collapse navbar-collapse" id="navbarColor01">
            <ul class="navbar-nav me-auto">

            <?php if ($AdminConnected):?>

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
                
            <?php else: ?>
            <!-- Redirect to login.php for non-authenticated admins -->
            <?php header('location: login.php'); ?>
            <?php endif; ?>

            </ul>

        </div>
    </div>
</nav>