<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel - Add user</title>
    <link id="style" href="./assets/css/dark.css" rel="stylesheet">
</head>
<body>
    <header>
        <div id="logo">
            <a href="./index.html"><img src="./assets/img/logos/logo.png" title="Accueil" alt="Accueil"></a>
        </div>
        <div class="iconRight">
            <a id="switchDesign" title="Design"><i id="designLogo" class="far fa-lightbulb fa-2x"></i></a>
            <a href="https://github.com/muonium/core" class="github" title="GitHub"><i class="fab fa-github fa-2x"></i></a>
        </div>
    </header>
    <div id="main">
        <div class="sidebar">
            <ul>
                <li><a href="./index.php"><i class="fas fa-home fa-2x"></i></a><span>Admin panel</span></li>
                <li><a href="./runCron.php"><i class="fas fa-play fa-2x"></i></a><span>Run cron</span></li>
                <li><a href="./stats.php"><i class="fas fa-chart-bar fa-2x"></i></a><span>Stats</span></li>
                <li><a href="./addUser.php"><i class="fas fa-user-plus fa-2x"></i></a><span>Add user</span></li>
                <li><a href="./plansManagement.php"><i class="fas fa-edit fa-2x"></i></a><span>Plans management</span></li>
                <li><a href="./deployNewVersion.php"><i class="fas fa-plus fa-2x"></i></a><span>Deploy new version</span></li>
                <li><a href="./deleteUser.php"><i class="fas fa-user-times fa-2x"></i></a><span>Delete user</span></li>
                <li><a href="./userDetails.php"><i class="fas fa-address-card fa-2x"></i></a><span>User details</span></li>
            </ul>
        </div>
        <div class="container-max">
            <section>
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
                <div id="return">
                    <p class="error"></p>
                </div>
            </section>
        </div>
    </div>
    <footer>
        <ul>
            <li>Muonium</li>
        </ul>
        <ul>
           <li><a href="./updatePanel.php">Update Panel</a></li>
        </ul>
    </footer>
    <script src="./assets/js/jQuery.min.js"></script>
    <script src="./assets/js/jsCookies.js"></script>
    <script src="./assets/js/fontAwesome.js"></script>
    <script src="./assets/js/switchDesign.js"></script>
    <script src="./assets/js/addUser.js"></script>
    <script src="./assets/js/sjcl.js"></script>
    <script src="./assets/js/base64.js"></script>
    <script src="./assets/js/sha512.js"></script>
</body>
</html>
