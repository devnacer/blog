<?php
// Define the page title
$pageTitle = 'My Blog - Admin Area';

// Include the page header
require_once '../includes/headAdmin.php';

// Include the admin navigation bar
require_once '../includes/navBarAdmin.php';

//config
require_once '../includes/config.php';

// database conn
require_once '../includes/conn_db.php';

//functions
require_once '../includes/functions.php';

// check if the admin is connected
checkAdminSession();
?>

<div class="container">
    <h2 class="mt-2">Add Admin</h2>

    <form method="POST">

    <?php

        $isFormValid = true;

        if (isset($_POST['createAdmin'])) {

                $fullName = $_POST['fullName'];
                $adminName = $_POST['adminName'];
                $email = $_POST['email'];
                $role = $_POST['role'];
                $password = $_POST['password'];
                $confirmPassword = $_POST['confirmPassword'];
                $dateCreation = date('Y-m-d H:i:s'); 

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

                    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password using bcrypt

                    // Insertion query
                    $sql = "INSERT INTO admin (fullname, adminName, email, role, password, date_creation) VALUES (?, ?, ?, ?, ?, ?)";

                    // Prepare the query
                    $stmt = $pdo->prepare($sql);

                    // Execute the query with the provided values
                    if ($stmt->execute([$fullName, $adminName, $email, $role, $password, $dateCreation  ])) {

                            ?>
                                <div class="alert alert-success" role="alert">
                                <p>The administrator <strong><?=$adminName?></strong> has been added successfully.</p>
                                </div>
                            <?php

                    } else {

                            ?>
                                <div class="alert alert-success" role="alert">
                                <p>Error adding the administrator <strong><?=$adminName?></strong>.</p>
                                </div>
                            <?php
                            
                    }
                }

            }
    ?>

            <div class="form-group">
                <label for="fullName" class="form-label mt-4">Full Name</label>
                <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Enter full name" required>
            </div>

            <div class="form-group">
                <label for="adminName" class="form-label mt-4">Name</label>
                <input type="text" class="form-control" id="adminName" name="adminName" placeholder="Enter adminName" required>
            </div>

            <div class="form-group">
                <label for="email" class="form-label mt-4">Email address</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email" required>
            </div>

            <div class="form-group">
                <label for="role" class="form-label mt-4">Role</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="editor">Editor</option>
                    <option value="author">Author</option>
                    <option value="contributor">Contributor</option>
                    <option value="subscriber">Subscriber</option>
                    <option value="guest">Guest</option>
                    <option value="moderator">Moderator</option>
                    <option value="manager">Manager</option>
                    <option value="viewer">Viewer</option>
                    <option value="designer">Designer</option>
                    <option value="developer">Developer</option>
                    <option value="analyst">Analyst</option>
                    <option value="default" selected>Default</option>
                </select>
            </div>

            <div class="form-group">
                <label for "password" class="form-label mt-4">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" required>
            </div>

            <div class="form-group">
                <label for="confirmPassword" class="form-label mt-4">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" autocomplete="off" required>
            </div>


            <input type="submit" name="createAdmin" value="Create Admin" class="btn btn-primary mt-4 mb-4">

    </form>

</div>