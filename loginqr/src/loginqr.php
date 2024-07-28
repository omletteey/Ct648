<?php
session_start();

include 'db.php'; // Include the database connection file
include 'jwt.php'; // Include the simple JWT implementation


// สร้างข้อความแจ้งเตือน
$message = "User : 65130695@dpu.ac.th \n
            loginQR \n
            token: ".$jwt;

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
<?
function generateRandomString($length = 20) {
    $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomIndex = rand(0, $charactersLength - 1);
        $randomString .= $characters[$randomIndex];
    }
    return $randomString;
}
$randomString = generateRandomString();


$RAC =  "CT648".$randomString;
date_default_timezone_set("Asia/Bangkok");
$date=date('Y-m-d H:i:s');
$sql = "INSERT INTO access_code_log (access_code,created_at) values ('$RAC','$date')";

$conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login QRCode</title>
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
</head>
<body>
    <div id="qrcode"></div>
    <h5><?php echo $RAC; ?></h5>
    <div id="status"></div>
    <script>
        // Get the RAC value from PHP
        var racValue = "<?php echo $RAC; ?>";

        // Generate QR code
        var qrcodeContainer = document.getElementById('qrcode');
        new QRCode(qrcodeContainer, {
            text: racValue,
            width: 256,
            height: 256,
        });

          // Function to send RAC value via POST and check status
          function checkRACStatus() {
            fetch('checkqr.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'RAC=' + racValue
            })
            .then(response => response.text())
            .then(data => {

                document.getElementById('status').innerText = data;
                if (data ==  'success') {
                    window.location.href = "index.php";
                }
            })
            .catch(error => console.error('Error:', error));
        }

        // Check RAC status every 5 seconds
        var interval = setInterval(checkRACStatus, 5000);
    </script>
</body>
</html>
