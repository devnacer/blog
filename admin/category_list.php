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

// Prepare and execute the SELECT query
$sqlStatement = $pdo->prepare('SELECT id, name, description FROM category');
$sqlStatement->execute();

// Fetch all records as an associative array
$listCategory = $sqlStatement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h2 class="mt-2">List categories</h2>

    <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            </tr>
        </thead>

        <tbody>
         <?php foreach($listCategory as $itemCategory) :?>
            <tr>
                <td><?= $itemCategory['id']?></td>
                <td><?= $itemCategory['name']?></td>
                <td><?= $itemCategory['description']?></td>
                <td>
                    <a href="category_update.php?id=<?php echo $itemCategory['id'] ?>" class="btn btn-primary">Edit</a>
                    <a href="category_delete.php?id=<?php echo $itemCategory['id'] ?>" onclick="return confirm('Are you sure you want to delete the category <?= $itemCategory['name']?> ?');" class="btn btn-danger">Delete</a>
                </td>
            </tr>
         <?php endforeach?>
        </tbody>
    </table>

</div>