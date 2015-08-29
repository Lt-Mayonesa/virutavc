<?php

require ('config' . DIRECTORY_SEPARATOR . 'config.php');
require ('basemysql.php');
$response = [
    'error' => true,
];
$cName = filter_input(INPUT_POST, 'category_name');
if ($cName) {
    $conn = new mysqli($dbhost, $dbuser, $dbpswd, $dbname);
    if ($conn->connect_error) {
        $response['msg'] = "Connection failed: " . $conn->connect_error;
    }
    $query = "SELECT * FROM categories WHERE name LIKE '" . $cName . "'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $response['error'] = true;
        $response['msg'] = 'La categoria ya existe';
        $response['noReload'] = true;
    } else if ($result) {
        $query = "INSERT INTO categories (`name`) VALUES ('" . $cName . "')";
        $insertResult = $conn->query($query);
        if ($insertResult) {
            $response['error'] = false;
        }else {
            $response['msg'] = 'Error mysql: / ' . $query . ' / ' . $conn->error;
        }
    } else {
        $response['msg'] = 'Error mysql: / ' . $query . ' / ' . $conn->error;
    }
    $conn->close();
} else {
    $response['msg'] = 'Debes ingresar un nombre de categoria';
}
echo json_encode($response);