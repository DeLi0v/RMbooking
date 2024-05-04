<?php 
require_once($_SERVER['DOCUMENT_ROOT']."/connect.php");
$db = new DB_Class();
$conn = $db->connect();
mysqli_select_db($conn, $db->database);

$booking_date = $_POST["booking_date"];
$client = $_POST["client"];
$timeBlocksFromDB = array();

$sql = "SELECT
            booking_time_begin AS booking_time_begin,
            booking_time_end AS booking_time_end
        FROM Booking
        WHERE
            booking_date = '$booking_date'
            AND client = '$client'";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) { 
    $start_time = $row['booking_time_begin'];
    $end_time = $row['booking_time_end'];
    while ($start_time <= $end_time) {
        $timeBlocksFromDB[] = date("H:i:s", $start_time);
        $start_time += 3600; // Увеличиваем на час
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
    $class = (in_array($time, $timeBlocksFromDB)) ? 'timeBlock selectedOther' : 'timeBlock off';
    // Выводим блок времени
    echo '<div class="' . $class . '" time="' . $time . '" onclick="selectTime(' . $hour . ')">' . $hour . ':00</div>';
}
?>
<!-- 
<div class="timeBlock off" time="10:00:00" onclick="selectTime(10)">10:00</div>
<div class="timeBlock off" time="11:00:00" onclick="selectTime(11)">11:00</div>
<div class="timeBlock off" time="12:00:00" onclick="selectTime(12)">12:00</div>
<div class="timeBlock off" time="13:00:00" onclick="selectTime(13)">13:00</div>
<div class="timeBlock off" time="14:00:00" onclick="selectTime(14)">14:00</div>
<div class="timeBlock off" time="15:00:00" onclick="selectTime(15)">15:00</div>
<div class="timeBlock off" time="16:00:00" onclick="selectTime(16)">16:00</div>
<div class="timeBlock off" time="17:00:00" onclick="selectTime(17)">17:00</div>
<div class="timeBlock off" time="18:00:00" onclick="selectTime(18)">18:00</div>
<div class="timeBlock off" time="19:00:00" onclick="selectTime(19)">19:00</div>
<div class="timeBlock off" time="20:00:00" onclick="selectTime(20)">20:00</div>
<div class="timeBlock off" time="21:00:00" onclick="selectTime(21)">21:00</div>
<div class="timeBlock off" time="22:00:00" onclick="selectTime(22)">22:00</div> -->