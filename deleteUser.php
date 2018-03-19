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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel - Delete user</title>
    <link id="style" href="./assets/css/dark.css" rel="stylesheet">
</head>
<body>
    <header>
        <div id="logo">
            <a href="./index.html"><img src="./assets/img/logos/logo.png" title="Accueil" alt="Accueil"></a>
        </div>
        <div class="iconRight">
            <a id="switchDesign" title="Design"><i id="designLogo" class="far fa-lightbulb fa-2x"></i></a>
            <a href="https://github.com/muonium/core" class="github" title="GitHub"><i class="fab fa-github fa-2x"></i></a>
        </div>
    </header>
    <div id="main">
        <div class="sidebar">
            <ul>
                <li><a href="./index.php"><i class="fas fa-home fa-2x"></i></a><span>Admin panel</span></li>
                <li><a href="./runCron.php"><i class="fas fa-play fa-2x"></i></a><span>Run cron</span></li>
                <li><a href="./stats.php"><i class="fas fa-chart-bar fa-2x"></i></a><span>Stats</span></li>
                <li><a href="./addUser.php"><i class="fas fa-user-plus fa-2x"></i></a><span>Add user</span></li>
                <li><a href="./plansManagement.php"><i class="fas fa-edit fa-2x"></i></a><span>Plans management</span></li>
                <li><a href="./deployNewVersion.php"><i class="fas fa-plus fa-2x"></i></a><span>Deploy new version</span></li>
                <li><a href="./deleteUser.php"><i class="fas fa-user-times fa-2x"></i></a><span>Delete user</span></li>
                <li><a href="./userDetails.php"><i class="fas fa-address-card fa-2x"></i></a><span>User details</span></li>
            </ul>
        </div>
        <div class="container-max">
            <section>
                <div>
                    <?php
                        if(isset($result)) {
                            echo $result; 
                        }
                    ?>
                </div>
                <br/>
                <form action="./deleteUser.php" method="post">
                    <fieldset>
                        <legend>Delete member</legend>
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
    <footer>
        <ul>
            <li>Muonium</li>
        </ul>
        <ul>
           <li><a href="./updatePanel.php">Update Panel</a></li>
        </ul>
    </footer>
    <script src="./assets/js/jQuery.min.js"></script>
    <script src="./assets/js/jsCookies.js"></script>
    <script src="./assets/js/fontAwesome.js"></script>
    <script src="./assets/js/switchDesign.js"></script>
</body>
</html>
