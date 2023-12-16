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
    <h2 class="mt-2">Create category</h2>

    <form method="POST">

    <?php

        $isFormValid = true;

        if (isset($_POST['createCategory'])) {

                $categoryName = $_POST['categoryName'];
                $categoryDescription = $_POST['categoryDescription'];
                $dateCreation = date('Y-m-d H:i:s'); 
            
                // Validate the category name
                if (!isValidName($categoryName, $minLengthCategoryName, $maxLengthCategoryName)) {
                
                    ?>
                        <div class="alert alert-warning" role="alert">
                        <p>The 'category name' field is invalid.</p>
                        </div>
                    <?php

                    $isFormValid = false;
                }

                // Validate the "category description" field
                if (!isValidName($categoryDescription, $minLengthCategoryDesc, $maxLengthCategoryDesc)) {

                    ?>
                        <div class="alert alert-warning" role="alert">
                        <p>The 'category description' field is invalid.</p>
                        </div>
                    <?php

                    $isFormValid = false;
                }

                
                if ($isFormValid) {


                    // Insertion query
                    $sql = "INSERT INTO category (name, description, date_creation) VALUES (?, ?, ?)";

                    // Prepare the query
                    $stmt = $pdo->prepare($sql);

                    // Execute the query with the provided values
                    if ($stmt->execute([$categoryName, $categoryDescription, $dateCreation])) {

                            ?>
                                <div class="alert alert-success" role="alert">
                                <p>The category <strong><?=$categoryName?></strong> has been added successfully.</p>
                                </div>
                            <?php

                    } else {

                            ?>
                                <div class="alert alert-success" role="alert">
                                <p>Error adding the category <strong><?=$categoryName?></strong>.</p>
                                </div>
                            <?php
                            
                    }
                }

            }
    ?>

            <div class="form-group">
                <label for="fullName" class="form-label mt-4">Name</label>
                <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="Enter name of category" required>
            </div>

            <div class="form-group">
                <label for="adminName" class="form-label mt-4">Description</label>
                <input type="text" class="form-control" id="categoryDescription" name="categoryDescription" placeholder="Enter description of category" required>
            </div>


            <input type="submit" name="createCategory" value="Create category" class="btn btn-primary mt-4 mb-4">

    </form>

</div>