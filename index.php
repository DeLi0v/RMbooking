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

    <!-- <script src="/js/jquery.min.js"></script> -->
    <!-- <script src="/js/jquery-3.7.1.slim.min.js"></script> -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="/js/jquery-mask.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"></script> -->
    <script src="/js/openPage.js"></script>
    <script>
        // Получаем все обязательные поля формы
        var requiredFields = document.querySelectorAll("#editForm [required]");

        // Добавляем обработчик события invalid для каждого обязательного поля
        requiredFields.forEach(function(field) {
        field.addEventListener("invalid", function() {
            // Добавляем класс invalid-input к незаполненному полю
            field.classList.add("invalid-input");
        });
        });

        // Добавляем обработчик события input для каждого обязательного поля, чтобы убрать подсветку при вводе
        requiredFields.forEach(function(field) {
        field.addEventListener("input", function() {
            // Убираем класс invalid-input у поля при вводе данных
            if (field.validity.valid) {
            field.classList.remove("invalid-input");
            }
        });
        });
    </script>
</body>

</html>