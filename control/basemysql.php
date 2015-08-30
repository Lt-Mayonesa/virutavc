<?php

require ('config' . DIRECTORY_SEPARATOR . 'config.php');
/**
 * Make query to db
 * @param String $query the mySQL sintax query
 * @param boolean $response true if query returns data (i.e: SELECT), or false if it doesn't (i.e: INSERT)
 * @return sql result or boolean
 */
function queryDB($query, $response = true) {
    global $dbhost, $dbuser, $dbpswd, $dbname;
    $data = [];
    $conn = new mysqli($dbhost, $dbuser, $dbpswd, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    if ($query) {
        $result = $conn->query($query);
        if ($response) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                return $data;
            }
        } else {
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }
    $conn->close();
}
