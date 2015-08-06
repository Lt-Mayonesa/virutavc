<?php

require ('config' . DIRECTORY_SEPARATOR . 'config.php');
require ('basemysql.php');
$response = [
    'error' => true,
];
$workFile = '..' . DIRECTORY_SEPARATOR . $UPLOADS_DIR . filter_input(INPUT_POST, 'work_file');
$workId = filter_input(INPUT_POST, 'work_id');

if ($workId) {
    $conn = new mysqli($dbhost, $dbuser, $dbpswd, $dbname);
    if (!($conn->connect_error)) {
        $query = "DELETE FROM works WHERE id = " . $workId;
        $result = $conn->query($query);
        if ($result) {
            $delete = unlink($workFile);
            if ($delete) {
                $response['error'] = false;
            } else {
                $response['msg'] = 'Error deleting file from server: ' . $workFile;
            }
        } else {
            $response['msg'] = 'Error mysql / ' . $query . ' / ' . $conn->error;
        }
        $conn->close();
    } else {
        $response['msg'] = "Connection failed: " . $conn->connect_error;
    }
} else {
    $response['msg'] = 'no id recieved';
}
echo json_encode($response);
