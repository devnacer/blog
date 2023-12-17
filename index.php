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
$sqls = $pdo->prepare('SELECT name FROM category');
$sqls->execute();
$categoryNames = $sqls->fetchAll(PDO::FETCH_ASSOC);

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

// echo '<pre>';
// var_dump($nameCategory);
// echo '</pre>';
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
         <?php foreach($categoryNames as $itemCategoryName):?>
             <li class="list-group-item">
                 <a class="#" href="#"><?= $itemCategoryName['name']?></a>
             </li>
         <?php endforeach?>
     </ul> 
    </div>
    
</main>