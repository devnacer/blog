<?php
// Define the page title
$pageTitle = 'My Blog - Admin Area';

// start session
session_start();

// minLength and maxLength for category name
$minLengthCategoryName = 3;
$maxLengthCategoryName = 55;

// minLength and maxLength for category description ;
$minLengthCategoryDesc = 3;
$maxLengthCategoryDesc = 255;

// Include the page header
require_once '../includes/header.php';

// Include the admin navigation bar
require_once '../includes/navBarAdmin.php';

// database conn
require_once '../includes/conn_db.php';

//functions
require_once '../includes/functions.php';

//select item admin 
$sqlStatement = $pdo->prepare('SELECT name, description FROM category WHERE id=?');
$id = $_GET['id'];
$sqlStatement->execute([$id]);
$itemCategory = $sqlStatement->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h2 class="mt-2">Edit category <strong><?= $itemCategory['name'] ?></strong></h2>

    <form method="POST">

    <?php

        $isFormValid = true;

        if (isset($_POST['updateCategory'])) {

                $categoryName = $_POST['categoryName'];
                $categoryDescription = $_POST['categoryDescription'];
            
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
                    $sql = "UPDATE category
                            SET name = ?,
                                description = ?
                            WHERE id = ?";

                    // Prepare the query
                    $stmt = $pdo->prepare($sql);

                    // Execute the query with the provided values
                    if ($stmt->execute([$categoryName, $categoryDescription, $id])) {

                        header('location: category_list.php');

                    } else {

                            ?>
                                <div class="alert alert-warning" role="alert">
                                <p>Error updating the category <strong><?=$categoryName?></strong>.</p>
                                </div>
                            <?php
                            
                    }
                }

            }
    ?>

            <div class="form-group">
                <label for="fullName" class="form-label mt-4">Name</label>
                <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="<?=$itemCategory['name']?>" required>
            </div>

            <div class="form-group">
                <label for="adminName" class="form-label mt-4">Description</label>
                <input type="text" class="form-control" id="categoryDescription" name="categoryDescription" placeholder="<?=$itemCategory['description']?>" required>
            </div>

            <input type="submit" name="updateCategory" value="Update category" class="btn btn-primary mt-4 mb-4">

    </form>

</div>