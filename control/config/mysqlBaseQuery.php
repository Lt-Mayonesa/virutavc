<?php

require ('config' . DIRECTORY_SEPARATOR . 'config.php');

$response = [
    'error' => true,
];
$conn = new mysqli($dbhost, $dbuser, $dbpswd, $dbname);
if (!$conn->connect_error) {
    $query = "";
    $result = $conn->query($query);
    if ($result) {
        $response['error'] = false;
    } else {
        $response['msg'] = 'Error mysql / ' . $query . ' / ' . $conn->error;
    }
    $conn->close();
} else {
    $response['msg'] = "Connection failed: " . $conn->connect_error;
}
echo json_encode($response);
