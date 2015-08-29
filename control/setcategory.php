<?php

require ('config' . DIRECTORY_SEPARATOR . 'config.php');
require ('basemysql.php');
$response = [
    'error' => true,
];
$cId = filter_input(INPUT_POST, 'category_id');
if ($cId) {
    $conn = new mysqli($dbhost, $dbuser, $dbpswd, $dbname);
    if ($conn->connect_error) {
        $response['msg'] = "Connection failed: " . $conn->connect_error;
    }
    $query = "UPDATE  `categories` SET  `active` = NOT `active` WHERE `id` = " . $cId . ";";
    $result = $conn->query($query);
    if ($result) {
        $response['error'] = false;
    } else {
        $response['msg'] = 'Error mysql / ' . $query . ' / ' . $conn->error;
    }
    $conn->close();
}
echo json_encode($response);
