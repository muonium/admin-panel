<?php

use \config as conf;

require_once(ROOT."/config/confDB.php");
require_once(ROOT."/config/confMail.php");
require_once(ROOT."/library/MVC/Mail.php");

class DAO {
    
    protected static $_sql;

    function __construct() {
        self::$_sql = new \PDO('mysql:host='.conf\confDB::host.';dbname='.conf\confDB::db,conf\confDB::user,conf\confDB::password);
    }
    
    public function getIDfromUsername($anUsername) {
        $theRequest = self::$_sql->prepare('SELECT id FROM users WHERE login = :login');
        $theRequest->bindParam(':login', $anUsername, PDO::PARAM_STR);
        $theRequest->execute();
        $id = $theRequest->fetch();
        return $id['id'];
    }

    public function getIDfromEmail($anEmail) {
        $theRequest = self::$_sql->prepare('SELECT id FROM users WHERE email = :email');
        $theRequest->bindParam(':email', $anEmail, PDO::PARAM_STR);
        $theRequest->execute();
        $id = $theRequest->fetch();
        return $id['id'];
    }

    public function getMailFromID($anID) {
        $theRequest = self::$_sql->prepare('SELECT email FROM users WHERE id = :id');
        $theRequest->bindParam(':id', $anID, PDO::PARAM_INT);
        $theRequest->execute();
        $mail = $theRequest->fetch();
        return $mail;
    }

    public function getUsernameFromID($anID) {
        $theRequest = self::$_sql->prepare('SELECT login FROM users WHERE id = :id');
        $theRequest->bindParam(':id', $anID, PDO::PARAM_INT);
        $theRequest->execute();
        $username = $theRequest->fetch();
        return $username;
    }
    
    function isEmailInDatabase($anEmail) {
        $theRequest = self::$_sql->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
        $theRequest->bindValue(':email', $anEmail, PDO::PARAM_STR);
        $theRequest->execute();
        $result = $theRequest->fetch();
        $theRequest->closeCursor();
        return !($result[0] == 0);
    }

    function isUsernameInDatabase($anUsername) {
        $theRequest = self::$_sql->prepare('SELECT COUNT(*) FROM users WHERE login = :login');
        $theRequest->bindValue(':login', $anUsername, PDO::PARAM_STR);
        $theRequest->execute();
        $result = $theRequest->fetch();
        $theRequest->closeCursor();
        return !($result[0] == 0);
    }
    
    function isIDinDatabase($anUserID) {
        $theRequest = self::$_sql->prepare('SELECT COUNT(*) FROM users WHERE id = :id');
        $theRequest->bindValue(':id', $anUserID, PDO::PARAM_INT);
        $theRequest->execute();
        $result = $theRequest->fetch();
        $theRequest->closeCursor();
        return !($result[0] == 0);
    }
    
    function deleteUserVerification($anUserID) {
        $req = self::$_sql->prepare("DELETE FROM user_validation WHERE id_user = :id_user");
        $req->bindValue(':id_user', $anUserID, PDO::PARAM_INT);
        $req->execute();
        $count = $req->rowCount();
        $req->closeCursor();
        return $count;
	}
    
    function getAllStoragePlans() {
        $req = self::$_sql->prepare("SELECT * FROM storage_plans");
        $req->execute();
        $result = $req->fetchAll();
        $req->closeCursor();
        return $result;
    }
    
}

?>