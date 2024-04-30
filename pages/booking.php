
    <tr>
        <td>1</td>
        <td>2</td>
        <td>3</td>
        <td>4</td>
        <td>5</td>
        <td>6</td>
    </tr>
</table>


<?php
    require_once("connect.php");

    $db = new DB_Class();
    $conn = $db->connect();
    mysqli_select_db($conn, $db->database);

    $sql = "SELECT
                room AS room,
                client AS client,
                staff AS staff,
                booking_date AS booking_date,
                booking_time_begin AS booking_time_begin,
                booking_time_end AS booking_time_end,
                sum AS sum,
            FROM Booking";

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
        </tr>
        
        <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row["booking_date"] . "</td>";
                echo "<td>" . $row["booking_time_begin"] . " - " . $row["booking_time_end"] . "</td>";
                echo "<td>" . $row["client"] . "</td>";
                echo "<td>" . $row["room"] . "</td>";
                echo "<td>" . $row["sum"] . "</td>";
                echo "<td>" . $row["staff"] . "</td>";
                echo "</tr>";
            }
        ?>

        </table>
    <?php
    } else {
        echo "<div>В таблице нет данных.</div>";
    } 
    $db->close();
?>