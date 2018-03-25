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
    //header('Location: ./login.php');
} else {
    if($_SESSION["rank"] != "master") {
        //header('Location: ./login.php');
    }
}

if(!empty($_POST)) {
    $errorMessage = "";
    if($_POST["field_pass"] == $_POST["field_passconfirm"]) {
        if($_POST["field_rank"] == "master" || $_POST["field_rank"] == "admin" ) {
            $accountExist = false;
            $accounts = file('./includes/logins');
            foreach($accounts as $line) {
                $details = explode(':', $line);
                if($details[0] == $_POST["field_login"]) {
                    $accountExist = true;
                }
            }
            if(!$accountExist) {
                $accountToAdd = $_POST["field_login"] . ":" . password_hash($_POST["field_pass"], PASSWORD_DEFAULT) . ":" . $_POST["field_rank"] . PHP_EOL;
                file_put_contents('./includes/logins', $accountToAdd, FILE_APPEND);
            } else {
                $errorMessage .= "Account already in file.<br/>";
            }
        } else {
            $errorMessage .= "Role not found.<br/>";
        }
    } else {
        $errorMessage .= "Passwords doesn't match.<br/>";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel - Add admin</title>
    <link id="style" href="./assets/css/<?php echo $_SESSION["design"]; ?>.css" rel="stylesheet">
</head>
<body>
    <?php include('./includes/header.php'); ?>
    <div id="main">
        <?php include('./includes/navbar.php'); ?>
        <div class="container-max">
            <section>
                <?php
                if(!empty($errorMessage)) {
                    echo '<div class="errorMessage">';
                    echo $errorMessage;
                    echo '</div>';
                }
                ?>
                <form action="./addAdmin.php" method="post">
                    <fieldset>
                        <legend>Add admin</legend>
                        <input id="field_login" name="field_login" type="text" placeholder="Username" required>
                        <input id="field_pass" name="field_pass" type="password" placeholder="Password" required>
                        <input id="field_passconfirm" name="field_passconfirm" type="password" placeholder="Password confirm" required>
                        <select id="field_rank" name="field_rank">
                            <option value="admin" selected>Admin</option> 
                            <option value="master">Master</option>
                        </select>
                        <button type="submit" id="submitButton" name="submitButton">Create an admin</button>
                    </fieldset>
                </form>
                <br/>
                <a href="./editAdmin.php" title="Edit existing admin">Edit existing admin</a>
            </section>
        </div>
    </div>
    <?php include('./includes/footer.php'); ?>
    <script src="./assets/js/jQuery.min.js"></script>
    <script src="./assets/js/fontAwesome.js"></script>
</body>
</html>
