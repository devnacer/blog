<?php
// Define the page title
$pageTitle = 'My Blog - Admin Area';

// start session
session_start();

// Include the page header
require_once '../includes/header.php';

// Include the admin navigation bar
require_once '../includes/navBarAdmin.php';

// database conn
require_once '../includes/conn_db.php';

//functions
require_once '../includes/functions.php';
