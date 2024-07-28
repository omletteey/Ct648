<?php
session_start();
$headers = getallheaders();

include 'db.php'; // Include the database connection file
include 'jwt.php'; // Include the simple JWT implementation

// Token สำหรับการแจ้งผ่าน Line Notify
$token = 'MeHN6VNE4a3m4CnB2IPJAvly7hNvlMdCCVi9pyzDaGh';

// ฟังก์ชันสำหรับส่งข้อความไปยัง Line Notify
function send_line_notify($message, $token)
{
    $line_api = 'https://notify-api.line.me/api/notify';
    $data = array('message' => $message);
    $headers = array(
        'Content-Type: multipart/form-data',
        'Authorization: Bearer ' . $token,
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $line_api);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userAgent = isset($headers['Agent']) ? $headers['Agent'] : null;
   
    if($userAgent != 'CT648_Assignment2_QR_Authen'){
        echo "Incorrect Agent";
        exit();
    }
    // Get the Authorization header
    $authorizationHeader = isset($headers['Authorization']) ? $headers['Authorization'] : null;

    if ($authorizationHeader) {
        // Extract the Bearer token
        if (preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
            $Token = $matches[1];
           
        } else {
            echo "Authorization header is present but does not contain a Bearer token.";
            exit();
        }
    } else {
        echo "Authorization header is not present.";
        exit();
    }

    // Print out the headers to debug
    // echo "Received Headers: ";
    // print_r($headers);
    $rac = isset($headers['RAC']) ? $headers['RAC'] : null;

    if (!$rac) {
        echo "RAC header is not present.";
        exit();
    }
    // echo $Token;
    $sql = "UPDATE access_code_log set token_before = '$Token' where access_code = '$rac'";
    // $conn->query($sql);
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        $message = "User Logged in Qrcode \n
            Student: 65130695 \n
            email: 65130695@dpu.ac.th \n
            token: " . $jwt;
            // Redirect with JWT
            send_line_notify($message, $token);
    } else {
        echo "Error updating record: " . $conn->error;
    }
    
    // echo $sql;
    // echo 'success';
    exit();
}
?>
