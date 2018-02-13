<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Admin Panel - Add member</title>
    <link href="./assets/css/css.css" rel="stylesheet">
</head>

<body>
    <?php include("./includes/navbar.php"); ?>
    <header>
        <h1>Add member</h1>
    </header>
    <div>
            <fieldset>
                <legend>Add member</legend>
                <div>
                    <label for="field_mail">Mail</label>  
                    <div>
                        <input id="field_mail" name="field_mail" type="text" placeholder="Mail" required>
                    </div>
                </div>
                <div>
                    <label for="field_login">Username</label>  
                    <div>
                        <input id="field_login" name="field_login" type="text" placeholder="Username" required>
                    </div>
                </div>
                <div>
                    <label for="field_pass">Password</label>  
                    <div>
                        <input id="field_pass" name="field_pass" type="password" placeholder="Password" required>
                    </div>
                </div>
                <div>
                    <label for="field_passphrase">Passphrase</label>  
                    <div>
                        <input id="field_passphrase" name="field_passphrase" type="password" placeholder="Passphrase" required>
                    </div>
                </div>
                <div>
                    <label for="doubleAuth">Double auth ?</label>  
                    <div>
                        <input id="doubleAuth" name="doubleAuth" type="checkbox">
                    </div>
                </div>

                <div>
                    <button type="submit" id="submitButton" name="submitButton" onclick="sendRegisterRequest()">Create an account</button>
                </div>
            </fieldset>
        <div id="return">
            <p class="error"></p>
        </div>
    </div>
    <?php include("./includes/footer.php"); ?>
    <script src="./assets/js/addAccount.js"></script>
    <script src="./assets/js/sjcl.js"></script>
    <script src="./assets/js/base64.js"></script>
    <script src="./assets/js/sha512.js"></script>
</body>
</html>
