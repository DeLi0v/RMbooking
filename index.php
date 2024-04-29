<!doctype html>
<html lang="ru">

<head>
    <?php include_once ("MainHead.php") ?>
</head>

<body>
    <div class="tab">
        <button class="tablinks" onclick="openPage(event, 'London')">London</button>
        <button class="tablinks" onclick="openPage(event, 'Paris')">Paris</button>
        <button class="tablinks" onclick="openPage(event, 'Tokyo')">Tokyo</button>
    </div>

    <div id="London" class="tabcontent">
        <h3>London</h3>
        <p>London is the capital city of England.</p>
    </div>

    <div id="Paris" class="tabcontent">
        <h3>Paris</h3>
        <p>Paris is the capital of France.</p>
    </div>

    <div id="Tokyo" class="tabcontent">
        <h3>Tokyo</h3>
        <p>Tokyo is the capital of Japan.</p>
    </div>
</body>

</html>