<?php
require_once("config.php");
echo 'Hi    '.$_SESSION['login'];
print ("<a href=\"logout.php"."\">Выход</a>");
?>