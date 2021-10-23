<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');
header('Content-type: json/application');

require 'functions.php';
$method = $_SERVER['REQUEST_METHOD'];
$q = $_GET['q'];
$params = explode('/', $q);

$type = $params[0];
$id = $params[1];

$connect = mysqli_connect('localhost', 'root', '', 'users');

if($method === 'GET'){
    if($type === 'downloads'){
        getFiles();
    }
    elseif($type == 'getfile'){
        $filename = $_REQUEST['filename'];
        downloadFile($filename);
    }
} elseif ($method === 'POST'){
    if($type = 'upload'){
        uploadFile();
    }
}
?>