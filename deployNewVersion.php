<?php
if(!empty($_POST)) {
    $output = shell_exec(dirname(__DIR__) . '/deploy.sh 2>&1');
    $error = $output;
    $message = "New version deployed.";
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
    <?php include("./includes/navbar.php"); ?>
    <header>
        <h1>Deploy new version</h1>
    </header>
    <div>
        <div>
            <?php
                echo '<br/>';
                if(isset($error)) {
                    echo $error;
                } else {
                   if(isset($message)) {
                        echo $message;
                   } 
                }
            ?>
            <br/>
            <br/>
        </div>
        <form action="./deployNewVersion.php" method="post">
            <fieldset>
                <legend>Deploy new version</legend>
                <div>
                    <button type="submit" id="deployButton" name="deployButton">Deploy</button>
                    <a href="/panel">Get back to the panel"</a>
                </div>
            </fieldset>
        </form>
    </div>
    <?php include("./includes/footer.php"); ?>
</body>
</html>
