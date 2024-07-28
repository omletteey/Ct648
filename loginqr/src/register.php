<?php 
    include 'db.php';
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // sanitize input
        $username = $conn->real_escape_string($_POST['username']);
        $password = $conn->real_escape_string($_POST['password']);
        $nameTH = $conn->real_escape_string($_POST['nameTH']);
        $nameEN = $conn->real_escape_string($_POST['nameEN']);
        $studentID = $conn->real_escape_string($_POST['studentID']);
        
        // generate UUID
        $uuid = bin2hex(random_bytes(16));
        
        // generate salt
        $salt = bin2hex(random_bytes(16));
        
        // hash the password with the salt
        $hashedPassword = hash('sha256', $password . $salt);
        
        // insert into the database
        $sql = "INSERT INTO employee (uuid, username, password, salt, nameTH, nameEN, studentID) VALUES ('$uuid', '$username', '$hashedPassword', '$salt', '$nameTH', '$nameEN', '$studentID')";
        
        if ($conn->query($sql) === TRUE) {
            echo "Registration successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
    $conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php
    include("layout/navbar.php");
?> 
    <form action="register.php" method="POST">
    <div class="mb-3">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>
    </div>
    <div class="mb-3">
        <label for="password">Password:</label>
        <input type="password" name="password" required><br>
    </div>
    <div class="mb-3">
        <label for="nameTH">Name (Thai):</label>
        <input type="text" name="nameTH" required><br>
    </div>
    <div class="mb-3">
        <label for="nameEN">Name (English):</label>
        <input type="text" name="nameEN" required><br>
    </div>
    <div class="mb-3">
        <label for="studentID">Student ID:</label>
        <input type="text" name="studentID" required><br>
    </div>
        <input type="submit" class="btn btn-info" value="Register">
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
