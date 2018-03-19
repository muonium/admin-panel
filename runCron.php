<?php

if(!empty($_POST)) {
    $message = "";
    
    if(isset($_POST["cronEveryHour"])) {
        if(file_exists(dirname(__DIR__).'/runEveryHour.php')) {
            require_once(dirname(__DIR__).'/runEveryHour.php');
            $message .= "cron runEveryHour executed.<br/>"; 
        } else {
            $message .= 'Couldn\'t find runEveryHour.php file.<br/>';
        }
    }
    
    if(isset($_POST["cronEveryDay"])) {
        if(file_exists(dirname(__DIR__).'/runEveryDay.php')) {
            require_once(dirname(__DIR__).'/runEveryDay.php');
            $message .= "cron runEveryDay executed.<br/>"; 
        } else {
            $message .= 'Couldn\'t find runEveryDay.php file.<br/>';
        }
    }
       
    if(isset($_POST["cronEveryMonth"])) {
        if(file_exists(dirname(__DIR__).'/runEveryMonth.php')) {
            require_once(dirname(__DIR__).'/runEveryMonth.php');
            $message .= "cron runEveryMonth executed.<br/>";
        } else {
            $message .= 'Couldn\'t find runEveryMonth.php file.<br/>';
        }
    }
}


?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel - Run crons</title>
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
                    if(isset($message)) {
                        echo $message."<br/>"; 
                    }
                    ?>
                </div>
                <form action="./runCron.php" method="post">
                    <fieldset>
                        <legend>Run crons</legend>
                        <div>
                            <label>Which crons would you like to run ?</label>
                            <br/>
                            <br/>
                            <input type="checkbox" name="cronEveryHour" id="cronEveryHour" value="cronEveryHour">
                            <label for="cronEveryHour">runEveryHour</label>
                            <br/>
                            <input type="checkbox" name="cronEveryDay" id="cronEveryDay" value="cronEveryDay">
                            <label for="cronEveryDay">runEveryDay</label>
                            <br/>
                            <input type="checkbox" name="cronEveryMonth" id="cronEveryMonth" value="cronEveryMonth">
                            <label for="cronEveryMonth">runEveryMonth</label>
                        </div>
                        <br/>
                        <button type="submit" id="runButton" name="runButton">Run</button>
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

