<?php 
// проверка подключения к базе данных
require_once($_SERVER['DOCUMENT_ROOT']."/connect.php");
$db = new DB_Class();
$conn = $db->connect();
if (!$conn) {
    header("Refresh: 0"); // если не подключилось - страница перезагружается
} else {

?>

<!doctype html>
<html lang="ru">

<head>
    <!-- основные настройки для head на всех страницах -->
    <?php include_once ($_SERVER['DOCUMENT_ROOT']."/mainHead.php") ?>
</head>

<body>

    <!-- навигационная панель для всех страниц -->
    <?php include_once ($_SERVER['DOCUMENT_ROOT']."/navBar.php") ?>

    <!-- блок, в который происходит загрузка "страниц" -->
    <div class="content">
    </div>

    <!-- подключение библиотек jquery и jquery-mask -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/jquery-mask.js"></script>
    <!-- подключение файла main.js с необходимыми скриптами -->
    <script src="/js/main.js"></script>
    <!-- скрипт для загрузки содержимого в зависимости от последней открытой страницы -->
    <script>
        $(document).ready(function() {
            if (localStorage.getItem('lastPage')) {
                openPage(localStorage.getItem('lastPage'));
            } else {
                openPage('booking');
            }
        });
    </script>
</body>

</html>
<?php $db->close(); } ?>