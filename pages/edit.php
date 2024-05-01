
<?php 
$id = $_POST['id'];
$page = $_POST['page'];

if ($page == 'booking') { ?>
    <form>
        
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
    <form>
        <label>
            Фамилия:
            <input type="text" name="surname" required value="<?php echo $row["surname"] ?>" />
        </label>
        <label>
            Имя:
            <input type="text" name="name" required value="<?php echo $row["name"] ?>" />
        </label>
        <label>
            Отчество:
            <input type="text" name="patronymic" value="<?php echo $row["patronymic"] ?>" />
        </label>
        <label>
            Телефон:
            <input type="tel" name="phone" required value="<?php echo $row["phone"] ?>" />
        </label>
        <label>
            Почта:
            <input type="email" name="email" required value="<?php echo $row["email"] ?>" />
        </label>
        <button>Сохранить</button>
    </form>
<?php } elseif ($page == 'rooms') { ?>

<?php } elseif ($page == 'staff') { ?>

<?php } else { ?>
    <div>Page not found</div>
<?php } ?>