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
