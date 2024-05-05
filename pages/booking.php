<button class="addBtn" onclick="addStr(event, 'booking')">Добавить</button>

<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/connect.php");

    $db = new DB_Class();
    $conn = $db->connect();
    if (!$conn) {
        header("Location: /");
    }
    mysqli_select_db($conn, $db->database);

    $sql = "SELECT
                Booking.id AS id,
                Rooms.name AS room,
                Clients.surname AS clientSurname,
                Clients.name AS clientName,
                Clients.patronymic AS clientPatronymic,
                Staff.surname AS staffSurname,
                Staff.name AS staffName,
                Staff.patronymic AS staffPatronymic,
                Booking.booking_date AS booking_date,
                Booking.booking_time_begin AS booking_time_begin,
                Booking.booking_time_end AS booking_time_end,
                Booking.sum AS sum
            FROM 
                `Booking`
                LEFT JOIN `Clients` ON Booking.client = Clients.id
                LEFT JOIN `Staff` ON Booking.staff = Staff.id
                LEFT JOIN `Rooms`ON Booking.room = Rooms.id
            ORDER BY 
                booking_date,
                booking_time_begin";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) { ?>
    
        <table>
        <tr>
            <th>Дата брони</th>
            <th>Время брони</th>
            <th>Клиент</th>
            <th>Помещение</th>
            <th>Стоимость</th>
            <th>Сотрудник</th>
            <th style="width: 0">Изменить</th>
            <th style="width: 0">Удалить</th>
        </tr>
        
        <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["booking_date"] . "</td>";
                echo "<td>" . $row["booking_time_begin"] . " - " . $row["booking_time_end"] . "</td>";
                echo "<td>" . $row["clientSurname"] . " " . $row["clientName"] . " " . $row["clientPatronymic"] . "</td>";
                echo "<td>" . $row["room"] . "</td>";
                echo "<td>" . $row["sum"] . "</td>";
                echo "<td>" . $row["staffSurname"] . " " . $row["staffName"] . " " . $row["staffPatronymic"] . "</td>";
                echo '<td class="center"><input type="image" src="/pictures/edit_orange.png" onclick="editStr(event, ' . $row["id"] . ', \'booking\')"></input></td>';
                echo '<td class="center"><input type="image" src="/pictures/remove.png" onclick="deleteStr(event, ' . $row["id"] . ', \'booking\')"></input></td>';
                echo "</tr>";
            }
        ?>

        </table>
    <?php
    } else {
        echo "<div class='noData'>В таблице нет данных.</div>";
    } 
    $db->close();
?>