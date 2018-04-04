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
        $accountExists = false;
        $accounts = file('./includes/logins');
        $newFile = "";
        foreach($accounts as $line) {
            $details = explode(':', $line);

            if($details[0] == $_POST["field_login"]) {
                $accountExists = true;
                $accountLogin = $details[0];
                $accountPass = $details[1];
                if($_POST["field_password"] != "") {
                    $accountPass = password_hash($_POST["field_password"], PASSWORD_DEFAULT);
                }

                $accountToAdd = $accountLogin . ":" . $accountPass . ":" . $_POST["field_rank"] . PHP_EOL;
                $newFile .= $accountToAdd;
            } else {
                $newFile .= $line;
            }
        }
        file_put_contents('./includes/logins', $newFile);
        $message .= "Account successfully edited.<br/>";

        if(!$accountExists) {
            $message .= "Account doesn't exist.<br/>";
        }
    } else {
        $message .= "Can't edit your own account.<br/>";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel - Edit admin</title>
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
                <form action="./editAdmin.php" method="post">
                    <fieldset>
                        <legend>Edit admin</legend>
                        <input id="field_login" name="field_login" type="text" placeholder="Username" required>
                        <input id="field_password" name="field_password" type="password" placeholder="Password">
                        <select id="field_rank" name="field_rank">
                            <option value="admin" selected>Admin</option> 
                            <option value="master">Master</option>
                        </select>
                        <button type="submit" id="submitButton" name="submitButton">Edit an admin</button>
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
