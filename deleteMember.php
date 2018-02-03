<?php

include_once("../runDeleteUser.php");
include_once("./includes/DAO.class.php");

$cron = new cronDeleteUser();
$DAO = new DAO();

if(!empty($_POST)) {
    ob_start();
    $error = false;
    switch($_POST['typeOfDelete']) {
            case "id":
                if(is_numeric($_POST['textValue'])) {
                    if(!$DAO->isIDinJSON($_POST['textValue'])) {
                        $cron->deleteByID($_POST['textValue']); 
                    } else {
                        $error = true;
                        $result = "Error : User is protected";
                    }
                } else {
                    $error = true;
                    $result = "ID specified isn't an integer.";
                }
                break;
            case "email":
                if(!$DAO->isEmailInJSON($_POST['textValue'])) {
                    $cron->deleteByEmail($_POST['textValue']);
                } else {
                    $error = true;
                    $result = "Error : User is protected";
                }
                break;
            case "username":
                if(!$DAO->isUsernameInJSON($_POST['textValue'])) {
                    $cron->deleteByUsername($_POST['textValue']);
                } else {
                    $error = true;
                    $result = "Error : User is protected";
                }
                break;
            default:
                $error = true;
                $result = "Unknow value of delete type"; 
                break;
    }
    $trashOutput = ob_get_clean();
    $isHere = strpos($trashOutput, "User not found in database.\n");
    if($isHere === false) {
        if(!$error) {
            $result = "User successfully deleted.";
        }
    } else {
        $result = "User not found in database.";
    }
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Admin Panel - Index</title>
    <link href="./assets/css/css.css" rel="stylesheet">
</head>

<body>
    <?php include("./includes/navbar.php"); ?>
    <header>
        <h1>Delete member</h1>
    </header>
    <div>
        <div>
            <?php
                if(isset($result)) {
                    echo $result; 
                }
            ?>
        </div>
        <form action="./deleteMember.php" method="post">
            <fieldset>
                <legend>Delete member</legend>
                <div>
                    <label>Delete by</label>
                    <div>
                        <label for="deleteByID">
                            <input type="radio" name="typeOfDelete" id="deleteByID" value="id" checked="checked">
                            ID
                        </label>
                        <label for="deleteByEmail">
                            <input type="radio" name="typeOfDelete" id="deleteByEmail" value="email">
                            E-mail
                        </label>
                        <label for="deleteByUsername">
                            <input type="radio" name="typeOfDelete" id="deleteByUsername" value="username">
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
                    <button type="submit" id="submitButton" name="submitButton">Submit</button>
                    <button type="reset" id="cancelButton" name="cancelButton">Cancel</button>
                </div>
            </fieldset>
        </form>
    </div>
    <?php include("./includes/footer.php"); ?>
</body>
</html>
