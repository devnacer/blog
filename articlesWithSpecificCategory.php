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

//////
// select name of all categories
$sqls = $pdo->prepare('SELECT * FROM category');
$sqls->execute();
$categories = $sqls->fetchAll(PDO::FETCH_ASSOC);

// select articles
$idCateg = $_GET['id'];
$sqlstm = $pdo->prepare('SELECT * FROM article WHERE id_category = ? ORDER BY date_creation DESC');
$sqlstm->execute([$idCateg]);
$articles = $sqlstm->fetchAll(PDO::FETCH_ASSOC);

// select name category
$sqlsCateName =$pdo->prepare('SELECT name FROM category WHERE id = ?');
$sqlsCateName->execute([$idCateg]);
$nameCatego = $sqlsCateName->fetch(PDO::FETCH_ASSOC);
// echo '<pre>';
// var_dump($articles);
// echo '</pre>';
?>



 

<main class="container">

    <!-- categories -->
    <h2>Categories</h2>

    <div class="py-1 mb-2">
        <ul class="list-group list-group-horizontal d-flex justify-content-center flex-wrap list-unstyled">
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

                <li class="my-1 mx-1">
                    <a class="btn btn-primary" href="articlesWithSpecificCategory.php?id=<?= $itemCategory['id'] ?>">
                        <?= $itemCategory['name']?> 
                        <span class='"badge bg-light text-dark'>
                            <?= '('.$nbArticleByCategory['articleCount'].')'?>articles
                        </span>
                    </a>
                </li>

            <?php endforeach?>
        </ul> 
    </div>

    <!-- articles -->
    <h2>Last articles ( <?=$nameCatego['name']?> )</h2>
    <div class="d-flex flex-row justify-content-center flex-wrap gap-3">
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
            <div class="card" style="width: 24rem;">
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
            </div>
        <?php endforeach?>

    </div>



</main>
    
