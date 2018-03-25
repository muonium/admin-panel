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
                    if(isset($message)) {
                        echo '<div class="userDetails">';
                        echo $message."<br/>"; 
                        echo '</div>';
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
    <?php include('./includes/footer.php'); ?>
    <script src="./assets/js/jQuery.min.js"></script>
    <script src="./assets/js/fontAwesome.js"></script>
</body>
</html>

