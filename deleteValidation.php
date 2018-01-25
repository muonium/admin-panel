<?php

include_once("../runDeleteUser.php");
include_once("./includes/DAO.class.php");

$DAO = new DAO();

if(!empty($_POST)) {
    $error = false;
    switch($_POST['typeOfDelete']) {
            case "id":
                $userID = $_POST['textValue'];
                if(is_numeric($userID)) {
                    if(!$DAO->isIDinDatabase($userID)) {
                        $error = true;
                        $message = "ID doesn't exist in database.";
                    }
                } else {
                    $error = true;
                    $message = "ID specified isn't an integer.";
                }
                break;
            case "email":
                if(!$DAO->isEmailInDatabase($_POST['textValue'])) {
                    $error = true;
                    $message = "Email doesn't exist in database.";
                } else {
                    $userID = $DAO->getIDfromEmail($_POST['textValue']);
                }
                break;
            case "username":
                if(!$DAO->isUsernameInDatabase($_POST['textValue'])) {
                    $error = true;
                    $message = "Username doesn't exist in database.";
                } else {
                    $userID = $DAO->getIDfromUsername($_POST['textValue']);
                }
                break;
            default:
                $error = true;
                $message = "Unknow value of delete type"; 
                break;
    }
    if(!$error) {
        $numberOfRowDeleted = $DAO->deleteUserVerification($userID);
        if($numberOfRowDeleted == 0) {
            $message = 'No validation found for ID : '.$userID;
        } else {
            $message = 'User validation succesfully deleted from database. (ID : '.$userID.')';
        }
    }
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Admin Panel - Delete user validation</title>
    <link href="./assets/css/css.css" rel="stylesheet">
</head>

<body>
    <?php include("./includes/navbar.php"); ?>
    <header>
        <h1>Delete user validation</h1>
    </header>
    <div>
        <div>
            <?php
                if(isset($message)) {
                    echo $message; 
                }
            ?>
        </div>
        <form action="./deleteValidation.php" method="post">
            <fieldset>
                <legend>Delete user validation</legend>
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
