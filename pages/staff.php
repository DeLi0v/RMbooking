<?php
    require_once("../connect.php");

    $db = new DB_Class();
    $conn = $db->connect();
    mysqli_select_db($conn, $db->database);

    $sql = "SELECT 
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

    if (mysqli_num_rows($result) > 0) { ?>
        <table>
            <tr>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Должность</th>
                <th>Телефон</th>
                <th>Почта</th>
                <th>Дата рождения</th>
                <th>Пол</th>
                <th>Паспорт</th>
            </tr>
        
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row["surname"] . "</td>";
            echo "<td>" . $row["name"] . "</td>";
            echo "<td>" . $row["patronymic"] . "</td>";
            echo "<td>" . $row["post"] . "</td>";
            echo "<td>" . $row["phone"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["birthday"] . "</td>";
            echo "<td>" . $row["sex"] . "</td>";
            echo "<td>" . $row["passport"] . "</td>";
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
