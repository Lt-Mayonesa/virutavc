<?php

require ('config' . DIRECTORY_SEPARATOR . 'config.php');
require ('basemysql.php');

$response = [
    'error' => true,
];
$albumTitle = filter_input(INPUT_POST, 'album_title');
$albumDescription = filter_input(INPUT_POST, 'album_description');

if ($albumTitle) {
    $conn = new mysqli($dbhost, $dbuser, $dbpswd, $dbname);
    if (!$conn->connect_error) {
        $query = "INSERT INTO albums (`title`,`description`) VALUES ('" . $albumTitle . "','" . $albumDescription . "')";
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
} else {
    $response['msg'] = 'No se ingreso un titulo';
}
echo json_encode($response);
