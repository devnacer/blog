<?php
// Define the page title
$pageTitle = 'My Blog - Admin Area';

// start session
session_start();

// Include the page header
require_once '../includes/header.php';

// Include the admin navigation bar
require_once '../includes/navBarAdmin.php';

// database conn
require_once '../includes/conn_db.php';

//functions
require_once '../includes/functions.php';

// Prepare and execute the SELECT query
$sqlStatement = $pdo->prepare('SELECT id, fullName, adminName, email, role FROM admin');
$sqlStatement->execute();

// Fetch all records as an associative array
$listAdmin = $sqlStatement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h2 class="mt-2">List Admin</h2>

    <table class="table">
        <thead>
            <tr>
            <th scope="col">#</th>
            <th scope="col">Full name</th>
            <th scope="col">Admin name</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            </tr>
        </thead>

        <tbody>
         <?php foreach($listAdmin as $itemAdmin) :?>
            <tr>
                <td><?= $itemAdmin['id']?></td>
                <td><?= $itemAdmin['fullName']?></td>
                <td><?= $itemAdmin['adminName']?></td>
                <td><?= $itemAdmin['email']?></td>
                <td><?= $itemAdmin['role']?></td>
                <td>
                    <a href="admin_update.php?id=<?php echo $itemAdmin['id'] ?>" class="btn btn-primary">Edit</a>
                    <a href="admin_delete.php?id=<?php echo $itemAdmin['id'] ?>" onclick="return confirm('Are you sure you want to delete the admin <?= $itemAdmin['adminName'] ?> ?');" class="btn btn-danger">Delete</a>
                </td>
            </tr>
         <?php endforeach?>
        </tbody>
    </table>

</div>