<?php
define('ROOT', dirname(dirname(__DIR__)));

require_once("./includes/DAO.class.php");

$DAO = new DAO();

if(!empty($_POST)) {
    if(!$DAO->isProductIDAlradyInDatabase($_POST['productID'])) {
        $DAO->addStoragePlan($_POST['size']*1000000000, $_POST['price'], $_POST['duration'], $_POST['productID']);
        $message = "Storage plan successfully added.";
    } else {
        $message = "Product ID already exists.";
    }
    
    header('refresh:2;url=./plansManagement.php');
}

?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel - Storage plan</title>
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
                <?php
                if(isset($message)) {
                    echo $message;
                }
                ?>
                <br/>
                <br/>
                <fieldset>
                    <legend>Add a storage plan</legend>
                    <div>
                        <form action="./plansAdd.php" method="post">
                            <div>
                                <label for="size">Size (GB)</label>  
                                <div>
                                    <input type="number" name="size" step="1" min="0" required>
                                </div>
                            </div>
                            <br/>
                            <div>
                                <label for="price">Price (€)</label>  
                                <div>
                                    <input type="number" name="price" min="0" required>
                                </div>
                            </div>
                            <br/>
                            <div>
                                <label for="duration">Duration (months)</label>  
                                <div>
                                    <input type="number" name="duration" min="1" required>
                                </div>
                            </div>
                            <br/>
                            <div>
                                <label for="productID">Product ID</label>  
                                <div>
                                    <input type="text" name="productID" required>
                                </div>
                            </div>
                            <br/>
                            <div>
                                <button type="submit" id="submitButton" name="submitButton">Add</button>
                                <button type="cancel" id="cancelButton" name="cancelButton">Cancel</button>
                            </div>
                        </form>
                    </div>
                </fieldset>
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