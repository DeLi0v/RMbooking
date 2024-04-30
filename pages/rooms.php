<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/connect.php");

    $db = new DB_Class();
    $conn = $db->connect();
    mysqli_select_db($conn, $db->database);

    $sql = "SELECT 
                type AS type,
                name AS name,
                description AS description,
                address AS address,
                cost AS cost
            FROM Rooms";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) { ?>
    <table>
        <tr>
            <th>Тип</th>
            <th>Название</th>
            <th>Описание</th>
            <th>Адрес</th>
            <th>Стоимость</th>
        </tr>
    
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["type"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["description"] . "</td>";
        echo "<td>" . $row["address"] . "</td>";
        echo "<td>" . $row["cost"] . "</td>";
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
