
<?php
    // Подключаемся к базе данных
    require_once($_SERVER['DOCUMENT_ROOT']."/connect.php");
    $db = new DB_Class();
    $conn = $db->connect();
    mysqli_select_db($conn, $db->database);

    // Получаем данные из POST запроса
    $id = $_POST['id'];
    $table = ucfirst($_POST['page']);
    $formData = $_POST['formData'];
    parse_str($formData, $formDataArr);

    if ($table == 'Booking') {

        $room               = $formDataArr['room'];
        $client             = $formDataArr['client'];
        $staff              = $formDataArr['staff'];
        $booking_date       = $formDataArr['booking_date'];
        $booking_time_begin = $formDataArr['booking_time_begin'];
        $booking_time_end   = $formDataArr['booking_time_end'];
        $sum                = $formDataArr['sum'];

        $sql = "UPDATE Booking 
                SET 
                    room                = '$room',
                    client              = '$client',
                    staff               = '$staff',
                    booking_date        = '$booking_date',
                    booking_time_begin  = '$booking_time_begin',
                    booking_time_end    = '$booking_time_end',
                    sum                 = '$sum'
                WHERE id = $id";

    } elseif ($table == 'Clients') {

        $surname    = $formDataArr['surname'];
        $name       = $formDataArr['name'];
        $patronymic = $formDataArr['patronymic'];
        $phone      = $formDataArr['phone'];
        $email      = $formDataArr['email'];

        $sql = "UPDATE Clients 
                SET 
                    surname     = '$surname',
                    name        = '$name',
                    patronymic  = '$patronymic',
                    phone       = '$phone',
                    email       = '$email'
                WHERE id = $id";

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

        $sql = "UPDATE Staff 
                SET 
                    surname     = '$surname',
                    name        = '$name',
                    patronymic  = '$patronymic',
                    post        = '$post',
                    phone       = '$phone',
                    email       = '$email',
                    birthday    = '$birthday',
                    sex         = '$sex',
                    passport    = '$passport'
                WHERE id = $id";

    } elseif ($table == 'Rooms') {
        
        $type           = $formDataArr['type'];
        $name           = $formDataArr['name'];
        $description    = $formDataArr['description'];
        $address        = $formDataArr['address'];
        $cost           = $formDataArr['cost'];

        $sql = "UPDATE Rooms 
                SET 
                    type        = '$type',
                    name        = '$name',
                    description = '$description',
                    address     = '$address',
                    cost        = '$cost'
                WHERE id = $id";

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