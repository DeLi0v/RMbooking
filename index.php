<!doctype html>
<html lang="ru">

<head>
    <?php include_once ($_SERVER['DOCUMENT_ROOT']."/mainHead.php") ?>
</head>

<body>

    <?php include_once ($_SERVER['DOCUMENT_ROOT']."/navBar.php") ?>

    <div class="content">
        <?php include_once ($_SERVER['DOCUMENT_ROOT']."/pages/booking.php") ?>
    </div>

    <!-- TODO: разобраться с подключением локальной копией JQuery  -->

    <script src="/js/jquery.min.js"></script>
    <!-- <script src="/js/jquery-3.7.1.slim.min.js"></script> -->
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->
    <script src="/js/jquery-mask.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script> -->
    <script src="/js/openPage.js"></script>
    <script>
        $(document).ready(function() {
            if (localStorage.getItem('lastPage')) {
                // Если есть, загружаем последнее содержимое в блок .content
                openPage(localStorage.getItem('lastPage'))
                // $('.content').html(localStorage.getItem('lastContent'));
            }
        });
    </script>
</body>

</html>