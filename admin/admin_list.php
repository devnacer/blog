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

// Check the admin's role 
$adminRole = isset($_SESSION['admin']['role']) ? $_SESSION['admin']['role'] : '';

// Store the ID of the connected admin
$connectedAdminId = $_SESSION['admin']['id'];

// Prepare and execute the SELECT query
$sqlStatement = $pdo->prepare('SELECT id, fullName, adminName, email, role FROM admin WHERE id <> :connectedAdminId');
$sqlStatement->execute([':connectedAdminId' => $connectedAdminId]);

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
            <th scope="col">Name</th>
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

                <?php if (canEditDeleteAdmin($adminRole)): ?>

                <td>

                    <a href="admin_update.php?id=<?php echo $itemAdmin['id'] ?>" class="btn btn-primary">Edit</a>

                    <a href="admin_delete.php?id=<?php echo $itemAdmin['id'] ?>" onclick="return confirm('Are you sure you want to delete the admin <?= $itemAdmin['adminName'] ?> ?');" class="btn btn-danger">Delete</a>

                </td>

                <?php endif; ?>
            </tr>
         <?php endforeach?>
        </tbody>
    </table>

</div>