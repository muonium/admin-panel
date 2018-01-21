<?php

include_once("../runDeleteUser.php");

$cron = new cronDeleteUser();
ob_start();
$error = false;
if(!empty($_POST)) {
    switch($_POST['typeOfDelete']) {
            case "id":
                $cron->deleteByID($_POST['textValue']);
                break;
            case "email":
                $cron->deleteByEmail($_POST['textValue']);
                break;
            case "username":
                $cron->deleteByUsername($_POST['textValue']);
                break;
            default:
                $error = true;
                $result = "Unknow value of delete type"; 
                break;
    }
    
}
$trashOutput = ob_get_clean();
$isHere = strpos($trashOutput, "User not found in database.\n");
if($isHere === false) {
    if(!$error) {
        $result = "User successfully deleted.";
    }
} else {
    $result = "User not found in database.";
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Panel Admin - Index</title>
    <link href="./assets/css/css.css" rel="stylesheet">
</head>

<body>
    <nav>
        <ul>
            <li><a href="./index.php">AdminPanel</a></li>
            <li><a href="./deleteMember.php">Delete member</a></li>
            <li><a href="./lastMembers.php">Lasts members</a></li>
        </ul>
    </nav>
    <header>
        <h1>Delete member</h1>
    </header>
    <div>
        <div>
           <?php echo $result; ?>
        </div>
        <form action="./deleteMember.php" method="post">
            <fieldset>
                <legend>Delete member</legend>
                <div>
                    <label>Delete by</label>
                    <div>
                        <label for="deleteByID">
                            <input type="radio" name="typeOfDelete" id="deleteByID" value="id" checked="checked">
                            ID
                        </label>
                        <label for="deleteByEmail">
                            <input type="radio" name="typeOfDelete" id="deleteByEmail" value="email">
                            E-mail
                        </label>
                        <label for="deleteByUsername">
                            <input type="radio" name="typeOfDelete" id="deleteByUsername" value="username">
                            Username
                        </label>
                    </div>
                </div>
                
                <div>
                    <label for=textValue>Value</label>  
                    <div>
                        <input id="textValue" name="textValue" type="text" placeholder="ID, email or username" required>
                    </div>
                </div>

                <div>
                    <button type="submit" id="submitButton" name="submitButton">Submit</button>
                    <button type="reset" id="cancelButton" name="cancelButton">Cancel</button>
                </div>
            </fieldset>
        </form>
    </div>
    <footer>
        <p>
            Panel Admin for Muonium 
        </p>
    </footer>
</body>
</html>