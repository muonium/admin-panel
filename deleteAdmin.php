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
} else {
    if($_SESSION["rank"] != "master") {
        header('Location: ./login.php');
    }
}

if(!empty($_POST)) {
    $message = "";
    if(!($_SESSION['login'] == $_POST["field_login"])) {
        $accountExist = false;
        $accounts = file('./includes/logins');
        $newFile = "";
        foreach($accounts as $line) {
            $details = explode(':', $line);

            if($details[0] != $_POST["field_login"]) {
                $newFile .= $line;
            } else {
                $accountExist = true;
            }
        }
        file_put_contents('./includes/logins', $newFile);

        if(!$accountExist) {
            $message .= "Account doesn't exist.<br/>";
        } else {
            $message .= "Account successfully deleted.<br/>";
        }
    } else {
        $message .= "Can't delete your own account.<br/>";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel - Delete admin</title>
    <link id="style" href="./assets/css/<?php echo $_SESSION["design"]; ?>.css" rel="stylesheet">
</head>
<body>
    <?php include('./includes/header.php'); ?>
    <div id="main">
        <?php include('./includes/navbar.php'); ?>
        <div class="container-max">
            <section>
                <?php
                if(!empty($message)) {
                    echo '<div class="errorMessage">';
                    echo $message;
                    echo '</div>';
                }
                ?>
                <form action="./deleteAdmin.php" method="post">
                    <fieldset>
                        <legend>Delete admin</legend>
                        <input id="field_login" name="field_login" type="text" placeholder="Username" required>
                        <button type="submit" id="submitButton" name="submitButton">Delete an admin</button>
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
