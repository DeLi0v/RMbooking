<button class="addBtn" onclick="addStr(event, 'clients')">Добавить</button>

<?php
require_once($_SERVER['DOCUMENT_ROOT']."/connect.php");

$db = new DB_Class();
$conn = $db->connect();
if (!$conn) {
    http_response_code(503);
}
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
        <th>ФИО</th>
        <th>Телефон</th>
        <th>Почта</th>
        <th style="width: 0">Изменить</th>
        <th style="width: 0">Удалить</th>
    </tr>
        
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["surname"] . " " . $row["name"] . " " . $row["patronymic"] . "</td>";
        echo "<td>" . $row["phone"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo '<td class="center"><input type="image" src="/pictures/edit_orange.png" onclick="editStr(event, ' . $row["id"] . ', \'clients\')"></input></td>';
        echo '<td class="center"><input type="image" src="/pictures/remove.png" onclick="deleteStr(event, ' . $row["id"] . ', \'clients\')"></input></td>';
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
