<?php
session_start();
$_SESSION["connected"] = false;
$_SESSION["rank"] = null;
$_SESSION["login"] = null;
header('Location: ./index.php');
?>