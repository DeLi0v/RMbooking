<?php 

require_once($_SERVER['DOCUMENT_ROOT']."/connect.php");
$db = new DB_Class();
$conn = $db->connect();
mysqli_select_db($conn, $db->database);

$type = $_POST["type"];

$sql = "SELECT
            id AS id,
            name AS name,
            description AS description,
            address AS address,
            cost AS cost
        FROM Rooms
        WHERE
            type = $type";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) { 
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<option value='". $row['id'] ."'>". $row["name"] . " - " . $row["description"] . " - " . $row["cost"] ." руб/ч</option>";
    }
}
$db->close();
?>