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
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel - Add user</title>
    <link id="style" href="./assets/css/<?php echo $_SESSION["design"]; ?>.css" rel="stylesheet">
</head>
<body>
    <?php include('./includes/header.php'); ?>
    <div id="main">
        <?php include('./includes/navbar.php'); ?>
        <div class="container-max">
            <section>
               <div id="return">
                    <p class="error">
                    </p>
                </div>
                <fieldset>
                    <legend>Add user</legend>
                    <input id="field_mail" name="field_mail" type="text" placeholder="Mail" required>
                    <input id="field_login" name="field_login" type="text" placeholder="Username" required>
                    <input id="field_pass" name="field_pass" type="password" placeholder="Password" required>
                    <input id="field_passphrase" name="field_passphrase" type="password" placeholder="Passphrase" required>
                    <input id="doubleAuth" name="doubleAuth" type="checkbox" class="checkboxDoubleAuth">
                    <label for="doubleAuth">Double auth ?</label>
                    <br/>
                    <button type="submit" id="submitButton" name="submitButton" onclick="sendRegisterRequest()">Create an account</button>
                </fieldset>
            </section>
        </div>
    </div>
    <?php include('./includes/footer.php'); ?>
    <script src="./assets/js/jQuery.min.js"></script>
    <script src="./assets/js/fontAwesome.js"></script>
    <script src="./assets/js/addUser.js"></script>
    <script src="./assets/js/sjcl.js"></script>
    <script src="./assets/js/base64.js"></script>
    <script src="./assets/js/sha512.js"></script>
</body>
</html>
