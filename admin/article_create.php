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

// Prepare and execute the SELECT query 'select categories'
$sqlStatement = $pdo->prepare('SELECT id, name FROM category');
$sqlStatement->execute();
$categories = $sqlStatement->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <h2 class="mt-2">Add article</h2>

    <form method="POST" enctype="multipart/form-data">

    <?php

        $isFormValid = true;

        if (isset($_POST['createArticle'])) {

                $title = $_POST['title'];
                $content = $_POST['content'];
                $category = $_POST['category'];
                $id_author = $_SESSION['admin']['id'];
                $dateCreation = date('Y-m-d H:i:s'); 
                 
                $id_image = 'blog.jpg'; 

                if(!empty($_FILES['image']['name'])){
                    $imageName = $_FILES['image']['name'];
                    $id_image = uniqid().$imageName;
                    move_uploaded_file($_FILES['image']['tmp_name'], '../uploaded/'.$id_image);
                }

                // Validate the "title" field
                if (!isValidName($title, $minLengthTitle, $maxLengthTitle)) {
                
                    ?>
                        <div class="alert alert-warning" role="alert">
                        <p>The 'Title' field is invalid.</p>
                        </div>
                    <?php

                    $isFormValid = false;
                }

                // Validate the "content" field
                if (!isValidName($content, $minLengthContent, $maxLengthContent)) {
            
                        ?>
                            <div class="alert alert-warning" role="alert">
                            <p>The 'content' field is invalid.</p>
                            </div>
                        <?php

                    $isFormValid = false;
                }


                if ($isFormValid) {

                    // Insertion query
                    $sql = "INSERT INTO article (title, content, id_category, id_author, id_image, date_creation) VALUES (?, ?, ?, ?, ?, ?)";

                    // Prepare the query
                    $stmt = $pdo->prepare($sql);

                    // Execute the query with the provided values
                    if ($stmt->execute([$title, $content, $category, $id_author, $id_image, $dateCreation])) {

                        header('location: article_list.php');

                    } else {

                            ?>
                                <div class="alert alert-success" role="alert">
                                <p>Error adding the article <strong><?=$title?></strong>.</p>
                                </div>
                            <?php
                            
                    }
                }

            }
    ?>

            <div class="form-group">
                <label for="fullName" class="form-label mt-4">Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter the title" required>
            </div>

            <div class="form-group">
                <label for="content" class="form-label mt-4">Content</label>
                <textarea class="form-control" id="content" name="content" placeholder="Enter the content (min. 7, max. 2000 characters" cols="30" rows="10" required></textarea>
            </div>


            <div class="form-group">
                <label for="category" class="form-label mt-4">Category</label>
                <select name="category" class="form-control">
                    <option value="" disabled selected>Choose a category</option>
                    <?php foreach($categories as $category) :?>
                    <option value="<?= $category['id']?>">
                            <?= $category['name']?>
                    </option>
                    <?php endforeach?>
                </select>
            </div>

            
            <div class="form-group">
                <label for="image" class="form-label mt-4">Image</label>
                <input type="file" class="form-control" id="image" name="image" placeholder="Enter your image">
            </div>

            

            <input type="submit" name="createArticle" value="Add article" class="btn btn-primary mt-4 mb-4">

    </form>

</div>