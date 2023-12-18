<?php
// Define the page title
$pageTitle = 'My Blog - Admin Area';

// Include the page header
require_once 'includes/head.php';

// Include the admin navigation bar
require_once 'includes/navBar.php';

// database conn
require_once 'includes/conn_db.php';

//functions
require_once 'includes/functions.php';

//////
// select name of all categories
$sqls = $pdo->prepare('SELECT * FROM category');
$sqls->execute();
$categories = $sqls->fetchAll(PDO::FETCH_ASSOC);

// last article
$sqlstat = $pdo->prepare('SELECT * FROM article ORDER BY id DESC LIMIT 1');
$sqlstat->execute();
$lastArticle = $sqlstat->fetch(PDO::FETCH_ASSOC);

//select author
$idAuthor = $lastArticle['id_author'];
$sqlstatement = $pdo->prepare('SELECT adminName FROM admin WHERE id = ?');
$sqlstatement->execute([$idAuthor]);
$nameAuthor = $sqlstatement->fetch(PDO::FETCH_ASSOC);

//select category
$idCategory = $lastArticle['id_category'];
$sqlstate = $pdo->prepare('SELECT name FROM category WHERE id = ?');
$sqlstate->execute([$idCategory]);
$nameCategory = $sqlstate->fetch(PDO::FETCH_ASSOC);

// select articles

$articles = $pdo->query('SELECT * FROM article ORDER BY date_creation')->fetchAll(PDO::FETCH_ASSOC);

echo '<pre>';
var_dump($articles);
echo '</pre>';
?>

<div class="container">

  <!-- header navBar -->
  <header class="py-3">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">MyBlog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
                </li>
                <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            </div>
        </div>
    </nav>
  </header>
 
</div>

<main class="container">
    <!-- last article -->
    <div class="card bg-dark text-white">
        <img src="uploaded/<?= $lastArticle['id_image'] ?>" class="card-img" alt="...">
        <div class="card-img-overlay">
            <h5 class="card-title"><?= $lastArticle['title'] ?> <span class="badge bg-info text-dark"><?= $nameCategory['name'] ?></span>
            </h5>
            <p class="card-text"> 
                <?php
                    $nameAuthor = $nameAuthor['adminName'];
                    $publicationDate = $lastArticle['date_creation']; 
                    $elapsedTime = time_elapsed_string($publicationDate);
                    echo "Published $elapsedTime by $nameAuthor";            
                ?>
            </p>
            <a href="article.php?id=<?= $lastArticle['id'] ?>" class="btn btn-primary">Read More</a>
        </div>
    </div>

    <!-- categories -->
    <div class="py-1 mb-2">
     <ul class="list-group">
         <?php foreach($categories as $itemCategory):?>
            <?php
            //select nb category for each aricle
            $itemCategoryId = $itemCategory['id'];
            $slqsNbcateByArticle = $pdo->prepare('SELECT COUNT(*) as articleCount
                                                 FROM article 
                                                 WHERE id_category = ?');
            $slqsNbcateByArticle->execute([$itemCategoryId]);
            $nbArticleByCategory = $slqsNbcateByArticle->fetch(PDO::FETCH_ASSOC);
            ?>
             <li class="list-group-item">
                <a class="#" href="#"><?= $itemCategory['name']?> 
                    <span class='"badge bg-light text-dark'>
                        <?= '('.$nbArticleByCategory['articleCount'].')'?>articles
                    </span>
                </a>
             </li>
         <?php endforeach?>
     </ul> 
    </div>

    <!-- articles -->
    <?php foreach($articles as $article):?>
    <?php
        //select category
        $idCate = $article['id_category'];
        $sqlstateCate = $pdo->prepare('SELECT name FROM category WHERE id = ?');
        $sqlstateCate->execute([$idCate]);
        $nameCate = $sqlstateCate->fetch(PDO::FETCH_ASSOC);
        // Published
        $pubDate = $article['date_creation']; 
        $elapsedTime = time_elapsed_string($pubDate);
        // select author
        $idAuth = $article['id_author'];
        $sqlsAuth = $pdo->prepare('SELECT adminName FROM admin WHERE id = ?');
        $sqlsAuth->execute([$idAuth]); 
        $nameAuth = $sqlsAuth->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="card" style="width: 18rem;">
        <img src="uploaded/<?= $article['id_image']?>" class="card-img-top" alt="...">
        <div class="card-body">
            <h5 class="card-title"><?= $article['title']?></h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Category: <strong><?= $nameCate['name'] ?></strong></li>
            <li class="list-group-item">Published <strong><?= $elapsedTime ?></strong> by <strong><?= $nameAuth['adminName'] ?></strong></li>
        </ul>
        <div class="card-body">
            <a href="article.php?id=<?= $article['id'] ?>" class="btn btn-primary d-flex justify-content-center">Read More</a>

    </div>
    <?php endforeach?>


</div>
    
</main>