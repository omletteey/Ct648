<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php
    include("layout/navbar.php");
    include("db.php");
    $sql = "SELECT employee_id, jwt_token, created_at,login_type FROM token_log";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        $i=1;
        
?>
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">uuid</th>
      <th scope="col">jwt_token</th>
      <th scope="col">created_at</th>
      <th scope="col">login_type</th>
    </tr>
  </thead>
    <?php while($row = $result->fetch_assoc()) {
        
    ?>
  <tbody>
    <tr>
      <th scope="row"><?php echo $i;?></th>
      <td><?php echo $row["employee_id"];?></td>
      <td><?php echo $row["jwt_token"];?></td>
      <td><?php echo $row["created_at"];?></td>
      <td><?php echo $row["login_type"];?></td>
    </tr>
    
  </tbody>
<?php 
$i++;
}
    }else{
        echo "0 results"  ;
    }
?>
</table>
<?php 
$conn->close();
?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>