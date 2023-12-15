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

//Your last articles
$sqlstate = $pdo->prepare('SELECT *
                            FROM article
                            WHERE id_author = ?
                            ORDER BY date_creation DESC
                            LIMIT 3');
$sqlstate->execute([$idAdmin]);
$lastThreeArticles = $sqlstate->fetchAll(PDO::FETCH_ASSOC);
echo('<pre>');

var_dump($lastThreeArticles);
echo('<pre>');
var_dump($lastThreeArticles['title']);

?>

<div class="container">
    <p class="h1 my-2">Welcome, <?= $fullNameAdmin ?></p>

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

    <p class="h4 my-3">Your lastest articles <?= $fullNameAdmin ?></p>

    <div class="card-group">
        <?php foreach ($lastThreeArticles as $itemArticle) :?>
        <div class="card">
            <img src="<?='../uploaded/'.$itemArticle['id_image']?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?= $itemArticle['title']?></h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                </div>
                <div class="card-footer">
                <small class="text-muted">Last updated 3 mins ago</small>
            </div>
        </div>
        <?php endforeach?>
   </div>

</div>

