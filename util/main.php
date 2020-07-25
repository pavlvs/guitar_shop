<?php
// Get the document root
$docRoot = filter_input(INPUT_SERVER, 'DOCUMENT_ROOT');

// Get the application path
$uri = filter_input(INPUT_SERVER, 'REQUEST_URI');
// echo $uri . '<br>';
$dirs = explode('/', $uri);
$appPath = '/';

// Set the include path
set_include_path($docRoot . $appPath);

// Get common code
require_once 'util/tags.php';
require_once 'model/database.php';

// Define some common functions
function displayDBError($errorMessage) {
    global $appPath;
    include 'errors/db_error.php';
    exit;
}

function displayError($errorMessage) {
    global $appPath;
    include 'errors/error.php';
    exit;
}

function redirect($url) {
    session_write_close();
    header('Location: ' . $url);
    exit;
}

// start session to store user and cart data
session_start();
