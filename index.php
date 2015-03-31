<?php
require_once('function.php');
if ($_POST) {
    list ($login, $password) = valid_fields();
    set_user();
    cleanMemberSession($_POST['login'], $_POST['password']);
    header("Location: members.php");
}
?>
<link href="Styles/style.css" rel="stylesheet" type="text/css">
<html>
<head>
    <title>HTML-форма добавления новых пользователей</title>
</head>
<body>

<h1>Session Test</h1>

<form action="" method="post">
    <table>
        <tr>
            <td>USER</td>
            <td><input type="text" name="login" maxlength="30" size="30">
        </tr>
        <tr>
            <td>PASSWORD</td>
            <td><input type="password" name="password" maxlength="30" size="30">
        </tr>
        <tr>
            <td><input type='submit' value="регистрация"/>
        </tr>
    </table>
</form>
</body>
</body>
</html>