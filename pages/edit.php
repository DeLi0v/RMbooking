
<?php 
$id = $_POST['id'];
$page = $_POST['page'];

require_once($_SERVER['DOCUMENT_ROOT']."/connect.php");

$db = new DB_Class();
$conn = $db->connect();
mysqli_select_db($conn, $db->database);

if ($page == 'booking') { ?>
    <form id="editForm">
        
    </form>
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
        </label>
        <label for="email">
            Почта:
            <input type="email" name="email" required value="<?php echo $row["email"] ?>" />
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
        <label for="post">
            Должность:
            <input type="text" name="post" required value="<?php echo $row["post"] ?>" />
        </label>
        <label for="phone">
            Телефон:
            <input type="tel" name="phone" required value="<?php echo $row["phone"] ?>" />
        </label>
        <label for="email">
            Почта:
            <input type="email" name="email" required value="<?php echo $row["email"] ?>" />
        </label>
        <label for="birthday">
            День рождения:
            <input type="date" name="birthday" required value="<?php echo $row["birthday"] ?>" />
        </label>
        <label for="sex">
            Пол:
            <input type="radio" name="sex" value="М" required <?php if ($row["sex"] === "М") echo "checked"; ?>>
            <input type="radio" name="sex" value="Ж" required <?php if ($row["sex"] === "Ж") echo "checked"; ?>>
        </label>
        <label for="passport">
            Паспорт:
            <input type="text" name="passport" required value="<?php echo $row["passport"] ?>" />
        </label>
        <button class="cancel" onclick="cancelEdit(event,'<?php echo $page ?>')">Отменить</button>
        <button class="save" onclick="saveEdit(event,'<?php echo $page ?>', '<?php echo $id ?>')">Сохранить</button>
    </form>
<?php } else { ?>
    <div>Page not found</div>
<?php } 
$db->close();?>