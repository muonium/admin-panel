<?php
define('ROOT', dirname(dirname(__DIR__)));

require_once("./includes/DAO.class.php");

$DAO = new DAO();

$stats = $DAO->getStats();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Admin Panel - Stats</title>
    <link href="./assets/css/css.css" rel="stylesheet">
</head>

<body>
    <?php include("./includes/navbar.php"); ?>
    <header>
        <h1>Stats</h1>
    </header>
    <div>
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
    </div>
    <?php include("./includes/footer.php"); ?>
</body>
</html>