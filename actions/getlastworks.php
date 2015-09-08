<?php

require ('..' . DIRECTORY_SEPARATOR . 'control' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php');
$response = [
    'error' => true,
];

$conn = new mysqli($dbhost, $dbuser, $dbpswd, $dbname);
if ($conn->connect_error) {
    $response['msg'] = 'MySQL error: ' . $conn->connect_error;
} else {
    $items = [];
    // gets las of each category
    //$query = "SELECT * FROM (SELECT category_id, Max(id) AS id FROM works GROUP BY category_id) a INNER JOIN works b ON b.id = a.id";
    
    // gets random of each category
    $query = "SELECT * FROM (SELECT id as id FROM works ORDER BY RAND()) a INNER JOIN works ON works.id = a.id GROUP BY category_id";
    $result = $conn->query($query);
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
            $response['error'] = false;
            $response['items'] = $items;
        } else {
            $response['msg'] = 'No hay ultimos trabajos';
        }
    } else {
        $response['msg'] = 'MySQL error: ' . $conn->error;
    }
}

echo json_encode($response);
