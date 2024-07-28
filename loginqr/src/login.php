<?php
session_start();

include 'db.php'; // Include the database connection file
include 'jwt.php'; // Include the simple JWT implementation


// สร้างข้อความแจ้งเตือน
// $message = "ทดสอบ";

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

?>
<script>
    // if session is null token local
</script>
<?php

$secret_key = "your_secret_key"; // Replace with your actual secret key

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM employee WHERE username='$username'";

    $result = $conn->query($sql);
    // var_dump($result);
    // die();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // var_dump($user);
        // die();
        $uuid = $user['uuid'];
        $salt = $user['salt'];
        $hashedPassword = hash('sha256', $password . $salt);

        // die();
        if ($user['password'] == $hashedPassword) {
            // Create token payload
            $payload = array(
                "iss" => "your_domain.com", // Issuer
                "aud" => "your_domain.com", // Audience
                "iat" => time(), // Issued at
                "nbf" => time(), // Not before
                "exp" => time() + 3600, // Expiration time (1 hour)
                "data" => array(
                    "id" => $user['id'],
                    "username" => $user['username']
                )
            );
            date_default_timezone_set("Asia/Bangkok");
            // echo "The time is " . date("Y-m-d H:i:s");;
            // Generate JWT
            $date = date('Y-m-d H:i:s');
            $jwt = JWT::encode($payload, $secret_key);
            $sql = "INSERT INTO token_log (employee_id, jwt_token, login_type,created_at) values ('$uuid', '$jwt', 'input','$date')";
            // echo $sql;
            $conn->query($sql);

            // die();
            $message = "User Logged in Web \n
            Student: 65130695 \n
            email: 65130695@dpu.ac.th \n
            token: " . $jwt;
            // Redirect with JWT
            send_line_notify($message, $token);
?>
            <script>
                localStorage.setItem("token", "<?php echo $jwt; ?>");
                window.location.href = "index.php";
            </script>
<?php
            exit(); // Ensure no further code is executed after the redirect
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that username.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width,minimum-scale=1">
    <link href="./css/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</head>

<body>
<div class="content home">
    <form method="post" action="login.php">
        <br>
        Username:<br> <input type="text" name="username" required><br>
        Password:<br> <input type="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</div>
    <div class="content home">

        <h1>
            Login
            <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" height="0.875em" viewBox="0 0 512 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                    <path d="M217.9 105.9L340.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L217.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1L32 320c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM352 416l64 0c17.7 0 32-14.3 32-32l0-256c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l64 0c53 0 96 43 96 96l0 256c0 53-43 96-96 96l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32z" />
                </svg>
            </span>
        </h1>

        <p class="login-txt">Please login using the button below. You'll be redirected to Google.</p>

        <a href="google-oauth.php" class="google-login-btn">
            <span class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 488 512"><!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                    <path d="M488 261.8C488 403.3 391.1 504 248 504 110.8 504 0 393.2 0 256S110.8 8 248 8c66.8 0 123 24.5 166.3 64.9l-67.5 64.9C258.5 52.6 94.3 116.6 94.3 256c0 86.5 69.1 156.6 153.7 156.6 98.2 0 135-70.4 140.8-106.9H248v-85.3h236.1c2.3 12.7 3.9 24.9 3.9 41.4z" />
                </svg>
            </span>
            Login with Google
        </a>

    </div>
</body>

</html>