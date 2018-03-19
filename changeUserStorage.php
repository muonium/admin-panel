<?php
define('ROOT', dirname(dirname(__DIR__)));

require_once("./includes/DAO.class.php");

$DAO = new DAO();

if(!empty($_POST)) {
    if(isset($_POST['cancelButton'])) {
        header('Location: ./userDetails.php');
    } elseif(isset($_POST['changeQuotaButton'])) {
        $id = $_POST['userID'];
        $DAO->changeStorageUser($id, $_POST['newQuotaValue']*1000000);
        $infos = $DAO->getInfos($id);
        $storage = $DAO->getStorage($id);
        $messageSuccess = 'Successfully changed user\'s storage';
    }
} else {
    
    if(empty($_GET['id']) || !is_numeric($_GET['id'])) {
        header('Location: ./userDetails.php');
    }

    $id = $_GET['id'];
    $infos = $DAO->getInfos($id);
    
    if(!$infos) {
        header('Location: ./userDetails.php');
    }
    
    $storage = $DAO->getStorage($id);
}
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel - Change user storage</title>
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
                    if(isset($messageSuccess)) {
                        echo $messageSuccess;
                    }
                    ?>
                    <br/>
                    <br/>
                    <fieldset>
                        <legend>Change user's storage</legend>
                        <div>
                            <br/>
                            <?php
                                echo 'ID : '.$id.'<br/>'; 
                                echo 'Email : '.$infos['email'].'<br/>'; 
                                echo 'Login : '.$infos['login'].'<br/>'; 
                                echo 'Actual storage : '.$storage/1000000 .' MB<br/>';
                            ?>
                            <br/>
                            <form action="./changeUserStorage.php" method="post">
                                <div>
                                    <input type="number" id="newQuotaValue" name="newQuotaValue" min="0" value="<?php echo $storage/1000000; ?>">
                                    <br/>
                                    <button type="submit" id="changeQuotaButton" name="changeQuotaButton">Change</button>
                                    <button type="submit" id="cancelButton" name="cancelButton">Cancel</button>
                                    <input type="hidden" id="userID" name="userID" value="<?php echo $id; ?>">
                                </div>
                            </form>
                        </div>
                    </fieldset>
                </div>
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