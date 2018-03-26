<?php
session_start();

if(empty($_SESSION["design"])) {
    $_SESSION["design"] = "dark";
}

$_SESSION["design"] = "dark";

/*if($_SESSION["design"] == "light") {
    $_SESSION["design"] = "dark";
} else {
    $_SESSION["design"] = "light";
}*/
if(!empty($_SERVER['HTTP_REFERER']))
    header("Location: {$_SERVER['HTTP_REFERER']}");
else {
    header("Location: ./index.php");
}
?>