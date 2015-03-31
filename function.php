<?php
require('config.php');
function getConnection()
{
    return new PDO(PDO_DSN, PDO_USERNAME, PDO_PASSWORD);
}

function valid_fields()
{
    $err = array();
    $login = isset($_POST['login']) ? trim(htmlspecialchars($_POST['login'])) : '';
    $password = isset($_POST['password']) ? trim(htmlspecialchars($_POST['password'])) : '';

    if (!ctype_alnum($login)) {
        return $err[] = 'логин должен складываться из латинских букв и цифр';
    }
    if (strlen($password) < 3 or strlen($password) > 30) {
        return $err[] = 'пароль должен не больше 30 и не меньше 3 символов';
    }
    if (strlen($login) < 3 or strlen($login) > 30) {
        return $err[] = 'логин должен не больше 30 и не меньше 3 символов';
    }
    try {
        $db = getConnection();
        $check_login = $db->prepare("SELECT `login`  FROM `authorization` WHERE `login`= :login");
        $check_login->bindValue(':login', $login, PDO::PARAM_STR);
        $check_login->execute();
        $check = $check_login->fetch(PDO::FETCH_ASSOC);

        if ($check) {
            return $err[] = 'Пользователь с таким логином уже существует в базе данных';
        }

    } catch (PDOException $e) {
        print_r($e->getTrace());
    }
}

function unsetMemberSession()
{
    unset($_SESSION['login']);
    unset($_SESSION['password']);
    session_destroy();
    return true;
}

function cleanMemberSession($login, $password)
{
    $_SESSION["login"] = $login;
    $_SESSION["password"] = $password;
}

function set_user()
{
    if ($errors = valid_fields()) {
        print ($errors);

    } else

        try {

            $login = $_POST['login'];
            $salt = substr(sha1($login), 10, 30) . "\3\1\2\6";
            $password = sha1(sha1($_POST['password']) . $salt);

            $db = getConnection();
            $insert = $db->prepare('INSERT INTO `authorization` (`login`, `password`)VALUES(:login,:password)');
            $insert->bindParam(':login', $login, PDO::PARAM_STR);
            $insert->bindParam(':password', $password, PDO::PARAM_STR);
            $insert->execute();

        } catch (PDOException $e) {
            print_r($e->getTrace());
        }
}

?>