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

define('ROOT', dirname(dirname(__DIR__)));

require_once("./includes/DAO.class.php");

$DAO = new DAO();

if(!empty($_POST)) {
    if(isset($_POST['cancelButton'])) {
        header('Location: ./userDetails.php');
    } elseif(isset($_POST['changeQuotaButton'])) {
        $id = $_POST['userID'];
        $DAO->changeStorageUser($id, $_POST['newQuotaValue']*1000000);
        $infos = $DAO->getInfos($id);
        $storage = $DAO->getStorage($id);
        $messageSuccess = 'Successfully changed user\'s storage';
    }
} else {
    
    if(empty($_GET['id']) || !is_numeric($_GET['id'])) {
        header('Location: ./userDetails.php');
    }

    $id = $_GET['id'];
    $infos = $DAO->getInfos($id);
    
    if(!$infos) {
        header('Location: ./userDetails.php');
    }
    
    $storage = $DAO->getStorage($id);
}
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Admin Panel - Change user storage</title>
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
                    if(isset($messageSuccess)) {
                        echo '<div class="userDetails">';
                        echo $messageSuccess;
                        echo '</div>'; 
                    }
                    ?>
                    <br/>
                    <br/>
                    <fieldset>
                        <legend>Change user's storage</legend>
                        <div>
                            <br/>
                            <?php
                                echo 'ID : '.$id.'<br/>'; 
                                echo 'Email : '.$infos['email'].'<br/>'; 
                                echo 'Login : '.$infos['login'].'<br/>'; 
                                echo 'Actual storage : '.$storage/1000000 .' MB<br/>';
                            ?>
                            <br/>
                            <form action="./changeUserStorage.php" method="post">
                                <div>
                                    <input type="number" id="newQuotaValue" name="newQuotaValue" min="0" value="<?php echo $storage/1000000; ?>">
                                    <br/>
                                    <button type="submit" id="changeQuotaButton" name="changeQuotaButton">Change</button>
                                    <button type="submit" id="cancelButton" name="cancelButton">Cancel</button>
                                    <input type="hidden" id="userID" name="userID" value="<?php echo $id; ?>">
                                </div>
                            </form>
                        </div>
                    </fieldset>
                </div>
            </section>
        </div>
    </div>
    <?php include('./includes/footer.php'); ?>
    <script src="./assets/js/jQuery.min.js"></script>
    <script src="./assets/js/fontAwesome.js"></script>
</body>
</html>