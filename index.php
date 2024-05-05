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
            // Получаем текущий URL
            var currentURL = window.location.href;
            // Если URL указывает на корень, загружаем главную страницу
            if (currentURL.endsWith("/")) {
                openPage("booking");
            } else {
                // Иначе, загружаем содержимое страницы, указанной в URL
                var pathArray = currentURL.split("/");
                var pageName = pathArray[pathArray.length - 1];
                openPage(pageName);
            }
        });
    </script>
</body>

</html>