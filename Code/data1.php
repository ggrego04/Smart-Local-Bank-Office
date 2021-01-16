<?php

$servername="localhost";
$username = "root";
$password = "1234";
$dbname = "OpenHAB";

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql="SELECT CarID,Time,Latitude,Longitude FROM Car WHERE CarID=1 AND Time > DATE_SUB(NOW(),INTERVAL 1 DAY)";
$result=$conn->query($sql);
while($r = mysqli_fetch_assoc($result)) {
    $rows[] = $r;
}
print json_encode($rows);

$conn->close();
?>
