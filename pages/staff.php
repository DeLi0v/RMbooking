<button class="addBtn" onclick="addStr(event, 'staff')">Добавить</button>

<?php
    // подключение к БД
    require_once($_SERVER['DOCUMENT_ROOT']."/connect.php");

    $db = new DB_Class();
    $conn = $db->connect();
    if (!$conn) {
        http_response_code(503);
    }
    mysqli_select_db($conn, $db->database);

    // формирование запроса для получения данных из БД
    $sql = "SELECT 
                id AS id,
                surname AS surname,
                name AS name,
                patronymic AS patronymic,
                post AS post,
                phone AS phone,
                email AS email,
                birthday AS birthday,
                sex AS sex,
                passport AS passport
            FROM Staff";

    $result = mysqli_query($conn, $sql);

    // если в таблице Staff найдены строки, то формируется таблица
    if (mysqli_num_rows($result) > 0) { ?>
        <table>
            <!-- Заголовки -->
            <tr>
                <th>ФИО</th>
                <th>Должность</th>
                <th>Телефон</th>
                <th>Почта</th>
                <th>Дата рождения</th>
                <th>Пол</th>
                <th>Паспорт</th>
                <th style="width: 0">Изменить</th>
                <th style="width: 0">Удалить</th>
            </tr>
        
        <?php
        // строки (выводятся, пока есть данные)
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["surname"] . " " . $row["name"] . " " . $row["patronymic"] . "</td>";
            echo "<td>" . $row["post"] . "</td>";
            echo "<td>" . $row["phone"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["birthday"] . "</td>";
            echo "<td>" . $row["sex"] . "</td>";
            echo "<td>" . $row["passport"] . "</td>";
            echo '<td class="center"><input type="image" src="/pictures/edit_orange.png" onclick="editStr(event, ' . $row["id"] . ', \'staff\')"></input></td>';
            echo '<td class="center"><input type="image" src="/pictures/remove.png" onclick="deleteStr(event, ' . $row["id"] . ', \'staff\')"></input></td>';
            echo "</tr>";
        }
        ?>

        </table>
    <?php
    } else {
        // иначе выводится сообщение
        echo "<div class='noData'>В таблице нет данных.</div>";
    } 
    $db->close();
?>
