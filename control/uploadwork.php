<?php
$response = [
    'error' => true,
    'msg' => 'unknown error',
];
require ('config' . DIRECTORY_SEPARATOR . 'config.php');
require ('basemysql.php');

$title = filter_input(INPUT_POST, 'work_title');
$desc = filter_input(INPUT_POST, 'work_description');
$categoryId = filter_input(INPUT_POST, 'work_category');
$albumId = filter_input(INPUT_POST, 'work_album');

$allowed = array('gif', 'png', 'jpg');
$filename = $_FILES['work_file']['name'];
$ext = pathinfo($filename, PATHINFO_EXTENSION);
if (!in_array($ext, $allowed)) {
    $response['msg'] = 'not supported format';
} else {
    $date = new DateTime('now');
    $url = 'file_' . $date->format('ymdhis') . '.' . $ext;
    $saveFile = move_uploaded_file($_FILES['work_file']['tmp_name'], '..' . DIRECTORY_SEPARATOR . $UPLOADS_DIR . $url);
    if ($saveFile) {
        $conn = new mysqli($dbhost, $dbuser, $dbpswd, $dbname);
        if ($conn->connect_error) {
            $response['msg'] = "Connection failed: " . $conn->connect_error;
        }
        $query = "INSERT INTO works (`title`, `description`, `url`, `category_id`, `album_id`) VALUES ('" . $title . "','" . $desc . "','" . $url . "'," . $categoryId . "," . $albumId . ")";
        $result = $conn->query($query);
        if ($result) {
            $response['error'] = false;
            $response['msg'] = '';
            $response['file_name'] = $url;
        } else {
            $response['msg'] = 'Error mysql / ' . $query . ' / ' . $conn->error;
        }
        $conn->close();
    } else {
        $response['msg'] = 'Failed to move file to - PATH: ' . '..' . DIRECTORY_SEPARATOR . $UPLOADS_DIR . $url;
    }
}
echo json_encode($response);
