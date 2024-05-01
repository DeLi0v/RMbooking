
<?php
    // Подключаемся к базе данных
    require_once($_SERVER['DOCUMENT_ROOT']."/connect.php");
    $db = new DB_Class();
    $conn = $db->connect();
    mysqli_select_db($conn, $db->database);

    // Получаем данные из POST запроса
    $id = ucfirst($_POST['id']);
    $table = ucfirst($_POST['page']);
    $formData = $_POST['formData'];
    parse_str($formData, $formDataArr);

    // Пишем SQL запрос для удаления строки из базы данных
    if ($table = 'Booking') {
        // $sql = "UPDATE Booking
        // SET 
        //     idCategory = '$category',
        //     EquepmentName = '$name',
        //     size = '$size',
        //     storage = '$storage',
        //     price = '$price'
        // WHERE (id = $id)";
    } elseif ($table = 'Clients') {
        $sql = "UPDATE 
        SET 
            surname     = '$formDataArr[surname]',
            name        = '$formDataArr[name]',
            patronymic  = '$formDataArr[patronymic]',
            phone       = '$formDataArr[phone]',
            email       = '$formDataArr[email]'
        WHERE (id = $id)";
    } elseif ($table = 'Staff') {
        // $sql = "UPDATE 
        // SET 
        //     idCategory = '$category',
        //     EquepmentName = '$name',
        //     size = '$size',
        //     storage = '$storage',
        //     price = '$price'
        // WHERE (id = $id)";
    } elseif ($table = 'Rooms') {
        // $sql = "UPDATE 
        // SET 
        //     idCategory = '$category',
        //     EquepmentName = '$name',
        //     size = '$size',
        //     storage = '$storage',
        //     price = '$price'
        // WHERE (id = $id)";
    }

    // Выполняем SQL запрос
    $result = mysqli_query($conn, $sql);

    // Закрываем соединение с базой данных
    $db->close();

    // Отправляем ответ клиенту (статус HTTP 200 для успешного выполнения)
    if (mysqli_query($conn, $sql)) {
        http_response_code(200);
    } else {
        http_response_code(500);
    }    
?>