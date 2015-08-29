<?php

require ('..' . DIRECTORY_SEPARATOR . 'control' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php');

$response = [
    'error' => true,
];

$albumId = filter_input(INPUT_GET, 'id');
$conn = new mysqli($dbhost, $dbuser, $dbpswd, $dbname);
if ($conn->connect_error) {
    $response['msg'] = 'MySQL error: ' . $conn->connect_error;
} else {
    $items = [];
    $query = "SELECT * FROM works WHERE album_id = " . $albumId;
    $result = $conn->query($query);
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
            $response['error'] = false;
            $response['items'] = $items;
        } else {
            $response['msg'] = 'No hay trabajos en este album';
        }
    } else {
        $response['msg'] = 'MySQL error: ' . $conn->error;
    }
}

echo json_encode($response);
