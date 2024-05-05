<?php
class DB_Class
{
    // Данные для подключения к базе данных
    // var $hostname = "localhost";
    // var $username = "a1";
    // var $password = "1";
    // var $database = "rmbooking";

    var $hostname = "192.168.0.2";
    var $username = "a1";
    var $password = "1";
    var $database = "rmbooking";

    // Переменные
    var $conn; // подключенная БД

    function connect()
    {
        // Создаем подключение к базе данных
        $this->conn = mysqli_connect($this->hostname, $this->username, $this->password, $this->database);

        // Проверяем, удалось ли подключиться к базе данных
        if (!$this->conn) {
            // header("Location: /index.php");
            // die("Подключение не удалось: " . mysqli_connect_error());
        } else {
            $this->conn->set_charset("utf8");
        }
        
        return $this->conn;
    }

    function close()
    {
        mysqli_close($this->conn);
    }
    
}
?>