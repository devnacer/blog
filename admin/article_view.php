<?php
// Define the page title
$pageTitle = 'My Blog - Admin Area';

// Include the page header
require_once '../includes/headAdmin.php';

// Include the admin navigation bar
require_once '../includes/navBarAdmin.php';

// database conn
require_once '../includes/conn_db.php';

//functions
require_once '../includes/functions.php';

// check if the admin is connected
checkAdminSession();

// select article
$id = $_GET['id'];
$sqlStatement = $pdo->prepare('SELECT * FROM article WHERE id = ?');
$sqlStatement->execute([$id]);
$itemArticle = $sqlStatement->fetch(PDO::FETCH_ASSOC);

// select item category
$idCategory = $itemArticle['id_category']; 
$sqls = $pdo->prepare('SELECT name FROM category WHERE id = ?');
$sqls->execute([$idCategory]);
$nameCategorie = $sqls->fetch(PDO::FETCH_ASSOC);
// select item admin(Author)
$idAdmin = $itemArticle['id_author'];
$sqlstat = $pdo->prepare('SELECT adminName FROM admin WHERE id = ?');
$sqlstat->execute([$idAdmin]);
$nameAdmin = $sqlstat->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">

    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="article_update.php?id=<?php echo $itemArticle['id'] ?>" class="btn btn-primary btn-lg">Edit</a>

        <a href="article_delete.php?id=<?php echo $itemArticle['id'] ?>" onclick="return confirm('Are you sure you want to delete the article <?= $itemArticle['title'] ?> ?');" class="btn btn-danger btn-lg">Delete</a>
    </div>

    <div class="article-header my-4">
        <h2><?= $itemArticle['title']?></h2>
    </div>

    <div class="article-details ">
        <p><strong>Category:</strong> <?= $nameCategorie['name']?></p>
        <p><strong>Created by:</strong> <?= $nameAdmin['adminName']?> </p>
        <p><strong>Created on:</strong> <?= $itemArticle['date_creation']?></p>
    </div>

    <div class="article-image mt-4">
        <img class="img img-fluid" src="../uploaded/<?= $itemArticle['id_image']?>" alt="">
    </div>

    <div class="article-content my-4">
        <p><?= $itemArticle['content']?></p>
    </div>
</div>
