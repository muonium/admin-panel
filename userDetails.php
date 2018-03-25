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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel - User's details</title>
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
                        echo '<br/>';
                        if(isset($infos)) {
                            echo '<div class="userDetails">';
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

                                echo 'Current Storage : '.($DAO->getStorage($infos['id'])/1000000) .' MB ';
                                echo '<a href="./changeUserStorage.php?id='.$infos['id'].'">Change</a><br/>';
                            }
                            else {
                                echo $errorMessage;
                            }
                            echo '</div>';
                        }
                    ?>
                    <br/>
                    <br/>
                </div>
                <form action="./userDetails.php" method="post">
                    <fieldset>
                        <legend>User's Details</legend>
                        <div>
                            <label>Search by :</label>
                            <br/>
                            <br/>
                            <div>
                                <input type="radio" name="typeOfSearch" id="searchByID" value="id" checked="checked">
                                <label for="deleteByID">ID</label>
                                <br/>
                                <input type="radio" name="typeOfSearch" id="searchByEmail" value="email">
                                <label for="deleteByEmail">E-mail</label>
                                <br/>
                                <input type="radio" name="typeOfSearch" id="searchByUsername" value="username">
                                <label for="deleteByUsername">Username</label>
                            </div>
                        </div>
                        <br/>
                        <input id="textValue" name="textValue" type="text" placeholder="ID, email or username" required>
                        <br/>
                        <button type="submit" id="submitButton" name="submitButton">Search</button>
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
