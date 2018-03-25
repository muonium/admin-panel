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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel - Delete user</title>
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
                        if(isset($result)) {
                            echo '<div class="userDetails">';
                            echo $result;
                            echo '</div>'; 
                        }
                    ?>
                </div>
                <br/>
                <form action="./deleteUser.php" method="post">
                    <fieldset>
                        <legend>Delete user</legend>
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
                <br/>
                <a href="./deleteValidation.php" title="Delete user valdiaiton">Delete user validation</a>
            </section>
        </div>
    </div>
    <?php include('./includes/footer.php'); ?>
    <script src="./assets/js/jQuery.min.js"></script>
    <script src="./assets/js/fontAwesome.js"></script>
</body>
</html>
