<?php
// database conn
require_once '../includes/conn_db.php';
$id = $_GET['id'];
$sqlState = $pdo->prepare('DELETE FROM category WHERE id=?');
$deleteItem = $sqlState->execute([$id]);
header('location: category_list.php');