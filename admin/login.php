<?php
// Define the page title
$pageTitle = 'Log in';

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

$isAdminConnected = isset($_SESSION['admin']);

// Redirect to homeAdmin.php if the admin is connected
if ($isAdminConnected) {
header("Location: homeAdmin.php");
exit();
}
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
