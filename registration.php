<?php 

require "db/connectOdb.php";

if(isset($_POST['register'])){

    $username = !empty($_POST['username']) ? trim($_POST['username']) : null;
    $email = !empty($_POST['email']) ? trim($_POST['email']) : null;
    $pass = !empty($_POST['password']) ? trim($_POST['password']) : null;
    $pass_repeat = !empty($_POST['password_repeat']) ? trim($_POST['password_repeat']) : null;

    $sql = 'SELECT true FROM `user` WHERE `email` = :email;';
    $stmt = $connection->prepare($sql);

    $stmt->bindValue(':email', $email);

    $stmt->execute();
   
    $isNewEmail = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!($pass === $pass_repeat)){ 
        echo "
            <script>
                alert('Пароли не совпадают! Повторите попытку.');
            </script>";
    } else {
        if(!($isNewEmail === false)){
            echo "
            <script>
                alert('Данная почта уже зарегистрирована! Повторите попытку.');
            </script>"; 
        } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "
            <script>
                alert('Почта введена некорректно! Повторите попытку.');
            </script>"; 
        } else {
        
            $sql = 'INSERT INTO `ott_users`.`user` (`name`, `password`, `email`) VALUES (:username, :pass, :email);';
            $stmt = $connection->prepare($sql);

            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':pass', $pass);
            $stmt->bindVaLue(':email', $email);

            $result = $stmt->execute();

            if($result){
                echo "
                    <script>
                        alert('Вы успешно зарегистрировались!');
                        window.location = 'index.php';
                    </script>";
                        }
                exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in/up</title>
</head>
<body>
    <div class="container" align="center">
        <h1>Регистрация</h1>
        <form method="post" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
            <p>
                <label for="username">Имя</label>
                <input type="text" 
                    id="username" 
                    autofocus="1" 
                    name="username"
                    placeholder="Ваше имя"
                ><br>
            </p>
            <p>
                <label for="email">Почта</label>
                <input type="text" 
                    id="email" 
                    name="email"
                    placeholder="Ваша почта"
                ><br>
            </p>
            <p>
                <label for="password">Пароль</label>
                <input type="text" 
                    id="password" 
                    name="password"
                    placeholder="Ваш пароль"
                ><br>
            </p>
            <p>
                <label for="password_repeat">Повторите пароль</label>
                <input type="text" 
                    id="password_repeat" 
                    name="password_repeat"
                    placeholder="Ваш пароль"
                ><br>
            </p>
            <p>
                <input type="submit" name="register" value="Зарегистрироваться!"></button>
            </p>
        </form>
        <button>
            <a href = "index.php" title="Вернуться">Вернуться</a>
        </button>
    </div>
    
</body>
</html>