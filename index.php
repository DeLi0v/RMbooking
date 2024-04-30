<!doctype html>
<html lang="ru">

<head>
    <?php include_once ("./mainHead.php") ?>
</head>

<body>
    <script defer src="/js/jquery-3.7.1.js"></script>
    <?php include_once ("./navBar.php") ?>

    <div class="content">
        <script>
            if (window.jQuery) {
                console.log("ok");
            } else {
                console.log("err");
            }
        </script>
        <?php include_once ("./pages/booking.php") ?>
    </div>

    <script src="./js/openPage.js"></script>

</body>

</html>