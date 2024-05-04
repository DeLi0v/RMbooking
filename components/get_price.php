<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/connect.php");
$db = new DB_Class();
$conn = $db->connect();
mysqli_select_db($conn, $db->database);

$room = $_POST["room"];

$sql = "SELECT
            cost AS cost
        FROM Rooms
        WHERE
            room = '$room'";

$result = mysqli_query($conn, $sql);
$price = 0;
if (mysqli_num_rows($result) > 0) { 
    $row = mysqli_fetch_assoc($result);
    $price = $row["price"];
}
$db->close();
echo $price;
?>