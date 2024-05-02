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
            <div class="timeSlots" id="timeSlots" required>
                <div class="timeBlock" time="10:00:00" onclick="selectTime(10)">10:00</div>
                <div class="timeBlock" time="11:00:00" onclick="selectTime(11)">11:00</div>
                <div class="timeBlock" time="12:00:00" onclick="selectTime(12)">12:00</div>
                <div class="timeBlock" time="13:00:00" onclick="selectTime(13)">13:00</div>
                <div class="timeBlock" time="14:00:00" onclick="selectTime(14)">14:00</div>
                <div class="timeBlock" time="15:00:00" onclick="selectTime(15)">15:00</div>
                <div class="timeBlock" time="16:00:00" onclick="selectTime(16)">16:00</div>
                <div class="timeBlock" time="17:00:00" onclick="selectTime(17)">17:00</div>
                <div class="timeBlock" time="18:00:00" onclick="selectTime(18)">18:00</div>
                <div class="timeBlock" time="19:00:00" onclick="selectTime(19)">19:00</div>
                <div class="timeBlock" time="20:00:00" onclick="selectTime(20)">20:00</div>
                <div class="timeBlock" time="21:00:00" onclick="selectTime(21)">21:00</div>
                <div class="timeBlock" time="22:00:00" onclick="selectTime(22)">22:00</div>
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
                $("#typeRoom").prop("disabled", false);
                if($("#room").val() !== ""){
                    $("#room").prop("disabled", false);
                    $("#booking_date").prop("disabled", false);
                }
                if($("#booking_date").val() !== ""){
                    $("#booking_date").prop("disabled", false);
                    $("#booking_time_begin").prop("disabled", false);
                }
                if($("#booking_time_begin").val() !== ""){
                    $("#booking_time_begin").prop("disabled", false);
                    $("#booking_time_end").prop("disabled", false);
                }
                if($("#booking_time_end").val() !== ""){
                    $("#booking_time_end").prop("disabled", false);
                    $("#sum").prop("disabled", false);
                }
                if($("#sum").val() !== ""){
                    $("#sum").prop("disabled", false);
                    $("#create").prop("disabled", false);
                }
            } else {
                $("#typeRoom").prop("disabled", true);
                $("#room").prop("disabled", true);
                $("#booking_date").prop("disabled", true);
                $("#booking_time_begin").prop("disabled", true);
                $("#booking_time_end").prop("disabled", true);
                $("#sum").prop("disabled", true);
                $("#create").prop("disabled", true);
            }
        });

        $("#typeRoom").on("change", function() {
            var selectedType = $(this).val();
            if (selectedType !== "") {
                $("#room").prop("disabled", false).val("");
                $("#booking_date").prop("disabled", true).val("");
                $("#booking_time_begin").prop("disabled", true).val("");
                $("#booking_time_end").prop("disabled", true).val("");
                $("#sum").prop("disabled", true).val("");

                var timeBlocks = document.querySelectorAll('.timeBlock');
                timeBlocks.forEach(function(block) {
                    block.classList.remove('select');
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
                $("#booking_time_begin").prop("disabled", true).val("");
                $("#booking_time_end").prop("disabled", true).val("");
                $("#sum").prop("disabled", true).val("");
                $("#create").prop("disabled", true);
                var timeBlocks = document.querySelectorAll('.timeBlock');
                timeBlocks.forEach(function(block) {
                    block.classList.remove('select');
                });
            }
        });

        $("#room").on("change", function() {
            if ($(this).val() !== "") {
                $("#booking_date").prop("disabled", false).val("");
                $("#booking_time_begin").prop("disabled", true).val("");
                $("#booking_time_end").prop("disabled", true).val("");
                $("#sum").prop("disabled", true).val("");
                var timeBlocks = document.querySelectorAll('.timeBlock');
                timeBlocks.forEach(function(block) {
                    block.classList.remove('select');
                });
            } else {
                $("#booking_date").prop("disabled", true).val("");
                $("#booking_time_begin").prop("disabled", true).val("");
                $("#booking_time_end").prop("disabled", true).val("");
                $("#sum").prop("disabled", true).val("");
                $("#create").prop("disabled", true);
                var timeBlocks = document.querySelectorAll('.timeBlock');
                timeBlocks.forEach(function(block) {
                    block.classList.remove('select');
                });
            }
        });

        $("#booking_date").on("change", function() {
            if ($(this).val() !== "") {
                $("#booking_time_begin").prop("disabled", false).val("");
                $("#booking_time_end").prop("disabled", true).val("");
                $("#sum").prop("disabled", true).val("");
                var timeBlocks = document.querySelectorAll('.timeBlock');
                timeBlocks.forEach(function(block) {
                    block.classList.remove('select');
                });
            } else {
                $("#booking_time_begin").prop("disabled", true).val("");
                $("#booking_time_end").prop("disabled", true).val("");
                $("#sum").prop("disabled", true).val("");
                $("#create").prop("disabled", true);
                var timeBlocks = document.querySelectorAll('.timeBlock');
                timeBlocks.forEach(function(block) {
                    block.classList.remove('select');
                });
            }
        });

        $("#booking_time_begin").on("change", function() {
            if ($(this).val() !== "") {
                $("#booking_time_end").prop("disabled", false).val("");
                $("#sum").prop("disabled", true).val("");
            } else {
                $("#booking_time_end").prop("disabled", true).val("");
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