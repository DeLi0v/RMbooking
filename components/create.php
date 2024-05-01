<?php
    // Подключаемся к базе данных
    require_once($_SERVER['DOCUMENT_ROOT']."/connect.php");
    $db = new DB_Class();
    $conn = $db->connect();
    mysqli_select_db($conn, $db->database);

    // Получаем данные из POST запроса
    $table = ucfirst($_POST['page']);
    $formData = $_POST['formData'];
    parse_str($formData, $formDataArr);

    $sql = "";
    if ($table == 'Booking') {

        $room               = $formDataArr['room'];
        $client             = $formDataArr['client'];
        $staff              = $formDataArr['staff'];
        $booking_date       = $formDataArr['booking_date'];
        $booking_time_begin = $formDataArr['booking_time_begin'];
        $booking_time_end   = $formDataArr['booking_time_end'];
        $sum                = $formDataArr['sum'];

        $sql = "INSERT INTO `Booking` (`room`, `client`, `staff`, `booking_date`, `booking_time_begin`, `booking_time_end`, `sum`) 
                VALUES ('$room', '$client', '$staff', '$booking_date', '$booking_time_begin', '$booking_time_end', '$sum');";

    } elseif ($table == 'Clients') {

        $surname    = $formDataArr['surname'];
        $name       = $formDataArr['name'];
        $patronymic = $formDataArr['patronymic'];
        $phone      = $formDataArr['phone'];
        $email      = $formDataArr['email'];

        $sql = "INSERT INTO `Clients` (`surname`, `name`, `patronymic`, `phone`, `email`) 
                VALUES ('$surname', '$name', '$patronymic', '$phone', '$email');";

    } elseif ($table == 'Staff') {

        $surname    = $formDataArr['surname'];
        $name       = $formDataArr['name'];
        $patronymic = $formDataArr['patronymic'];
        $post       = $formDataArr['post'];
        $phone      = $formDataArr['phone'];
        $email      = $formDataArr['email'];
        $birthday   = $formDataArr['birthday'];
        $sex        = $formDataArr['sex'];
        $passport   = $formDataArr['passport'];

        $sql = "INSERT INTO `Staff` (`surname`, `name`, `patronymic`, `post`, `phone`, `email`, `birthday`, `sex`, `passport`) 
                VALUES ('$surname', '$name', '$patronymic', '$post', '$phone', '$email', '$birthday', '$sex', '$passport');";

    } elseif ($table == 'Rooms') {

        $type           = $formDataArr['type'];
        $name           = $formDataArr['name'];
        $description    = $formDataArr['description'];
        $address        = $formDataArr['address'];
        $cost           = $formDataArr['cost'];

        $sql = "INSERT INTO `Rooms` (`type`, `name`, `description`, `address`, `cost`) 
                VALUES ('$type', '$name', '$description', '$address', '$cost');";

    }

    // Выполняем SQL запрос
    $result = mysqli_query($conn, $sql);

    // Закрываем соединение с базой данных
    $db->close();

    // Отправляем ответ клиенту (статус HTTP 200 для успешного выполнения)
    if ($result) {
        http_response_code(200);
    } else {
        http_response_code(500);
    }    
?>