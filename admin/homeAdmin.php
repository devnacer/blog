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
echo('<pre>');
// var_dump($_SESSION);
echo('</pre>');
$fullNameAdmin = $_SESSION['admin']['fullName'];
$idAdmin = $_SESSION['admin']['id'];

// Number of Published Articles by you
$sqls = $pdo->prepare('SELECT COUNT(*) as articleCount
                       FROM article
                       WHERE id_author = ?');
$sqls->execute([$idAdmin]);
$nbArticlesPublished = $sqls->fetch(PDO::FETCH_ASSOC);

// Latest Published Article title
$sqlstat = $pdo->prepare('SELECT title
                       FROM article
                       WHERE id_author = ?
                       ORDER BY date_creation DESC LIMIT 1');
$sqlstat->execute([$idAdmin]);
$titleLastArticlePublishedTitle = $sqlstat->fetch(PDO::FETCH_ASSOC);

// Latest Published Article Date
$sqlstatement = $pdo->prepare('SELECT date_creation
                       FROM article
                       WHERE id_author = ?
                       ORDER BY date_creation DESC LIMIT 1');
$sqlstatement->execute([$idAdmin]);
$titleLastArticlePublishedDate = $sqlstatement->fetch(PDO::FETCH_ASSOC);
//  var_dump($titleLastArticlePublishedDate);


///°°°°°°°°°°°°°°°°°°
// Number of Articles Published Last Month
// $articlesPublishedLastMonth['articleCount']
// $sql = 'SELECT COUNT(*) AS articleCount
//         FROM article
//         WHERE id_author = ?
//         AND DATE_FORMAT(date_creation, "%Y-%m") = DATE_FORMAT(CURDATE() - INTERVAL 1 MONTH, "%Y-%m")';

// $sqlStatement = $pdo->prepare($sql);
                       
// $sqlStatement->execute([$idAdmin]);
// $articlesPublishedLastMonth = $sqlStatement->fetch(PDO::FETCH_ASSOC);
// var_dump($articlesPublishedLastMonth);
///°°°°°°°°°°°°°°°°°°


//Your last articles // select lastest 3 article  
$sqlstate = $pdo->prepare('SELECT *
                            FROM article
                            WHERE id_author = ?
                            ORDER BY date_creation DESC
                            LIMIT 3');
$sqlstate->execute([$idAdmin]);
$lastThreeArticles = $sqlstate->fetchAll(PDO::FETCH_ASSOC);

// var_dump($lastThreeArticles);

?>

<div class="container">
    <p class="h1 my-5">Welcome, <?= $fullNameAdmin ?></p>

    <ul class="list-group">

        <li class="list-group-item d-flex justify-content-between align-items-center h6">
            Number of Articles Published by You:
            <span class="badge bg-primary rounded-pill"><?= $nbArticlesPublished['articleCount'] ?></span>
        </li>

        <li class="list-group-item d-flex justify-content-between align-items-center h6">
            Latest Published Article:
            <span class="badge bg-primary rounded-pill"><?= $titleLastArticlePublishedTitle['title'] ?> at <?= $titleLastArticlePublishedDate['date_creation']?></span>
        </li>
        <li class="list-group-item d-flex justify-content-between align-items-center h6">
            Number of Articles Published Last Month:
            <span class="badge bg-primary rounded-pill"></span>
        </li>

        <!-- <li class="list-group-item d-flex justify-content-between align-items-center h5">
            Number of Comments Received:
            <span class="badge bg-primary rounded-pill"></span>
        </li> -->
    </ul>

    <p class="h4 my-5">Your lastest articles <?= $fullNameAdmin ?></p>

    <div class="row row-cols-1 row-cols-md-3 g-4 mb-5">
            <?php foreach ($lastThreeArticles as $itemArticle) :?>

                <?php //select name categorie
                    $idCategory = $itemArticle['id_category'];
                    $sqlStatem = $pdo->prepare('SELECT name FROM category WHERE id = ?');
                    $sqlStatem->execute([$idCategory]);
                    $namecategory = $sqlStatem->fetch(PDO::FETCH_ASSOC);
                ?>

                <div class="col">
                    <div class="card h-100">

                        <img src="<?='../uploaded/'.$itemArticle['id_image']?>" class="card-img-top" alt="...">

                        <div class="card-body">
                            <h5 class="card-title"><?= $itemArticle['title']?></h5>
                            <p class="card-text">Category: <?= $namecategory['name'] ?></p>
                        </div>

                        <div class="card-footer">
                            <small class="text-muted">
                                <?php
                                    $publicationDate = $itemArticle['date_creation']; 
                                    $elapsedTime = time_elapsed_string($publicationDate);
                                    echo "Published $elapsedTime";            
                                ?>
                            </small>
                        </div>
                    </div>
                </div>
            <?php endforeach?>
        </div>

</div>

