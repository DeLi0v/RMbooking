<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/connect.php");
$db = new DB_Class();
$conn = $db->connect();
mysqli_select_db($conn, $db->database);

$booking_date = $_POST["booking_date"];
$client = $_POST["client"];
$room = $_POST["room"];
$timeBlocksFromDB = array();
$clientTimeBlocksFromDB = array();

$sql = "SELECT
            booking_time_begin AS booking_time_begin,
            booking_time_end AS booking_time_end,
            client AS client
        FROM Booking
        WHERE
            booking_date = '$booking_date'
            AND room = '$room'";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) { 
    while ($row = mysqli_fetch_assoc($result)) {
        $start_time = new DateTime($row['booking_time_begin']);
        $end_time = new DateTime($row['booking_time_end']);
        while ($start_time <= $end_time) {
            if ($client !== null && $client !== "" && $row["client"] == $client) {
                $clientTimeBlocksFromDB[] = $start_time->format("H");;
            }
            $timeBlocksFromDB[] = $start_time->format("H");;
            $start_time->modify('+1 hour'); // Увеличиваем на час
        }
    }
}
$db->close();
?>

<?php
// Генерируем блоки времени от 10:00 до 22:00
for ($hour = 10; $hour <= 22; $hour++) {
    // Форматируем время в формат "час:00:00"
    $time = sprintf("%02d:00:00", $hour);
    // Создаем класс timeBlock с временем и проверяем, есть ли это время в массиве времени из БД
    $class = (in_array($hour, $timeBlocksFromDB)) ? 'timeBlock selectedOther' : 'timeBlock';
    if ($client !== null && $client !== "" && $row["client"] == $client) {
        $class = (in_array($hour, $clientTimeBlocksFromDB)) ? 'timeBlock select' : 'timeBlock';
    }
// Выводим блок времени
    echo '<div class="' . $class . '" time="' . $hour . ':00:00" onclick="selectTime(' . $hour . ')">' . $hour . ':00</div>';
}
?>