<?php
define('ROOT', dirname(dirname(__DIR__)));

require_once("./includes/DAO.class.php");

$DAO = new DAO();

if(!empty($_POST)) {
    if(isset($_POST['cancelButton'])) {
        header('Location: ./plansManagement.php');
    } elseif(isset($_POST['deleteButton'])) {
        $DAO->deleteStoragePlan($_POST['storagePlanID']);
        header('Location: ./plansManagement.php');
    }
} else {
    if(empty($_GET['id']) || !is_numeric($_GET['id'])) {
        header('Location: ./plansManagement.php');
    }

    $plan = $DAO->getStoragePlan($_GET['id']);
    
    if(!$plan) {
        header('Location: ./plansManagement.php');
    }
}


?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel - Delete storage plan</title>
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
                <fieldset>
                    <legend>Delete confirmation</legend>
                    <div>
                        Are you sure you want to delete this storage plan ?
                        <br/>
                        <br/>
                        <?php echo 'Product ID : '.$plan['product_id']; ?>
                        <br/>
                        <br/>
                        <form action="./plansDelete.php" method="post">
                            <div>
                                <button type="submit" id="deleteButton" name="deleteButton">Delete</button>
                                <button type="submit" id="cancelButton" name="cancelButton">Cancel</button>
                                <input type="hidden" id="storagePlanID" name="storagePlanID" value="<?php echo $_GET['id']; ?>">
                            </div>
                        </form>
                    </div>
                </fieldset>
                <div class="addNewPlanLink">
                    <a href="./plansAdd.php"><i class="fa fa-plus" aria-hidden="true"></i> Add a new storage plan</a>
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