<?php
if(!empty($_POST)) {
    $output = shell_exec(dirname(__DIR__) . '/deploy.sh 2>&1');
    $error = $output;
    $message = "New version deployed.<br/>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Admin Panel - Deploy new version</title>
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
        <h1>Deploy new version</h1>
    </header>
    <div>
        <div>
            <?php
                if(isset($message)) {
                    echo $message; 
                }
                echo '<br/>';
                if(isset($error)) {
                    echo $error.'<br/><br/>';
                }
            ?>
        </div>
        <form action="./deployNewVersion.php" method="post">
            <fieldset>
                <legend>Deploy new version</legend>
                <div>
                    <button type="submit" id="deployButton" name="deployButton">Deploy</button>
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
