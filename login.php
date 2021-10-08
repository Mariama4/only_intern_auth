<?php 
    require "db/connectOdb.php";

    if(isset($_POST['login'])){

        $login = !empty($_POST['login']) ? trim($_POST['login']) : null;
        $pass = !empty($_POST['password']) ? trim($_POST['password']) : null;
        
        $sql = 'SELECT id, name FROM `user` WHERE `name` = :login and `password` = :pass ;';
        $stmt = $connection->prepare($sql);
        
        
        $stmt->bindValue(':login', $login);
        $stmt->bindValue(':pass', $pass);
        
        
        $stmt->execute();
        
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if($user === false){
            echo "
            <script>
                alert('Ошибка, повторите попытку!');
            </script>";
        } else{
            echo "
            <script>
                alert('Вы успешно авторизировались!');
            </script>";


            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = time();

            header('Location: home.php');
            exit;
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
        <h1>Авторизация</h1>
        <form method="post" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
            <p>
                <label for="login">Логин</label>
                <input 
                    id="login"
                    type="text" 
                    name = "login" 
                    autofocus="1" 
                    placeholder="Ваш логин" 
                >
            </p>
            <p>
                <label for="password">Пароль</label>
                <input 
                    id="password"
                    type="password" 
                    name = "password" 
                    placeholder="Ваш пароль" 
                >
            </p>
            <p>
                <button type = "submit" value="login">Войти</button>
            </p>
        </form>
        <button>
            <a href = "index.php" title="Вернуться">Вернуться</a>
        </button>
    </div>
</body>
</html>