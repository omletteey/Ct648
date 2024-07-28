<?php
session_start();

include 'db.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $racCheck = $_POST['RAC'];
    $sql = "SELECT * FROM access_code_log WHERE access_code ='$racCheck' and token_before != ''";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $row_id = $user['row_id'];
        echo 'success';
    }else {
        echo 'waiting';
    }
}
?>