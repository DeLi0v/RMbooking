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
        window.onpopstate = function(event) {
            // Обработка изменения истории
            console.log("Location: " + document.location + ", state: " + JSON.stringify(event.state));
        };
    </script>
</body>

</html>