<button>Добавить</button>

<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/connect.php");

    $db = new DB_Class();
    $conn = $db->connect();
    mysqli_select_db($conn, $db->database);

    $sql = "SELECT 
                id AS id,
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
            <th style="width: 0">Изменить</th>
            <th style="width: 0">Удалить</th>
        </tr>
    
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["type"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["description"] . "</td>";
        echo "<td>" . $row["address"] . "</td>";
        echo "<td>" . $row["cost"] . "</td>";
        echo '<td class="center"><input type="image" src="/pictures/edit_orange.png" onclick="editStr(event, ' . $row["id"] . ', \'rooms\')"></input></td>';
        echo '<td class="center"><input type="image" src="/pictures/remove.png" onclick="deleteStr(event, ' . $row["id"] . ', \'rooms\')"></input></td>';
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
