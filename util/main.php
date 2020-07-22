<?php
// Get the document root
$docRoot = $_SERVER['DOCUMENT_ROOT'];

// Get the application path
$uri = $_SERVER['REQUEST_URI'];
$dirs = explode('/', $uri);
$appPath = '/' . $dirs[1] . '/' . $dirs[2] . '/';

// Set the include path
set_include_path($docRoot . $appPath);
