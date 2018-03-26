<?php
session_start();
if(empty($_POST)) {
    exit();
}

if(empty($_SESSION["connected"])) {
    exit();
} else {
    if(!$_SESSION["connected"]) {
        exit();
    }
}

define('ROOT', dirname(dirname(__DIR__)));
define('NOVA', dirname(dirname(dirname(__DIR__))).'/nova/');
include("./includes/DAO.class.php");

$DAO = new DAO();
$db = $DAO->getDb();

if(filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
    if(preg_match("/^[A-Za-z0-9_.-]{2,19}$/", $_POST['login'])) {
        
        
        $email = $_POST['mail'];
        $password = password_hash(urldecode($_POST['pass']), PASSWORD_BCRYPT);
        $login = $_POST['login'];
        $cek = $_POST['cek'];
        
        if(!($DAO->isEmailInDatabase($email))) {
            if(!($DAO->isUsernameInDatabase($login))) {
                $doubleAuth = 0;
                if($_POST['doubleAuth'] == 'true') $doubleAuth = 1;
                    
                    
                //AInsert row on users
                $theRequest = $db->prepare('INSERT INTO users(login, password, email, registration_date, last_connection, cek, double_auth, auth_code) VALUES(:login, :password, :email, :registration_date, :last_connection, :cek, :double_auth, :auth_code)');
                
                $theRequest->bindValue(':login', $login, PDO::PARAM_STR);
                $theRequest->bindValue(':password', $password, PDO::PARAM_STR);
                $theRequest->bindValue(':email', $email, PDO::PARAM_STR);
                $theRequest->bindValue(':registration_date', time(), PDO::PARAM_INT);
                $theRequest->bindValue(':last_connection', time(), PDO::PARAM_INT);
                $theRequest->bindValue(':cek', $cek, PDO::PARAM_STR);
                $theRequest->bindValue(':double_auth', $doubleAuth, PDO::PARAM_INT);
                $theRequest->bindValue(':auth_code', '', PDO::PARAM_STR);
                $theRequest->execute();
                
                $id_user = $db->lastInsertId();
                $key = hash('sha512', uniqid(rand(), true));
                                    
                //Insert new row on storage
                $theRequest = $db->prepare('INSERT INTO storage(id_user, user_quota, size_stored) VALUES(:id_user, :user_quota, :size_stored)');
                
                $theRequest->bindValue(':id_user', $id_user, PDO::PARAM_INT);
                $theRequest->bindValue(':user_quota', 2*1000*1000*1000, PDO::PARAM_INT);
                $theRequest->bindValue(':size_stored', 0, PDO::PARAM_INT);
                $theRequest->execute();
                
                                    
                mkdir(NOVA.'/'.$id_user, 0770);
                echo "ok@".htmlentities("User successfully created");
            }
            else {
                // "loginExists" response
                echo htmlentities("Login already exists in database");
            }
        }
        else {
            // "mailExists" response
            echo htmlentities("Mail already exists in database");
        }
    }
    else {
        // "loginFormat" response
        echo htmlentities("Login doesn't match required format");
    }
}
else {
    // "mailFormat" response
    echo htmlentities("Mail doesn't match required format");
}

?>