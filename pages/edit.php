
<?php 
$id = $_POST['id'];
$page = $_POST['page'];

require_once($_SERVER['DOCUMENT_ROOT']."/connect.php");

$db = new DB_Class();
$conn = $db->connect();
mysqli_select_db($conn, $db->database);

if ($page == 'booking') {
    $sql = "SELECT
                Booking.id AS id,
                Booking.room AS idRoom,
                Rooms.name AS room,
                Rooms.type AS roomType,
                Booking.client AS idClient,
                Clients.surname AS clientSurname,
                Clients.name AS clientName,
                Clients.patronymic AS clientPatronymic,
                Booking.staff AS idStaff,
                Staff.surname AS staffSurname,
                Staff.name AS staffName,
                Staff.patronymic AS staffPatronymic,
                Booking.booking_date AS booking_date,
                Booking.booking_time_begin AS booking_time_begin,
                Booking.booking_time_end AS booking_time_end,
                Booking.sum AS sum
            FROM 
                `Booking`
                LEFT JOIN `Clients` ON Booking.client = Clients.id
                LEFT JOIN `Staff` ON Booking.staff = Staff.id
                LEFT JOIN `Rooms`ON Booking.room = Rooms.id
            WHERE
                Booking.id = '$id'";

    $result = mysqli_query($conn, $sql);
    $rowBooking = mysqli_fetch_assoc($result); ?>

    <form id="editForm">
        <label for="staff">Сотрудник:
            <select name="staff" id="staff">
                <option value="">--Сотрудник не выбран--</option>
                
                <?php 
                    $sql = "SELECT 
                                id AS id,
                                surname AS surname,
                                name AS name,
                                patronymic AS patronymic
                            FROM Staff";
                    
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) { 
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selected = ($rowBooking['idStaff'] == $row['id']) ? 'selected' : '';
                            echo "<option value='". $row['id'] ."' $selected>". $row["surname"] . " " . $row["name"] . " " . $row["patronymic"] . "</option>";
                        }
                    }
                ?>
            </select>
        </label>
        <label for="client">Клиент:
            <select name="client" id="client">
                <option value="">--Клиент не выбран--</option>
                
                <?php 
                    $sql = "SELECT 
                                id AS id,
                                surname AS surname,
                                name AS name,
                                patronymic AS patronymic
                            FROM Clients";
                    
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) { 
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selected = ($rowBooking['idClient'] == $row['id']) ? 'selected' : '';
                            echo "<option value='". $row['id'] ."' $selected>". $row["surname"] . " " . $row["name"] . " " . $row["patronymic"] . "</option>";
                        }
                    }
                ?>
            </select>
        </label>
        <label for="typeRoom">Тип помещения:
            <select name="typeRoom" id="typeRoom" >
                <option value="">--Тип помещения не выбран--</option>
                
                <?php 
                    $sql = "SELECT DISTINCT
                                type AS type
                            FROM Rooms";
                    
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) { 
                        while ($row = mysqli_fetch_assoc($result)) {
                            $selected = ($rowBooking['roomType'] == $row['type']) ? 'selected' : '';
                            echo "<option value='". $row['type'] ."' $selected>". $row["type"] ."</option>";
                        }
                    }
                ?>
            </select>
        </label>
        <label for="room">Помещение:
            <select name="room" id="room">
                <option value="">--Помещение не выбрано--</option>
            </select>
        </label>
        <label for="booking_date">Дата бронирования:
            <input type="date" name="booking_date" id="booking_date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo $rowBooking['booking_date']?>" />
        </label>
        <label for="booking_time_begin">Время бронирования:
            <div class="timeSlots" id="timeSlots">
                <?php 
                $timeBlocksFromDB = array();
                $clientTimeBlocksFromDB = array();

                $sql = "SELECT
                    booking_time_begin AS booking_time_begin,
                    booking_time_end AS booking_time_end,
                    client AS client
                FROM Booking
                WHERE
                    booking_date = '$booking_date'
                    AND room = '$room'";

                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) { 
                    while ($row = mysqli_fetch_assoc($result)) {
                        $start_time = new DateTime($row['booking_time_begin']);
                        $end_time = new DateTime($row['booking_time_end']);
                        while ($start_time <= $end_time) {
                            if ($client !== null && $client !== "" && $row["client"] == $client) {
                                $clientTimeBlocksFromDB[] = $start_time->format("H");;
                            }
                            $timeBlocksFromDB[] = $start_time->format("H");;
                            $start_time->modify('+1 hour'); // Увеличиваем на час
                        }
                    }
                }    

                // Генерируем блоки времени от 10:00 до 22:00
                for ($hour = 10; $hour <= 22; $hour++) {
                    // Форматируем время в формат "час:00:00"
                    $time = sprintf("%02d:00:00", $hour);
                    // Создаем класс timeBlock с временем и проверяем, есть ли это время в массиве времени из БД
                    $class = (in_array($hour, $timeBlocksFromDB)) ? 'timeBlock selectedOther' : 'timeBlock';
                    if ($client !== null && $client !== "" && $row["client"] == $client) {
                        $class = (in_array($hour, $clientTimeBlocksFromDB)) ? 'timeBlock select' : 'timeBlock';
                    }
                    // Выводим блок времени
                    echo '<div class="' . $class . '" time="' . $hour . ':00:00" onclick="selectTime(' . $hour . ')">' . $hour . ':00</div>';
                }
                ?>
            </div>
            <input type="hidden" name="booking_time_begin" id="booking_time_begin" value="" />
            <input type="hidden" name="booking_time_end" id="booking_time_end" value="" />
        </label>
        <label for="sum">Сумма:
            <input type="text" name="sum" id="sum" value="<?php echo $rowBooking["sum"] ?>" />
        </label>
        <button class="cancel" onclick="cancelEdit(event,'<?php echo $page ?>')">Отменить</button>
        <button class="save" id="create" type="submit" onclick="saveEdit(event,'<?php echo $page ?>', '<?php echo $id ?>')">Сохранить</button>
    </form>
    <script>
        $("#staff").on("change", function() {
            if ($(this).val() !== "") {
                $("#client").prop("disabled", false);
                if($("#client").val() !== "") {
                    $("#typeRoom").prop("disabled", false);
                } 
                if ($("#client").val() !== "" && $("#typeRoom").val() !== ""){
                    $("#room").prop("disabled", false);
                    $("#booking_date").prop("disabled", false);
                }
                if($("#client").val() !== "" && $("#typeRoom").val() !== "" && $("#room").val() !== ""){
                    $("#room").prop("disabled", false);
                    $("#booking_date").prop("disabled", false);
                }
                var timeBlocks = document.querySelectorAll(".timeBlock");
                if($("#client").val() !== "" && $("#typeRoom").val() !== "" && $("#room").val() !== "" && $("#booking_date").val() !== ""){
                    $("#booking_date").prop("disabled", false);
                    
                    timeBlocks.forEach(function (block) {
                        block.classList.remove("off");
                    });
                }
                timeBlocks.forEach(function() {
                    if ($("#client").val() !== "" && $("#typeRoom").val() !== "" && $("#room").val() !== "" && $("#booking_date").val() !== "" && $("#booking_time_end").val() !== "") {
                        $("#sum").prop("disabled", false);
                        return;
                    }
                });                
                if($("#client").val() !== "" && $("#typeRoom").val() !== "" && $("#room").val() !== "" && $("#booking_date").val() !== "" && $("#booking_time_end").val() !== "" &&  $("#sum").val() !== ""){
                    $("#sum").prop("disabled", false);
                    $("#create").prop("disabled", false);
                }
            } else {
                $("#client").prop("disabled", true);
                $("#typeRoom").prop("disabled", true);
                $("#room").prop("disabled", true);
                $("#booking_date").prop("disabled", true);
                var timeBlocks = document.querySelectorAll(".timeBlock");
                timeBlocks.forEach(function (block) {
                        block.classList.add("off");
                });
                $("#sum").prop("disabled", true);
                $("#create").prop("disabled", true);
            }
        });
        var client = "";
        $("#client").on("change", function() {
            client = $(this).val();
            if (client !== "") {
                $("#typeRoom").prop("disabled", false);
                if ($("#typeRoom").val() !== ""){
                    $("#room").prop("disabled", false);
                }
                if($("#typeRoom").val() !== "" && $("#room").val() !== ""){
                    $("#room").prop("disabled", false);
                    $("#booking_date").prop("disabled", false);
                }
                var timeBlocks = document.querySelectorAll(".timeBlock");
                if($("#typeRoom").val() !== "" && $("#room").val() !== "" && $("#booking_date").val() !== ""){
                    $("#booking_date").prop("disabled", false);
                    
                    timeBlocks.forEach(function (block) {
                        block.classList.remove("off");
                    });
                }
                timeBlocks.forEach(function() {
                    if ($("#typeRoom").val() !== "" && $("#room").val() !== "" && $("#booking_date").val() !== "" && $("#booking_time_end").val() !== "") {
                        $("#sum").prop("disabled", false);
                        return;
                    }
                });                
                if($("#typeRoom").val() !== "" && $("#room").val() !== "" && $("#booking_date").val() !== "" && $("#booking_time_end").val() !== "" &&  $("#sum").val() !== ""){
                    $("#sum").prop("disabled", false);
                    $("#create").prop("disabled", false);
                }
            } else {
                $("#typeRoom").prop("disabled", true);
                $("#room").prop("disabled", true);
                $("#booking_date").prop("disabled", true);
                var timeBlocks = document.querySelectorAll(".timeBlock");
                timeBlocks.forEach(function (block) {
                        block.classList.add("off");
                });
                $("#sum").prop("disabled", true);
                $("#create").prop("disabled", true);
            }
        });

        $("#typeRoom").on("change", function() {
            var selectedType = $(this).val();
            if (selectedType !== "") {
                $("#room").prop("disabled", false).val("");
                $("#booking_date").prop("disabled", true).val("");
                $("#booking_time_begin").val("");
                $("#booking_time_end").val("");
                $("#sum").prop("disabled", true).val("");
                $("#create").prop("disabled", true);

                var timeBlocks = document.querySelectorAll('.timeBlock');
                timeBlocks.forEach(function(block) {
                    block.classList.remove('select');
                    block.classList.add("off");
                });


                $.ajax({
                    url: "/components/get_rooms.php",
                    method: "POST",
                    data: { type: selectedType, room: <?php echo $rowBooking["idRoom"]?> },
                    success: function(response) {
                        $("#room").html(response).prop("disabled", false);
                    },
                    error: function(xhr, status, error) {
                        console.error("Ошибка получения списка помещений:", error);
                    }
                });

            } else {
                $("#room").prop("disabled", true).val("");
                $("#booking_date").prop("disabled", true).val("");
                $("#booking_time_begin").val("");
                $("#booking_time_end").val("");
                $("#sum").prop("disabled", true).val("");
                $("#create").prop("disabled", true);
                var timeBlocks = document.querySelectorAll('.timeBlock');
                timeBlocks.forEach(function(block) {
                    block.classList.remove('select');
                    block.classList.add("off");
                });
            }
        });
        var room;
        $("#room").on("change", function() {
            room = $(this).val();
            if (room !== "") {
                $("#booking_date").prop("disabled", false).val("");
                $("#booking_time_begin").val("");
                $("#booking_time_end").val("");
                $("#sum").prop("disabled", true).val("");
                $("#create").prop("disabled", true);
                var timeBlocks = document.querySelectorAll('.timeBlock');
                timeBlocks.forEach(function(block) {
                    block.classList.remove('select');
                    block.classList.add("off");
                });
            } else {
                $("#booking_date").prop("disabled", true).val("");
                $("#booking_time_begin").val("");
                $("#booking_time_end").val("");
                $("#sum").prop("disabled", true).val("");
                $("#create").prop("disabled", true);
                var timeBlocks = document.querySelectorAll('.timeBlock');
                timeBlocks.forEach(function(block) {
                    block.classList.remove('select');
                    block.classList.add("off");
                });
            }
        });

        $("#booking_date").on("change", function() {
            var selectedDate = $(this).val();
            if (selectedDate !== "") {
                $("#booking_time_begin").val("");
                $("#booking_time_end").val("");
                $("#sum").prop("disabled", true).val("");
                $("#create").prop("disabled", true);
                
                $.ajax({
                    url: "/components/get_time.php",
                    method: "POST",
                    data: { booking_date: selectedDate, room: room },
                    success: function(response) {
                        $("#timeSlots").html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error("Ошибка получения списка времени:", error);
                    }
                });

                var timeBlocks = document.querySelectorAll('.timeBlock');
                timeBlocks.forEach(function(block) {
                    block.classList.remove('select');
                    block.classList.remove("off");
                });

            } else {
                $("#booking_time_begin").prop("disabled", true).val("");
                $("#booking_time_end").prop("disabled", true).val("");
                $("#sum").prop("disabled", true).val("");
                $("#create").prop("disabled", true);
                var timeBlocks = document.querySelectorAll('.timeBlock');
                timeBlocks.forEach(function(block) {
                    block.classList.remove('select');
                    block.classList.remove('selectedOther');
                    block.classList.add("off");
                });
            }
        });

        $("#booking_time_begin").on("change", function() {
            if ($(this).val() !== "") {
                $("#sum").prop("disabled", true).val("");
            } else {
                $("#sum").prop("disabled", true).val("");
                $("#create").prop("disabled", true);
            }
        });

        $("#booking_time_end").on("change", function() {
            if ($(this).val() !== "") {
                $("#sum").prop("disabled", false).val("");
            } else {
                $("#sum").prop("disabled", true).val("");
            }
        });

        $("#sum").on("change", function() {
            if ($(this).val() !== "") {
                $("#create").prop("disabled", false);
            } else {
                $("#create").prop("disabled", true);
            }
        });

    </script>
<?php } elseif ($page == 'clients') { 
    $sql = "SELECT 
                id AS id,
                surname AS surname,
                name AS name,
                patronymic AS patronymic,
                phone AS phone,
                email AS email
            FROM Clients
            WHERE
                id = $id";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result); ?>
    <form id="editForm">
        <label for="surname">
            Фамилия:
            <input type="text" name="surname" required value="<?php echo $row["surname"] ?>" />
        </label>
        <label for="name">
            Имя:
            <input type="text" name="name" required value="<?php echo $row["name"] ?>" />
        </label>
        <label for="patronymic">
            Отчество:
            <input type="text" name="patronymic" value="<?php echo $row["patronymic"] ?>" />
        </label>
        <label for="phone">
            Телефон:
            <input type="tel" name="phone" required value="<?php echo $row["phone"] ?>" />
            <script>
                $('input[name="phone"]').eq(0).mask('+7 (999) 999-99-99', {placeholder: "+7 (999) 999-99-99" });
            </script>
        </label>
        <label for="email">
            Почта:
            <input type="email" name="email" value="<?php echo $row["email"] ?>" />
        </label>
        <button class="cancel" onclick="cancelEdit(event,'<?php echo $page ?>')">Отменить</button>
        <button class="save" onclick="saveEdit(event,'<?php echo $page ?>', '<?php echo $id ?>')">Сохранить</button>
    </form>

<?php } elseif ($page == 'rooms') { 
    $sql = "SELECT 
                id AS id,
                type AS type,
                name AS name,
                description AS description,
                address AS address,
                cost AS cost
            FROM Rooms
            WHERE
                id = $id";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result); ?>
    
    <form id="editForm">
        <label for="type">
            Тип помещения:
            <input type="text" name="type" required value="<?php echo $row["type"] ?>" />
        </label>
        <label for="name">
            Название:
            <input type="text" name="name" required value="<?php echo $row["name"] ?>" />
        </label>
        <label for="description">
            Описание:
            <input type="text" name="description" value="<?php echo $row["description"] ?>" />
        </label>
        <label for="address">
            Адрес:
            <input type="text" name="address" required value="<?php echo $row["address"] ?>" />
        </label>
        <label for="cost">
            Стоимость (руб/час):
            <input type="text" name="cost" required value="<?php echo $row["cost"] ?>" />
        </label>
        <button class="cancel" onclick="cancelEdit(event,'<?php echo $page ?>')">Отменить</button>
        <button class="save" onclick="saveEdit(event,'<?php echo $page ?>', '<?php echo $id ?>')">Сохранить</button>
    </form>

<?php } elseif ($page == 'staff') { 
    $sql = "SELECT 
                id AS id,
                surname AS surname,
                name AS name,
                patronymic AS patronymic,
                post AS post,
                phone AS phone,
                email AS email,
                birthday AS birthday,
                sex AS sex,
                passport AS passport
            FROM Staff
            WHERE
                id = $id";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result); ?>

    <form id="editForm">
        <label for="surname">
            Фамилия:
            <input type="text" name="surname" required value="<?php echo $row["surname"] ?>" />
        </label>
        <label for="name">
            Имя:
            <input type="text" name="name" required value="<?php echo $row["name"] ?>" />
        </label>
        <label for="patronymic">
            Отчество:
            <input type="text" name="patronymic" value="<?php echo $row["patronymic"] ?>" />
        </label>
        <label for="sex" class="sex">
            Пол:
            <div><input type="radio" name="sex" value="М" required <?php if ($row["sex"] === "М") echo "checked"; ?>>Мужской</div>
            <div><input type="radio" name="sex" value="Ж" required <?php if ($row["sex"] === "Ж") echo "checked"; ?>>Женский</div>
        </label>
        <label for="birthday">
            День рождения:
            <input type="date" name="birthday" max="<?php echo date('Y-m-d'); ?>" value="<?php echo $row["birthday"] ?>" />
        </label>
        <label for="passport">
            Паспорт:
            <input type="text" name="passport" required value="<?php echo $row["passport"] ?>" />
            <script>
                $('input[name="passport"]').eq(0).mask('9999 999999', {placeholder: "____ ______" });
            </script>
        </label>
        <label for="phone">
            Телефон:
            <input type="tel" name="phone" required value="<?php echo $row["phone"] ?>" />
            <script>
                $('input[name="phone"]').eq(0).mask('+7 (999) 999-99-99', {placeholder: "+7 (999) 999-99-99" });
            </script>
        </label>
        <label for="email">
            Почта:
            <input type="email" name="email" required value="<?php echo $row["email"] ?>" />
        </label>
        <label for="post">
            Должность:
            <input type="text" name="post" required value="<?php echo $row["post"] ?>" />
        </label>
        <button class="cancel" onclick="cancelEdit(event,'<?php echo $page ?>')">Отменить</button>
        <button class="save" type="submit" onclick="saveEdit(event,'<?php echo $page ?>', '<?php echo $id ?>')">Сохранить</button>
    </form>
<?php } else { ?>
    <div>Page not found</div>
<?php } 
$db->close();?>
<script>
// Удаляем подсветку при начале ввода в обязательных полях
  $("#editForm [required]").on("focus", function() {
    $(this).removeClass("highlight");
  });
</script>