<?php
// Define the page title
$pageTitle = 'My Blog - Admin Area';

// minLength and maxLength for fullName, username, role
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
?>

<div class="container">
    <h2 class="mt-2">Add Admin</h2>

    <form method="POST">


        <?php $isFormValid = true; ?>
        <?php if (isset($_POST['createAdmin'])) : ?>
            <div class="form-group">
                <label for="fullName" class="form-label mt-4">Full Name</label>
                <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Enter full name" required>
                <small id="nameHelp" class="form-text text-muted">
                    <?php
                    $fullName = $_POST['fullName'];
                    // Validate the full name
                    if (!isValidName($fullName, $minLengthName, $maxLengthName)) {
                        echo "The 'Full Name' field is invalid.";
                        $isFormValid = false;
                    }
                    ?>
                </small>
            </div>


            <div class="form-group">
                <label for="username" class="form-label mt-4">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" required>
                <small id="usernameHelp" class="form-text text-muted">
                    <?php
                    // Validate the "Username" field
                    $username = $_POST['username'];
                    if (!isValidName($username, $minLengthName, $maxLengthName)) {
                        echo "The 'Username' field is invalid.";
                        $isFormValid = false;
                    }
                    ?>
                </small>
            </div>


            <div class="form-group">
                <label for="email" class="form-label mt-4">Email address</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email" required>
                <small id="emailHelp" class="form-text text-muted">
                    <?php
                    // Validate the "Email address" field
                    $email = $_POST['email'];
                    if (!isValidEmail($email)) {
                        echo "The email address is not valid.";
                        $isFormValid = false;
                    }
                    ?>
                </small>
            </div>


            <div class="form-group">
                <label for="role" class="form-label mt-4">Role</label>
                <input type="text" class="form-control" id="role" name="role" placeholder="Enter role" required>
                <small id="roleHelp" class="form-text text-muted">
                    <?php
                    // Validate the "Role" field
                    $role = $_POST['role'];
                    if (!isValidName($role, $minLengthName, $maxLengthName)) {
                        echo "The 'Role' field is invalid.";
                        $isFormValid = false;
                    }
                    ?>
                </small>
            </div>


            <div class="form-group">
                <label for "password" class="form-label mt-4">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" required>
                <small id="passwordHelp" class="form-text text-muted">
                    <?php
                    // Validate the "Password" field
                    $password = $_POST['password'];
                    if (!isValidPassword($password, $minLengthPassword, $maxLengthPassword)) {
                        echo "The password is not valid.";
                        $isFormValid = false;
                    }
                    ?>
                </small>
            </div>




            <div class="form-group">
                <label for="confirmPassword" class="form-label mt-4">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" autocomplete="off" required>
                <small id="confirmPasswordHelp" class="form-text text-muted">
                    <?php
                    // Validate the "Confirm Password" field
                    $confirmPassword = $_POST['confirmPassword'];
                    if (!isValidPassword($confirmPassword, $minLengthPassword, $maxLengthPassword)) {
                        echo "The confirmation password is not valid.";
                        $isFormValid = false;
                    }
                    // Check if the passwords match
                    if ($password !== $confirmPassword) {
                        $isFormValid = false;
                    }

                    ?>
                </small>
            </div>

            <?php if ($isFormValid) {

                $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hachez le mot de passe

                // Requête d'insertion
                $sql = "INSERT INTO admin (fullname, username, email, role, password) VALUES (?, ?, ?, ?, ?)";

                // Préparez la requête
                $stmt = $pdo->prepare($sql);

                if ($stmt->execute([$fullName, $username, $email, $role, $password])) {
                    echo "L'administrateur a été ajouté avec succès.";
                } else {
                    echo "Erreur lors de l'ajout de l'administrateur.";
                }
            } ?>


            <input type="submit" name="createAdmin" value="Create Admin" class="btn btn-primary mt-4 mb-4">

        <?php endif; ?>
    </form>






</div>