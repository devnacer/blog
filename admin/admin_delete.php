<?php
session_start();

//functions
require_once '../includes/functions.php';

// check if the admin is connected
checkAdminSession();

// database conn
require_once '../includes/conn_db.php';

$id = $_GET['id'];
$sqlState = $pdo->prepare('DELETE FROM admin WHERE id=?');
$deleteItem = $sqlState->execute([$id]);
header('location: admin_list.php');