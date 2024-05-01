    <?php
    require_once($_SERVER['DOCUMENT_ROOT']."/connect.php");

    $db = new DB_Class();
    $conn = $db->connect();
    mysqli_select_db($conn, $db->database);

    $sql = "SELECT 
                id AS id,
                surname AS surname,
                name AS name,
                patronymic AS patronymic,
                phone AS phone,
                email AS email
            FROM Clients";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) { ?>
        <table>
        <tr>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Телефон</th>
            <th>Почта</th>
            <th>Удалить</th>
        </tr>
        
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["surname"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["patronymic"] . "</td>";
            echo "<td>" . $row["phone"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo '<td><input type="image" src="/pictures/remove.png" value="' . $row["id"] . '">Удалить</input></td>';
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
