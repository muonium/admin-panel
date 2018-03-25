<?php

session_start();

if(empty($_SESSION["design"])) {
    $_SESSION["design"] = "dark";
}

if(empty($_SESSION["connected"])) {
    $_SESSION["connected"] = false;
    $_SESSION["rank"] = null;
}
if(!$_SESSION["connected"]) {
    header('Location: ./login.php');
}

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel - Delete user validation</title>
    <link id="style" href="./assets/css/<?php echo $_SESSION["design"]; ?>.css" rel="stylesheet">
</head>
<body>
    <?php include('./includes/header.php'); ?>
    <div id="main">
        <?php include('./includes/navbar.php'); ?>
        <div class="container-max">
            <section>
                <div>
                    <?php
                        if(isset($message)) {
                            echo '<div class="userDetails">';
                            echo $message;
                            echo '</div>'; 
                        }
                    ?>
                </div>
                <br/>
                <form action="./deleteValidation.php" method="post">
                    <fieldset>
                        <legend>Delete user validation</legend>
                        <div>
                            <label>Delete by :</label>
                            <br/>
                            <br/>
                            <div>
                                <input type="radio" name="typeOfDelete" id="deleteByID" value="id" checked="checked">
                                <label for="deleteByID">ID</label>
                                <br/>
                                <input type="radio" name="typeOfDelete" id="deleteByEmail" value="email">
                                <label for="deleteByEmail">E-mail</label>
                                <br/>
                                <input type="radio" name="typeOfDelete" id="deleteByUsername" value="username">
                                <label for="deleteByUsername">Username</label>
                            </div>
                            <br/>
                        </div>
                        <input id="textValue" name="textValue" type="text" placeholder="ID, email or username" required>
                        <button type="submit" id="submitButton" name="submitButton">Submit</button>
                        <button type="reset" id="cancelButton" name="cancelButton">Cancel</button>
                    </fieldset>
                </form>
            </section>
        </div>
    </div>
    <?php include('./includes/footer.php'); ?>
    <script src="./assets/js/jQuery.min.js"></script>
    <script src="./assets/js/fontAwesome.js"></script>
</body>
</html>
