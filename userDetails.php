<?php
define('ROOT', dirname(dirname(__DIR__)));

require_once("./includes/DAO.class.php");

$DAO = new DAO();

if(!empty($_POST)) {
    $error = false;
    switch($_POST['typeOfSearch']) {
            case "id":
                if(is_numeric($_POST['textValue'])) {
                    $infos = $DAO->getInfos($_POST['textValue']); 
                    if(!$infos) {
                        $error = true;
                        $errorMessage = "No user found with this ID.";
                    }
                } else {
                    $error = true;
                    $errorMessage = "ID specified isn't an integer.";
                }
                break;
            case "email":
                $infos = $DAO->getInfos($DAO->getIDfromEmail($_POST['textValue']));
                if(!$infos) {
                    $error = true;
                    $errorMessage = "No user found with this email.";
                }
                break;
            case "username":
                $infos = $DAO->getInfos($DAO->getIDfromUsername($_POST['textValue']));
                if(!$infos) {
                    $error = true;
                    $errorMessage = "No user found with this username.";
                }
                break;
            default:
                $error = true;
                $errorMessage = "Unknow value of search type."; 
                break;
    }
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Admin Panel - User search</title>
    <link href="./assets/css/css.css" rel="stylesheet">
</head>

<body>
    <?php include("./includes/navbar.php"); ?>
    <header>
        <h1>User search</h1>
    </header>
    <div>
        <div>
            <?php
                echo '<br/>';
                if(isset($infos)) {
                    if($infos != false) {
                        
                        $isValidated = $DAO->isValidated($infos['id']);
                        
                        if($isValidated) {
                            echo 'Validated.<br/>';
                        } else {
                            echo 'Not validated.<br/>';
                        }
                        
                        echo 'ID : '.$infos['id'].'<br/>';
                        echo 'Username : '.$infos['login'].'<br/>';
                        echo 'Email : '.$infos['email'].'<br/>';
                        echo 'Registration date : '.date('d/m/Y H:i:s', $infos['registration_date']).'<br/>';
                        echo 'Last connection : '.date('d/m/Y H:i:s', $infos['last_connection']).'<br/>';
                        
                        echo 'Actual Storage : '.($DAO->getStorage($infos['id'])/1000000) .' MB ';
                        echo '<a href="./changeUserStorage.php?id='.$infos['id'].'">Change</a><br/>';
                    }
                    else {
                        echo $errorMessage;
                    }
                }
            ?>
            <br/>
            <br/>
        </div>
        <form action="./userDetails.php" method="post">
            <fieldset>
                <legend>User's Details</legend>
                <div>
                    <label>Search by</label>
                    <div>
                        <label for="deleteByID">
                            <input type="radio" name="typeOfSearch" id="searchByID" value="id" checked="checked">
                            ID
                        </label>
                        <label for="deleteByEmail">
                            <input type="radio" name="typeOfSearch" id="searchByEmail" value="email">
                            E-mail
                        </label>
                        <label for="deleteByUsername">
                            <input type="radio" name="typeOfSearch" id="searchByUsername" value="username">
                            Username
                        </label>
                    </div>
                </div>
                
                <div>
                    <label for=textValue>Value</label>  
                    <div>
                        <input id="textValue" name="textValue" type="text" placeholder="ID, email or username" required>
                    </div>
                </div>

                <div>
                    <button type="submit" id="submitButton" name="submitButton">Search</button>
                    <button type="reset" id="cancelButton" name="cancelButton">Cancel</button>
                </div>
            </fieldset>
        </form>
    </div>
    <?php include("./includes/footer.php"); ?>
</body>
</html>