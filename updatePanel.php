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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel - Delete storage plan</title>
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
                        <input id="branch" name="branch" type="text" placeholder="Branch">
                        <br/>
                        <button type="submit" id="updatePanelButton" name="updatePanelButton">Update</button>
                        <br/>
                        <br/>
                        <a href="/panel">Get back to the panel</a>
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