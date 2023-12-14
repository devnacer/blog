<?php
// Define the page title
$pageTitle = 'My Blog - Admin Area';

// Include the page header
require_once '../includes/header.php';

// Include the admin navigation bar
require_once '../includes/navBarAdmin.php';

// database conn
require_once '../includes/conn_db.php';

//functions
require_once '../includes/functions.php';

// check if the admin is connected
checkAdminSession();

// select article
// Prepare and execute the SELECT query
$id = $_GET['id'];
$sqlStatement = $pdo->prepare('SELECT * FROM article WHERE id = ?');
$sqlStatement->execute([$id]);

// Fetch all records as an associative array
$itemArticle = $sqlStatement->fetch(PDO::FETCH_ASSOC);
echo('<pre>');
// var_dump($itemArticle);
echo('</pre>');
?>

<div class="container">
    <h2 class="mt-2"><?= $itemArticle['title']?></h2>

    <div class="article-details">
        <p><strong>Category:</strong> </p>
        <p><strong>Created by:</strong> </p>
        <p><strong>Date:</strong> <?= $itemArticle['date_creation']?></p>
    </div>

    <div class="article-content">
        <p><?= $itemArticle['content']?></p>
    </div>
</div>
