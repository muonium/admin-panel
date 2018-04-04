<?php
session_start();

if(empty($_SESSION["design"])) {
    $_SESSION["design"] = "dark";
}

if(!empty($_SESSION["connected"])) {
    if($_SESSION["connected"]) {
        header('Location: index.php');
    }
}

if(!empty($_POST)) {
    $errorMessage = "";
    $login = $_POST['field_login'];
    $password = $_POST['field_pass'];
    
    $errorMessage = "";
    $accountFound = false;
    
    $accounts = file('./includes/logins');
    foreach($accounts as $line) {
        $details = explode(':', $line);
        if($details[0] == $login) {
            $accountFound = true;
            if(password_verify($password, $details[1])) {
                $_SESSION["connected"] = true;
                $_SESSION["login"] = $details[0];
                $_SESSION["rank"] = trim($details[2]);
                header('Location: index.php');
            } else {
                $errorMessage .= "Login or password is incorrect.<br/>";
            }
        }
    }
    
    if(!$accountFound) {
        $errorMessage .= "Login or password is incorrect.<br/>";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel - Login</title>
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
                <form action="./login.php" method="post">
                    <fieldset>
                        <legend>Login</legend>
                        <input id="field_login" name="field_login" type="text" placeholder="Username" required>
                        <input id="field_pass" name="field_pass" type="password" placeholder="Password" required>
                        <button type="submit" id="loginButton" name="loginButton">Login</button>
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
