<?php

if(!empty($_POST)) {
    $message = "";
    if(isset($_POST["cronEveryDay"])) {
        require_once(dirname(__DIR__).'/runEveryDay.php');
        $message .= "cron runEveryDay executed.<br/>";
    }
       
    if(isset($_POST["cronEveryMonth"])) {
        require_once(dirname(__DIR__).'/runEveryMonth.php');
        $message .= "cron runEveryMonth executed.<br/>";
    }
}


?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Admin Panel - Run cron</title>
    <link href="./assets/css/css.css" rel="stylesheet">
</head>

<body>
    <nav>
        <ul>
            <li><a href="./index.php">AdminPanel</a></li>
            <li><a href="./runCron.php">Run crons</a></li>
            <li><a href="./deployNewVersion.php">Deploy new version</a></li>
            <li><a href="./deleteMember.php">Delete member</a></li>
            <li><a href="./deleteValidation.php">Delete user validation</a></li>
        </ul>
    </nav>
    <header>
        <h1>Run crons</h1>
    </header>
    <div>
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
                    <div>
                        <label for="cronEveryDay">
                            <input type="checkbox" name="cronEveryDay" id="cronEveryDay" value="cronEveryDay">
                            runEveryDay
                        </label>
                        <br/>
                        <label for="cronEveryMonth">
                            <input type="checkbox" name="cronEveryMonth" id="cronEveryMonth" value="cronEveryMonth">
                            runEveryMonth
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit" id="runButton" name="runButton">Run</button>
                </div>
            </fieldset>
        </form>
    </div>
    <footer>
        <p>
            Admin Panel for Muonium 
        </p>
    </footer>
</body>
</html>
