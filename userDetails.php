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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel - User's details</title>
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

                                echo 'Current Storage : '.($DAO->getStorage($infos['id'])/1000000) .' MB ';
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
