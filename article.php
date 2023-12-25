<?php
// Define the page title
$pageTitle = 'My Blog - Admin Area';

// Include the page header
require_once 'includes/head.php';

// Include the navigation bar
require_once 'includes/navBar.php';

// database conn
require_once 'includes/conn_db.php';

//functions
require_once 'includes/functions.php';

// select article
$idArticle = $_GET['id'];
$sqlsArticle = $pdo->prepare('SELECT * FROM article WHERE id = ?');
$sqlsArticle->execute([$idArticle]);
$itemArticle = $sqlsArticle->fetch(PDO::FETCH_ASSOC);

// select category
$idCatego = $itemArticle['id_category'];
$sqlsCatego = $pdo->prepare('SELECT name FROM category WHERE id = ?');
$sqlsCatego->execute([$idCatego]);
$nameCatego = $sqlsCatego->fetch(PDO::FETCH_ASSOC);

// select author
$idAuthor = $itemArticle['id_author'];
$sqlsAuthor = $pdo->prepare('SELECT adminName FROM admin WHERE id = ?');
$sqlsAuthor->execute([$idAuthor]);
$nameAuthor = $sqlsAuthor->fetch(PDO::FETCH_ASSOC);
?>



 

<main class="container">
    <!-- articles --> 
    <article>
        <h1><?= $itemArticle['title']?></h1>

        <div class="image">
            <img src="Uploaded/<?= $itemArticle['id_image'] ?>" class="img img-fluid" alt="">
        </div>
        
        <p><strong>Title:</strong><?= $itemArticle['title']?></p>
        
        <p><?= $itemArticle['content']?></p>

        <div class="info">
            <p><strong>Author:</strong> <?= $nameAuthor['adminName']?> </p>
            <p><strong>Date:</strong> <?= $itemArticle['date_creation']?></p>
            <p><strong>Category:</strong> <?= $nameCatego['name']?></p>
        </div>
    </article>

</main>
    
<?php include('includes/footer.php')?>
