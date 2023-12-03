<?php
// Define the page title
$pageTitle = 'Log in';

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
    <h2 class="mt-2">Log in</h2>

    <form method="POST">

    <?php

        $isFormValid = true;

        if (isset($_POST['login'])) {

                $email = $_POST['email'];
                $password = $_POST['password'];

                // Validate the "Email address" field
                if (!isValidEmail($email)) {
                    $isFormValid = false;
                }


                // Validate the "Password" field
                if (!isValidPassword($password, $minLengthPassword, $maxLengthPassword)) {
                    $isFormValid = false;
                }


                if ($isFormValid) {

                    // Insertion query
                    $sql = "SELECT * FROM admin WHERE email = ?";
                    
                    // Prepare the query
                    $stmt = $pdo->prepare($sql);
                    
                    // Execute the query with the provided values
                    $stmt->execute([$email]);
                    
                    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
                    var_dump($admin);
                    
                    if ($admin) {
                        // Password verification
                        $passwordHash = $admin['password'];
                        if (password_verify($password, $passwordHash)) {
                            session_start();
                            $_SESSION['admin'] = [
                                'id' => $admin['id'],
                                'fullName' => $admin['fullName'],
                                'adminName' => $admin['adminName'],
                                'email' => $admin['email'],
                                'role' => $admin['role'],
                                'password' => $admin['password'],
                                'date_creation' => $admin['date_creation']
                            ];
                            header('location: homeAdmin.php');
                            exit();
                        } else {
                            // Incorrect password

                            ?>
                                <div class="alert alert-success" role="alert">
                                <p>Error.</p>
                                </div>
                            <?php

                        }
                    } else {
                        // No admin found with this email

                        ?>
                            <div class="alert alert-warning" role="alert">
                            <p>Error.</p>
                            </div>
                        <?php

                    }
                            
                }             

            }
    ?>


            <div class="form-group">
                <label for="email" class="form-label mt-4">Email address</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email" required>
            </div>



            <div class="form-group">
                <label for "password" class="form-label mt-4">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" required>
            </div>



            <input type="submit" name="login" value="Log in" class="btn btn-primary mt-4 mb-4">

    </form>

</div>