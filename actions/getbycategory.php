<?php

require ('..' . DIRECTORY_SEPARATOR . 'control' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php');

$response = [
    'error' => true,
];

$categoryId = filter_input(INPUT_GET, 'id');
$conn = new mysqli($dbhost, $dbuser, $dbpswd, $dbname);
if ($conn->connect_error) {
    $response['msg'] = 'MySQL error: ' . $conn->connect_error;
} else {
    $items = [];
    $query = "SELECT w.id, w.`title`, w.`description`, w.`url`, w.`category_id`, w.`album_id`, w.`created`, a.`title` as albumTitle, a.`description` as albumDescription FROM works as w INNER JOIN albums as a ON w.album_id = a.id WHERE w.category_id = " . $categoryId . " ORDER BY w.created ASC";
    $result = $conn->query($query);
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
            $response['error'] = false;
            $response['items'] = $items;
        } else {
            $response['msg'] = 'No hay trabajos en esta categoria';
        }
    } else {
        $response['msg'] = 'MySQL error: ' . $conn->error;
    }
}

echo json_encode($response);
