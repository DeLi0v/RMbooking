<!doctype html>
<html lang="ru">

<head>
    <?php include_once ("./mainHead.php") ?>
    <script defer src="/js/jquery-3.7.1.js"></script>
</head>

<body>
    <?php include_once ("./navBar.php") ?>

    <div class="content">
        <script>
            if (window.JQuery) {
                var vJq = jQuery.fn.jquery;
                console.log(vJq);
            } else { console.log("ERror"); }
        </script>
        <?php include_once ("./pages/booking.php") ?>
    </div>

    <script src="./js/openPage.js"></script>

</body>

</html>