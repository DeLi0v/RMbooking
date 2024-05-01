
<?php
    // Подключаемся к базе данных
    require_once($_SERVER['DOCUMENT_ROOT']."/connect.php");
    $db = new DB_Class();
    $conn = $db->connect();
    mysqli_select_db($conn, $db->database);

    // Получаем данные из POST запроса
    $id = $_POST['id'];
    $table = ucfirst($_POST['table']);

    // Пишем SQL запрос для удаления строки из базы данных
    $sql = "DELETE FROM " . $table . " WHERE id = " . $id;

    // Выполняем SQL запрос
    $result = mysqli_query($conn, $sql);

    // Закрываем соединение с базой данных
    $db->close();

    // Отправляем ответ клиенту (статус HTTP 200 для успешного выполнения)
    http_response_code(200);

?>