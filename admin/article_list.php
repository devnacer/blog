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

// select all articles
// Prepare and execute the SELECT query
$sqlStatement = $pdo->prepare('SELECT * FROM article');
$sqlStatement->execute();

// Fetch all records as an associative array
$listArticle = $sqlStatement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h2 class="mt-2">List Articles</h2>

    <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Category</th>
            <th scope="col">Author</th>
            <th scope="col">Date creation</th>
            </tr>
        </thead>

        <tbody>
         <?php foreach($listArticle as $itemArticle) :?>

            <?php
            // select category
            $idCategory = $itemArticle['id_category'];
            $sqls = $pdo->prepare('SELECT name FROM category WHERE id = ?');
            $sqls->execute([$idCategory]);
            $categoryName = $sqls->fetch(PDO::FETCH_ASSOC);
            // select Author
            $idAuthor = $itemArticle['id_author'];
            $sqlStat = $pdo->prepare('SELECT adminName FROM admin WHERE id = ?');
            $sqlStat->execute([$idAuthor]);
            $authorName = $sqlStat->fetch(PDO::FETCH_ASSOC);
            ?>

            <tr>
                <td><?= $itemArticle['id']?></td>
                <td><?= $itemArticle['title']?></td>
                <td><?= $categoryName['name']?></td>
                <td><?= $authorName['adminName']?></td>
                <td><?= $itemArticle['date_creation']?></td>

                <td>

                    <a href="article_update.php?id=<?php echo $itemArticle['id'] ?>" class="btn btn-primary">Edit</a>

                    <a href="article_delete.php?id=<?php echo $itemArticle['id'] ?>" onclick="return confirm('Are you sure you want to delete the article <?= $itemArticle['title'] ?> ?');" class="btn btn-danger">Delete</a>

                </td>

            </tr>
         <?php endforeach?>
        </tbody>
    </table>

</div>