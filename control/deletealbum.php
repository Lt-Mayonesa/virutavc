<?php

require ('config' . DIRECTORY_SEPARATOR . 'config.php');
require ('basemysql.php');
$response = [
    'error' => true,
];
$albumId = filter_input(INPUT_POST, 'album_id');
$deleteWorks = filter_input(INPUT_POST, 'album_works');
$newAlbumId = filter_input(INPUT_POST, 'album_new');
if ($albumId) {
    $conn = new mysqli($dbhost, $dbuser, $dbpswd, $dbname);
    if (!$conn->connect_error) {
        if ($deleteWorks == 'true') {
            $query = "SELECT url FROM works WHERE album_id = " . $albumId;
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $deleting = unlink('..' . DIRECTORY_SEPARATOR . $UPLOADS_DIR . $row['url']);
                }
                if ($deleting) {
                    $query = "DELETE FROM works WHERE album_id = " . $albumId;
                    $result = $conn->query($query);
                    if ($result) {
                        $response['error'] = false;
                    } else {
                        $response['msg'] = 'No se pudieron eliminar los trabajos. mysql: ' . $conn->error;
                    }
                } else {
                    $response['msg'] = 'Problema borrando los archivos';
                }
            } else {
                $response['msg'] = 'No se encontraron trabajos de serie o MYSQL Error: ' . $conn->error;
            }
        } else {
            $query = "UPDATE works SET album_id = " . $newAlbumId . " WHERE album_id = " . $albumId;
            $result = $conn->query($query);
            if ($result) {
                $query = "DELETE FROM albums WHERE id = " . $albumId;
                $result = $conn->query($query);
                if ($result) {
                    $response['error'] = false;
                } else {
                    $response['msg'] = 'No se pudieron modificar los trabajos: / ' . $query . ' / ' . $conn->error;
                }
            } else {
                $response['msg'] = 'Error mysql / ' . $query . ' / ' . $conn->error;
            }
        }
    } else {
        $response['msg'] = "Connection failed: " . $conn->connect_error;
    }
    $conn->close();
} else {
    $response['msg'] = 'No id';
}
echo json_encode($response);
