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
    
    public function isUsernameInJSON($anUsername) {
        $protectedAccounts = file_get_contents("./accountsProtected.json");
        $accounts = json_decode($protectedAccounts, true);

        foreach($accounts as $value) {
            if($value['login'] == $anUsername) {
                return true;
            }
        }
        return false;
    }
    
    public function isIDinJSON($anID) {
        $protectedAccounts = file_get_contents("./accountsProtected.json");
        $accounts = json_decode($protectedAccounts, true);

        foreach($accounts as $value) {
            if($value['id'] == $anID) {
                return true;
            }
        }
        return false;
    }
    
    public function isEmailInJSON($anEmail) {
        $protectedAccounts = file_get_contents("./accountsProtected.json");
        $accounts = json_decode($protectedAccounts, true);

        foreach($accounts as $value) {
            if($value['email'] == $anEmail) {
                return true;
            }
        }
        return false;
    }
    
    public function isValidated($anUserID) {
        $theRequest = self::$_sql->prepare('SELECT COUNT(*) FROM user_validation WHERE id_user = :id_user');
        $theRequest->bindValue(':id_user', $anUserID, PDO::PARAM_INT);
        $theRequest->execute();
        $result = $theRequest->fetch();
        $theRequest->closeCursor();
        return ($result[0] == 0);
        
    }
    
    public function getInfos($anID) {
        $theRequest = self::$_sql->prepare('SELECT * FROM users WHERE id = :id');
        $theRequest->bindParam(':id', $anID, PDO::PARAM_INT);
        $theRequest->execute();
        $infos = $theRequest->fetchAll(\PDO::FETCH_ASSOC);
        if(isset($infos[0])) {
            return $infos[0];
        }
        else {
            return false;
        }
    }
    
    public function getStats() {
        $stats['nbAccounts'] = self::getNbAccounts();
        $stats['nbPaidPlans'] = self::getNbPaidPlans();
        $stats['storedSize'] = self::getStoredSize();
        $stats['freeSpaceRemaining'] = self::getFreeSpaceRemaining();
        return $stats;
    }
    
    public function getNbAccounts() {
        $theRequest = self::$_sql->prepare('SELECT COUNT(*) FROM users');
        $theRequest->execute();
        $nbAccouts = $theRequest->fetch();
        return $nbAccouts[0];
    }
    
    public function getNbPaidPlans() {
        $theRequest = self::$_sql->prepare('SELECT COUNT(*) FROM upgrade');
        $theRequest->execute();
        $nbPaidPlans = $theRequest->fetch();
        return $nbPaidPlans[0];
    }
    
    public function getStoredSize() {
        $theRequest = self::$_sql->prepare('SELECT SUM(size_stored) FROM storage');
        $theRequest->execute();
        $storedSize = $theRequest->fetch();
        return $storedSize[0];
    }
    
    public function getFreeSpaceRemaining() {
        $dir = dirname(dirname(dirname(dirname(__DIR__)))).'/nova';
        $freeSpaceRemaining = disk_free_space($dir);
        return $freeSpaceRemaining;
    }
    
    public function getStorage($anUserID) {
        $theRequest = self::$_sql->prepare('SELECT user_quota FROM storage WHERE id_user = :id_user');
        $theRequest->bindParam(':id_user', $anUserID, PDO::PARAM_INT);
        $theRequest->execute();
        $storage = $theRequest->fetch();
        return $storage['user_quota'];
    }
    
    public function changeStorageUser($anUserID, $aNewQuota) {
        $theRequest = self::$_sql->prepare('UPDATE storage SET user_quota = :user_quota WHERE id_user = :id_user');
        $theRequest->bindValue(':user_quota', $aNewQuota, PDO::PARAM_INT);
        $theRequest->bindValue(':id_user', $anUserID, PDO::PARAM_INT);
        $theRequest->execute();
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
    
    public function isEmailInDatabase($anEmail) {
        $theRequest = self::$_sql->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
        $theRequest->bindValue(':email', $anEmail, PDO::PARAM_STR);
        $theRequest->execute();
        $result = $theRequest->fetch();
        $theRequest->closeCursor();
        return !($result[0] == 0);
    }

    public function isUsernameInDatabase($anUsername) {
        $theRequest = self::$_sql->prepare('SELECT COUNT(*) FROM users WHERE login = :login');
        $theRequest->bindValue(':login', $anUsername, PDO::PARAM_STR);
        $theRequest->execute();
        $result = $theRequest->fetch();
        $theRequest->closeCursor();
        return !($result[0] == 0);
    }
    
    public function isIDinDatabase($anUserID) {
        $theRequest = self::$_sql->prepare('SELECT COUNT(*) FROM users WHERE id = :id');
        $theRequest->bindValue(':id', $anUserID, PDO::PARAM_INT);
        $theRequest->execute();
        $result = $theRequest->fetch();
        $theRequest->closeCursor();
        return !($result[0] == 0);
    }
    
    public function deleteUserVerification($anUserID) {
        $theRequest = self::$_sql->prepare("DELETE FROM user_validation WHERE id_user = :id_user");
        $theRequest->bindValue(':id_user', $anUserID, PDO::PARAM_INT);
        $theRequest->execute();
        $count = $theRequest->rowCount();
        $theRequest->closeCursor();
        return $count;
	}
    
    public function getAllStoragePlans() {
        $theRequest = self::$_sql->prepare("SELECT * FROM storage_plans");
        $theRequest->execute();
        $result = $theRequest->fetchAll();
        $theRequest->closeCursor();
        return $result;
    }
    
    public function deleteStoragePlan($planID) {
        $theRequest = self::$_sql->prepare("DELETE FROM storage_plans WHERE id = :id");
        $theRequest->bindValue(':id', $planID, PDO::PARAM_INT);
        $theRequest->execute();
    }
    
    public function getStoragePlan($planID) {
        $theRequest = self::$_sql->prepare("SELECT * FROM storage_plans WHERE id = :id");
        $theRequest->bindValue(':id', $planID, PDO::PARAM_INT);
        $theRequest->execute();
        $result = $theRequest->fetchAll();
        $theRequest->closeCursor();
        if(!empty($result[0])) {
            return $result[0];
        } else {
            return false;
        }
    }
    
    public function isProductIDAlradyInDatabase($productID) {
        $theRequest = self::$_sql->prepare('SELECT COUNT(*) FROM storage_plans WHERE product_id = :product_id');
        $theRequest->bindValue(':product_id', $productID, PDO::PARAM_INT);
        $theRequest->execute();
        $result = $theRequest->fetch();
        $theRequest->closeCursor();
        return !($result[0] == 0); 
    }
    
    public function isEditProductID($aID, $productID) {
        $theRequest = self::$_sql->prepare('SELECT COUNT(*) FROM storage_plans WHERE product_id = :product_id AND id != :id');
        $theRequest->bindValue(':product_id', $productID, PDO::PARAM_INT);
        $theRequest->bindValue(':id', $aID, PDO::PARAM_INT);
        $theRequest->execute();
        $result = $theRequest->fetch();
        $theRequest->closeCursor();
        return !($result[0] == 0); 
    }
    
    public function isProductAlradyInDatabase($aID) {
        $theRequest = self::$_sql->prepare('SELECT COUNT(*) FROM storage_plans WHERE id = :id');
        $theRequest->bindValue(':id', $aID, PDO::PARAM_INT);
        $theRequest->execute();
        $result = $theRequest->fetch();
        $theRequest->closeCursor();
        return !($result[0] == 0); 
    }
    
    public function addStoragePlan($aSize, $aPrice, $aDuration, $aProductID) {
        $theRequest = self::$_sql->prepare('INSERT INTO storage_plans(size, price, currency, duration, product_id) VALUES(:size, :price, :currency, :duration, :product_id)');
        $theRequest->bindValue(':size', $aSize, PDO::PARAM_INT);
        $theRequest->bindValue(':price', $aPrice, PDO::PARAM_INT);
        $theRequest->bindValue(':currency', "EUR", PDO::PARAM_STR);
        $theRequest->bindValue(':duration', $aDuration, PDO::PARAM_INT);
        $theRequest->bindValue(':product_id', $aProductID, PDO::PARAM_STR);
        $theRequest->execute();
    }
    
    public function modifyStoragePlan($aID, $aSize, $aPrice, $aDuration, $aProductID) {
        $theRequest = self::$_sql->prepare('UPDATE storage_plans SET size = :size, price = :price, duration = :duration, product_id = :product_id WHERE id = :id');
        $theRequest->bindValue(':size', $aSize, PDO::PARAM_INT);
        $theRequest->bindValue(':price', $aPrice, PDO::PARAM_INT);
        $theRequest->bindValue(':duration', $aDuration, PDO::PARAM_INT);
        $theRequest->bindValue(':product_id', $aProductID, PDO::PARAM_STR);
        $theRequest->bindValue(':id', $aID, PDO::PARAM_INT);
        $theRequest->execute();
    }
    
}

?>