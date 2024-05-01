<?php 

$page = $_POST['page'];

require_once($_SERVER['DOCUMENT_ROOT']."/connect.php");

$db = new DB_Class();
$conn = $db->connect();
mysqli_select_db($conn, $db->database);

if ($page == "booking") { ?>
    <form id="editForm">
        
    </form>
<?php } elseif ($page == "clients") { ?>
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
<?php }

$db->close();
?>
<script>
    // Удаляем подсветку при начале ввода в обязательных полях
    $("#editForm [required]").on("focus", function() {
        $(this).removeClass("highlight");
    });
</script>