<?php 

$page = $_POST['page'];

if ($page == "booking") { 
    
    require_once($_SERVER['DOCUMENT_ROOT']."/connect.php");
    $db = new DB_Class();
    $conn = $db->connect();
    mysqli_select_db($conn, $db->database); ?>

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
                            echo "<option value='". $row['id'] ."'>". $row["surname"] . " " . $row["name"] . " " . $row["patronymic"] . "</option>";
                        }
                    }
                ?>
            </select>
        </label>
        <label for="client">Клиент:
            <select name="client" id="client" disabled>
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
                            echo "<option value='". $row['id'] ."'>". $row["surname"] . " " . $row["name"] . " " . $row["patronymic"] . "</option>";
                        }
                    }
                ?>
            </select>
        </label>
        <label for="typeRoom">Тип помещения:
            <select name="typeRoom" id="typeRoom" disabled >
                <option value="">--Тип помещения не выбран--</option>
                
                <?php 
                    $sql = "SELECT DISTINCT
                                type AS type
                            FROM Rooms";
                    
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) { 
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='". $row['type'] ."'>". $row["type"] ."</option>";
                        }
                    }
                ?>
            </select>
        </label>
        <label for="room">Помещение:
            <select name="room" id="room" disabled>
                <option value="">--Помещение не выбрано--</option>
            </select>
        </label>
        <label for="booking_date">Дата бронирования:
            <input type="date" name="booking_date" id="booking_date" min="<?php echo date('Y-m-d'); ?>" disabled />
        </label>
        <label for="booking_time_begin">Время бронирования:
            <div class="timeSlots" id="timeSlots">
                <div class="timeBlock off" time="10:00:00" onclick="selectTime(10)">10:00</div>
                <div class="timeBlock off" time="11:00:00" onclick="selectTime(11)">11:00</div>
                <div class="timeBlock off" time="12:00:00" onclick="selectTime(12)">12:00</div>
                <div class="timeBlock off" time="13:00:00" onclick="selectTime(13)">13:00</div>
                <div class="timeBlock off" time="14:00:00" onclick="selectTime(14)">14:00</div>
                <div class="timeBlock off" time="15:00:00" onclick="selectTime(15)">15:00</div>
                <div class="timeBlock off" time="16:00:00" onclick="selectTime(16)">16:00</div>
                <div class="timeBlock off" time="17:00:00" onclick="selectTime(17)">17:00</div>
                <div class="timeBlock off" time="18:00:00" onclick="selectTime(18)">18:00</div>
                <div class="timeBlock off" time="19:00:00" onclick="selectTime(19)">19:00</div>
                <div class="timeBlock off" time="20:00:00" onclick="selectTime(20)">20:00</div>
                <div class="timeBlock off" time="21:00:00" onclick="selectTime(21)">21:00</div>
                <div class="timeBlock off" time="22:00:00" onclick="selectTime(22)">22:00</div>
            </div>
            <input type="hidden" name="booking_time_begin" id="booking_time_begin" value="" />
            <input type="hidden" name="booking_time_end" id="booking_time_end" value="" />
        </label>
        <label for="sum">Сумма:
            <input type="text" name="sum" id="sum" disabled />
        </label>
        <button class="cancel" onclick="cancelEdit(event,'<?php echo $page ?>')">Отменить</button>
        <button class="save" id="create" onclick="createStr(event,'<?php echo $page ?>')" disabled>Создать</button>
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
                    data: { type: selectedType },
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
                    data: { booking_date: selectedDate, room: room, client: null },
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
<?php $db->close(); 
} elseif ($page == "clients") { ?>
    <form id="editForm">
        <label for="surname">
            Фамилия:
            <input type="text" name="surname" required />
        </label>
        <label for="name">
            Имя:
            <input type="text" name="name" required />
        </label>
        <label for="patronymic">
            Отчество:
            <input type="text" name="patronymic" />
        </label>
        <label for="phone">
            Телефон:
            <input type="tel" name="phone" required />
            <script>
                $('input[name="phone"]').eq(0).mask('+7 (999) 999-99-99', {placeholder: "+7 (999) 999-99-99" });
            </script>
        </label>
        <label for="email">
            Почта:
            <input type="email" name="email" required />
        </label>
        <button class="cancel" onclick="cancelEdit(event,'<?php echo $page ?>')">Отменить</button>
        <button class="save" onclick="createStr(event,'<?php echo $page ?>')">Создать</button>
    </form>
<?php } elseif ($page == "staff") { ?>
    <form id="editForm">
        <label for="surname">
            Фамилия:
            <input type="text" name="surname" required />
        </label>
        <label for="name">
            Имя:
            <input type="text" name="name" required />
        </label>
        <label for="patronymic">
            Отчество:
            <input type="text" name="patronymic" />
        </label>
        <label for="sex" class="sex">
            Пол:
            <div><input type="radio" name="sex" value="М" required />Мужской</div>
            <div><input type="radio" name="sex" value="Ж" required />Женский</div>
            
        </label>
        <label for="birthday">
            День рождения:
            <input type="date" name="birthday" />
        </label>
        <label for="passport">
            Паспорт:
            <input type="text" name="passport" required />
            <script>
                $('input[name="passport"]').eq(0).mask('9999 999999', {placeholder: "____ ______" });
            </script>
        </label>
        <label for="phone">
            Телефон:
            <input type="tel" name="phone" required />
            <script>
                $('input[name="phone"]').eq(0).mask('+7 (999) 999-99-99', {placeholder: "+7 (999) 999-99-99" });
            </script>
        </label>
        <label for="email">
            Почта:
            <input type="email" name="email" required />
        </label>
        <label for="post">
            Должность:
            <input type="text" name="post" required />
        </label>
        <button class="cancel" onclick="cancelEdit(event,'<?php echo $page ?>')">Отменить</button>
        <button class="save" type="submit" onclick="createStr(event,'<?php echo $page ?>')">Создать</button>
    </form>
<?php } elseif ($page == "rooms") { ?>
    <form id="editForm">
        <label for="type">
            Тип помещения:
            <input type="text" name="type" required />
        </label>
        <label for="name">
            Название:
            <input type="text" name="name" required />
        </label>
        <label for="description">
            Описание:
            <input type="text" name="description" />
        </label>
        <label for="address">
            Адрес:
            <input type="text" name="address" required />
        </label>
        <label for="cost">
            Стоимость (руб/час):
            <input type="text" name="cost" required />
        </label>
        <button class="cancel" onclick="cancelEdit(event,'<?php echo $page ?>')">Отменить</button>
        <button class="save" onclick="createStr(event,'<?php echo $page ?>')">Создать</button>
    </form>
<?php } ?>
<script>
    // Удаляем подсветку при начале ввода в обязательных полях
    $("#editForm [required]").on("focus", function() {
        $(this).removeClass("highlight");
    });
</script>