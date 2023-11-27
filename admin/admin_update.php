<?php
// Define the page title
$pageTitle = 'My Blog - Admin Area';

// minLength and maxLength for fullName, adminName, role
$minLengthName = 3;
$maxLengthName = 55;

// minLength and maxLength for Password;
$minLengthPassword = 3;
$maxLengthPassword = 55;

// Include the page header
require_once '../includes/header.php';

// Include the admin navigation bar
require_once '../includes/navBarAdmin.php';

// database conn
require_once '../includes/conn_db.php';

//functions
require_once '../includes/functions.php';

//select item admin 
$sqlStatement = $pdo->prepare('SELECT fullName, adminName, email, role FROM admin WHERE id=?');
$id = $_GET['id'];
$sqlStatement->execute([$id]);
$itemUpdate = $sqlStatement->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h2 class="mt-2">Edit Admin <?= $itemUpdate['adminName'] ?></h2>

    <form method="POST">

    <?php

        $isFormValid = true;

        if (isset($_POST['editAdmin'])) {

                $fullName = $_POST['fullName'];
                $adminName = $_POST['adminName'];
                $email = $_POST['email'];
                $role = $_POST['role'];
                $password = $_POST['password'];
                $confirmPassword = $_POST['confirmPassword'];

                // Validate the full name
                if (!isValidName($fullName, $minLengthName, $maxLengthName)) {
                
                    ?>
                        <div class="alert alert-warning" role="alert">
                        <p>The 'Full Name' field is invalid.</p>
                        </div>
                    <?php

                    $isFormValid = false;
                }

                // Validate the "adminName" field
                if (!isValidName($adminName, $minLengthName, $maxLengthName)) {

                    ?>
                        <div class="alert alert-warning" role="alert">
                        <p>The 'adminName' field is invalid.</p>
                        </div>
                    <?php

                    $isFormValid = false;
                }

                // Validate the "Email address" field
                if (!isValidEmail($email)) {

                    ?>
                        <div class="alert alert-warning" role="alert">
                        <p>The email address is not valid.</p>
                        </div>
                    <?php

                    $isFormValid = false;
                }

                // Validate the "Role" field
                if (!isValidName($role, $minLengthName, $maxLengthName)) {

                    ?>
                        <div class="alert alert-warning" role="alert">
                        <p>The 'Role' field is invalid.</p>
                        </div>
                    <?php

                    $isFormValid = false;
                }

                // Validate the "Password" field
                if (!isValidPassword($password, $minLengthPassword, $maxLengthPassword)) {

                    ?>
                        <div class="alert alert-warning" role="alert">
                        <p>The password is not valid.</p>
                        </div>
                    <?php

                    $isFormValid = false;
                }

                // Check if the passwords match
                if (!isValidPassword($confirmPassword, $minLengthPassword, $maxLengthPassword) || ($password !== $confirmPassword)) {

                    ?>
                        <div class="alert alert-warning" role="alert">
                        <p>The confirmation password is not valid.</p>
                        </div>
                    <?php


                    $isFormValid = false;
                }


                if ($isFormValid) {

                    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password using bcrypt

                    // Insertion query
                    $sql = "UPDATE admin
                            SET fullname = ?,
                                adminName = ?,
                                email = ?,
                                role = ?,
                                password = ? 
                            WHERE id = ?";

                    // Prepare the query
                    $stmt = $pdo->prepare($sql);

                    // Execute the query with the provided values
                    if ($stmt->execute([$fullName, $adminName, $email, $role, $password, $id])) {

                            ?>
                                <div class="alert alert-success" role="alert">
                                <p>The administrator <strong><?=$adminName?></strong> has been updated successfully.</p>
                                </div>
                            <?php

                    } else {

                            ?>
                                <div class="alert alert-success" role="alert">
                                <p>Error updating the administrator <strong><?=$adminName?></strong>.</p>
                                </div>
                            <?php
                            
                    }
                }

            }
    ?>

            <div class="form-group">
                <label for="fullName" class="form-label mt-4">Full Name</label>
                <input type="text" class="form-control" id="fullName" name="fullName" placeholder="<?= $itemUpdate['fullName'] ?>" required>
            </div>

            <div class="form-group">
                <label for="adminName" class="form-label mt-4">Admin Name</label>
                <input type="text" class="form-control" id="adminName" name="adminName" placeholder="<?= $itemUpdate['adminName'] ?>" required>
            </div>

            <div class="form-group">
                <label for="email" class="form-label mt-4">Email address</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="<?= $itemUpdate['email'] ?>" required>
            </div>

            <div class="form-group">
                <label for="role" class="form-label mt-4">Role</label>
                <input type="text" class="form-control" id="role" name="role" placeholder="<?= $itemUpdate['role'] ?>" required>
            </div>

            <div class="form-group">
                <label for "password" class="form-label mt-4">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your new password" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label for="confirmPassword" class="form-label mt-4">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm your new password" autocomplete="off" required>
            </div>


            <input type="submit" name="editAdmin" value="Edit Admin" class="btn btn-primary mt-4 mb-4">

    </form>

</div>