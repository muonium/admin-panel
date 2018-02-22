<?php
if(!empty($_POST)) {
    $branch = $_POST['branch'];
    $output = shell_exec(dirname(__DIR__) . '/deploy.sh --panel "'.$branch.'" 2>&1');
    $error = $output;
    $message = "New version of admin panel deployed.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Admin Panel - Update panel</title>
    <link href="./assets/css/css.css" rel="stylesheet">
</head>

<body>
    <?php include("./includes/navbar.php"); ?>
    <header>
        <h1>Update Admin panel</h1>
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
        <form action="./updatePanel.php" method="post">
            <fieldset>
                <legend>Update Admin panel</legend>
                <div>
                    <label for="branch">Branch</label>
                    <div>
                        <input id="branch" name="branch" type="text" placeholder="Branch">
                    </div>
                </div>
                <div>
                    <button type="submit" id="updatePanelButton" name="updatePanelButton">Update</button>
					          <a href="/panel">Get back to the panel</a>
                </div>
            </fieldset>
        </form>
        <fieldset>
            <legend>Rollback admin panel</legend>
            <div>
                <a href="./rollbackPanel.php">Rollback</a>
            </div>
        </fieldset>
    </div>
    <?php include("./includes/footer.php"); ?>
</body>
</html>
