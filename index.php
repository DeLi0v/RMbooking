<!doctype html>
<html lang="ru">

<head>
    <?php include_once ("./mainHead.php") ?>
</head>

<body>

    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->
    <?php include_once ("./navBar.php") ?>

    <div class="content">
        <?php include_once ("./pages/booking.php") ?>
    </div>
    <script>
        if (window.jQuery) {
            console.log("ok");
        } else {
            console.log("err");
        }
    </script>

    <script src="./js/jquery.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> -->
    <script src="./js/openPage.js"></script>
</body>

</html>