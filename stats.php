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

$stats = $DAO->getStats();
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel - Stats</title>
    <link id="style" href="./assets/css/<?php echo $_SESSION["design"]; ?>.css" rel="stylesheet">
</head>
<body>
    <?php include('./includes/header.php'); ?>
    <div id="main">
        <?php include('./includes/navbar.php'); ?>
        <div class="container-max">
            <section>
                <fieldset>
                    <legend>Stats</legend>
                    <div>
                        <?php
                        echo 'Number of accounts : '.$stats['nbAccounts'].'<br/>';
                        echo 'Number of paid plans : '.$stats['nbPaidPlans'].'<br/>';
                        echo 'Total stored size (B)  : '.$stats['storedSize'].' Bytes<br/>';
                        echo 'Total stored size (GB) : '.round($stats['storedSize']/1000000000, 4).' GB<br/>';
                        echo 'Free storage space remaining (B)  : '.$stats['freeSpaceRemaining'].' Bytes<br/>';
                        echo 'Free storage space remaining (GB) : '.round($stats['freeSpaceRemaining']/1000000000, 2).' GB<br/>';

                        ?>
                    </div>
                </fieldset>
            </section>
        </div>
    </div>
    <?php include('./includes/footer.php'); ?>
    <script src="./assets/js/jQuery.min.js"></script>
    <script src="./assets/js/fontAwesome.js"></script>
</body>
</html>